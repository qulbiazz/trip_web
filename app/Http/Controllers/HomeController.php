<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\Promo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $destinasis = Destinasi::where('is_aktif', true)->take(6)->get();
        $promos = Promo::where('is_aktif', true)->take(3)->get();
        $siteSetting = \App\Models\SiteSetting::where('is_active', true)->first();
        $testimonis = \App\Models\Testimoni::where('is_aktif', true)->get();

        return view('welcome', compact('destinasis', 'promos', 'siteSetting', 'testimonis'));
    }

    public function showDestinasi(string $id)
    {
        $destinasi = Destinasi::with(['jadwals' => function($query) {
            $query->whereIn('status', ['tersedia', 'penuh'])->orderBy('tanggal_berangkat');
        }])->findOrFail($id);

        return view('destinasi-detail', compact('destinasi'));
    }
}
