<?php

/** @var \App\Models\Destinasi $destinasi */ ?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $destinasi->nama }} - Lokachara</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
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

        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-800 bg-gray-50 selection:bg-brand-blue selection:text-white">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 shadow-sm bg-white/95 border-b border-gray-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center cursor-pointer">
                    <div class="relative w-10 h-10 mr-2 flex items-center justify-center">
                        <div class="absolute inset-0 bg-brand-yellow rounded-full opacity-20"></div>
                        <svg class="w-8 h-8 text-brand-green" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                        </svg>
                    </div>
                    <span class="font-bold text-2xl tracking-tight">
                        <span class="text-brand-blue">Loka</span><span class="text-brand-green">chara</span>
                    </span>
                </a>

                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-brand-blue font-medium transition-colors">Beranda</a>
                    @auth
                    <a href="{{ url('/admin') }}" class="text-gray-600 hover:text-brand-blue font-medium transition-colors">Dashboard Admin</a>
                    @else
                    <a href="{{ url('/admin/login') }}" class="text-gray-600 hover:text-brand-blue font-medium transition-colors">Login Admin</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Header Image -->
    <div class="relative pt-20 h-96 flex items-center justify-center">
        @if($destinasi->gambar)
        <div class="absolute inset-0 w-full h-full bg-center bg-cover" style="background-image: url('<?php echo asset('storage/' . $destinasi->gambar); ?>');">
            <div class="absolute inset-0 bg-black opacity-40"></div>
        </div>
        @else
        <div class="absolute inset-0 w-full h-full bg-brand-blue opacity-10"></div>
        @endif

        <div class="relative z-10 text-center text-white px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow-lg">{{ $destinasi->nama }}</h1>
            <p class="text-xl md:text-2xl font-light drop-shadow-md flex items-center justify-center">
                <svg class="w-6 h-6 mr-2 text-brand-yellow" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                </svg>
                {{ $destinasi->lokasi }}, {{ $destinasi->negara }}
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Left Column: Details -->
            <div class="lg:col-span-2 space-y-10">
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-4">Tentang Destinasi</h2>
                    <div class="prose max-w-none text-gray-600 leading-relaxed">
                        {{ $destinasi->deskripsi ?? 'Belum ada deskripsi untuk destinasi ini.' }}
                    </div>
                </div>

                <!-- Jadwal Tersedia -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-4">Jadwal Keberangkatan</h2>

                    @if($destinasi->jadwals->count() > 0)
                    <div class="space-y-4">
                        @foreach($destinasi->jadwals as $jadwal)
                        @php
                        $isPast = \Carbon\Carbon::parse($jadwal->tanggal_berangkat)->endOfDay()->isPast();
                        @endphp
                        <div class="flex flex-col sm:flex-row justify-between items-center p-5 rounded-xl border {{ ($jadwal->status == 'tersedia' && !$isPast) ? 'border-green-100 bg-green-50/30' : 'border-gray-100 bg-gray-50' }}">
                            <div class="mb-4 sm:mb-0">
                                <p class="font-bold text-lg text-gray-900">
                                    {{ \Carbon\Carbon::parse($jadwal->tanggal_berangkat)->translatedFormat('d F Y') }}
                                    -
                                    {{ \Carbon\Carbon::parse($jadwal->tanggal_pulang)->translatedFormat('d F Y') }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Sisa Kursi:
                                    @if($jadwal->status == 'tersedia')
                                    <span class="font-semibold text-brand-green">{{ $jadwal->sisa_kursi }}</span> / {{ $jadwal->kuota }}
                                    @else
                                    <span class="font-semibold text-red-500">Penuh</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                @if($isPast)
                                <span class="inline-block bg-gray-200 text-gray-500 px-6 py-2.5 rounded-full font-medium cursor-not-allowed">
                                    Sudah Lewat
                                </span>
                                @elseif($jadwal->status == 'tersedia')
                                <a href="{{ route('booking.create', $jadwal->id) }}" class="inline-block bg-brand-blue hover:bg-brand-blue-dark text-white px-6 py-2.5 rounded-full font-medium transition-colors shadow-md">
                                    Pilih Jadwal
                                </a>
                                @else
                                <span class="inline-block bg-gray-200 text-gray-500 px-6 py-2.5 rounded-full font-medium cursor-not-allowed">
                                    Penuh
                                </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">Belum ada jadwal keberangkatan yang tersedia saat ini.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Summary Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 sticky top-28">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Harga</h3>
                    <p class="text-sm text-gray-500 mb-2">Mulai dari</p>
                    <p class="text-3xl font-bold text-brand-blue mb-6">Rp {{ number_format($destinasi->harga_dasar ?? 0, 0, ',', '.') }}<span class="text-sm text-gray-500 font-normal">/pax</span></p>

                    <hr class="mb-6">

                    <h4 class="font-semibold mb-3">Butuh Bantuan?</h4>
                    <p class="text-sm text-gray-600 mb-6">Hubungi travel consultant kami untuk informasi lebih lanjut.</p>
                    <a href="#" class="w-full block text-center bg-brand-green text-white hover:bg-brand-green  font-semibold py-3 rounded-xl transition-colors shadow-md">
                        Hubungi WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 pt-12 pb-8 border-t border-gray-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} Lokachara Travel. All rights reserved.
            </p>
        </div>
    </footer>
</body>

</html>