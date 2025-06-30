<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InternationalNewsController extends Controller
{
    /**
     * Display a listing of international news.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = $this->getNewsData();
        return view('international.index', compact('articles'));
    }

    /**
     * Show the specified international news article.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $articles = $this->getNewsData();
        
        // Find the article with the matching ID
        $article = null;
        foreach ($articles as $item) {
            if ($item['id'] === $id) {
                $article = $item;
                break;
            }
        }
        
        if (!$article) {
            // If article not found, use first article as fallback
            $article = $articles[0] ?? null;
        }
        
        return view('international.show', compact('article'));
    }

    /**
     * Get international news data for the API endpoint.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNews()
    {
        $articles = $this->getNewsData();
        
        return response()->json([
            'status' => 'success',
            'data' => $articles
        ]);
    }
    
    /**
     * Get sample news data.
     * 
     * @return array
     */
    private function getNewsData()
    {
        // For demonstration, we're using sample data
        // In a real app, you would connect to a news API like NewsAPI.org
        return [
            [
                'id' => 'tech-1',
                'source' => ['name' => 'Teknologi Today'],
                'title' => 'Teknologi Terbaru Revolusioner Ditemukan',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed semper malesuada auctor. Nam et dictum.',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed semper malesuada auctor. Nam et dictum dolor sit amet, consectetur adipiscing elit. Sed semper malesuada auctor. Nam et dictum. Penelitian terbaru telah menghasilkan terobosan teknologi yang memungkinkan transfer data berkecepatan tinggi tanpa menggunakan kabel atau sinyal nirkabel tradisional.',
                'urlToImage' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'publishedAt' => '2025-05-14T10:30:00Z',
                'url' => '#'
            ],
            [
                'id' => 'ent-1',
                'source' => ['name' => 'Entertainment Weekly'],
                'title' => 'Film Blockbuster Terbaru Pecahkan Rekor Box Office',
                'description' => 'Film terbaru yang dirilis akhir pekan ini berhasil memecahkan rekor box office global dengan pendapatan mencapai 1 miliar dollar dalam waktu singkat.',
                'content' => 'Film terbaru yang dirilis akhir pekan ini berhasil memecahkan rekor box office global dengan pendapatan mencapai 1 miliar dollar dalam waktu singkat. Para kritikus film memberikan ulasan positif terhadap akting dan efek visual yang ditampilkan. Film ini disebut-sebut akan mendapatkan sejumlah nominasi di ajang penghargaan film bergengsi tahun depan.',
                'urlToImage' => 'https://images.unsplash.com/photo-1585951237318-9ea5e175b891?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'publishedAt' => '2025-04-26T15:45:00Z',
                'url' => '#'
            ],
            [
                'id' => 'pol-1',
                'source' => ['name' => 'World Politics'],
                'title' => 'Konferensi Perdamaian Global Dimulai di New York',
                'description' => 'Para pemimpin dunia berkumpul di New York untuk membahas upaya perdamaian global dan kerjasama internasional dalam menghadapi tantangan global.',
                'content' => 'Para pemimpin dunia berkumpul di New York untuk membahas upaya perdamaian global dan kerjasama internasional dalam menghadapi tantangan global. Konferensi ini dihadiri oleh lebih dari 100 kepala negara dan diharapkan akan menghasilkan resolusi penting. Isu utama yang dibahas meliputi perubahan iklim, konflik regional, dan ketahanan ekonomi global pasca pandemi.',
                'urlToImage' => 'https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'publishedAt' => '2025-05-10T09:15:00Z',
                'url' => '#'
            ]
        ];
    }
}