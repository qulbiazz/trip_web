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
        .text-brand-blue { color: #1A6DFF; }
        .bg-brand-blue { background-color: #1A6DFF; }
        .hover\:bg-brand-blue-dark:hover { background-color: #1558CC; }
        .text-brand-green { color: #03C988; }
        .bg-brand-green { background-color: #03C988; }
        .text-brand-yellow { color: #FFCE3F; }
    </style>
</head>

<body class="font-sans antialiased text-gray-800 bg-gray-50">

    <nav class="bg-white border-b border-gray-100 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex-shrink-0 flex items-center cursor-pointer" onclick="window.scrollTo(0,0)">
                <div class="relative w-12 h-12 mr-2 flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Lokachara" class="h-10">
                </div>
            </div>
            <a href="{{ route('destinasi.show', $jadwal->destinasi_id) }}"
                class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Destinasi
            </a>
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
            <div class="lg:col-span-2">
                <form action="{{ route('booking.store', $jadwal->id) }}" method="POST" id="bookingForm"
                    class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    @csrf

                    <h2 class="text-xl font-bold mb-6 border-b pb-4">Data Pemesan</h2>

                    <div class="mb-5">
                        <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700 mb-2">Nama
                            Lengkap (Peserta 1)</label>
                        <input type="text" name="nama_pelanggan" id="nama_pelanggan" value="{{ old('nama_pelanggan') }}" placeholder="Nama sesuai KTP"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-brand-blue focus:border-brand-blue">
                    </div>

                    <div class="mb-5">
                        <label for="email_pelanggan" class="block text-sm font-medium text-gray-700 mb-2">Alamat
                            Email</label>
                        <input type="email" name="email_pelanggan" id="email_pelanggan"
                            value="{{ old('email_pelanggan') }}" placeholder="Alamat email"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-brand-blue focus:border-brand-blue">
                        <p class="text-xs text-gray-500 mt-1">Invoice akan dikirimkan ke email ini.</p>
                    </div>

                    <div class="mb-5">
                        <label for="nomor_handphone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Handphone / WhatsApp</label>
                        <input type="text" name="nomor_handphone" id="nomor_handphone"
                            value="{{ old('nomor_handphone') }}" placeholder="Nomor handphone aktif (contoh: 08123456789)"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-brand-blue focus:border-brand-blue">
                        <p class="text-xs text-gray-500 mt-1">Nomor telepon aktif untuk koordinasi keberangkatan.</p>
                    </div>

                    @if(str_contains(strtolower($jadwal->destinasi->nama), 'bromo'))
                    <div class="mb-5">
                        <label for="alamat_penjemputan" class="block text-sm font-medium text-gray-700 mb-2">Alamat Penjemputan</label>
                        <textarea name="alamat_penjemputan" id="alamat_penjemputan" rows="3" placeholder="Alamat lengkap lokasi penjemputan" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-brand-blue focus:border-brand-blue">{{ old('alamat_penjemputan') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Khusus destinasi Bromo, harap isi alamat penjemputan Anda secara lengkap.</p>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label for="jumlah_peserta" class="block text-sm font-medium text-gray-700 mb-2">Jumlah
                                Peserta</label>
                            <input type="number" name="jumlah_peserta" id="jumlah_peserta" min="1"
                                max="{{ $jadwal->sisa_kursi }}" value="{{ old('jumlah_peserta', 1) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-brand-blue focus:border-brand-blue"
                                onchange="calculateTotal(); generateAnggotaInputs();" onkeyup="calculateTotal(); generateAnggotaInputs();">
                            <p class="text-xs text-gray-500 mt-1">Sisa kursi tersedia: {{ $jadwal->sisa_kursi }}</p>
                        </div>
                        <div>
                            <label for="promo_id" class="block text-sm font-medium text-gray-700 mb-2">Kode Promo
                                (Opsional)</label>
                            <select name="promo_id" id="promo_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-brand-blue focus:border-brand-blue"
                                onchange="calculateTotal()">
                                <option value="">Tidak pakai promo</option>
                                @foreach($promos as $promo)
                                    <option value="{{ $promo->id }}" data-tipe="{{ $promo->tipe_diskon }}"
                                        data-nilai="{{ $promo->nilai_diskon }}" {{ old('promo_id') == $promo->id ? 'selected' : '' }}>
                                        {{ $promo->kode }} ({{ $promo->nama }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="anggota_container" class="space-y-4 mb-8">
                        </div>

                    <hr class="mb-6">

                    <button type="submit"
                        class="w-full bg-brand-blue hover:bg-brand-blue-dark text-white font-bold py-4 rounded-xl shadow-md transition-colors text-lg">
                        Selesaikan Pemesanan
                    </button>
                    <p class="text-center text-sm text-gray-500 mt-4">Pesanan akan berstatus pending hingga pembayaran
                        dikonfirmasi admin.</p>
                </form>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-gray-900 rounded-2xl p-6 text-white sticky top-10">
                    <h3 class="text-lg font-bold mb-4 border-b border-gray-700 pb-3">Ringkasan Pesanan</h3>

                    <div class="flex items-center mb-6">
                        @if($jadwal->destinasi->gambar)
                            <div class="w-16 h-16 rounded-lg bg-cover bg-center mr-4"
                                style="background-image: url('<?php    /** @var \App\Models\Jadwal $jadwal */ echo asset('storage/' . $jadwal->destinasi->gambar); ?>')">
                            </div>
                        @endif
                        <div>
                            <p class="font-bold">{{ $jadwal->destinasi->nama }}</p>
                            <p class="text-xs text-gray-400">{{ $jadwal->destinasi->lokasi }}</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-sm border-b border-gray-700 pb-4 mb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Jadwal</span>
                            <span
                                class="font-medium">{{ \Carbon\Carbon::parse($jadwal->tanggal_berangkat)->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Harga per pax</span>
                            <span class="font-medium" id="displayHargaDasar"
                                data-harga="{{ $jadwal->destinasi->harga_dasar }}">Rp
                                {{ number_format($jadwal->destinasi->harga_dasar, 0, ',', '.') }}</span>
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

        function generateAnggotaInputs() {
            const qty = parseInt(document.getElementById('jumlah_peserta').value) || 1;
            const container = document.getElementById('anggota_container');
            
            // Bersihkan form anggota sebelumnya
            container.innerHTML = '';

            // Jika peserta lebih dari 1, buat input tambahan
            if (qty > 1) {
                let html = '<h3 class="text-md font-semibold text-gray-700 mb-3 border-t pt-4">Data Peserta Tambahan</h3>';
                
                // Looping dimulai dari 2, karena peserta 1 adalah data pemesan
                for (let i = 2; i <= qty; i++) {
                    html += `
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap (Peserta ${i})</label>
                            <input type="text" name="nama_anggota[]" placeholder="Nama peserta ke-${i}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-brand-blue focus:border-brand-blue">
                        </div>
                    `;
                }
                container.innerHTML = html;
            }
        }

        // Initialize calculation and inputs on load
        document.addEventListener('DOMContentLoaded', () => {
            calculateTotal();
            generateAnggotaInputs();
        });
    </script>
</body>

</html>