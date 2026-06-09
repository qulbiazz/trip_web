<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $destinasis = Destinasi::where('is_aktif', true)
            ->orderBy('updated_at', 'desc')
            ->get(['id', 'updated_at']);

        $content = view('sitemap', compact('destinasis'))->render();

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
