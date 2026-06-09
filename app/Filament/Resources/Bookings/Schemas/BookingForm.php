<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Models\Booking;
use App\Models\Jadwal;
use App\Models\Promo;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_booking')
                    ->label('Kode Pemesanan')
                    ->disabled()
                    ->dehydrated(false)
                    ->placeholder('auto'),
                TextInput::make('nomor_invoice')
                    ->label('Nomor Invoice')
                    ->disabled()
                    ->dehydrated(false)
                    ->placeholder('auto'),
                Select::make('jadwal_id')
                    ->label('Jadwal')
                    ->relationship('jadwal', 'id', function ($query) {
                        $query->whereHas('destinasi', function ($q) {
                            $q->where('is_aktif', true);
                        });
                    })
                    ->getOptionLabelFromRecordUsing(function (Jadwal $row) {
                        $nama = $row->destinasi?->nama ?? '-';
                        $tgl = $row->tanggal_berangkat
                            ? $row->tanggal_berangkat->format('d M Y')
                            : '-';

                        return $nama . ' — ' . $tgl;
                    })
                    ->required()
                    ->disabled(fn (?Booking $record) => (bool) $record)
                    ->live()
                    ->helperText(function (Get $get) {
                        $id = $get('jadwal_id');
                        if (! $id) {
                            return null;
                        }
                        $j = Jadwal::find($id);
                        if (! $j) {
                            return null;
                        }
                        $sisa = (int) $j->sisa_kursi;
                        if ($sisa <= 0) {
                            return 'Kursi penuh';
                        }

                        return 'Sisa: ' . $sisa;
                    })
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $j = $get('jadwal_id') ? Jadwal::find($get('jadwal_id')) : null;
                        if ($j && (int) $j->sisa_kursi <= 0) {
                            $set('jumlah_peserta', null);
                            $set('total_bayar', 0);

                            return;
                        }
                        self::hitungTotal($get, $set);
                    }),

                TextInput::make('nama_pelanggan')
                    ->label('Nama Pelanggan')
                    ->disabled()
                    ->required(),
                TextInput::make('email_pelanggan')
                    ->label('Email Pelanggan')
                    ->disabled()
                    ->email()
                    ->maxLength(255),
                TextInput::make('nomor_handphone')
                    ->label('Nomor Handphone')
                    ->disabled()
                    ->maxLength(50),
                Textarea::make('alamat_penjemputan')
                    ->label('Alamat Penjemputan')
                    ->visible(function (Get $get) {
                        $jid = $get('jadwal_id');
                        if (! $jid) {
                            return false;
                        }
                        $j = Jadwal::find($jid);
                        return $j && str_contains(strtolower($j->destinasi?->nama ?? ''), 'bromo');
                    })
                    ->disabled()
                    ->columnSpanFull(),

                Select::make('promo_id')
                    ->label('Promo')
                    ->relationship('promo', 'kode', function ($query) {
                        $query->where('is_aktif', true)
                            ->where(function ($q) {
                                $q->whereNull('expired_at')
                                    ->orWhereDate('expired_at', '>=', now()->toDateString());
                            });
                    })
                    ->getOptionLabelFromRecordUsing(fn (Promo $p) => $p->kode . ' (' . $p->nama . ')')
                    ->helperText(function (Get $get) {
                        $pid = $get('promo_id');
                        if (! $pid) {
                            return null;
                        }
                        $p = Promo::find($pid);
                        if (! $p || ! $p->is_aktif || ($p->expired_at && $p->expired_at->isPast())) {
                            return null;
                        }

                        $jid = $get('jadwal_id');
                        $n = (int) ($get('jumlah_peserta') ?? 0);
                        if (! $jid || $n <= 0) {
                            if ($p->tipe_diskon === 'persentase') {
                                return 'Diskon ' . $p->nilai_diskon . '%';
                            }

                            return 'Potongan Rp' . number_format((float) $p->nilai_diskon, 0, ',', '.');
                        }

                        $jadwal = Jadwal::find($jid);
                        if (! $jadwal) {
                            return null;
                        }
                        $sub = (float) $jadwal->harga * $n;
                        if ($p->tipe_diskon === 'persentase') {
                            $diskon = $sub * ((float) $p->nilai_diskon / 100);
                        } else {
                            $diskon = (float) $p->nilai_diskon;
                        }

                        return 'Diskon: Rp' . number_format(max(0, $diskon), 0, ',', '.');
                    })
                    ->searchable()
                    ->disabled()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(fn (Get $get, Set $set) => self::hitungTotal($get, $set)),

                TextInput::make('jumlah_peserta')
                    ->label('Jumlah Peserta')
                    ->required(function (Get $get) {
                        $j = $get('jadwal_id') ? Jadwal::find($get('jadwal_id')) : null;

                        return (int) ($j?->sisa_kursi ?? 0) > 0;
                    })
                    ->numeric()
                    ->minValue(1)
                    ->disabled(function (Get $get) {
                        $j = $get('jadwal_id') ? Jadwal::find($get('jadwal_id')) : null;

                        return (int) ($j?->sisa_kursi ?? 0) <= 0;
                    })
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Get $get, Set $set) => self::hitungTotal($get, $set)),

                TextInput::make('total_bayar')
                    ->label('Total Bayar')
                    ->required()
                    ->numeric()
                    ->disabled()
                    ->readOnly()
                    ->prefix('Rp')
                    ->default(0),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Belum dibayar',
                        'dikonfirmasi' => 'Dikonfirmasi',
                        'dibayar' => 'Berhasil dibayar',
                        'dibatalkan' => 'Dibatalkan',
                    ])
                    ->required()
                    ->default('pending'),
            ]);
    }

    protected static function hitungTotal(Get $get, Set $set): void
    {
        $n = (int) ($get('jumlah_peserta') ?? 0);
        $jid = $get('jadwal_id');
        if (! $jid || $n <= 0) {
            $set('total_bayar', 0);

            return;
        }

        $jadwal = Jadwal::find($jid);
        if (! $jadwal) {
            $set('total_bayar', 0);

            return;
        }

        $total = (float) $jadwal->harga * $n;

        $pid = $get('promo_id');
        if ($pid) {
            $p = Promo::find($pid);
            if ($p && $p->is_aktif && (! $p->expired_at || ! $p->expired_at->isPast())) {
                if ($p->tipe_diskon === 'persentase') {
                    $total -= $total * ((float) $p->nilai_diskon / 100);
                } else {
                    $total -= (float) $p->nilai_diskon;
                }
            }
        }

        $set('total_bayar', max(0, (int) round($total)));
    }
}
