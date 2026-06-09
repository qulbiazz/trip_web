<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    {{-- Halaman Utama --}}
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
    </url>

    {{-- Halaman Detail Destinasi --}}
    @foreach ($destinasis as $destinasi)
    <url>
        <loc>{{ url('/destinasi/' . $destinasi->id) }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
        <lastmod>{{ $destinasi->updated_at->toAtomString() }}</lastmod>
    </url>
    @endforeach

</urlset>
