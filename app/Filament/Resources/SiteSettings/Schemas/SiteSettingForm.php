<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //  Section::make('Informasi Umum')
                //      ->description('Pengaturan nama website dan status keaktifan halaman utama.')
                //      ->collapsible()
                //      ->columnSpanFull()
                //      ->schema([
                //          Grid::make(2)
                //              ->columnSpanFull()
                //              ->schema([
                //                  TextInput::make('site_name')
                //                      ->label('Nama Website')
                //                      ->placeholder('Contoh: Traval')
                //                      ->helperText('Nama website yang akan tampil di tab browser dan footer.')
                //                      ->required()
                //                      ->maxLength(255),
                //                  Toggle::make('is_active')
                //                      ->label('Status Aktif')
                //                      ->helperText('Aktifkan agar landing page dapat diakses oleh publik.')
                //                      ->required()
                //                      ->default(true),
                //              ]),
                //          TextInput::make('whatsapp_number')
                //              ->label('Nomor WhatsApp Admin')
                //              ->placeholder('Contoh: 6285954413123')
                //              ->helperText('Nomor WhatsApp tanpa tanda + dan spasi (contoh: 6281234567890). Digunakan untuk tombol konfirmasi pembayaran di halaman invoice.')
                //              ->required()
                //              ->maxLength(20)
                //              ->columnSpanFull(),
                //      ]),

                Section::make('Bagian Hero (Banner Utama)')
                    ->description('Teks, tombol (CTA), dan gambar latar belakang yang tampil di bagian atas halaman.')
                    ->collapsible()
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->columnSpanFull()
                            ->schema([
                                TextInput::make('hero_badge')
                                    ->label('Lencana Hero (Hero Badge)')
                                    ->placeholder('Contoh: New Promo / Destinasi Impian')
                                    ->helperText('Teks kecil di atas judul utama.')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('hero_highlight')
                                    ->label('Sorotan Judul (Hero Highlight)')
                                    ->placeholder('Contoh: Petualangan Menanti!')
                                    ->helperText('Kata kunci penting yang diberi sorotan warna khusus.')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        TextInput::make('hero_title')
                            ->label('Judul Utama Hero')
                            ->placeholder('Contoh: Jelajahi Keindahan Dunia Bersama Kami')
                            ->helperText('Judul besar utama di bagian banner.')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('hero_description')
                            ->label('Deskripsi Hero')
                            ->placeholder('Tulis deskripsi singkat yang menarik pengunjung...')
                            ->helperText('Teks penjelasan di bawah judul utama.')
                            ->rows(3)
                            ->columnSpanFull(),
                        FileUpload::make('hero_image')
                            ->label('Gambar Latar Belakang Hero')
                            ->image()
                            ->disk('public')
                            ->directory('site-settings')
                            ->visibility('public')
                            ->columnSpanFull()
                            ->helperText('Unggah gambar resolusi tinggi (Minimal: 1280x720px, Rekomendasi: 1920x1080px. Format: JPG/PNG/WEBP. Maks: 5MB).')
                            ->rules([
                                'mimes:jpg,jpeg,png,webp',
                                'max:5120',
                                'dimensions:min_width=1280,min_height=720' // <-- Ini validasi minimal panjang dan lebarnya
                            ])
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                        Grid::make(2)
                            ->columnSpanFull()
                            ->schema([
                                TextInput::make('cta_primary_text')
                                    ->label('Teks Tombol Utama (CTA)')
                                    ->placeholder('Contoh: Cari Destinasi')
                                    ->helperText('Teks untuk tombol pencarian utama.')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('cta_secondary_text')
                                    ->label('Teks Tombol Sekunder (CTA)')
                                    ->placeholder('Contoh: Hubungi Kami')
                                    ->helperText('Teks untuk tombol penjelasan tambahan.')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ]),
            ]);
    }
}
