<?php

namespace Database\Seeders;

use App\Models\Destinasi;
use Illuminate\Database\Seeder;

class DestinasiSeeder extends Seeder
{
    public function run(): void
    {
        $destinasi = [

            [
                'nama' => 'Open Trip Bromo Sunrise & Kawah',
                'deskripsi' => 'Rasakan pengalaman tak terlupakan menyaksikan matahari terbit dari titik pandang terbaik, dilanjutkan dengan petualangan melintasi lautan pasir menggunakan Jeep 4WD menuju Kawah Bromo, Pasir Berbisik, dan Padang Savana.',
                'lokasi' => 'Taman Nasional Bromo Tengger Semeru, Jawa Timur',
                'negara' => 'Indonesia',
                'harga_dasar' => 350000,
                'gambar' => null,
                'kategori' => 'domestik',
                'fasilitas' => "Jeep 4WD Bromo\nTiket Masuk TNBTS\nSnack & Air Mineral\nDokumentasi Foto\nGuide Lokal",
                'is_aktif' => true,
            ],

            [
                'nama' => 'Eksplorasi Budaya dan Alam Ubud',
                'deskripsi' => 'Paket wisata eksklusif menikmati keindahan alam persawahan Tegalalang, Monkey Forest, dan kekayaan seni budaya Bali.',
                'lokasi' => 'Gianyar, Bali',
                'negara' => 'Indonesia',
                'harga_dasar' => 750000,
                'gambar' => null,
                'kategori' => 'domestik',
                'fasilitas' => "Transportasi Mobil AC Pribadi\nMakan Siang Buffet\nTiket Masuk Wisata\nPemandu Wisata",
                'is_aktif' => true,
            ],

            [
                'nama' => 'Island Hopping Kepulauan Seribu',
                'deskripsi' => 'Nikmati keindahan bawah laut, snorkeling, bersepeda santai, dan bersantai di Pantai Pasir Perawan.',
                'lokasi' => 'Kepulauan Seribu, DKI Jakarta',
                'negara' => 'Indonesia',
                'harga_dasar' => 450000,
                'gambar' => null,
                'kategori' => 'domestik',
                'fasilitas' => "Tiket Kapal PP\nHomestay AC\nAlat Snorkeling\nBBQ Seafood\nSepeda",
                'is_aktif' => true,
            ],

            [
                'nama' => 'Labuan Bajo Sailing Trip',
                'deskripsi' => 'Jelajahi Pulau Padar, Pink Beach, Pulau Komodo, dan spot snorkeling terbaik di Labuan Bajo.',
                'lokasi' => 'Labuan Bajo, Nusa Tenggara Timur',
                'negara' => 'Indonesia',
                'harga_dasar' => 1850000,
                'gambar' => null,
                'kategori' => 'domestik',
                'fasilitas' => "Kapal Wisata\nMakan 3x\nGuide Lokal\nLife Jacket\nDokumentasi",
                'is_aktif' => true,
            ],

            [
                'nama' => 'Open Trip Kawah Ijen Blue Fire',
                'deskripsi' => 'Menyaksikan fenomena Blue Fire yang langka dan menikmati panorama kawah berwarna hijau toska.',
                'lokasi' => 'Banyuwangi, Jawa Timur',
                'negara' => 'Indonesia',
                'harga_dasar' => 500000,
                'gambar' => null,
                'kategori' => 'domestik',
                'fasilitas' => "Transportasi\nMasker Gas\nGuide Pendakian\nTiket Masuk",
                'is_aktif' => true,
            ],

            [
                'nama' => 'Raja Ampat Snorkeling Adventure',
                'deskripsi' => 'Petualangan bahari menikmati surga bawah laut Raja Ampat dengan keanekaragaman hayati kelas dunia.',
                'lokasi' => 'Raja Ampat, Papua Barat Daya',
                'negara' => 'Indonesia',
                'harga_dasar' => 3500000,
                'gambar' => null,
                'kategori' => 'domestik',
                'fasilitas' => "Speedboat\nPenginapan\nAlat Snorkeling\nMakan 3x\nGuide",
                'is_aktif' => true,
            ],

            [
                'nama' => 'Bangkok City Tour',
                'deskripsi' => 'Menjelajahi Grand Palace, Wat Arun, Chatuchak Market, dan wisata kuliner khas Thailand.',
                'lokasi' => 'Bangkok',
                'negara' => 'Thailand',
                'harga_dasar' => 4200000,
                'gambar' => null,
                'kategori' => 'internasional',
                'fasilitas' => "Hotel 3 Malam\nTransportasi\nGuide\nTiket Wisata",
                'is_aktif' => true,
            ],

            [
                'nama' => 'Singapore Explorer',
                'deskripsi' => 'Kunjungi Marina Bay Sands, Gardens by the Bay, Merlion Park, dan Universal Studios Singapore.',
                'lokasi' => 'Singapore',
                'negara' => 'Singapore',
                'harga_dasar' => 5500000,
                'gambar' => null,
                'kategori' => 'internasional',
                'fasilitas' => "Hotel 3 Malam\nTransportasi\nTiket USS\nSarapan",
                'is_aktif' => true,
            ],
        ];

        foreach ($destinasi as $item) {
            Destinasi::create($item);
        }
    }
}