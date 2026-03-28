<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ get_setting('app_name', 'Kos') }}{{ get_setting('app_name_suffix', 'Admin') }} — Solusi Hunian Nyaman dan Terpercaya</title>
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>

    <!-- Navigation -->
    <nav id="navbar">
        <div class="container nav-content">
            <a href="/" class="logo">
                <div class="icon">
                    <i class="ph-bold ph-house-line"></i>
                </div>
                <span>{{ get_setting('app_name', 'Kos') }}</span>{{ get_setting('app_name_suffix', 'Admin') }}
            </a>
            
            <div class="nav-links">
                <a href="#featured">Koleksi</a>
                <a href="#areas">Area Populer</a>
                <a href="#about">Tentang Kami</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn-auth">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" style="font-weight: 700; color: var(--text-main);">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-auth">Daftar Sekarang</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" style="background-image: linear-gradient(rgba(255, 255, 255, 0.85), rgba(255, 255, 255, 0.9)), url('{{ asset('images/hero-bg.png') }}');">
        <div class="container">
            <span class="hero-tag reveal-up">#1 Platform Cari Kos Indonesia</span>
            <h1 class="reveal-up">
                Temukan <span>Kenyamanan</span><br>di Mana Pun Anda Berada.
            </h1>
            <p class="reveal-up" style="transition-delay: 0.1s;">
                Ribuan pilihan kos eksklusif dengan fasilitas lengkap dan harga transparan di lokasi-lokasi strategis seluruh Indonesia.
            </p>

            <!-- Search Bar -->
            <div class="search-container reveal-up" style="transition-delay: 0.2s;">
                <div class="search-field">
                    <label><i class="ph ph-map-pin"></i> Lokasi</label>
                    <input type="text" placeholder="Mau tinggal di mana?">
                </div>
                <div class="search-field">
                    <label><i class="ph ph-squares-four"></i> Kategori</label>
                    <select>
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="search-field">
                    <label><i class="ph ph-currency-circle-dollar"></i> Budget</label>
                    <select>
                        <option value="">Rentang Harga</option>
                        <option value="1">Di bawah 2jt</option>
                        <option value="2">2jt - 5jt</option>
                        <option value="3">Di atas 5jt</option>
                    </select>
                </div>
                <button class="btn-search">
                    <i class="ph-bold ph-magnifying-glass"></i> Cari Kos
                </button>
            </div>
        </div>
    </section>

    <!-- Popular Areas -->
    <section id="areas" class="container">
        <div class="section-header reveal-up">
            <div>
                <h2>Area Populer</h2>
                <p>Eksplorasi pilihan hunian terbaik di kota-kota besar yang kami kurasi khusus untuk Anda.</p>
            </div>
            <a href="#" style="color: var(--primary); font-weight: 700; text-decoration: none;">Lihat Semua Kota <i class="ph ph-arrow-right"></i></a>
        </div>

        <div class="area-grid">
            <a href="#" class="area-card reveal-in">
                <img src="{{ asset('images/jakarta.png') }}" alt="Jakarta">
                <div class="area-overlay">
                    <h3>Jakarta</h3>
                    <p>840+ Properti Tersedia</p>
                </div>
            </a>
            @foreach($categories->take(2) as $category)
            <a href="#" class="area-card reveal-in" style="transition-delay: {{ 0.1 * $loop->iteration }}s;">
                <img src="https://images.unsplash.com/photo-1555881400-74d7acaacd8b?auto=format&fit=crop&w=800&q=80" alt="{{ $category->name }}">
                <div class="area-overlay">
                    <h3>{{ $category->name }}</h3>
                    <p>120+ Properti Tersedia</p>
                </div>
            </a>
            @endforeach
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works container">
        <div class="section-header reveal-up" style="display: block; text-align: center;">
            <h2 style="margin-bottom: 10px;">Cara Mudah Cari Kos</h2>
            <p style="margin: 0 auto;">Tiga langkah sederhana untuk menemukan hunian impian Anda.</p>
        </div>

        <div class="steps-grid">
            <div class="step-item reveal-up">
                <div class="step-icon"><i class="ph ph-magnifying-glass"></i></div>
                <h3>Cari Lokasi</h3>
                <p>Masukkan nama kota atau area populer untuk mulai mencari.</p>
                <div class="step-arrow">
                    <svg width="100" height="20" viewBox="0 0 100 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 10C30 10 70 10 99 10" stroke="currentColor" stroke-width="2" stroke-dasharray="4 4"/>
                        <path d="M90 5L100 10L90 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
            <div class="step-item reveal-up" style="transition-delay: 0.1s;">
                <div class="step-icon"><i class="ph ph-house"></i></div>
                <h3>Pilih Hunian</h3>
                <p>Bandingkan fasilitas dan harga transparan dari berbagai pilihan.</p>
                <div class="step-arrow">
                    <svg width="100" height="20" viewBox="0 0 100 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 10C30 10 70 10 99 10" stroke="currentColor" stroke-width="2" stroke-dasharray="4 4"/>
                        <path d="M90 5L100 10L90 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
            <div class="step-item reveal-up" style="transition-delay: 0.2s;">
                <div class="step-icon"><i class="ph ph-calendar-check"></i></div>
                <h3>Booking & Survei</h3>
                <p>Jadwalkan kunjungan atau booking langsung dengan aman.</p>
            </div>
        </div>
    </section>

    <!-- Featured Listings -->
    <section id="featured" style="background-color: var(--bg-light);">
        <div class="container">
            <div class="section-header reveal-up">
                <div>
                    <h2>Elite Collection</h2>
                    <p>Koleksi kos pilihan dengan fasilitas premium dan level keamanan terbaik.</p>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button class="btn-icon" style="background: #fff; border: 1px solid var(--border-light); width: 44px; height: 44px; border-radius: 50%;"><i class="ph ph-caret-left"></i></button>
                    <button class="btn-icon" style="background: var(--primary); color: #fff; border: none; width: 44px; height: 44px; border-radius: 50%;"><i class="ph ph-caret-right"></i></button>
                </div>
            </div>

            <div class="listing-grid">
                @forelse($featured_listings as $listing)
                    <div class="property-card reveal-up" style="transition-delay: {{ 0.05 * $loop->iteration }}s;">
                        <div class="property-img">
                            <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80" alt="{{ $listing->name }}">
                            @if($listing->is_premium)
                                <span class="property-badge">Premium</span>
                            @endif
                            <div class="property-fav"><i class="ph ph-heart"></i></div>
                        </div>
                        <div class="property-body">
                            <div class="property-price">Rp {{ number_format($listing->price / 1000, 0) }}rb <span>/ bulan</span></div>
                            <h3 class="property-title">{{ Str::limit($listing->name, 30) }}</h3>
                            <div class="property-loc">
                                <i class="ph ph-map-pin"></i> {{ Str::limit($listing->address, 45) }}
                            </div>
                            <div class="property-amenities">
                                <div class="amenity"><i class="ph ph-wifi-high"></i> WiFi</div>
                                <div class="amenity"><i class="ph ph-thermometer-simple"></i> AC</div>
                                <div class="amenity"><i class="ph ph-shower"></i> K. Mandi Dalam</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; color: var(--text-muted); padding: 40px;">Belum ada hunian pilihan saat ini.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Latest Listings -->
    <section class="container">
        <div class="section-header reveal-up">
            <div>
                <h2>Baru Saja Bergabung</h2>
                <p>Jadilah yang pertama untuk menghuni kos-kosan terbaru dengan harga promo.</p>
            </div>
        </div>

        <div class="listing-grid">
            @forelse($latest_listings->take(3) as $listing)
                <div class="property-card reveal-up" style="transition-delay: {{ 0.05 * $loop->iteration }}s;">
                    <div class="property-img">
                        <img src="https://images.unsplash.com/photo-1493809842364-78817add7ffb?auto=format&fit=crop&w=800&q=80" alt="{{ $listing->name }}">
                        <div class="property-fav"><i class="ph ph-heart"></i></div>
                    </div>
                    <div class="property-body">
                        <div class="property-price">Rp {{ number_format($listing->price / 1000, 0) }}rb <span>/ bulan</span></div>
                        <h3 class="property-title">{{ Str::limit($listing->name, 30) }}</h3>
                        <div class="property-loc">
                            <i class="ph ph-map-pin"></i> {{ Str::limit($listing->address, 45) }}
                        </div>
                        <div class="property-amenities">
                            <div class="amenity"><i class="ph ph-bed"></i> Single Bed</div>
                            <div class="amenity"><i class="ph ph-car"></i> Parkir</div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Handled -->
            @endforelse
        </div>
        
        <div style="text-align: center; margin-top: 60px;" class="reveal-up">
            <button class="btn-auth" style="padding: 16px 40px; font-size: 1rem;">Lihat Katalog Lengkap</button>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="/" class="logo">
                        <div class="icon">
                            <i class="ph-bold ph-house-line"></i>
                        </div>
                        <span>{{ get_setting('app_name', 'Kos') }}</span>{{ get_setting('app_name_suffix', 'Admin') }}
                    </a>
                    <p>Membantu Anda menemukan rumah kedua dengan cara yang paling efisien, transparan, dan terpercaya di Indonesia.</p>
                    <div style="display: flex; gap: 15px; font-size: 1.5rem;">
                        <a href="#" style="color: var(--primary);"><i class="ph ph-instagram-logo"></i></a>
                        <a href="#" style="color: var(--primary);"><i class="ph ph-facebook-logo"></i></a>
                        <a href="#" style="color: var(--primary);"><i class="ph ph-twitter-logo"></i></a>
                    </div>
                </div>
                
                <div class="footer-links">
                    <h4>Perusahaan</h4>
                    <ul>
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Karir</a></li>
                        <li><a href="#">Hubungi Kami</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>

                <div class="footer-links">
                    <h4>Bantuan</h4>
                    <ul>
                        <li><a href="#">Pusat Bantuan</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Tips Cari Kos</a></li>
                    </ul>
                </div>

                <div class="footer-links">
                    <h4>Lainnya</h4>
                    <ul>
                        <li><a href="#">Jadi Partner</a></li>
                        <li><a href="#">Aplikasi Mobile</a></li>
                        <li><a href="#">Koleksi Premium</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div>&copy; {{ date('Y') }} {{ get_setting('app_name', 'Kos') }}. Seluruh hak cipta dilindungi.</div>
                <div style="display: flex; gap: 20px;">
                    <span>Indonesia</span>
                    <span>Bahasa Indonesia</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Navbar scrolled state
        const nav = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) nav.classList.add('scrolled');
            else nav.classList.remove('scrolled');
        });

        // Intersection Observer for reveal animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal-up, .reveal-in').forEach(el => observer.observe(el));
    </script>

</body>
</html>
