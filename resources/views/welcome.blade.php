<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteSetting->site_name ?? 'Lokachara' }} - Jelajahi Keindahan Dunia</title>
    <meta name="description" content="Platform pemesanan travel terbaik untuk liburan impianmu.">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Lokachara Brand Colors from Figma */
        .text-brand-blue {
            color: #1A6DFF;
        }

        .bg-brand-blue {
            background-color: #1A6DFF;
        }

        .hover\:bg-brand-blue-dark:hover {
            background-color: #1558CC;
        }

        .text-brand-green {
            color: #03C988;
        }

        .bg-brand-green {
            background-color: #03C988;
        }

        .text-brand-yellow {
            color: #FFCE3F;
        }

        .bg-brand-yellow {
            background-color: #FFCE3F;
        }

        .hover\:text-white:hover {
            color: #ffffff !important;
        }

        /* Gradients & Utilities */
        .bg-gradient-hero {
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 100%);
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-800 bg-gray-50 selection:bg-brand-blue selection:text-white">

    <nav class="fixed w-full z-50 bg-white border-b border-gray-100 transition-all duration-300 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center cursor-pointer" onclick="window.scrollTo(0,0)">
                    <div class="relative w-12 h-12 mr-2 flex items-center justify-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Lokachara" class="h-10">
                    </div>
                </div>

                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#destinasi"
                        class="text-gray-600 hover:text-brand-blue font-medium transition-colors">Destinasi</a>
                    <a href="#promo" class="text-gray-600 hover:text-brand-blue font-medium transition-colors">Promo</a>
                    <a href="#lokasi"
                        class="text-gray-600 hover:text-brand-blue font-medium transition-colors">Lokasi</a>
                    {{-- @auth
                    <a href="{{ url('/admin') }}"
                        class="text-gray-600 hover:text-brand-blue font-medium transition-colors">Dashboard Admin</a>
                    @else
                    <a href="{{ url('/admin/login') }}"
                        class="text-gray-600 hover:text-brand-blue font-medium transition-colors">Login Admin</a>
                    @endauth --}}
                    <a href="#destinasi"
                        class="bg-brand-blue hover:bg-brand-blue-dark text-white px-6 py-2.5 rounded-full font-medium transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        Pesan Sekarang
                    </a>
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn"
                        class="text-gray-600 hover:text-brand-blue focus:outline-none p-2 rounded-md hover:bg-gray-100 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path id="menu-icon-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path id="menu-icon-close" class="hidden" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu"
            class="hidden md:hidden bg-white border-t border-gray-100 shadow-xl absolute w-full transition-all duration-300 origin-top">
            <div class="px-4 pt-2 pb-6 space-y-2 flex flex-col">
                <a href="#destinasi"
                    class="block px-4 py-3 rounded-md text-base font-medium text-gray-700 hover:text-brand-blue hover:bg-blue-50 transition-colors mobile-link">Destinasi</a>
                <a href="#promo"
                    class="block px-4 py-3 rounded-md text-base font-medium text-gray-700 hover:text-brand-blue hover:bg-blue-50 transition-colors mobile-link">Promo</a>
                <a href="#lokasi"
                    class="block px-4 py-3 rounded-md text-base font-medium text-gray-700 hover:text-brand-blue hover:bg-blue-50 transition-colors mobile-link">Lokasi</a>
                {{-- @auth
                <a href="{{ url('/admin') }}"
                    class="block px-4 py-3 rounded-md text-base font-medium text-gray-700 hover:text-brand-blue hover:bg-blue-50 transition-colors mobile-link">Dashboard
                    Admin</a>
                @else
                <a href="{{ url('/admin/login') }}"
                    class="block px-4 py-3 rounded-md text-base font-medium text-gray-700 hover:text-brand-blue hover:bg-blue-50 transition-colors mobile-link">Login
                    Admin</a>
                @endauth --}}
                <div class="pt-4 mt-2 border-t border-gray-100">
                    <a href="#destinasi"
                        class="block w-full text-center bg-brand-blue hover:bg-brand-blue-dark text-white px-6 py-3 rounded-full font-medium transition-colors shadow-md mobile-link">
                        Pesan Sekarang
                    </a>
                </div>
            </div>
        </div>
    </nav>


    <div class="relative pt-20 pb-32 flex content-center items-center justify-center min-h-screen">

        @if($jadwalOpen->isNotEmpty())
            <div
                class="absolute top-20 w-full z-30 bg-brand-yellow/95 backdrop-blur-sm border-b border-yellow-400 shadow-md">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2.5">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-2 text-sm">
                        <div class="flex items-center space-x-3 text-gray-900">
                            <span class="relative flex h-3 w-3 flex-shrink-0">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-600"></span>
                            </span>

                            <span class="font-medium text-center sm:text-left line-clamp-1 sm:line-clamp-none">
                                <strong class="uppercase font-extrabold tracking-wide text-red-600">Kuota
                                    Terbatas!</strong> Siap-siap berangkat untuk trip terdekat:

                                @foreach($jadwalOpen as $jadwal)
                                    <span class="font-bold">{{ $jadwal->destinasi->nama }}</span>
                                    ({{ $jadwal->tanggal_berangkat->translatedFormat('d M') }})
                                    @if(!$loop->last) <span class="mx-1">&bull;</span> @endif
                                @endforeach
                            </span>
                        </div>

                        <a href="#destinasi"
                            class="inline-flex items-center font-bold text-brand-blue hover:text-brand-blue-dark transition-colors whitespace-nowrap">
                            Amankan Seat Sekarang
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endif
        @php
            $heroBg = (isset($siteSetting) && $siteSetting->hero_image)
                ? asset('storage/' . $siteSetting->hero_image)
                : asset('images/hero-bg.png');
        @endphp
        <div class="absolute top-0 w-full h-full bg-center bg-cover"
            style="background-image: url('{{ $heroBg }}');">
            <span id="blackOverlay" class="w-full h-full absolute opacity-50 bg-black"></span>
            <div class="absolute inset-0 bg-gradient-hero mix-blend-multiply"></div>
        </div>

        <div class="container relative mx-auto px-4 z-10 text-center">
            <div class="max-w-3xl mx-auto mt-16">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-brand-yellow text-gray-900 text-sm font-bold tracking-wider mb-6 shadow-sm">
                    {{ $siteSetting->hero_badge ?? 'TEMUKAN KEINDAHAN DUNIA' }}
                </span>
                <h1 class="text-white font-bold text-5xl md:text-7xl leading-tight mb-6 drop-shadow-lg">
                    @if(isset($siteSetting) && ($siteSetting->hero_title || $siteSetting->hero_highlight))
                        {{ $siteSetting->hero_title }} <span
                            class="text-brand-green">{{ $siteSetting->hero_highlight }}</span>
                    @else
                        Perjalanan <span class="text-brand-green">Impianmu</span> Dimulai disini
                    @endif
                </h1>
                <p class="mt-4 text-xl md:text-2xl text-gray-200 mb-10 drop-shadow-md font-light">
                    {{ $siteSetting->hero_description ?? 'Lokachara menghadirkan pengalaman liburan premium dengan harga terbaik. Jelajahi destinasi eksotis bersama kami.' }}
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#destinasi"
                        class="bg-brand-blue hover:bg-brand-blue-dark text-white font-semibold px-8 py-4 rounded-full shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 text-lg">
                        {{ $siteSetting->cta_primary_text ?? 'Mulai Eksplorasi' }}
                    </a>
                    <a href="#promo"
                        class="bg-white hover:bg-gray-50 text-gray-900 font-semibold px-8 py-4 rounded-full shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 text-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2 text-brand-yellow" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        {{ $siteSetting->cta_secondary_text ?? 'Lihat Promo' }}
                    </a>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0">
            <svg class="w-full h-16 md:h-24 fill-current text-gray-50" viewBox="0 0 1440 120"
                preserveAspectRatio="none">
                <path
                    d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z">
                </path>
            </svg>
        </div>
    </div>

    <section id="keunggulan" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-base text-brand-blue font-semibold tracking-wide uppercase">Mengapa Memilih Kami</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Keunggulan Lokachara
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Kami berkomitmen memberikan pengalaman liburan terbaik dengan layanan yang tak tertandingi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div
                    class="bg-gray-50 rounded-2xl p-8 text-center hover:-translate-y-2 transition-transform duration-300 border border-gray-100">
                    <div
                        class="w-16 h-16 mx-auto bg-blue-100 text-brand-blue rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Harga Terbaik</h3>
                    <p class="text-gray-600 text-sm">Penawaran harga transparan tanpa biaya tersembunyi untuk setiap
                        destinasi.</p>
                </div>
                <div
                    class="bg-gray-50 rounded-2xl p-8 text-center hover:-translate-y-2 transition-transform duration-300 border border-gray-100">
                    <div
                        class="w-16 h-16 mx-auto bg-green-100 text-brand-green rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Layanan 24/7</h3>
                    <p class="text-gray-600 text-sm">Tim support kami selalu siap membantu Anda kapanpun dan dimanapun
                        berada.</p>
                </div>
                <div
                    class="bg-gray-50 rounded-2xl p-8 text-center hover:-translate-y-2 transition-transform duration-300 border border-gray-100">
                    <div
                        class="w-16 h-16 mx-auto bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Destinasi Eksklusif</h3>
                    <p class="text-gray-600 text-sm">Pilihan destinasi liburan yang dikurasi khusus untuk memberikan
                        pengalaman unik.</p>
                </div>
                <div
                    class="bg-gray-50 rounded-2xl p-8 text-center hover:-translate-y-2 transition-transform duration-300 border border-gray-100">
                    <div
                        class="w-16 h-16 mx-auto bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pembayaran Aman</h3>
                    <p class="text-gray-600 text-sm">Sistem pembayaran terenkripsi yang menjamin keamanan setiap
                        transaksi Anda.</p>
                </div>
            </div>
        </div>
    </section>

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
                    <div
                        class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden group cursor-pointer border border-gray-100">
                        <div class="relative h-64 overflow-hidden bg-gray-200">
                            @if($destinasi->gambar)
                                <img src="{{ asset('storage/' . $destinasi->gambar) }}" alt="{{ $destinasi->nama }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400 group-hover:scale-110 transition-transform duration-500">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                            <div
                                class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold text-brand-green flex items-center shadow-sm">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $destinasi->lokasi }}
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3
                                        class="text-xl font-bold text-gray-900 mb-1 group-hover:text-brand-blue transition-colors">
                                        {{ $destinasi->nama }}
                                    </h3>
                                    <p class="text-sm text-gray-500">{{ $destinasi->negara }}</p>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm mb-6 line-clamp-2">
                                {{ $destinasi->deskripsi ?? 'Jelajahi keindahan tersembunyi dan nikmati pengalaman liburan yang tak terlupakan di destinasi spektakuler ini.' }}
                            </p>
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Mulai dari</p>
                                    <p class="text-lg font-bold text-gray-900">Rp
                                        {{ number_format($destinasi->harga_dasar ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>
                                <a href="{{ route('destinasi.show', $destinasi->id) }}"
                                    class="bg-brand-blue/10 text-brand-blue border border-brand-blue hover:bg-brand-blue hover:text-white px-5 py-2 rounded-lg font-medium transition-colors text-center inline-block">
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

    <section id="promo" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-brand-blue rounded-3xl overflow-hidden shadow-2xl relative">
                <div class="absolute top-0 right-0 -mt-16 -mr-16 text-white opacity-10">
                    <svg width="300" height="300" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                    </svg>
                </div>
                <div
                    class="absolute bottom-0 left-0 -mb-16 -ml-16 w-64 h-64 bg-brand-yellow rounded-full mix-blend-multiply filter blur-3xl opacity-50">
                </div>
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-brand-green rounded-full mix-blend-multiply filter blur-3xl opacity-50">
                </div>

                <div
                    class="relative px-6 py-16 sm:px-12 lg:px-16 flex flex-col lg:flex-row items-center justify-between">
                    <div class="lg:w-1/3 mb-10 lg:mb-0 text-center lg:text-left">
                        <h2 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl mb-4">
                            Promo Spesial!
                        </h2>
                        <p class="text-xl text-blue-100 max-w-3xl">
                            Dapatkan penawaran eksklusif dan diskon menarik untuk liburan hemat tanpa mengurangi
                            kenyamanan.
                        </p>
                    </div>

                    <div class="lg:w-2/3 flex flex-col sm:flex-row gap-6 justify-end w-full">
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 text-white w-full text-center sm:text-left flex flex-col justify-between">
                            <div>
                                <h3 class="text-2xl font-bold mb-3 flex items-center justify-center sm:justify-start gap-2">
                                    <svg class="w-6 h-6 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Cari Info Promo di Medsos Kami!
                                </h3>
                                <p class="text-blue-100 mb-6 text-sm sm:text-base leading-relaxed">
                                    Kode promo dan penawaran spesial kini dibagikan secara eksklusif melalui media sosial resmi kami. Pastikan Anda mengikuti akun kami agar tidak ketinggalan informasi promo menarik berikutnya!
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-4 justify-center sm:justify-start">
                                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white font-semibold px-5 py-2.5 rounded-full transition-all shadow-md transform hover:-translate-y-0.5">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                    </svg>
                                    Instagram
                                </a>
                                <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-full transition-all shadow-md transform hover:-translate-y-0.5">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    Facebook
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-gray-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="absolute top-0 left-0 -mt-20 -ml-20 w-40 h-40 bg-brand-blue/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 -mb-20 -mr-20 w-40 h-40 bg-brand-yellow/20 rounded-full blur-3xl">
            </div>

            <div class="text-center mb-16 relative z-10">
                <h2 class="text-base text-brand-blue font-semibold tracking-wide uppercase">Testimoni</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Apa Kata Mereka?
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Cerita dan pengalaman liburan tak terlupakan dari pelanggan setia Lokachara.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
                @forelse($testimonis as $index => $testimoni)
                    @php
                        // Dynamic avatar classes
                        $bgClasses = ['bg-blue-100 text-brand-blue', 'bg-green-100 text-brand-green', 'bg-yellow-100 text-yellow-600'];
                        $avatarClass = $bgClasses[$index % count($bgClasses)];

                        // Dynamic premium translation for middle cards (2nd card, 5th card, etc.)
                        $transformClass = ($index % 3 === 1) ? 'transform md:-translate-y-4' : '';

                        // Extract initial
                        $initial = strtoupper(substr($testimoni->nama, 0, 1));
                    @endphp
                    <div
                        class="bg-white rounded-3xl p-8 shadow-sm hover:shadow-lg transition-shadow duration-300 relative border border-gray-100 {{ $transformClass }}">
                        <svg class="absolute top-6 right-6 w-10 h-10 text-gray-200" fill="currentColor" viewBox="0 0 32 32"
                            aria-hidden="true">
                            <path
                                d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z">
                            </path>
                        </svg>
                        <div class="flex items-center mb-6">
                            <div
                                class="h-12 w-12 rounded-full {{ $avatarClass }} flex items-center justify-center font-bold text-xl mr-4">
                                {{ $initial }}
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">{{ $testimoni->nama }}</h4>
                                <div class="flex text-brand-yellow text-sm">
                                    {{ str_repeat('★', $testimoni->rating) }}
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 leading-relaxed italic">
                            "{{ $testimoni->konten }}"
                        </p>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12">
                        <p class="text-gray-500 text-lg">Belum ada testimoni aktif saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="lokasi" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-base text-brand-blue font-semibold tracking-wide uppercase">Lokasi Kami</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Kunjungi Kantor Kami
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Temukan kami dengan mudah dan rencanakan liburanmu langsung bersama travel consultant kami.
                </p>
            </div>

            <div
                class="flex flex-col lg:flex-row bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
                <div class="w-full lg:w-5/12 p-8 lg:p-12 flex flex-col justify-center bg-white relative z-10">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-brand-blue/5 rounded-bl-full -z-10"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-brand-yellow/10 rounded-tr-full -z-10"></div>

                    <h3 class="text-3xl font-bold text-gray-900 mb-8">Hubungi Kami</h3>

                    <div class="space-y-8">
                        <div class="flex items-start group">
                            <div
                                class="flex-shrink-0 w-14 h-14 bg-blue-50 text-brand-blue rounded-2xl flex items-center justify-center group-hover:bg-brand-blue group-hover:text-white transition-colors shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h4 class="text-lg font-bold text-gray-900">Alamat Kantor</h4>
                                <p class="mt-1 text-gray-500 leading-relaxed">Jl. Bareng Tengah V No.816, Bareng, Kec.
                                    Klojen<br>Kota Malang, Jawa Timur 65116, Indonesia</p>
                            </div>
                        </div>

                        <div class="flex items-start group">
                            <div
                                class="flex-shrink-0 w-14 h-14 bg-green-50 text-brand-green rounded-2xl flex items-center justify-center group-hover:bg-brand-green group-hover:text-white transition-colors shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h4 class="text-lg font-bold text-gray-900">Kontak</h4>
                                <p class="mt-1 text-gray-500 leading-relaxed"><span
                                        class="block hover:text-brand-blue cursor-pointer transition-colors">+62 21 5555
                                        1234</span><span
                                        class="block hover:text-brand-blue cursor-pointer transition-colors">halo@lokachara.com</span>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start group">
                            <div
                                class="flex-shrink-0 w-14 h-14 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center group-hover:bg-brand-yellow group-hover:text-white transition-colors shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h4 class="text-lg font-bold text-gray-900">Jam Operasional</h4>
                                <p class="mt-1 text-gray-500 leading-relaxed">Senin - Jumat: 09:00 - 18:00<br>Sabtu:
                                    09:00 - 14:00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-7/12 min-h-[400px] lg:min-h-full relative">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3606.4941292208273!2d112.61772747460076!3d-7.978816579549072!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd6296d5bab0c33%3A0x38bf0d78e7dab133!2sSewa%20mobil%20malang%20%7C%20JackTrans%20tour%20%26%20travel!5e1!3m2!1sen!2sid!4v1780231398433!5m2!1sen!2sid"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>

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
                        Kami percaya setiap perjalanan memiliki cerita. Lokachara hadir untuk memastikan ceritamu tak
                        terlupakan, dengan layanan travel tepercaya, aman, dan memuaskan.
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Layanan</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-brand-yellow transition-colors text-sm">Pesan
                                Tiket</a></li>
                        <li><a href="#destinasi"
                                class="text-gray-400 hover:text-brand-yellow transition-colors text-sm">Destinasi Jawa
                                Timur</a></li>
                        <li><a href="#destinasi"
                                class="text-gray-400 hover:text-brand-yellow transition-colors text-sm">Destinasi Luar
                                Jawa Timur</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-brand-yellow transition-colors text-sm">Tour
                                Guide</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Perusahaan</h3>
                    <ul class="space-y-3">
                        <li><a href="#keunggulan"
                                class="text-gray-400 hover:text-brand-yellow transition-colors text-sm">Tentang Kami</a>
                        </li>
                        <li><a href="#lokasi"
                                class="text-gray-400 hover:text-brand-yellow transition-colors text-sm">Kontak</a></li>
                        {{-- <li><a href="#"
                                class="text-gray-400 hover:text-brand-yellow transition-colors text-sm">Kebijakan
                                Privasi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-brand-yellow transition-colors text-sm">Syarat &
                                Ketentuan</a></li> --}}
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm">
                    © {{ date('Y') }} Lokachara Travel. Hak cipta dilindungi.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-500 hover:text-white">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-white">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Guide Button (Bottom Right) -->
    <button id="guide-fab" class="fixed bottom-6 right-6 z-40 bg-brand-blue hover:bg-brand-blue-dark text-white p-4 rounded-full shadow-2xl transition-all transform hover:scale-110 flex items-center justify-center gap-2 group">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="max-w-0 overflow-hidden group-hover:max-w-xs transition-all duration-300 ease-out font-semibold text-sm whitespace-nowrap">
            Panduan Pemesanan
        </span>
    </button>

    <!-- Tutorial Modal Container (Hidden by Default) -->
    <div id="tutorial-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <!-- Backdrop -->
        <div id="tutorial-backdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300 opacity-0"></div>
        
        <!-- Modal Card -->
        <div class="relative bg-white rounded-3xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl border border-gray-100 transform transition-all scale-95 opacity-0 duration-300 z-10" id="tutorial-card">
            <!-- Close button -->
            <button id="close-tutorial" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 focus:outline-none p-2 rounded-full hover:bg-gray-100 transition-colors z-20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="p-8">
                <!-- Step Progress Indicator -->
                <div class="flex justify-between items-center mb-8 border-b pb-4 border-gray-100">
                    <span class="text-xs font-bold uppercase tracking-wider text-brand-blue" id="tutorial-step-indicator">Langkah 1 dari 4</span>
                    <div class="flex gap-1.5" id="tutorial-dots">
                        <span class="h-2 w-6 rounded-full bg-brand-blue transition-all duration-300"></span>
                        <span class="h-2 w-2 rounded-full bg-gray-200 transition-all duration-300"></span>
                        <span class="h-2 w-2 rounded-full bg-gray-200 transition-all duration-300"></span>
                        <span class="h-2 w-2 rounded-full bg-gray-200 transition-all duration-300"></span>
                    </div>
                </div>

                <!-- Slide Content Area -->
                <div class="min-h-[220px] flex flex-col justify-between" id="tutorial-slides">
                    <!-- Slide 1 -->
                    <div class="tutorial-slide" data-step="1">
                        <div class="w-14 h-14 bg-blue-50 text-brand-blue rounded-2xl flex items-center justify-center mb-5 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">1. Pilih Destinasi Wisata</h3>
                        <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
                            Jelajahi halaman beranda untuk menemukan berbagai destinasi wisata menarik. Klik tombol <strong class="text-brand-blue">"Detail"</strong> pada destinasi yang Anda inginkan untuk info selengkapnya.
                        </p>
                    </div>

                    <!-- Slide 2 -->
                    <div class="tutorial-slide hidden" data-step="2">
                        <div class="w-14 h-14 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center mb-5 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">2. Tentukan Jadwal Keberangkatan</h3>
                        <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
                            Di halaman detail destinasi, Anda akan melihat daftar jadwal keberangkatan yang tersedia beserta sisa kuota kursi. Klik <strong class="text-brand-blue">"Pilih Jadwal"</strong> pada tanggal yang Anda kehendaki.
                        </p>
                    </div>

                    <!-- Slide 3 -->
                    <div class="tutorial-slide hidden" data-step="3">
                        <div class="w-14 h-14 bg-green-50 text-brand-green rounded-2xl flex items-center justify-center mb-5 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">3. Lengkapi Form Pemesanan</h3>
                        <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
                            Isi formulir pemesanan dengan nama, email, nomor HP/WhatsApp, dan jumlah tiket. <strong class="text-brand-green">Sangat praktis, Anda tidak perlu registrasi atau login akun!</strong>
                        </p>
                    </div>

                    <!-- Slide 4 -->
                    <div class="tutorial-slide hidden" data-step="4">
                        <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-5 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">4. Selesaikan & Bayar</h3>
                        <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
                            Masukkan kode promo jika ada, lalu klik <strong class="text-brand-blue">"Selesaikan Pemesanan"</strong>. Invoice resmi akan langsung dikirim ke email Anda untuk rincian pembayaran.
                        </p>
                    </div>
                </div>

                <!-- Footer Action Buttons -->
                <div class="flex items-center justify-between mt-8 pt-5 border-t border-gray-100">
                    <button id="tutorial-prev" class="text-gray-500 hover:text-gray-900 font-semibold text-sm transition-colors opacity-0 pointer-events-none px-4 py-2 rounded-lg hover:bg-gray-50">
                        Kembali
                    </button>
                    <div class="flex gap-2">
                        <button id="tutorial-skip" class="text-gray-400 hover:text-gray-600 font-semibold text-sm transition-colors px-4 py-2 rounded-lg hover:bg-gray-50">
                            Lewati
                        </button>
                        <button id="tutorial-next" class="bg-brand-blue hover:bg-brand-blue-dark text-white font-semibold text-sm px-6 py-2.5 rounded-full transition-all shadow-md transform hover:-translate-y-0.5">
                            Lanjut
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Navbar blur and shadow on scroll
        window.addEventListener('scroll', function () {
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

        // Mobile menu toggle
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('menu-icon-open');
        const iconClose = document.getElementById('menu-icon-close');
        const mobileLinks = document.querySelectorAll('.mobile-link');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        });

        // Close mobile menu when clicking a link
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.add('hidden');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
            });
        });

        // Tutorial Onboarding logic
        document.addEventListener('DOMContentLoaded', function () {
            const tutorialSeen = localStorage.getItem('booking_tutorial_seen');
            const modal = document.getElementById('tutorial-modal');
            const card = document.getElementById('tutorial-card');
            const backdrop = document.getElementById('tutorial-backdrop');
            const fab = document.getElementById('guide-fab');
            const closeBtn = document.getElementById('close-tutorial');
            const skipBtn = document.getElementById('tutorial-skip');
            const nextBtn = document.getElementById('tutorial-next');
            const prevBtn = document.getElementById('tutorial-prev');
            const slides = document.querySelectorAll('.tutorial-slide');
            const dotsContainer = document.getElementById('tutorial-dots');
            const indicator = document.getElementById('tutorial-step-indicator');
            
            let currentStep = 1;
            const totalSteps = slides.length;

            function openTutorial() {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    backdrop.classList.remove('opacity-0');
                    backdrop.classList.add('opacity-100');
                    card.classList.remove('scale-95', 'opacity-0');
                    card.classList.add('scale-100', 'opacity-100');
                }, 50);
                showStep(1);
            }

            function closeTutorial() {
                card.classList.remove('scale-100', 'opacity-100');
                card.classList.add('scale-95', 'opacity-0');
                backdrop.classList.remove('opacity-100');
                backdrop.classList.add('opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
                localStorage.setItem('booking_tutorial_seen', 'true');
            }

            function showStep(step) {
                currentStep = step;
                
                // Hide all slides
                slides.forEach(slide => slide.classList.add('hidden'));
                
                // Show current slide
                const activeSlide = document.querySelector(`.tutorial-slide[data-step="${step}"]`);
                if (activeSlide) {
                    activeSlide.classList.remove('hidden');
                }

                // Update indicator text
                indicator.innerText = `Langkah ${step} dari ${totalSteps}`;

                // Update Dots
                dotsContainer.innerHTML = '';
                for (let i = 1; i <= totalSteps; i++) {
                    const dot = document.createElement('span');
                    if (i === step) {
                        dot.className = 'h-2 w-6 rounded-full bg-brand-blue transition-all duration-300';
                    } else {
                        dot.className = 'h-2 w-2 rounded-full bg-gray-200 transition-all duration-300';
                    }
                    dotsContainer.appendChild(dot);
                }

                // Update Buttons
                if (step === 1) {
                    prevBtn.classList.add('opacity-0', 'pointer-events-none');
                } else {
                    prevBtn.classList.remove('opacity-0', 'pointer-events-none');
                }

                if (step === totalSteps) {
                    nextBtn.innerText = 'Selesai';
                } else {
                    nextBtn.innerText = 'Lanjut';
                }
            }

            // Next button click
            nextBtn.addEventListener('click', () => {
                if (currentStep < totalSteps) {
                    showStep(currentStep + 1);
                } else {
                    closeTutorial();
                }
            });

            // Prev button click
            prevBtn.addEventListener('click', () => {
                if (currentStep > 1) {
                    showStep(currentStep - 1);
                }
            });

            // Skip button click
            skipBtn.addEventListener('click', closeTutorial);
            closeBtn.addEventListener('click', closeTutorial);
            backdrop.addEventListener('click', closeTutorial);

            // FAB click
            fab.addEventListener('click', openTutorial);

            // Auto-trigger for first time visitor
            if (!tutorialSeen) {
                setTimeout(openTutorial, 1500);
            }
        });
    </script>
</body>

</html>