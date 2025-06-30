<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

class NewsApiController extends Controller
{
    // Konfigurasi cache
    protected $cacheTime = 60; // Cache dalam menit
    protected $useCache = true;
    protected $maxArticles = 12; // Batasi jumlah artikel untuk performa

    /**
     * Fetch international news from available sources
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInternationalNews()
    {
        try {
            // Cek apakah ada cache
            if ($this->useCache && Cache::has('international_news_articles')) {
                Log::info('Returning international news from cache');
                $articles = Cache::get('international_news_articles');
                
                return response()->json([
                    'status' => 'success',
                    'data' => $articles,
                    'source' => 'cache',
                    'timestamp' => now()->toIso8601String()
                ]);
            }

            Log::info('Attempting to fetch international news from RSS feeds');
            
            // Coba mendapatkan berita dari RSS feeds
            $result = $this->getNewsFromRssFeeds();
            
            // Jika RSS feeds gagal, coba API dengan key jika tersedia
            if (!$result) {
                Log::info('RSS feeds failed, trying APIs with keys');
                $apiPreference = env('NEWS_API_PREFERENCE', 'newsdata');
                
                try {
                    switch ($apiPreference) {
                        case 'newsdata':
                            $result = $this->getNewsFromNewsDataApi();
                            break;
                        case 'gnews':
                            $result = $this->getNewsFromGnewsApi();
                            break;
                        case 'newsapi':
                            $result = $this->getNewsFromNewsApi();
                            break;
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to fetch news from API: ' . $e->getMessage());
                }
            }
            
            // Jika semua cara gagal, coba gunakan cache lama jika ada
            if (!$result && Cache::has('international_news_articles_backup')) {
                Log::info('Using backup cache for international news');
                $articles = Cache::get('international_news_articles_backup');
                
                return response()->json([
                    'status' => 'success',
                    'data' => $articles,
                    'source' => 'backup_cache',
                    'timestamp' => now()->toIso8601String()
                ]);
            }
            
            // Jika semua cara gagal, berikan pesan error
            if (!$result) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to fetch international news. Please try again later.',
                    'data' => []
                ], 500);
            }
            
            return $result;
            
        } catch (\Exception $e) {
            Log::error('Critical error in getInternationalNews: ' . $e->getMessage());
            
            // Gunakan cache lama jika ada error
            if (Cache::has('international_news_articles_backup')) {
                Log::info('Error occurred, using backup cache for international news');
                $articles = Cache::get('international_news_articles_backup');
                
                return response()->json([
                    'status' => 'success',
                    'data' => $articles,
                    'source' => 'backup_cache',
                    'timestamp' => now()->toIso8601String()
                ]);
            }
            
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred while fetching international news. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Cache the articles for future use
     * 
     * @param array $articles
     * @return void
     */
    private function cacheArticles($articles)
    {
        if (empty($articles)) {
            Log::warning('Attempted to cache empty articles array');
            return;
        }
        
        // Cache for regular use
        Cache::put('international_news_articles', $articles, now()->addMinutes($this->cacheTime));
        
        // Create a backup cache with longer expiration
        Cache::put('international_news_articles_backup', $articles, now()->addHours(12));
        
        Log::info('Cached ' . count($articles) . ' articles successfully');
    }
    
