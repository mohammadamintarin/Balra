<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($categories as $item)
        <url>
            <loc>
                https://www.nivor.ir/{{$item->slug}}
            </loc>
            <lastmod>{{ $item->created_at->tz('UTC')->toAtomString()}}</lastmod>
        </url>
    @endforeach
</urlset>
