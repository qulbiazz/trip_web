<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan - {{ $jadwal->destinasi->nama }}</title>

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
    </style>
</head>

<body class="font-sans antialiased text-gray-800 bg-gray-50">

    <!-- Navbar Minimalis -->
    <nav class="bg-white border-b border-gray-100 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <a href="{{ url('/') }}" class="flex items-center">
                <svg class="w-8 h-8 text-brand-green mr-2" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                </svg>
                <span class="font-bold text-xl tracking-tight text-gray-900">Lokachara</span>
            </a>
            <a href="{{ route('destinasi.show', $jadwal->destinasi_id) }}" class="text-sm font-medium text-gray-500 hover:text-gray-900">Kembali ke Destinasi</a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Selesaikan Pemesanan Anda</h1>

        @if ($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-8 border border-red-100">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Kiri -->
            <div class="lg:col-span-2">
                <form action="{{ route('booking.store', $jadwal->id) }}" method="POST" id="bookingForm" class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    @csrf

                    <h2 class="text-xl font-bold mb-6 border-b pb-4">Data Pemesan</h2>

                    <div class="mb-5">
                        <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_pelanggan" id="nama_pelanggan" value="{{ old('nama_pelanggan') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-brand-blue focus:border-brand-blue">
                    </div>

                    <div class="mb-5">
                        <label for="email_pelanggan" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                        <input type="email" name="email_pelanggan" id="email_pelanggan" value="{{ old('email_pelanggan') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-brand-blue focus:border-brand-blue">
                        <p class="text-xs text-gray-500 mt-1">Invoice akan dikirimkan ke email ini.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                        <div>
                            <label for="jumlah_peserta" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Peserta</label>
                            <input type="number" name="jumlah_peserta" id="jumlah_peserta" min="1" max="{{ $jadwal->sisa_kursi }}" value="{{ old('jumlah_peserta', 1) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-brand-blue focus:border-brand-blue" onchange="calculateTotal()">
                            <p class="text-xs text-gray-500 mt-1">Sisa kursi tersedia: {{ $jadwal->sisa_kursi }}</p>
                        </div>
                        <div>
                            <label for="promo_id" class="block text-sm font-medium text-gray-700 mb-2">Kode Promo (Opsional)</label>
                            <select name="promo_id" id="promo_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-brand-blue focus:border-brand-blue" onchange="calculateTotal()">
                                <option value="">Tidak pakai promo</option>
                                @foreach($promos as $promo)
                                <option value="{{ $promo->id }}"
                                    data-tipe="{{ $promo->tipe_diskon }}"
                                    data-nilai="{{ $promo->nilai_diskon }}"
                                    {{ old('promo_id') == $promo->id ? 'selected' : '' }}>
                                    {{ $promo->kode }} ({{ $promo->nama }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr class="mb-6">

                    <button type="submit" class="w-full bg-brand-blue hover:bg-brand-blue-dark text-white font-bold py-4 rounded-xl shadow-md transition-colors text-lg">
                        Selesaikan Pemesanan
                    </button>
                    <p class="text-center text-sm text-gray-500 mt-4">Pesanan akan berstatus pending hingga pembayaran dikonfirmasi admin.</p>
                </form>
            </div>

            <!-- Ringkasan Kanan -->
            <div class="lg:col-span-1">
                <div class="bg-gray-900 rounded-2xl p-6 text-white sticky top-10">
                    <h3 class="text-lg font-bold mb-4 border-b border-gray-700 pb-3">Ringkasan Pesanan</h3>

                    <div class="flex items-center mb-6">
                        @if($jadwal->destinasi->gambar)
                        <div class="w-16 h-16 rounded-lg bg-cover bg-center mr-4" style="background-image: url('<?php /** @var \App\Models\Jadwal $jadwal */ echo asset('storage/' . $jadwal->destinasi->gambar); ?>')"></div>
                        @endif
                        <div>
                            <p class="font-bold">{{ $jadwal->destinasi->nama }}</p>
                            <p class="text-xs text-gray-400">{{ $jadwal->destinasi->lokasi }}</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-sm border-b border-gray-700 pb-4 mb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Jadwal</span>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($jadwal->tanggal_berangkat)->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Harga per pax</span>
                            <span class="font-medium" id="displayHargaDasar" data-harga="{{ $jadwal->destinasi->harga_dasar }}">Rp {{ number_format($jadwal->destinasi->harga_dasar, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Subtotal</span>
                            <span class="font-medium" id="displaySubtotal">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-brand-yellow">
                            <span>Diskon Promo</span>
                            <span class="font-medium" id="displayDiskon">- Rp 0</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-end">
                        <span class="text-gray-400 text-sm">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-brand-green" id="displayTotal">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }

        function calculateTotal() {
            const hargaDasar = parseInt(document.getElementById('displayHargaDasar').getAttribute('data-harga'));
            const qty = parseInt(document.getElementById('jumlah_peserta').value) || 1;
            const promoSelect = document.getElementById('promo_id');

            let subtotal = hargaDasar * qty;
            let diskon = 0;

            if (promoSelect.selectedIndex > 0) {
                const option = promoSelect.options[promoSelect.selectedIndex];
                const tipe = option.getAttribute('data-tipe');
                const nilai = parseInt(option.getAttribute('data-nilai'));

                if (tipe === 'persentase') {
                    diskon = subtotal * (nilai / 100);
                } else {
                    diskon = nilai;
                }
            }

            let total = subtotal - diskon;
            if (total < 0) total = 0;

            document.getElementById('displaySubtotal').innerText = formatRupiah(subtotal);
            document.getElementById('displayDiskon').innerText = '- ' + formatRupiah(diskon);
            document.getElementById('displayTotal').innerText = formatRupiah(total);
        }

        // Initialize calculation on load
        document.addEventListener('DOMContentLoaded', calculateTotal);
    </script>
</body>

</html>