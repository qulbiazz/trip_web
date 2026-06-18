<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\Promo;
use App\Models\Jadwal; // Tambahan model Jadwal
use Carbon\Carbon;     // Tambahan Carbon untuk filter tanggal
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $destinasis = Destinasi::where('is_aktif', true)->paginate(6);
        $promos = Promo::where('is_aktif', true)->take(3)->get();
        $siteSettings = \App\Models\SiteSetting::where('is_active', true)->get();
        $siteSetting = $siteSettings->first();
        $siteSetting = $siteSettings->first();
        $testimonis = \App\Models\Testimoni::where('is_aktif', true)->get();

        // Query untuk data realtime Open Booking di Navbar
        $jadwalOpen = Jadwal::with('destinasi')
            ->where('status', 'tersedia') // Menggunakan status 'tersedia' sesuai sistem Anda
            ->where('pendaftaran_tutup', '>=', Carbon::now()->format('Y-m-d'))
            ->where('sisa_kursi', '>', 0)
            ->orderBy('tanggal_berangkat', 'asc')
            ->limit(3) // Dibatasi 3 agar banner tidak terlalu panjang di UI
            ->get();

         return view('welcome', compact('destinasis', 'promos', 'siteSettings', 'siteSetting', 'testimonis', 'jadwalOpen'));
    }

    public function showDestinasi(string $id)
    {
        $destinasi = Destinasi::with(['jadwals' => function($query) {
            $query->whereIn('status', ['tersedia', 'penuh'])->orderBy('tanggal_berangkat');
        }])->findOrFail($id);

        return view('destinasi-detail', compact('destinasi'));
    }
}