    /**
     * Get news from RSS feeds of major international news sources
     * This method doesn't require any API key
     * 
     * @return \Illuminate\Http\JsonResponse|null
     */
    private function getNewsFromRssFeeds()
    {
        try {
            Log::info('Fetching news from RSS feeds');
            
            // Array of RSS feeds from major news sources with better image handling
            $rssFeeds = [
                [
                    'url' => 'https://feeds.bbci.co.uk/news/world/rss.xml',
                    'source' => 'BBC News',
                    'imageStrategy' => 'fetchPage',  // We'll fetch the actual page to get the image
                    'imageSelector' => 'meta[property="og:image"]', // BBC uses OpenGraph image tags
                ],
                [
                    'url' => 'https://rss.cnn.com/rss/cnn_world.rss',
                    'source' => 'CNN',
                    'imageStrategy' => 'mediaContent',
                ],
                [
                    'url' => 'https://moxie.foxnews.com/google-publisher/world.xml',
                    'source' => 'Fox News',
                    'imageStrategy' => 'mediaContent',
                ],
                [
                    'url' => 'https://www.aljazeera.com/xml/rss/all.xml',
                    'source' => 'Al Jazeera',
                    'imageStrategy' => 'mediaContent',
                ],
                [
                    'url' => 'https://rss.nytimes.com/services/xml/rss/nyt/World.xml',
                    'source' => 'New York Times',
                    'imageStrategy' => 'mediaContent',
                ],
                [
                    'url' => 'https://www.jpost.com/rss/rssfeedsmideastfront.aspx',
                    'source' => 'Jerusalem Post',
                    'imageStrategy' => 'content', // Look for images in content
                    'topics' => ['israel', 'iran', 'gaza', 'palestine', 'middle east']
                ],
                [
                    'url' => 'https://news.google.com/rss?hl=en&gl=US&ceid=US:en',
                    'source' => 'Google News',
                    'imageStrategy' => 'fetchPage',
                    'imageSelector' => 'img'
                ],
            ];
            
            $allArticles = [];
            $successCount = 0;
            
            // Try each feed until we have enough articles
            foreach ($rssFeeds as $feed) {
                try {
                    $response = Http::timeout(8)->get($feed['url']);
                    
                    if ($response->successful()) {
                        $xml = new SimpleXMLElement($response->body());
                        $sourceName = $feed['source'];
                        
                        // Parse the RSS feed (handle different RSS formats)
                        $items = [];
                        
                        if (isset($xml->channel) && isset($xml->channel->item)) {
                            // Standard RSS format
                            $items = $xml->channel->item;
                        } elseif (isset($xml->entry)) {
                            // Atom format
                            $items = $xml->entry;
                        }
                        
                        foreach ($items as $index => $item) {
                            // Skip if we already have too many articles
                            if (count($allArticles) >= 20) {
                                break;
                            }
                            
                            // Extract title
                            $title = (string)($item->title ?? 'No Title');
                            
                            // Skip articles with titles that are too short
                            if (strlen($title) < 10) {
                                continue;
                            }
                            
                            // Extract URL
                            $url = '';
                            if (isset($item->link['href'])) {
                                // Atom format
                                $url = (string)$item->link['href'];
                            } elseif (isset($item->link)) {
                                // RSS format
                                $url = (string)$item->link;
                            }
                            
                            // Skip if URL is empty
                            if (empty($url)) {
                                continue;
                            }
                            
                            // Extract description and content
                            $description = '';
                            $content = '';
                            
                            if (isset($item->description)) {
                                $description = (string)$item->description;
                                $content = (string)$item->description;
                            } elseif (isset($item->summary)) {
                                $description = (string)$item->summary;
                                $content = (string)$item->summary;
                            } elseif (isset($item->content)) {
                                $content = (string)$item->content;
                                $description = substr(strip_tags($content), 0, 150) . '...';
                            } elseif (isset($item->children('content', true)->encoded)) {
                                $content = (string)$item->children('content', true)->encoded;
                                $description = substr(strip_tags($content), 0, 150) . '...';
                            }
                            
                            // Extract publish date
                            $publishedAt = date('c');
                            if (isset($item->pubDate)) {
                                $publishedAt = date('c', strtotime((string)$item->pubDate));
                            } elseif (isset($item->published)) {
                                $publishedAt = date('c', strtotime((string)$item->published));
                            } elseif (isset($item->updated)) {
                                $publishedAt = date('c', strtotime((string)$item->updated));
                            }
                            
                            // --------------------
                            // ADVANCED IMAGE EXTRACTION
                            // --------------------
                            $imageUrl = null;
                            $imageStrategy = $feed['imageStrategy'] ?? 'default';
                            
                            // Different image extraction strategies based on the feed
                            switch ($imageStrategy) {
                                case 'mediaContent':
                                    // Look for media:content tag
                                    if (isset($item->children('media', true)->content)) {
                                        foreach ($item->children('media', true)->content as $media) {
                                            if ((string)$media['medium'] === 'image' || strpos((string)$media['type'], 'image') !== false) {
                                                $imageUrl = (string)$media['url'];
                                                break;
                                            }
                                        }
                                    }
                                    
                                    // If not found, try media:thumbnail
                                    if (!$imageUrl && isset($item->children('media', true)->thumbnail)) {
                                        $imageUrl = (string)$item->children('media', true)->thumbnail['url'];
                                    }
                                    
                                    break;
                                    
                                case 'fetchPage':
                                    // For sources that don't include images in the RSS feed,
                                    // we need to fetch the actual page and extract the image
                                    try {
                                        $pageResponse = Http::timeout(5)->get($url);
                                        if ($pageResponse->successful()) {
                                            $html = $pageResponse->body();
                                            $selector = $feed['imageSelector'] ?? 'meta[property="og:image"]';
                                            
                                            // Extract image from meta tag (OpenGraph)
                                            if (stripos($selector, 'meta') !== false) {
                                                preg_match('/<meta[^>]*property=["\']og:image["\'][^>]*content=["\'](.*?)["\']/', $html, $matches);
                                                if (!empty($matches[1])) {
                                                    $imageUrl = $matches[1];
                                                }
                                            } 
                                            // Extract first significant image
                                            else if (stripos($selector, 'img') !== false) {
                                                preg_match_all('/<img[^>]*src=["\'](.*?)["\'][^>]*>/i', $html, $matches);
                                                if (!empty($matches[1])) {
                                                    foreach ($matches[1] as $imgSrc) {
                                                        // Skip small icons and pixel trackers
                                                        if (stripos($imgSrc, 'icon') === false && 
                                                            stripos($imgSrc, 'logo') === false && 
                                                            stripos($imgSrc, 'pixel') === false && 
                                                            stripos($imgSrc, '.gif') === false) {
                                                            $imageUrl = $imgSrc;
                                                            break;
                                                        }
                                                    }
                                                }
                                            }
                                            
                                            // Handle relative URLs
                                            if ($imageUrl && strpos($imageUrl, 'http') !== 0) {
                                                $parsedUrl = parse_url($url);
                                                $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
                                                $imageUrl = $baseUrl . ($imageUrl[0] === '/' ? '' : '/') . $imageUrl;
                                            }
                                        }
                                    } catch (\Exception $e) {
                                        Log::warning("Failed to fetch page for image: " . $e->getMessage());
                                    }
                                    break;
                                    
                                case 'content':
                                    // Extract image from content or description
                                    $html = $content ?: $description;
                                    preg_match('/<img[^>]*src=[\'"](?P<src>[^\'"]+)[\'"]/i', $html, $matches);
                                    if (!empty($matches['src'])) {
                                        $imageUrl = $matches['src'];
                                        
                                        // Handle relative URLs
                                        if (strpos($imageUrl, 'http') !== 0) {
                                            $parsedUrl = parse_url($url);
                                            $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
                                            $imageUrl = $baseUrl . ($imageUrl[0] === '/' ? '' : '/') . $imageUrl;
                                        }
                                    }
                                    break;
                                    
                                default:
                                    // Try all methods in sequence
                                    
                                    // 1. Look for media:content
                                    if (isset($item->children('media', true)->content)) {
                                        foreach ($item->children('media', true)->content as $media) {
                                            if ((string)$media['medium'] === 'image' || strpos((string)$media['type'], 'image') !== false) {
                                                $imageUrl = (string)$media['url'];
                                                break;
                                            }
                                        }
                                    }
                                    
                                    // 2. Look for media:thumbnail
                                    if (!$imageUrl && isset($item->children('media', true)->thumbnail)) {
                                        $imageUrl = (string)$item->children('media', true)->thumbnail['url'];
                                    }
                                    
                                    // 3. Look for enclosure with image type
                                    if (!$imageUrl && isset($item->enclosure)) {
                                        foreach ($item->enclosure as $enclosure) {
                                            if (strpos((string)$enclosure['type'], 'image') !== false) {
                                                $imageUrl = (string)$enclosure['url'];
                                                break;
                                            }
                                        }
                                    }
                                    
                                    // 4. Try to extract from content
                                    if (!$imageUrl) {
                                        $html = $content ?: $description;
                                        preg_match('/<img[^>]*src=[\'"](?P<src>[^\'"]+)[\'"]/i', $html, $matches);
                                        if (!empty($matches['src'])) {
                                            $imageUrl = $matches['src'];
                                        }
                                    }
                            }
                            
                            // If still no image, use topic-specific images
                            if (!$imageUrl) {
                                $imageUrl = $this->getTopicSpecificImage($title . ' ' . $description);
                            }
                            
                            // Format the article
                            $article = [
                                'id' => md5($url . $title . $index),
                                'title' => $title,
                                'description' => $description ? strip_tags($description) : 'No description available',
                                'content' => $content,
                                'url' => $url,
                                'urlToImage' => $imageUrl,
                                'publishedAt' => $publishedAt,
                                'source' => ['name' => $sourceName],
                                'author' => (string)($item->author ?? 'Unknown')
                            ];
                            
                            $allArticles[] = $article;
                        }
                        
                        $successCount++;
                        Log::info("Successfully fetched articles from {$sourceName}");
                        
                        // Break if we have enough articles from enough sources
                        if ($successCount >= 3 && count($allArticles) >= 12) {
                            break;
                        }
                    }
                } catch (\Exception $e) {
                    Log::warning("Failed to fetch from feed {$feed['source']}: " . $e->getMessage());
                    // Continue to next feed
                }
            }
            
            if (count($allArticles) > 0) {
                // Sort articles by publish date (newest first)
                usort($allArticles, function($a, $b) {
                    return strtotime($b['publishedAt']) - strtotime($a['publishedAt']);
                });
                
                // Limit to 20 articles
                $allArticles = array_slice($allArticles, 0, 20);
                
                // Cache the articles
                $this->cacheArticles($allArticles);
                
                Log::info("Successfully fetched " . count($allArticles) . " articles from RSS feeds");
                
                return response()->json([
                    'status' => 'success',
                    'data' => $allArticles,
                    'source' => 'rss',
                    'timestamp' => now()->toIso8601String()
                ]);
            }
            
            Log::warning("Failed to fetch any articles from RSS feeds");
            return null;
            
        } catch (\Exception $e) {
            Log::error('Failed to fetch news from RSS feeds: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get topic-specific images based on content analysis
     */
    private function getTopicSpecificImage($content)
    {
        // Topic dictionaries with relevant keywords and corresponding image URLs
        $topicDictionaries = [
            'nato_military' => [
                'keywords' => ['nato', 'military', 'defense', 'defence', 'army', 'troop', 'soldier', 'war', 'spending'],
                'images' => [
                    'https://www.nato.int/nato_static_fl2014/assets/pictures/images_mfu/2023/6/stock/220613-NATO_HQ_0349_rdax_775x440s.jpg',
                    'https://www.nato.int/nato_static_fl2014/assets/pictures/images_mfu/2021/6/stock/210614-nato-summit-002_rdax_775x440s.jpg',
                    'https://static.euronews.com/articles/stories/07/26/74/04/1100x619_cmsv2_4330511c-bef0-5d7e-963d-a3b2cf4b47d2-7267404.jpg'
                ]
            ],
            'israel_iran_conflict' => [
                'keywords' => ['israel', 'iran', 'hamas', 'gaza', 'palestine', 'missile', 'strike', 'jerusalem', 'tehran', 'nuclear'],
                'images' => [
                    'https://static.timesofisrael.com/www/uploads/2023/04/F230420FFAM01-1024x640.jpg',
                    'https://static.timesofisrael.com/www/uploads/2022/11/000_32NL9VN-1024x640.jpg',
                    'https://www.arabnews.com/sites/default/files/styles/n_670_395/public/main-image/2023/04/14/3689581-1296365383.jpg'
                ]
            ],
            'space_exploration' => [
                'keywords' => ['space', 'nasa', 'astronaut', 'rocket', 'launch', 'satellite', 'mars', 'moon', 'spacecraft', 'orbit'],
                'images' => [
                    'https://static.scientificamerican.com/sciam/cache/file/41DF7AFE-EF01-4E13-B2B5C4692794C3DF_source.jpg',
                    'https://cdn.mos.cms.futurecdn.net/yyMdcvfmfZTdPVfoMm66WP-1200-80.jpg',
                    'https://www.newscientist.com/wp-content/uploads/2023/02/23-february-2023_spacewalk.jpg'
                ]
            ],
            'climate_environment' => [
                'keywords' => ['climate', 'environment', 'global warming', 'carbon', 'emission', 'pollution', 'renewable', 'sustainability'],
                'images' => [
                    'https://cdn.vox-cdn.com/thumbor/9P3FaZBGE_zHYwFY5bvQCHlFWjQ=/0x0:5464x3640/1820x1213/filters:focal(2295x1383:3169x2257):format(webp)/cdn.vox-cdn.com/uploads/chorus_image/image/72565059/1235971000.0.jpg',
                    'https://www.un.org/sites/un2.un.org/files/field/image/1-climate-change-image.jpg',
                    'https://www.thegreenage.co.uk/wp-content/uploads/2022/10/Calculating-carbon-emissions.jpeg'
                ]
            ],
            'health_pandemic' => [
                'keywords' => ['health', 'pandemic', 'virus', 'disease', 'covid', 'vaccine', 'hospital', 'medical', 'doctor', 'patient'],
                'images' => [
                    'https://www.gannett-cdn.com/presto/2020/10/20/USAT/1a9060e9-7e3f-4c5e-ae96-4263d542995d-VPC_COVID_VACCINE_LATEST_DESK_THUMB.jpg',
                    'https://assets.weforum.org/article/image/large_Da5Ue9bDyJgGqg44ZpEYVErubWsSbLTa-5g7YL7tBuQ.jpg',
                    'https://i0.wp.com/post.medicalnewstoday.com/wp-content/uploads/sites/3/2020/03/GettyImages-1142183783_header-1024x575.jpg'
                ]
            ],
            'economy_business' => [
                'keywords' => ['economy', 'business', 'market', 'finance', 'stock', 'trade', 'inflation', 'recession', 'investment'],
                'images' => [
                    'https://www.investopedia.com/thmb/V-Bu-elY2g82DMxEt-9ZiLOQVJY=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/GettyImages-927385390-342e2f8159cd472491c62c020a966f8d.jpg',
                    'https://imageio.forbes.com/specials-images/imageserve/641d3eb6a5b366dec7efe323/Economy/960x0.jpg',
                    'https://www.marketplace.org/wp-content/uploads/2023/05/Federal-Reserve.jpg'
                ]
            ],
            'politics_diplomacy' => [
                'keywords' => ['politics', 'election', 'president', 'minister', 'government', 'parliament', 'democracy', 'vote', 'campaign', 'diplomatic'],
                'images' => [
                    'https://www.devdiscourse.com/remote.axd?https://devdiscourse.blob.core.windows.net/imagegallery/07_05_2021_14_56_44_6747049.jpg',
                    'https://www.history.com/.image/ar_16:9%2Cc_fill%2Ccs_srgb%2Cfl_progressive%2Cq_auto:good%2Cw_1200/MTc4MzA0MjE3MzQwNzYzMTgw/white-house-history-gettyimages-1147690170.jpg',
                    'https://www.chathamhouse.org/sites/default/files/2023-02/2023-02-08-usa-eu-flags-GettyImages-1246685227.jpg'
                ]
            ],
            'technology_innovation' => [
                'keywords' => ['technology', 'innovation', 'ai', 'artificial intelligence', 'digital', 'tech', 'robot', 'computer', 'internet', 'software'],
                'images' => [
                    'https://media.licdn.com/dms/image/D4D12AQGB39VCt8jKgw/article-cover_image-shrink_720_1280/0/1664894040170?e=2147483647&v=beta&t=waslUDrmmwXiVZkEk1aPug9xagEHekc5gh4id-8G9Z0',
                    'https://zeevector.com/wp-content/uploads/Artificial-Intelligence-Technology-Background.jpg',
                    'https://www.simplilearn.com/ice9/free_resources_article_thumb/Why-get-certified-in-Artificial-Intelligence.jpg'
                ]
            ],
            'disaster_emergency' => [
                'keywords' => ['disaster', 'emergency', 'earthquake', 'tsunami', 'hurricane', 'flood', 'fire', 'accident', 'crash', 'explosion'],
                'images' => [
                    'https://i.natgeofe.com/n/1fa13f54-d5fd-46ba-a853-bc14acf9045e/GettyImages-1428377358_square.jpg',
                    'https://media.istockphoto.com/id/1357365823/vector/default-image-icon-vector-missing-picture-page-for-website-design-or-mobile-app-no-photo.jpg',
                    'https://www.zurich.com/-/media/project/zurich/dotcom/sustainability/docs/flood-risk.jpg'
                ]
            ]
        ];
        
        // Normalize content for keyword search
        $content = strtolower($content);
        
        // Find the most relevant topic based on keyword matches
        $bestTopic = null;
        $highestMatchCount = 0;
        
        foreach ($topicDictionaries as $topic => $data) {
            $matchCount = 0;
            foreach ($data['keywords'] as $keyword) {
                if (strpos($content, $keyword) !== false) {
                    $matchCount++;
                }
            }
            
            if ($matchCount > $highestMatchCount) {
                $highestMatchCount = $matchCount;
                $bestTopic = $topic;
            }
        }
        
        // If we found a matching topic, return a random image from that topic
        if ($bestTopic && $highestMatchCount > 0) {
            $images = $topicDictionaries[$bestTopic]['images'];
            return $images[array_rand($images)];
        }
        
        // Default image if no topic matched
        $defaultImages = [
            'https://static.euronews.com/articles/stories/07/40/53/02/1000x563_cmsv2_af0e8a05-e5f4-5970-9618-5ef748a2f488-7405302.jpg',
            'https://www.reuters.com/pf/resources/images/reuters/reuters-default.webp?d=139',
            'https://static.dw.com/image/64772152_1006.jpg',
            'https://assets.bwbx.io/images/users/iqjWHBFdfxIU/iWA0ZQn14HQo/v0/1200x800.jpg',
            'https://static01.nyt.com/newsgraphics/images/icons/defaultPromoCrop.png'
        ];
        
        return $defaultImages[array_rand($defaultImages)];
    }
    
    /**
     * Show detailed view of an international news article
     * 
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function showInternationalNews($id)
    {
        try {
            // Log untuk debugging
            Log::info('Attempting to fetch article with ID: ' . $id);
            
            // Refresh cache if needed
            if (!Cache::has('international_news_articles')) {
                // Coba gunakan backup cache dulu
                if (Cache::has('international_news_articles_backup')) {
                    $articles = Cache::get('international_news_articles_backup');
                    Cache::put('international_news_articles', $articles, now()->addMinutes($this->cacheTime));
                } else {
                    Log::info('Cache miss for international_news_articles, refreshing cache');
                    $this->getInternationalNews();
                }
            }
            
            $articles = Cache::get('international_news_articles', []);
            
            // Find the article by ID
            $article = collect($articles)->firstWhere('id', $id);
            
            // If not found, try to refresh the cache and search again
            if (!$article) {
                Log::warning('Article not found in cache, refreshing: ' . $id);
                
                $this->getInternationalNews();
                $articles = Cache::get('international_news_articles', []);
                $article = collect($articles)->firstWhere('id', $id);
                
                // If still not found, return 404
                if (!$article) {
                    Log::warning('Article not found after cache refresh: ' . $id);
                    abort(404, 'Berita internasional tidak ditemukan');
                }
            }
            
            // Get related news
            $relatedArticles = collect($articles)
                ->filter(function($item) use ($id) {
                    return isset($item['id']) && $item['id'] !== $id;
                })
                ->take(3)
                ->toArray();
                
            Log::info('Successfully found article: ' . $article['title']);
            
            return view('international.show', [
                'article' => $article,
                'relatedArticles' => $relatedArticles
            ]);
        } catch (\Exception $e) {
            Log::error('Error in showInternationalNews: ' . $e->getMessage());
            abort(404, 'Berita internasional tidak ditemukan - Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Menampilkan halaman daftar berita internasional
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            // Cek dan refresh cache jika diperlukan
            if (!Cache::has('international_news_articles')) {
                Log::info('Cache miss for international news index page, refreshing cache');
                $this->getInternationalNews();
            }
            
            $articles = Cache::get('international_news_articles', []);
            
            // Jika data kosong, coba dapatkan data
            if (empty($articles)) {
                Log::info('Empty articles cache, retrying to fetch');
                $this->getInternationalNews();
                $articles = Cache::get('international_news_articles', []);
            }
            
            return view('international.index', [
                'articles' => $articles,
                'title' => 'Berita Internasional Terkini'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in international news index: ' . $e->getMessage());
            return view('international.index', [
                'articles' => [],
                'title' => 'Berita Internasional Terkini',
                'error' => 'Terjadi kesalahan saat mengambil berita internasional.'
            ]);
        }
    }
    
    /**
     * Get news from NewsData.io API
     * 
     * @return \Illuminate\Http\JsonResponse|null
     */
    private function getNewsFromNewsDataApi()
    {
        try {
            Log::info('Fetching news from NewsData.io API');
            
            $apiKey = env('NEWSDATA_API_KEY');
            if (!$apiKey) {
                Log::error('NewsData API key is missing');
                return null;
            }
            
            $response = Http::timeout(10)->get('https://newsdata.io/api/1/news', [
                'apikey' => $apiKey,
                'language' => 'en',
                'category' => 'world',
                'size' => 20
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['results']) && is_array($data['results'])) {
                    $articles = [];
                    
                    foreach ($data['results'] as $article) {
                        $articles[] = [
                            'id' => md5($article['link'] . $article['title']),
                            'title' => $article['title'],
                            'description' => $article['description'] ?? 'No description available',
                            'content' => $article['content'] ?? $article['description'] ?? '',
                            'url' => $article['link'],
                            'urlToImage' => $article['image_url'] ?? $this->getTopicSpecificImage($article['title']),
                            'publishedAt' => $article['pubDate'],
                            'source' => ['name' => $article['source_id']],
                            'author' => $article['creator'][0] ?? 'Unknown'
                        ];
                    }
                    
                    // Cache the articles
                    $this->cacheArticles($articles);
                    
                    Log::info("Successfully fetched " . count($articles) . " articles from NewsData API");
                    
                    return response()->json([
                        'status' => 'success',
                        'data' => $articles,
                        'source' => 'newsdata',
                        'timestamp' => now()->toIso8601String()
                    ]);
                }
            }
            
            Log::warning("Failed to fetch articles from NewsData API");
            return null;
            
        } catch (\Exception $e) {
            Log::error('Failed to fetch news from NewsData API: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get news from Gnews API
     * 
     * @return \Illuminate\Http\JsonResponse|null
     */
    private function getNewsFromGnewsApi()
    {
        try {
            Log::info('Fetching news from Gnews API');
            
            $apiKey = env('GNEWS_API_KEY');
            if (!$apiKey) {
                Log::error('Gnews API key is missing');
                return null;
            }
            
            $response = Http::timeout(10)->get('https://gnews.io/api/v4/top-headlines', [
                'token' => $apiKey,
                'lang' => 'en',
                'topic' => 'world',
                'max' => 20
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['articles']) && is_array($data['articles'])) {
                    $articles = [];
                    
                    foreach ($data['articles'] as $article) {
                        $articles[] = [
                            'id' => md5($article['url'] . $article['title']),
                            'title' => $article['title'],
                            'description' => $article['description'] ?? 'No description available',
                            'content' => $article['content'] ?? $article['description'] ?? '',
                            'url' => $article['url'],
                            'urlToImage' => $article['image'] ?? $this->getTopicSpecificImage($article['title']),
                            'publishedAt' => $article['publishedAt'],
                            'source' => ['name' => $article['source']['name']],
                            'author' => 'Unknown'
                        ];
                    }
                    
                    // Cache the articles
                    $this->cacheArticles($articles);
                    
                    Log::info("Successfully fetched " . count($articles) . " articles from Gnews API");
                    
                    return response()->json([
                        'status' => 'success',
                        'data' => $articles,
                        'source' => 'gnews',
                        'timestamp' => now()->toIso8601String()
                    ]);
                }
            }
            
            Log::warning("Failed to fetch articles from Gnews API");
            return null;
            
        } catch (\Exception $e) {
            Log::error('Failed to fetch news from Gnews API: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get news from News API
     * 
     * @return \Illuminate\Http\JsonResponse|null
     */
    private function getNewsFromNewsApi()
    {
        try {
            Log::info('Fetching news from News API');
            
            $apiKey = env('NEWS_API_KEY');
            if (!$apiKey) {
                Log::error('News API key is missing');
                return null;
            }
            
            $response = Http::timeout(10)->get('https://newsapi.org/v2/top-headlines', [
                'apiKey' => $apiKey,
                'language' => 'en',
                'category' => 'general',
                'pageSize' => 20
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['articles']) && is_array($data['articles'])) {
                    $articles = [];
                    
                    foreach ($data['articles'] as $article) {
                        $articles[] = [
                            'id' => md5($article['url'] . $article['title']),
                            'title' => $article['title'],
                            'description' => $article['description'] ?? 'No description available',
                            'content' => $article['content'] ?? $article['description'] ?? '',
                            'url' => $article['url'],
                            'urlToImage' => $article['urlToImage'] ?? $this->getTopicSpecificImage($article['title']),
                            'publishedAt' => $article['publishedAt'],
                            'source' => ['name' => $article['source']['name']],
                            'author' => $article['author'] ?? 'Unknown'
                        ];
                    }
                    
                    // Cache the articles
                    $this->cacheArticles($articles);
                    
                    Log::info("Successfully fetched " . count($articles) . " articles from News API");
                    
                    return response()->json([
                        'status' => 'success',
                        'data' => $articles,
                        'source' => 'newsapi',
                        'timestamp' => now()->toIso8601String()
                    ]);
                }
            }
            
            Log::warning("Failed to fetch articles from News API");
            return null;
            
        } catch (\Exception $e) {
            Log::error('Failed to fetch news from News API: ' . $e->getMessage());
            return null;
        }
    }
}