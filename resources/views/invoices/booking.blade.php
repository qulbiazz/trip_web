<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $booking->nomor_invoice ?? ('BOOKING-' . $booking->id) }}</title>
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
                <div class="label">Nomor Invoice</div>
                <div class="value">{{ $booking->nomor_invoice }}</div>
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
                    <div class="row"><span class="key">Jumlah Peserta</span><span class="val">{{ $booking->jumlah_peserta }} orang</span></div>
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

            <div class="footer">
                Terima kasih telah melakukan pemesanan. Simpan invoice ini sebagai bukti transaksi resmi.
                Jika ada kendala, silakan hubungi admin travel.
            </div>

            <div class="actions">
                @if(strtolower($booking->status) === 'pending')
                <form action="{{ route('bookings.simulate-payment', $booking) }}" method="POST" style="margin: 0; display: inline-block;">
                    @csrf
                    <button type="submit" class="btn" style="background-color: #10b981; color: white; border-color: #10b981; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Simulasi Bayar
                    </button>
                </form>
                @endif
                @if(request()->has('admin'))
                    <a href="{{ route('bookings.invoice.download', $booking) }}" class="btn">Unduh</a>
                    <a href="javascript:window.print()" class="btn primary">Cetak</a>
                    <button id="sendEmailBtn" onclick="sendInvoiceEmail()" class="btn" style="background-color: #f59e0b; color: white; border-color: #f59e0b; cursor: pointer;">Kirim Ulang Email</button>
                @endif
            </div>
        </div>
    </div>

    <!-- EmailJS SDK -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
    <script type="text/javascript">
        (function() {
            // TODO: Ganti 'YOUR_PUBLIC_KEY' dengan Public Key dari akun EmailJS Anda
            emailjs.init({
                publicKey: "tgHFKu2zVmBHp6h6t",
            });
        })();

        function sendInvoiceEmail() {
            console.log("Mengirim email otomatis...");

            // Template params sesuai dengan data invoice
            const templateParams = {
                to_email: "{{ $booking->email_pelanggan }}",
                to_name: "{{ $booking->nama_pelanggan }}",
                invoice_no: "{{ $booking->nomor_invoice ?? ('BOOKING-' . $booking->id) }}",
                booking_code: "{{ $booking->kode_booking }}",
                destination: "{{ $booking->jadwal?->destinasi?->nama ?? '-' }}",
                departure_date: "{{ optional($booking->jadwal?->tanggal_berangkat)->format('d M Y') ?? '-' }}",
                total_amount: "Rp{{ number_format((float) $booking->total_bayar, 0, ',', '.') }}"
            };

            emailjs.send('service_dtc7o08', 'template_jckdjnv', templateParams)
                .then(function() {
                    console.log('Email berhasil dikirim!');
                    // Anda bisa mengganti alert ini dengan SweetAlert atau notifikasi lain jika mau
                }, function(error) {
                    console.log('FAILED...', error);
                });
        }
    </script>
    
    @if(session('auto_send_email'))
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            setTimeout(function() {
                sendInvoiceEmail();
            }, 500);
        });
    </script>
    @endif
</body>
</html>
