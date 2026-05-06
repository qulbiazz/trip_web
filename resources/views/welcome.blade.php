<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokachara - Jelajahi Keindahan Dunia</title>
    <meta name="description" content="Platform pemesanan travel terbaik untuk liburan impianmu.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Lokachara Brand Colors from Figma */
        .text-brand-blue { color: #1A6DFF; }
        .bg-brand-blue { background-color: #1A6DFF; }
        .hover\:bg-brand-blue-dark:hover { background-color: #1558CC; }
        
        .text-brand-green { color: #03C988; }
        .bg-brand-green { background-color: #03C988; }
        
        .text-brand-yellow { color: #FFCE3F; }
        .bg-brand-yellow { background-color: #FFCE3F; }
        
        .hover\:text-white:hover { color: #ffffff !important; }
        
        /* Gradients & Utilities */
        .bg-gradient-hero {
            background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.7) 100%);
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-50 selection:bg-brand-blue selection:text-white">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass-nav border-b border-gray-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center cursor-pointer" onclick="window.scrollTo(0,0)">
                    <div class="relative w-12 h-12 mr-2 flex items-center justify-center">        
                        <img src="{{ asset('images/logo.png') }}" alt="Lokachara" class="h-10">
                    </div>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#destinasi" class="text-gray-600 hover:text-brand-blue font-medium transition-colors">Destinasi</a>
                    <a href="#promo" class="text-gray-600 hover:text-brand-blue font-medium transition-colors">Promo</a>
                    @auth
                        <a href="{{ url('/admin') }}" class="text-gray-600 hover:text-brand-blue font-medium transition-colors">Dashboard Admin</a>
                    @else
                        <a href="{{ url('/admin/login') }}" class="text-gray-600 hover:text-brand-blue font-medium transition-colors">Login Admin</a>
                    @endauth
                    <a href="#destinasi" class="bg-brand-blue hover:bg-brand-blue-dark text-white px-6 py-2.5 rounded-full font-medium transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        Pesan Sekarang
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-20 pb-32 flex content-center items-center justify-center min-h-screen">
        <div class="absolute top-0 w-full h-full bg-center bg-cover" style="background-image: url('<?php echo asset('images/hero-bg.png'); ?>');">
            <span id="blackOverlay" class="w-full h-full absolute opacity-50 bg-black"></span>
            <!-- Beautiful Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-hero mix-blend-multiply"></div>
        </div>
        
        <div class="container relative mx-auto px-4 z-10 text-center">
            <div class="max-w-3xl mx-auto mt-16">
                <span class="inline-block py-1 px-3 rounded-full bg-brand-yellow text-gray-900 text-sm font-bold tracking-wider mb-6 shadow-sm">
                    ✨ TEMUKAN KEINDAHAN DUNIA
                </span>
                <h1 class="text-white font-bold text-5xl md:text-7xl leading-tight mb-6 drop-shadow-lg">
                    Perjalanan <span class="text-brand-green">Impianmu</span> Dimulai disini
                </h1>
                <p class="mt-4 text-xl md:text-2xl text-gray-200 mb-10 drop-shadow-md font-light">
                    Lokachara menghadirkan pengalaman liburan premium dengan harga terbaik. Jelajahi destinasi eksotis bersama kami.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#destinasi" class="bg-brand-blue hover:bg-brand-blue-dark text-white font-semibold px-8 py-4 rounded-full shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 text-lg">
                        Mulai Eksplorasi
                    </a>
                    <a href="#promo" class="bg-white hover:bg-gray-50 text-gray-900 font-semibold px-8 py-4 rounded-full shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 text-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2 text-brand-yellow" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Lihat Promo
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Decorative wave divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg class="w-full h-16 md:h-24 fill-current text-gray-50" viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
            </svg>
        </div>
    </div>

    <!-- Destinasi Section -->
    <section id="destinasi" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-base text-brand-blue font-semibold tracking-wide uppercase">Populer</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Destinasi Pilihan
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Pilih petualanganmu berikutnya dari daftar destinasi terbaik yang kami miliki.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse($destinasis as $destinasi)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden group cursor-pointer border border-gray-100">
                    <div class="relative h-64 overflow-hidden bg-gray-200">
                        @if($destinasi->gambar)
                            <img src="{{ asset('storage/' . $destinasi->gambar) }}" alt="{{ $destinasi->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400 group-hover:scale-110 transition-transform duration-500">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold text-brand-green flex items-center shadow-sm">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                            {{ $destinasi->lokasi }}
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-brand-blue transition-colors">{{ $destinasi->nama }}</h3>
                                <p class="text-sm text-gray-500">{{ $destinasi->negara }}</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-6 line-clamp-2">
                            {{ $destinasi->deskripsi ?? 'Jelajahi keindahan tersembunyi dan nikmati pengalaman liburan yang tak terlupakan di destinasi spektakuler ini.' }}
                        </p>
                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Mulai dari</p>
                                <p class="text-lg font-bold text-gray-900">Rp {{ number_format($destinasi->harga_dasar, 0, ',', '.') }}</p>
                            </div>
                            <a href="{{ route('destinasi.show', $destinasi->id) }}" class="bg-brand-blue/10 text-brand-blue border border-brand-blue hover:bg-brand-blue hover:text-white px-5 py-2 rounded-lg font-medium transition-colors text-center inline-block">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500 text-lg">Belum ada destinasi wisata yang aktif saat ini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Promos Section -->
    <section id="promo" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-brand-blue rounded-3xl overflow-hidden shadow-2xl relative">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 -mt-16 -mr-16 text-white opacity-10">
                    <svg width="300" height="300" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                </div>
                <div class="absolute bottom-0 left-0 -mb-16 -ml-16 w-64 h-64 bg-brand-yellow rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
                <div class="absolute top-0 right-0 w-64 h-64 bg-brand-green rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
                
                <div class="relative px-6 py-16 sm:px-12 lg:px-16 flex flex-col lg:flex-row items-center justify-between">
                    <div class="lg:w-1/3 mb-10 lg:mb-0 text-center lg:text-left">
                        <h2 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl mb-4">
                            Promo Spesial!
                        </h2>
                        <p class="text-xl text-blue-100 max-w-3xl">
                            Dapatkan penawaran eksklusif dan diskon menarik untuk liburan hemat tanpa mengurangi kenyamanan.
                        </p>
                    </div>
                    
                    <div class="lg:w-2/3 flex flex-col sm:flex-row gap-6 justify-end w-full">
                        @forelse($promos as $promo)
                        <div class="bg-white rounded-xl p-6 shadow-lg flex-1 transform transition hover:-translate-y-2 hover:shadow-xl relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-16 h-16 bg-brand-yellow transform rotate-45 translate-x-8 -translate-y-8"></div>
                            <div class="relative z-10">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $promo->nama }}</h3>
                                <div class="inline-block bg-green-100 text-brand-green font-mono font-bold px-3 py-1 rounded border border-green-200 mb-4 tracking-widest text-lg">
                                    {{ $promo->kode }}
                                </div>
                                <p class="text-gray-600 text-sm mb-4">
                                    Diskon {{ $promo->tipe_diskon == 'persentase' ? number_format($promo->nilai_diskon, 0) . '%' : 'Rp ' . number_format($promo->nilai_diskon, 0, ',', '.') }}
                                </p>
                                <div class="text-xs text-gray-500 border-t border-gray-100 pt-3">
                                    Berlaku s/d {{ \Carbon\Carbon::parse($promo->expired_at)->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-white/20 text-white w-full text-center">
                            <p class="text-lg">Tunggu promo menarik dari kami selanjutnya!</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 pt-16 pb-8 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-6">
                        <div class="relative w-12 h-12 mr-2 flex items-center justify-center">        
                        <img src="{{ asset('images/logo.png') }}" alt="Lokachara" class="h-10">
                    </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-sm">
                        Kami percaya setiap perjalanan memiliki cerita. Lokachara hadir untuk memastikan ceritamu tak terlupakan, dengan layanan travel tepercaya, aman, dan memuaskan.
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Layanan</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-brand-yellow transition-colors text-sm">Pesan Tiket</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-brand-yellow transition-colors text-sm">Destinasi Internasional</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-brand-yellow transition-colors text-sm">Destinasi Domestik</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-brand-yellow transition-colors text-sm">Tour Guide</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Perusahaan</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-brand-yellow transition-colors text-sm">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-brand-yellow transition-colors text-sm">Kontak</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-brand-yellow transition-colors text-sm">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-brand-yellow transition-colors text-sm">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm">
                    &copy; {{ date('Y') }} Lokachara Travel. All rights reserved.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-500 hover:text-white">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-white">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Navbar blur and shadow on scroll
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 10) {
                nav.classList.add('shadow-sm');
                nav.classList.add('bg-white/95');
                nav.classList.remove('glass-nav');
            } else {
                nav.classList.remove('shadow-sm');
                nav.classList.remove('bg-white/95');
                nav.classList.add('glass-nav');
            }
        });
    </script>
</body>
</html>
