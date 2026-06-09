<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $booking->nomor_invoice ?? ('BOOKING-' . $booking->id) }}</title>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --text: #111827;
            --muted: #6b7280;
            --border: #e5e7eb;
            --primary: #0ea5e9;
            --bg: #f8fafc;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: var(--bg);
            font-family: "Inter", "Segoe UI", Arial, sans-serif;
            color: var(--text);
            padding: 24px;
        }
        .page {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }
        .topbar {
            background: linear-gradient(135deg, #0284c7, #0ea5e9);
            color: #fff;
            padding: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }
        .brand h1 {
            margin: 0;
            font-size: 22px;
            letter-spacing: .3px;
        }
        .brand p { margin: 6px 0 0; opacity: .9; font-size: 13px; }
        .invoice-id { text-align: right; }
        .invoice-id .label { font-size: 12px; opacity: .85; text-transform: uppercase; letter-spacing: .8px; }
        .invoice-id .value { font-size: 18px; font-weight: 700; margin-top: 4px; }
        .content { padding: 24px; }
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }
        .card {
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 14px 16px;
        }
        .card h3 {
            margin: 0 0 10px;
            font-size: 13px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .6px;
        }
        .row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin: 8px 0;
            font-size: 14px;
        }
        .row .key { color: var(--muted); }
        .row .val { font-weight: 600; text-align: right; }
        .status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            background: #e0f2fe;
            color: #075985;
        }
        .status.dibayar { background: #ecfdf5; color: #047857; border: 1px solid #10b981; }
        .status.dikonfirmasi { background: #eff6ff; color: #1d4ed8; border: 1px solid #3b82f6; }
        .status.pending { background: #fffbeb; color: #b45309; border: 1px solid #f59e0b; }
        .status.dibatalkan { background: #fef2f2; color: #b91c1c; border: 1px solid #ef4444; }
        .summary {
            margin-top: 8px;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 16px;
        }
        .summary .total {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed var(--border);
            font-size: 20px;
            font-weight: 800;
            color: #0c4a6e;
        }
        .footer {
            margin-top: 20px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
        }
        .actions {
            margin-top: 18px;
            display: flex;
            gap: 10px;
        }
        .btn {
            display: inline-block;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 8px 12px;
            text-decoration: none;
            color: var(--text);
            font-size: 13px;
            font-weight: 600;
            background: #fff;
        }
        .btn.primary {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }
        @media print {
            body { background: #fff; padding: 0; }
            .page { border: none; border-radius: 0; }
            .actions { display: none; }
        }
        
        /* Premium Payment Panel Styling */
        .payment-panel {
            margin-top: 24px;
            background: #ffffff;
            border: 2px solid #e0f2fe;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .payment-panel:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.03);
            border-color: #bae6fd;
        }
        .payment-title-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 12px;
        }
        .payment-title {
            color: #0c4a6e;
            font-size: 15px;
            font-weight: 800;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }
        .bank-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin: 20px 0;
        }
        .bank-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 16px;
            position: relative;
            transition: all 0.2s ease;
        }
        .bank-card:hover {
            border-color: #cbd5e1;
            background: #f1f5f9;
        }
        .bank-badge {
            display: inline-block;
            font-size: 10px;
            font-weight: 800;
            color: white;
            padding: 3px 8px;
            border-radius: 6px;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }
        .bank-badge.bca {
            background: #1A6DFF;
        }
        .bank-badge.mandiri {
            background: #F59E0B;
        }
        .bank-number-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
        }
        .bank-number {
            font-family: 'Courier New', Courier, monospace;
            font-size: 20px;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: 0.5px;
        }
        .btn-copy {
            background: none;
            border: none;
            padding: 6px;
            cursor: pointer;
            border-radius: 6px;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .btn-copy:hover {
            background: #e2e8f0;
            color: #1e293b;
        }
        .bank-holder {
            font-size: 12px;
            color: #64748b;
        }
        .payment-steps {
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
        }
        .payment-steps ol {
            margin: 0;
            padding-left: 20px;
            font-size: 13.5px;
            color: #475569;
            line-height: 1.6;
        }
        .payment-steps ol li {
            margin-bottom: 6px;
        }
        .payment-steps ol li:last-child {
            margin-bottom: 0;
        }
        .whatsapp-banner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            padding: 16px;
            border-radius: 10px;
            flex-wrap: wrap;
        }
        .whatsapp-text {
            font-size: 13px;
            color: #166534;
            max-width: 380px;
            line-height: 1.5;
        }
        .whatsapp-btn {
            background: #25D366;
            color: white !important;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.25);
            transition: all 0.2s ease;
        }
        .whatsapp-btn:hover {
            background: #128C7E;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 211, 102, 0.35);
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="topbar">
            <div class="brand">
                <h1>Travel Invoice</h1>
                <p>Dokumen resmi transaksi pemesanan perjalanan</p>
            </div>
            <div class="invoice-id">
                <div class="label">Kode Booking</div>
                <div class="value">{{ $booking->kode_booking }}</div>
            </div>
        </div>
        <div class="content">
            @if(session('success'))
                <div style="background-color: #ecfdf5; border-left: 4px solid #10b981; color: #047857; padding: 12px 16px; margin-bottom: 20px; border-radius: 4px;">
                    <strong>Berhasil!</strong> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background-color: #fef2f2; border-left: 4px solid #ef4444; color: #b91c1c; padding: 12px 16px; margin-bottom: 20px; border-radius: 4px;">
                    <strong>Gagal!</strong> {{ session('error') }}
                </div>
            @endif

            <div class="grid">
                <div class="card">
                    <h3>Informasi Pemesanan</h3>
                    <div class="row"><span class="key">Kode Pemesanan</span><span class="val">{{ $booking->kode_booking }}</span></div>
                    <div class="row"><span class="key">Tanggal Transaksi</span><span class="val">{{ optional($booking->created_at)->format('d M Y H:i') }}</span></div>
                    <div class="row">
                        <span class="key">Status</span>
                        <span class="val"><span class="status {{ strtolower($booking->status) }}">{{ $booking->status }}</span></span>
                    </div>
                </div>

                <div class="card">
                    <h3>Informasi Pelanggan</h3>
                    <div class="row"><span class="key">Nama</span><span class="val">{{ $booking->nama_pelanggan }}</span></div>
                    <div class="row"><span class="key">Email</span><span class="val">{{ $booking->email_pelanggan ?? '-' }}</span></div>
                    <div class="row"><span class="key">No. Handphone</span><span class="val">{{ $booking->nomor_handphone ?? '-' }}</span></div>
                    @if($booking->alamat_penjemputan)
                    <div class="row"><span class="key">Alamat Penjemputan</span><span class="val">{{ $booking->alamat_penjemputan }}</span></div>
                    @endif
                    <div class="row"><span class="key">Jumlah Peserta</span><span class="val">{{ $booking->jumlah_peserta }} orang</span></div>
                    @if($booking->nama_anggota && is_array($booking->nama_anggota) && count($booking->nama_anggota) > 0)
                    <div class="row"><span class="key">Peserta Tambahan</span><span class="val">{{ implode(', ', $booking->nama_anggota) }}</span></div>
                    @endif
                    <div class="row"><span class="key">Promo</span><span class="val">{{ $booking->promo?->kode ?? '-' }}</span></div>
                </div>
            </div>

            <div class="card">
                <h3>Detail Perjalanan</h3>
                <div class="row"><span class="key">Destinasi</span><span class="val">{{ $booking->jadwal?->destinasi?->nama ?? '-' }}</span></div>
                <div class="row"><span class="key">Tanggal Berangkat</span><span class="val">{{ optional($booking->jadwal?->tanggal_berangkat)->format('d M Y') ?? '-' }}</span></div>
                <div class="row"><span class="key">Tanggal Pulang</span><span class="val">{{ optional($booking->jadwal?->tanggal_pulang)->format('d M Y') ?? '-' }}</span></div>
            </div>

            @php
                $subtotalAsli = ($booking->jadwal?->destinasi?->harga_dasar ?? 0) * $booking->jumlah_peserta;
                $nominalDiskon = $subtotalAsli - $booking->total_bayar;
            @endphp

            <div class="summary">
                <div class="row"><span class="key">Subtotal</span><span class="val">Rp{{ number_format($subtotalAsli, 0, ',', '.') }}</span></div>
                @if($nominalDiskon > 0)
                    <div class="row" style="color: #f59e0b;"><span class="key">Potongan Promo ({{ $booking->promo?->kode }})</span><span class="val">- Rp{{ number_format($nominalDiskon, 0, ',', '.') }}</span></div>
                @endif
                <div class="row total"><span>Total Bayar</span><span>Rp{{ number_format((float) $booking->total_bayar, 0, ',', '.') }}</span></div>
            </div>

            <!-- Premium Card Cara Pembayaran -->
            <div class="payment-panel">
                <div class="payment-title-wrapper">
                    <svg style="width: 20px; height: 20px; color: #0c4a6e;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <h3 class="payment-title">Cara Pembayaran</h3>
                </div>
                <p style="font-size: 13.5px; line-height: 1.5; margin: 0; color: #475569;">
                    Silakan lakukan pembayaran sesuai dengan nominal <strong>Total Bayar</strong> ke salah satu rekening resmi Lokachara di bawah ini:
                </p>
                
                <div class="bank-grid">
                    <!-- BCA -->
                    <div class="bank-card">
                        <span class="bank-badge bca">BCA</span>
                        <div class="bank-number-wrapper">
                            <span class="bank-number">1234567890</span>
                            <button class="btn-copy" onclick="copyToClipboard('1234567890', 'BCA')" title="Salin Rekening">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="bank-holder">a.n. Lokachara Travel</div>
                    </div>
                    
                    <!-- Mandiri -->
                    <div class="bank-card">
                        <span class="bank-badge mandiri">MANDIRI</span>
                        <div class="bank-number-wrapper">
                            <span class="bank-number">0987654321</span>
                            <button class="btn-copy" onclick="copyToClipboard('0987654321', 'MANDIRI')" title="Salin Rekening">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="bank-holder">a.n. Lokachara Travel</div>
                    </div>
                </div>

                <div class="payment-steps">
                    <ol>
                        <li>Transfer sesuai jumlah <strong>Total Bayar</strong> ke rekening resmi di atas.</li>
                        <li>Simpan bukti transfer/transaksi Anda.</li>
                        <li>Klik tombol <strong>Konfirmasi via WhatsApp</strong> untuk mengirimkan bukti pembayaran guna verifikasi instan.</li>
                    </ol>
                </div>

                <div class="whatsapp-banner">
                    <div class="whatsapp-text">
                        Punya kendala atau ingin melakukan konfirmasi? Layanan verifikasi pembayaran kami aktif dan siap membantu Anda.
                    </div>
                    <a href="https://wa.me/{{ $siteSetting?->whatsapp_number ?? '6285954413123' }}?text=Halo%20Admin%2C%20saya%20ingin%20konfirmasi%20pembayaran%20dengan%20Kode%20Booking%20{{ $booking->kode_booking }}" 
                       target="_blank" rel="noopener noreferrer" 
                       class="whatsapp-btn">
                        <svg style="width: 18px; height: 18px;" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm5.735-3.305c1.552.921 3.42 1.408 5.321 1.409 5.568 0 10.101-4.524 10.104-10.086.002-2.695-1.044-5.228-2.949-7.135C16.362 2.977 13.84 1.931 11.16 1.932c-5.572 0-10.106 4.526-10.11 10.088-.001 1.902.501 3.761 1.454 5.334l-.994 3.63 3.725-.976zM17.472 14.382c-.32-.16-1.89-.93-2.185-1.04-.294-.11-.508-.16-.723.16-.214.32-.83 1.04-1.016 1.25-.187.21-.374.24-.694.08-.32-.16-1.353-.5-2.578-1.593-.952-.85-1.595-1.9-1.782-2.22-.187-.32-.02-.493.14-.653.143-.143.32-.373.48-.56.16-.188.213-.32.32-.533.107-.213.054-.4-.027-.56-.08-.16-.723-1.74-.99-2.39-.26-.623-.52-.538-.714-.548-.186-.01-.399-.01-.612-.01-.214 0-.56.08-.853.4-.294.32-1.123 1.1-1.123 2.68 0 1.58 1.15 3.11 1.31 3.32.16.21 2.263 3.456 5.482 4.847.765.33 1.363.528 1.83.676.768.243 1.467.209 2.02.127.618-.093 1.89-.773 2.157-1.48.267-.707.267-1.313.187-1.438-.08-.125-.294-.21-.614-.37z"/></svg>
                        Konfirmasi via WhatsApp
                    </a>
                </div>
            </div>

            <div class="footer">
                Terima kasih telah melakukan pemesanan. Simpan invoice ini sebagai bukti transaksi resmi.
                Jika ada kendala, silakan hubungi admin travel.
            </div>

            <div class="actions">

                @if(request()->has('admin'))
                    <a href="{{ route('bookings.invoice.download', $booking) }}" class="btn">Unduh</a>
                    <a href="javascript:window.print()" class="btn primary">Cetak</a>
                    <button id="sendEmailBtn" onclick="sendBothEmails()" class="btn" style="background-color: #f59e0b; color: white; border-color: #f59e0b; cursor: pointer;">Kirim Ulang Email</button>
                @endif
            </div>
        </div>
    </div>

    <!-- EmailJS SDK -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
    <script type="text/javascript">
        // Copy to clipboard helper
        function copyToClipboard(text, bankName) {
            navigator.clipboard.writeText(text).then(function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Rekening ' + bankName + ' berhasil disalin!',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            }, function(err) {
                console.error('Gagal menyalin text: ', err);
            });
        }
        (function() {
            // TODO: Ganti 'YOUR_PUBLIC_KEY' dengan Public Key dari akun EmailJS Anda
            emailjs.init({
                publicKey: "tgHFKu2zVmBHp6h6t",
            });
        })();

        function sendInvoiceEmail() {
            console.log("Mengirim email otomatis...");

            const templateParams = {
                to_email: "{{ $booking->email_pelanggan }}",
                to_name: "{{ $booking->nama_pelanggan }}",
                invoice_no: "{{ $booking->nomor_invoice }}",
                booking_code: "{{ $booking->kode_booking }}",
                destination: "{{ $booking->jadwal?->destinasi?->nama ?? '-' }}",
                departure_date: "{{ optional($booking->jadwal?->tanggal_berangkat)->format('d M Y') ?? '-' }}",
                total_amount: "Rp{{ number_format((float) $booking->total_bayar, 0, ',', '.') }}",
                jumlah_peserta: "{{ $booking->jumlah_peserta }} orang",
                nama_anggota: "{{ $booking->nama_anggota && is_array($booking->nama_anggota) ? implode(', ', $booking->nama_anggota) : '-' }}"
            };

            return emailjs.send('service_dtc7o08', 'template_jckdjnv', templateParams)
                .then(function() {
                    console.log('Email invoice berhasil dikirim!');
                }, function(error) {
                    console.error('Email invoice FAILED...', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Mengirim Email Invoice',
                        text: 'Error: ' + JSON.stringify(error)
                    });
                });
        }

        function sendPaymentInstructionsEmail() {
            console.log("Mengirim email cara pembayaran...");

            const templateParams = {
                to_email: "{{ $booking->email_pelanggan }}",
                to_name: "{{ $booking->nama_pelanggan }}",
                booking_code: "{{ $booking->kode_booking }}",
                total_amount: "Rp{{ number_format((float) $booking->total_bayar, 0, ',', '.') }}",
                destination: "{{ $booking->jadwal?->destinasi?->nama ?? '-' }}",
                departure_date: "{{ optional($booking->jadwal?->tanggal_berangkat)->format('d M Y') ?? '-' }}",
                payment_instructions: "Transfer ke Rekening Resmi Lokachara:\n- BCA: 1234567890 (a.n. Lokachara Travel)\n- Mandiri: 0987654321 (a.n. Lokachara Travel)"
            };

            return emailjs.send('service_dtc7o08', 'template_778nit1', templateParams)
                .then(function() {
                    console.log('Email instruksi pembayaran berhasil dikirim!');
                }, function(error) {
                    console.error('Email instruksi pembayaran FAILED...', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Mengirim Email Cara Pembayaran',
                        text: 'Harap periksa pengaturan template_778nit1 Anda di dashboard EmailJS. Error: ' + JSON.stringify(error)
                    });
                });
        }

        function sendBothEmails() {
            if ("{{ strtolower($booking->status) }}" === "dibayar") {
                sendInvoiceEmail();
            } else {
                sendPaymentInstructionsEmail();
            }
        }
    </script>

    @if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Pemesanan Berhasil!',
                text: "Silakan lakukan pembayaran sesuai dengan total tagihan ke salah satu rekening resmi di bawah, lalu lakukan konfirmasi via WhatsApp. Jika tidak melakukan pembayaran sekarang, detail tagihan ini juga telah dikirimkan ke email Anda.",
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#0ea5e9'
            });
        });
    </script>
    @endif
    
    @if(session('auto_send_email'))
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            setTimeout(function() {
                sendBothEmails();
            }, 500);
        });
    </script>
    @endif
</body>
</html>
