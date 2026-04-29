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

        return view('welcome', compact('destinasis', 'promos'));
    }

    public function showDestinasi($id)
    {
        $destinasi = Destinasi::with(['jadwals' => function($query) {
            $query->whereIn('status', ['tersedia', 'penuh'])->orderBy('tanggal_berangkat');
        }])->findOrFail($id);

        return view('destinasi-detail', compact('destinasi'));
    }
}
