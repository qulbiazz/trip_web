<x-filament-panels::page>
    {{-- HTML untuk tampilan di layar (Hanya tampil di layar, tersembunyi saat dicetak) --}}
    <div class="space-y-6 screen-only print:hidden">
        {{-- Widget native Filament di layar --}}
    </div>

    {{-- HTML untuk Dokumen Resmi Cetak Laporan (Hanya tampil saat dicetak) --}}
    <div class="print-only-report">
        <!-- Kop Surat (Letterhead) Resmi -->
        <div class="letterhead">
            <h1 class="company-name">LOKACHARA TRAVEL</h1>
            <p class="company-address">Jln. Raya Wisata No. 45, Jakarta Selatan | Telp: (021) 888-9999 | Email: info@lokachara.com</p>
            <div class="letterhead-divider"></div>
        </div>

        <!-- Judul Laporan & Metadata Informasi -->
        <div class="report-meta">
            <h2 class="report-title">LAPORAN KINERJA OPERASIONAL & KEUANGAN</h2>
            <table class="meta-table">
                <tr>
                    <td style="width: 15%;"><strong>Tanggal Cetak</strong></td>
                    <td style="width: 35%;">: {{ now()->translatedFormat('d F Y H:i') }} WIB</td>
                    <td style="width: 15%;"><strong>Pencetak</strong></td>
                    <td style="width: 35%;">: Admin Sistem</td>
                </tr>
                <tr>
                    <td><strong>Periode</strong></td>
                    <td>: Seluruh Waktu</td>
                    <td><strong>Status Dokumen</strong></td>
                    <td>: Resmi / Terverifikasi</td>
                </tr>
            </table>
        </div>

        <!-- Bagian I: Ringkasan Statistik -->
        <div class="section-title">I. RINGKASAN STATISTIK OPERASIONAL & KEUANGAN</div>
        <table class="data-table summary-table">
            <thead>
                <tr>
                    <th style="width: 33.3%;">STATISTIK PEMESANAN</th>
                    <th style="width: 33.3%;">STATISTIK KEUANGAN</th>
                    <th style="width: 33.3%;">STATISTIK PENGGUNA</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <ul class="stats-list">
                            <li><strong>Total Pemesanan:</strong> {{ $stats['bookings_total'] }} transaksi</li>
                            <li><strong>Pemesanan Sukses:</strong> {{ $stats['bookings_success'] }}</li>
                            <li><strong>Menunggu Pembayaran:</strong> {{ $stats['bookings_pending'] }}</li>
                            <li><strong>Pemesanan Batal:</strong> {{ $stats['bookings_cancelled'] }}</li>
                        </ul>
                    </td>
                    <td>
                        <ul class="stats-list">
                            <li><strong>Pemasukan Berhasil:</strong> Rp{{ number_format($stats['revenue_total'], 0, ',', '.') }}</li>
                            <li><strong>Pemasukan Pending:</strong> Rp{{ number_format($stats['revenue_pending'], 0, ',', '.') }}</li>
                            <li><strong>Potensi Hilang (Batal):</strong> Rp{{ number_format($stats['revenue_cancelled'], 0, ',', '.') }}</li>
                        </ul>
                    </td>
                    <td>
                        <ul class="stats-list">
                            <li><strong>Total Pengguna:</strong> {{ $stats['users_total'] }} terdaftar</li>
                            <li><strong>Pengguna Baru (30 Hari):</strong> +{{ $stats['users_new_30d'] }}</li>
                            <li><strong>Rasio Pertumbuhan:</strong> {{ $stats['users_growth'] }}%</li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Bagian II: Destinasi Terpopuler -->
        <div class="section-title" style="margin-top: 30px;">II. DESTINASI PERJALANAN TERPOPULER</div>
        <table class="data-table popular-table">
            <thead>
                <tr>
                    <th style="width: 10%; text-align: center;">No.</th>
                    <th style="text-align: left;">Nama Destinasi Wisata</th>
                    <th style="width: 25%; text-align: center;">Jumlah Pemesanan Sukses</th>
                    <th style="width: 35%; text-align: right;">Total Pendapatan Terkumpul</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @forelse($popularDestinations as $dest)
                    <tr>
                        <td style="text-align: center;">{{ $no++ }}</td>
                        <td style="font-weight: bold;">{{ $dest['nama'] }}</td>
                        <td style="text-align: center;">{{ $dest['total_bookings'] }} x</td>
                        <td style="text-align: right; font-weight: bold;">Rp{{ number_format($dest['total_revenue'], 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #666; padding: 20px;">Belum ada data pemesanan yang berhasil dibayar/dikonfirmasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>    </div>

    {{-- CSS Stylesheet khusus untuk print layout dan screen rules --}}
    <style>
        /* Sembunyikan bagian print saat tampil di layar */
        .print-only-report {
            display: none !important;
        }

        @media print {
            /* Sembunyikan seluruh elemen navigasi admin panel, tombol aksi, header page, dan widget bawaan layar */
            .fi-sidebar,
            .fi-topbar,
            .fi-actions,
            .fi-header,
            .fi-sidebar-close-overlay,
            .fi-sidebar-open-button,
            header,
            aside,
            nav,
            button,
            .fi-page-header,
            .fi-breadcrumbs,
            .screen-only,
            .print\:hidden {
                display: none !important;
            }

            /* Sembunyikan widget bawaan layar (header widgets) yang dirender di dalam fi-page-content */
            .fi-page-content > * {
                display: none !important;
            }

            /* Tampilkan HANYA kontainer laporan cetak kustom kita */
            .fi-page-content > .print-only-report {
                display: block !important;
            }

            /* Hapus padding, margin, dan background bawaan admin panel */
            .fi-main-ctn,
            .fi-main,
            .fi-content,
            .fi-page,
            main {
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                background: transparent !important;
            }

            body {
                background-color: #ffffff !important;
                color: #000000 !important;
            }

            /* Desain Khusus Dokumen Laporan Bisnis Formal */
            .print-only-report {
                display: block !important;
                font-family: 'Georgia', 'Times New Roman', Times, serif !important;
                color: #000000 !important;
                line-height: 1.6 !important;
                font-size: 11pt !important;
                padding: 20px 10px !important;
            }

            .letterhead {
                text-align: center !important;
                margin-bottom: 20px !important;
            }

            .company-name {
                font-size: 24pt !important;
                font-weight: bold !important;
                letter-spacing: 2px !important;
                margin: 0 !important;
                color: #000000 !important;
                font-family: 'Times New Roman', Times, serif !important;
            }

            .company-address {
                font-size: 9pt !important;
                margin: 5px 0 0 0 !important;
                color: #444444 !important;
                font-style: italic !important;
            }

            .letterhead-divider {
                border-top: 3px double #000000 !important;
                margin-top: 10px !important;
                margin-bottom: 25px !important;
            }

            .report-meta {
                margin-bottom: 25px !important;
            }

            .report-title {
                font-size: 14pt !important;
                font-weight: bold !important;
                text-align: center !important;
                text-decoration: underline !important;
                margin-bottom: 20px !important;
                text-transform: uppercase !important;
                letter-spacing: 0.5px !important;
            }

            .meta-table {
                width: 100% !important;
                border-collapse: collapse !important;
                margin-bottom: 15px !important;
                font-size: 10pt !important;
            }

            .meta-table td {
                padding: 4px 0 !important;
                border: none !important;
            }

            .section-title {
                font-size: 11pt !important;
                font-weight: bold !important;
                border-bottom: 1.5px solid #000000 !important;
                padding-bottom: 3px !important;
                margin-bottom: 12px !important;
                text-transform: uppercase !important;
                letter-spacing: 0.5px !important;
                margin-top: 20px !important;
            }

            .data-table {
                width: 100% !important;
                border-collapse: collapse !important;
                margin-bottom: 20px !important;
                font-size: 10pt !important;
            }

            .data-table th {
                background-color: #f2f2f2 !important;
                border: 1px solid #000000 !important;
                padding: 8px 10px !important;
                font-weight: bold !important;
                text-align: center !important;
            }

            .data-table td {
                border: 1px solid #000000 !important;
                padding: 8px 10px !important;
                vertical-align: middle !important;
            }

            .stats-list {
                list-style-type: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .stats-list li {
                margin-bottom: 6px !important;
                font-size: 9.5pt !important;
            }
        }
    </style>
</x-filament-panels::page>
