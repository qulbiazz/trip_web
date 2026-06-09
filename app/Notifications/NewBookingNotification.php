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
        // Susun nama peserta tambahan jika ada
        $namaTambahan = '';
        if (!empty($this->booking->nama_anggota) && is_array($this->booking->nama_anggota)) {
            $namaTambahan = "\nPeserta Tambahan: **" . implode(', ', $this->booking->nama_anggota) . "**";
        }

        return FilamentNotification::make()
            ->title('Booking Baru Masuk!')
            ->icon('heroicon-o-ticket')
            ->iconColor('warning')
            ->body(
                "**{$this->booking->nama_pelanggan}** memesan **{$this->booking->jadwal?->destinasi?->nama}** " .
                "untuk **{$this->booking->jumlah_peserta} peserta**. Kode: `{$this->booking->kode_booking}`" .
                $namaTambahan
            )
            ->actions([
                Action::make('lihat')
                    ->label('Lihat Pemesanan')
                    ->url(route('filament.admin.resources.bookings.edit', $this->booking))
                    ->markAsRead(),
            ])
            ->getDatabaseMessage();
    }
}
