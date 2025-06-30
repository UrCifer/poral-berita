document.addEventListener("DOMContentLoaded", function() {
    // Mobile menu toggling
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('translate-x-0');
            mobileMenu.classList.toggle('-translate-x-full');
            mobileMenu.classList.toggle('hidden');
        });
    }
    
    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', function() {
            mobileMenu.classList.add('-translate-x-full');
            mobileMenu.classList.remove('translate-x-0');
            setTimeout(() => {
                mobileMenu.classList.add('hidden');
            }, 300);
        });
    }
    
    // Back to top button
    const backToTopButton = document.getElementById('back-to-top');
    if (backToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
                backToTopButton.classList.add('opacity-100', 'visible');
            } else {
                backToTopButton.classList.remove('opacity-100', 'visible');
                backToTopButton.classList.add('opacity-0', 'invisible');
            }
        });
        
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Footer category links
    const footerCategoryLinks = document.querySelectorAll('footer a[href="#"]');
    footerCategoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const categoryText = this.textContent.trim();
            const categoryId = getCategoryIdByName(categoryText);
            if (categoryId) {
                e.preventDefault();
                window.location.href = '/posts?category=' + categoryId;
            }
        });
    });
    
    // Helper function to map category names to IDs
    function getCategoryIdByName(name) {
        const categoryMap = {
            'Politik': 1,
            'Teknologi': 2,
            'Olahraga': 3,
            'Hiburan': 4,
            'Pendidikan': 5,
            'Bisnis': 6
        };
        return categoryMap[name];
    }

    // Hero slider
    const heroSlides = document.querySelectorAll('.slide-item');
    const prevSlideBtn = document.getElementById('prev-slide');
    const nextSlideBtn = document.getElementById('next-slide');
    
    if (heroSlides.length > 0) {
        let currentSlide = 0;
        
        // Function to show a specific slide
        function showSlide(index) {
            heroSlides.forEach(slide => slide.classList.remove('active'));
            
            // Make sure index is within bounds
            if (index < 0) index = heroSlides.length - 1;
            if (index >= heroSlides.length) index = 0;
            
            currentSlide = index;
            heroSlides[currentSlide].classList.add('active');
        }
        
        // Event listeners for slide controls
        if (prevSlideBtn) {
            prevSlideBtn.addEventListener('click', () => showSlide(currentSlide - 1));
        }
        
        if (nextSlideBtn) {
            nextSlideBtn.addEventListener('click', () => showSlide(currentSlide + 1));
        }
        
        // Auto slide change
        setInterval(() => showSlide(currentSlide + 1), 5000);
    }

    // Berita Internasional: Fetch dan tampilkan berita
    const newsContainer = document.getElementById('international-news-container');
    
    if (newsContainer) {
        // Cache API response in sessionStorage
        const newsApiCacheKey = 'international_news_cache';
        const newsApiCacheTime = 'international_news_timestamp';
        const cacheExpiryTime = 30 * 60 * 1000; // 30 menit dalam milidetik
        
        function fetchAndDisplayNews() {
            // Cek apakah ada data yang tersimpan dalam cache dan masih berlaku
            const cachedTimestamp = sessionStorage.getItem(newsApiCacheTime);
            const cachedData = sessionStorage.getItem(newsApiCacheKey);
            const now = new Date().getTime();
            
            if (cachedData && cachedTimestamp && (now - cachedTimestamp < cacheExpiryTime)) {
                // Gunakan data dari cache jika masih berlaku
                displayNews(JSON.parse(cachedData));
            } else {
                // Fetch dari API jika cache sudah kadaluarsa atau tidak ada
                fetchNews();
            }
        }
        
        function fetchNews() {
            fetch('/api/international-news')
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        // Simpan data dalam cache
                        sessionStorage.setItem(newsApiCacheKey, JSON.stringify(result.data));
                        sessionStorage.setItem(newsApiCacheTime, new Date().getTime().toString());
                        
                        // Tampilkan berita
                        displayNews(result.data);
                    } else {
                        throw new Error(result.message || 'Failed to load news');
                    }
                })
                .catch(error => {
                    console.error('Error fetching news:', error);
                    newsContainer.innerHTML = `
                        <div class="col-span-full text-center py-8">
                            <p class="text-gray-500">Gagal memuat berita internasional. Silakan coba lagi nanti.</p>
                        </div>
                    `;
                });
        }
        
        function displayNews(articles) {
            // Hapus loading spinner
            newsContainer.innerHTML = '';
            
            // Batasi jumlah artikel yang ditampilkan di halaman utama
            const maxArticles = (window.location.pathname === '/' || window.location.pathname === '/home') ? 3 : articles.length;
            
            // Tampilkan berita
            articles.slice(0, maxArticles).forEach(article => {
                const newsCard = createNewsCard(article);
                newsContainer.appendChild(newsCard);
            });
        }
        
        // Fungsi untuk membuat kartu berita
        function createNewsCard(article) {
            const card = document.createElement('div');
            card.className = 'bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 h-full flex flex-col';
            
            // Format tanggal
            const publishDate = new Date(article.publishedAt);
            const formattedDate = publishDate.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
            
            // Tentukan URL gambar dengan fallback yang lebih baik
            let imageUrl;
            
            // Cek apakah URL gambar valid
            if (article.urlToImage && article.urlToImage !== 'null' && article.urlToImage !== 'undefined' && !article.urlToImage.includes('unavailable')) {
                imageUrl = article.urlToImage;
            } else {
                // Gunakan gambar fallback berdasarkan kategori berita atau sumber berita
                const sourceName = (article.source && article.source.name) ? article.source.name.toLowerCase() : '';
                
                if (sourceName.includes('politic') || sourceName.includes('world')) {
                    imageUrl = 'https://images.unsplash.com/photo-1612594181377-64ac85880ceb?q=80&w=800';
                } else if (sourceName.includes('tech')) {
                    imageUrl = 'https://images.unsplash.com/photo-1488590528505-98d2b5aba04b?q=80&w=800';
                } else if (sourceName.includes('health')) {
                    imageUrl = 'https://images.unsplash.com/photo-1631815584016-2ef8873d5170?q=80&w=800';
                } else if (sourceName.includes('space') || sourceName.includes('science')) {
                    imageUrl = 'https://images.unsplash.com/photo-1446776653964-20c1d3a81b06?q=80&w=800';
                } else if (sourceName.includes('art') || sourceName.includes('culture')) {
                    imageUrl = 'https://images.unsplash.com/photo-1580656449548-a223a88dce5c?q=80&w=800';
                } else {
                    // Default fallback image
                    imageUrl = 'https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=800';
                }
            }
            
            // Pastikan article.id ada, jika tidak buat ID baru
            const articleId = article.id || btoa(article.title).replace(/[^a-zA-Z0-9]/g, '');
            
            // Menggunakan route internasional untuk baca selengkapnya
            const articleUrl = `/berita-internasional/${encodeURIComponent(articleId)}`;
            
            // Format tanggal
            const date = new Date(article.publishedAt);
            const day = date.getDate().toString().padStart(2, '0');
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
            const month = monthNames[date.getMonth()];
            
            card.innerHTML = `
                <div class="relative">
                    <div class="absolute top-0 left-0 bg-indigo-600 text-white text-center py-1 px-3 m-2 rounded shadow">
                        <div class="text-center">
                            <span class="block text-lg font-bold leading-none">${day}</span>
                            <span class="block text-xs uppercase">${month}</span>
                        </div>
                    </div>
                    
                    <a href="${articleUrl}">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1 1'%3E%3C/svg%3E" 
                            data-src="${imageUrl}" 
                            alt="${article.title}" 
                            class="w-full h-48 object-cover lazy-load"
                            loading="lazy">
                    </a>
                    
                    <div class="absolute bottom-0 right-0 bg-indigo-700 text-white px-3 py-1 m-2 rounded-full text-xs font-semibold">
                        ${article.source.name}
                    </div>
                </div>
                
                <div class="p-6 flex-grow">
                    <h2 class="text-xl font-bold mb-3 line-clamp-2">
                        <a href="${articleUrl}" class="text-gray-800 hover:text-indigo-700">
                            ${article.title}
                        </a>
                    </h2>
                    
                    <p class="text-gray-600 mb-4 line-clamp-3">${article.description || 'No description available'}</p>
                </div>
                
                <div class="p-6 pt-0 mt-auto">
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <a href="${articleUrl}" class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-4 py-2 transition duration-300 flex items-center">
                            <span>Baca selengkapnya</span>
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        
                        <span class="text-gray-500 text-sm">${formattedDate}</span>
                    </div>
                </div>
            `;
            
            return card;
        }
        
        // Implementasi lazy loading untuk gambar
        function setupLazyLoading() {
            if ('IntersectionObserver' in window) {
                const lazyImageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const lazyImage = entry.target;
                            lazyImage.src = lazyImage.dataset.src;
                            lazyImage.classList.remove('lazy-load');
                            lazyImageObserver.unobserve(lazyImage);
                        }
                    });
                });
        
                document.querySelectorAll('.lazy-load').forEach(lazyImage => {
                    lazyImageObserver.observe(lazyImage);
                });
            } else {
                // Fallback untuk browser yang tidak mendukung IntersectionObserver
                document.querySelectorAll('.lazy-load').forEach(lazyImage => {
                    lazyImage.src = lazyImage.dataset.src;
                    lazyImage.classList.remove('lazy-load');
                });
            }
        }
        
        // Jalankan fetch berita
        fetchAndDisplayNews();
        
        // Setelah berita ditampilkan, setup lazy loading
        setTimeout(setupLazyLoading, 500);
    }
});