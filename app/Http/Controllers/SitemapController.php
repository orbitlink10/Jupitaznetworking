<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $base = rtrim(config('app.url'), '/');

        $urls = [];

        $urls[] = $this->entry($base.'/', now()->toAtomString(), '1.0');

        foreach (Category::active()->orderBy('id')->get() as $category) {
            $urls[] = $this->entry($base.'/'.$category->path(), $category->updated_at?->toAtomString());
        }

        foreach (Brand::active()->orderBy('id')->get() as $brand) {
            $urls[] = $this->entry($base.'/brands/'.$brand->slug, $brand->updated_at?->toAtomString());
        }

        foreach (Product::active()->orderBy('id')->get() as $product) {
            $urls[] = $this->entry($base.'/product/'.$product->slug, $product->updated_at?->toAtomString());
        }

        $pages = [
            'products', 'about-us', 'contact-us', 'faq', 'delivery-information',
            'returns-refunds', 'warranty-information', 'privacy-policy', 'terms-and-conditions', 'blog',
        ];

        foreach ($pages as $page) {
            $urls[] = $this->entry($base.'/'.$page, now()->toAtomString(), '0.6');
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
        $xml .= implode("\n", $urls)."\n";
        $xml .= '</urlset>';

        return Response::make($xml, 200, ['Content-Type' => 'application/xml']);
    }

    private function entry(string $loc, ?string $lastmod = null, string $priority = '0.8'): string
    {
        $xml = '  <url>';
        $xml .= '<loc>'.htmlspecialchars($loc, ENT_XML1).'</loc>';
        if ($lastmod) {
            $xml .= '<lastmod>'.htmlspecialchars($lastmod, ENT_XML1).'</lastmod>';
        }
        $xml .= '<changefreq>weekly</changefreq>';
        $xml .= '<priority>'.$priority.'</priority>';
        $xml .= '</url>';

        return $xml;
    }
}
