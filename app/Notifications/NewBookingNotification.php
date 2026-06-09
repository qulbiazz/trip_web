<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Actions\Action;

class NewBookingNotification extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $destinasi  = $this->booking->jadwal?->destinasi?->nama ?? '-';
        $tanggal    = $this->booking->jadwal?->tanggal_berangkat
                        ? \Carbon\Carbon::parse($this->booking->jadwal->tanggal_berangkat)->translatedFormat('d M Y')
                        : '-';
        $peserta    = $this->booking->jumlah_peserta;
        $kode       = $this->booking->kode_booking;
        $nama       = $this->booking->nama_pelanggan;
        $hp         = $this->booking->nomor_handphone ?? '-';
        $total      = 'Rp' . number_format($this->booking->total_bayar, 0, ',', '.');

        $body  = "👤 **{$nama}** | 📞 {$hp}\n";
        $body .= "🏖️ **{$destinasi}** — 📅 {$tanggal}\n";
        $body .= "👥 Peserta: **{$peserta} orang**\n";

        if (!empty($this->booking->nama_anggota) && is_array($this->booking->nama_anggota)) {
            $body .= "🧑‍🤝‍🧑 Tambahan: " . implode(', ', $this->booking->nama_anggota) . "\n";
        }

        $body .= "💰 Total: **{$total}**\n";
        $body .= "🔖 Kode: `{$kode}`";

        return FilamentNotification::make()
            ->title('🎉 Booking Baru Masuk!')
            ->icon('heroicon-o-ticket')
            ->iconColor('warning')
            ->body($body)
            ->actions([
                Action::make('lihat')
                    ->label('Lihat Pemesanan')
                    ->url(route('filament.admin.resources.bookings.edit', $this->booking))
                    ->markAsRead(),
            ])
            ->getDatabaseMessage();
    }
}
