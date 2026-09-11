<?php

namespace App\Http\Controllers;

class BlogController extends Controller
{
    private array $posts = [
        [
            'slug' => 'networking-equipment-suppliers-in-kenya',
            'title' => 'How to Choose a Networking Equipment Supplier in Kenya',
            'excerpt' => 'What ISPs, installers and IT teams should look for when buying routers, switches, fibre and wireless gear in Kenya.',
            'category' => 'Buying Guides',
            'date' => '2026-09-01',
        ],
        [
            'slug' => 'mikrotik-vs-ubiquiti-for-isps',
            'title' => 'MikroTik vs Ubiquiti: Which Is Right for a Kenyan ISP?',
            'excerpt' => 'A practical comparison of the two most popular brands among Kenyan ISPs and WISPs.',
            'category' => 'Brand Comparison',
            'date' => '2026-09-05',
        ],
        [
            'slug' => 'how-to-choose-a-network-switch',
            'title' => 'How to Choose a Network Switch: Ports, PoE and Management',
            'excerpt' => 'A plain-language guide to picking the right managed, unmanaged or PoE switch for your network.',
            'category' => 'Buying Guides',
            'date' => '2026-09-08',
        ],
        [
            'slug' => 'fibre-optic-tools-every-technician-needs',
            'title' => 'Fibre Optic Tools Every FTTH Technician Needs in Kenya',
            'excerpt' => 'The essential splicing, testing and installation tools for fibre-to-the-home deployments.',
            'category' => 'FTTH',
            'date' => '2026-09-10',
        ],
    ];

    public function index()
    {
        return view('blog.index', ['posts' => $this->posts]);
    }

    public function show(string $slug)
    {
        $post = collect($this->posts)->firstWhere('slug', $slug);

        abort_if(! $post, 404);

        return view('blog.show', ['post' => $post]);
    }
}
