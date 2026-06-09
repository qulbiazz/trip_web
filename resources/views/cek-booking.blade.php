<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Booking — Lokachara</title>
    <meta name="description" content="Cek status pemesanan perjalanan Anda dengan memasukkan kode booking.">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Instrument Sans', sans-serif; background: #f0f4ff; min-height: 100vh; }

        .brand-blue { color: #1A6DFF; }
        .bg-brand-blue { background: #1A6DFF; }
        .bg-brand-blue:hover { background: #1558CC; }

        .navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #e5e7eb;
            position: sticky; top: 0; z-index: 50;
        }

        .hero-section {
            background: linear-gradient(135deg, #1A6DFF 0%, #0a3fbf 60%, #03C988 100%);
            padding: 60px 0 80px;
        }

        .search-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(26,109,255,0.15);
            padding: 40px;
            max-width: 560px;
            margin: 0 auto;
        }

        .input-booking {
            width: 100%;
            padding: 14px 20px;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            outline: none;
            transition: border-color 0.2s;
        }
        .input-booking:focus { border-color: #1A6DFF; }

        .btn-cek {
            width: 100%;
            padding: 14px;
            background: #1A6DFF;
            color: white;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }
        .btn-cek:hover { background: #1558CC; transform: translateY(-1px); }
        .btn-cek:active { transform: translateY(0); }

        .result-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            overflow: hidden;
            max-width: 680px;
            margin: 40px auto;
        }

        .result-header {
            padding: 24px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 14px;
        }
        .status-pending    { background: #FFF3CD; color: #856404; }
        .status-dikonfirmasi { background: #CCE5FF; color: #004085; }
        .status-dibayar    { background: #D4EDDA; color: #155724; }
        .status-dibatalkan { background: #F8D7DA; color: #721c24; }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            border-top: 1px solid #f0f0f0;
        }
        .info-item {
            padding: 18px 32px;
            border-bottom: 1px solid #f0f0f0;
        }
        .info-item:nth-child(odd) { border-right: 1px solid #f0f0f0; }
        .info-label { font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .info-value { font-size: 15px; font-weight: 600; color: #1f2937; }

        .not-found-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            padding: 60px 40px;
            text-align: center;
            max-width: 480px;
            margin: 40px auto;
        }

        .wa-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #25D366;
            color: white;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            transition: background 0.2s, transform 0.1s;
        }
        .wa-btn:hover { background: #1eba57; transform: translateY(-1px); }

        .steps-row {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }
        .step-card {
            background: white;
            border-radius: 14px;
            padding: 20px 24px;
            text-align: center;
            flex: 1;
            min-width: 160px;
            max-width: 200px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }
        .step-num {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: #1A6DFF;
            color: white;
            font-weight: 700;
            font-size: 16px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 10px;
        }

        @media (max-width: 640px) {
            .info-grid { grid-template-columns: 1fr; }
            .info-item:nth-child(odd) { border-right: none; }
            .search-card { padding: 24px 20px; }
        }
    </style>
</head>

<body>
    {{-- Navbar --}}
    <nav class="navbar px-6 py-4">
        <div class="max-w-5xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-8">
                <span class="font-bold text-lg text-gray-800">Lokachara</span>
            </a>
            <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="hero-section">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-2 bg-white/20 text-white text-sm font-semibold px-4 py-2 rounded-full mb-6">
                🔍 Cek Status Pemesanan
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">Cek Status Booking Kamu</h1>
            <p class="text-white/80 mb-10">Masukkan kode booking yang kamu terima saat melakukan pemesanan</p>

            {{-- Search Card --}}
            <div class="search-card">
                <form method="POST" action="{{ route('cek-booking.cek') }}">
                    @csrf
                    <label class="block text-sm font-semibold text-gray-500 uppercase tracking-widest mb-3 text-left">
                        Kode Booking
                    </label>
                    <input
                        type="text"
                        name="kode_booking"
                        id="kode_booking"
                        class="input-booking mb-2"
                        placeholder="Contoh: BK-ABCD1234"
                        value="{{ old('kode_booking', request()->old('kode_booking')) }}"
                        autocomplete="off"
                        autofocus
                    >
                    @error('kode_booking')
                        <p class="text-red-500 text-sm mb-3 text-left">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="btn-cek mt-3">
                        🔍 Cek Status Sekarang
                    </button>
                </form>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <main class="max-w-5xl mx-auto px-6 py-10">

        @if (isset($searched))
            @if (isset($booking) && $booking)

                {{-- RESULT FOUND --}}
                @php
                    $statusConfig = [
                        'pending'      => ['label' => '⏳ Menunggu Konfirmasi', 'class' => 'status-pending',       'desc' => 'Pesanan kamu sedang menunggu konfirmasi dari admin.'],
                        'dikonfirmasi' => ['label' => '✅ Dikonfirmasi',        'class' => 'status-dikonfirmasi',  'desc' => 'Pesanan kamu sudah dikonfirmasi. Silakan lakukan pembayaran.'],
                        'dibayar'      => ['label' => '🎉 Berhasil Dibayar',   'class' => 'status-dibayar',       'desc' => 'Pembayaran diterima! Selamat menikmati perjalanan kamu.'],
                        'dibatalkan'   => ['label' => '❌ Dibatalkan',          'class' => 'status-dibatalkan',    'desc' => 'Booking ini telah dibatalkan.'],
                    ];
                    $sc = $statusConfig[$booking->status] ?? ['label' => $booking->status, 'class' => '', 'desc' => ''];
                @endphp

                <div class="result-card">
                    {{-- Header --}}
                    <div class="result-header bg-gray-50">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Kode Booking</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $booking->kode_booking }}</p>
                        </div>
                        <span class="status-badge {{ $sc['class'] }}">{{ $sc['label'] }}</span>
                    </div>

                    {{-- Status description --}}
                    <div class="px-8 py-4 bg-blue-50 border-y border-blue-100">
                        <p class="text-sm text-blue-700">{{ $sc['desc'] }}</p>
                    </div>

                    {{-- Info Grid --}}
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Nama Pelanggan</div>
                            <div class="info-value">{{ $booking->nama_pelanggan }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">No. Handphone</div>
                            <div class="info-value">{{ $booking->nomor_handphone }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Destinasi</div>
                            <div class="info-value">{{ $booking->jadwal?->destinasi?->nama ?? '-' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Tanggal Berangkat</div>
                            <div class="info-value">
                                {{ $booking->jadwal?->tanggal_berangkat
                                    ? \Carbon\Carbon::parse($booking->jadwal->tanggal_berangkat)->translatedFormat('d M Y')
                                    : '-' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Jumlah Peserta</div>
                            <div class="info-value">{{ $booking->jumlah_peserta }} orang</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Total Bayar</div>
                            <div class="info-value text-blue-600">Rp{{ number_format($booking->total_bayar, 0, ',', '.') }}</div>
                        </div>
                        @if (!empty($booking->nama_anggota))
                        <div class="info-item" style="grid-column: 1 / -1;">
                            <div class="info-label">Peserta Tambahan</div>
                            <div class="info-value">{{ implode(', ', $booking->nama_anggota) }}</div>
                        </div>
                        @endif
                        <div class="info-item">
                            <div class="info-label">Nomor Invoice</div>
                            <div class="info-value text-sm">{{ $booking->nomor_invoice ?? '-' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Tanggal Pesan</div>
                            <div class="info-value text-sm">{{ $booking->created_at->translatedFormat('d M Y, H:i') }}</div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="px-8 py-6 flex flex-wrap gap-3">
                        <a href="{{ route('bookings.invoice.show', $booking) }}" target="_blank"
                           class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-3 rounded-xl font-semibold text-sm hover:bg-blue-700 transition-colors">
                            📄 Lihat Invoice
                        </a>
                        @if (in_array($booking->status, ['pending', 'dikonfirmasi']))
                        @php $siteSetting = \App\Models\SiteSetting::first(); @endphp
                        <a href="https://wa.me/{{ $siteSetting?->whatsapp_number ?? '6285954413123' }}?text=Halo%20Admin%2C%20saya%20ingin%20konfirmasi%20pembayaran%20dengan%20Kode%20Booking%20{{ $booking->kode_booking }}"
                           target="_blank" class="wa-btn">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Konfirmasi via WhatsApp
                        </a>
                        @endif
                    </div>
                </div>

            @else
                {{-- NOT FOUND --}}
                <div class="not-found-card">
                    <div class="text-6xl mb-4">🔍</div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Booking Tidak Ditemukan</h2>
                    <p class="text-gray-500 mb-6">Kode booking <strong class="text-gray-700">{{ strtoupper(request()->old('kode_booking', '')) }}</strong> tidak ditemukan di sistem kami.<br>Pastikan kode yang dimasukkan sudah benar.</p>
                    <p class="text-sm text-gray-400">Contoh format kode booking: <strong>BK-ABCD1234</strong></p>
                </div>
            @endif
        @else
            {{-- TIPS --}}
            <div class="text-center mb-8">
                <h2 class="text-lg font-bold text-gray-700 mb-6">Cara Cek Status Booking</h2>
                <div class="steps-row">
                    <div class="step-card">
                        <div class="step-num">1</div>
                        <p class="text-sm font-semibold text-gray-700">Temukan Kode Booking</p>
                        <p class="text-xs text-gray-400 mt-1">Cek email atau invoice yang kamu terima</p>
                    </div>
                    <div class="step-card">
                        <div class="step-num">2</div>
                        <p class="text-sm font-semibold text-gray-700">Masukkan Kode</p>
                        <p class="text-xs text-gray-400 mt-1">Ketik kode booking di form di atas</p>
                    </div>
                    <div class="step-card">
                        <div class="step-num">3</div>
                        <p class="text-sm font-semibold text-gray-700">Lihat Status</p>
                        <p class="text-xs text-gray-400 mt-1">Detail pesanan dan status akan muncul</p>
                    </div>
                </div>
            </div>
        @endif

    </main>

    {{-- Footer --}}
    <footer class="text-center py-8 text-sm text-gray-400 border-t border-gray-100 bg-white mt-10">
        <p>© {{ date('Y') }} Lokachara. Semua hak dilindungi.</p>
    </footer>
</body>
</html>
