@extends('layouts.app')

@section('title', $post['title'].' | Jupitaz')
@section('meta_description', $post['excerpt'])
@section('canonical', route('blog.show', $post['slug']))

@section('schema')
<script type="application/ld+json">{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BlogPosting',
    'headline' => $post['title'],
    'description' => $post['excerpt'],
    'datePublished' => $post['date'],
    'author' => ['@type' => 'Organization', 'name' => 'Jupitaz'],
    'publisher' => ['@type' => 'Organization', 'name' => 'Jupitaz'],
    'mainEntityOfPage' => route('blog.show', $post['slug']),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endsection

@section('content')
<div class="container py-4" style="max-width:820px;">
    <nav aria-label="Breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
            <li class="breadcrumb-item active">{{ $post['title'] }}</li>
        </ol>
    </nav>

    <span class="badge text-bg-light border mb-2">{{ $post['category'] }}</span>
    <h1 class="fw-bold">{{ $post['title'] }}</h1>
    <p class="text-muted small">{{ \Carbon\Carbon::parse($post['date'])->format('d M Y') }}</p>

    <article class="article-body">
        @include('blog.posts.'.$post['slug'])
    </article>

    <div class="card border-0 shadow-sm p-4 mt-5 bg-brand text-white">
        <h2 class="h5 fw-bold">Need networking equipment in Kenya?</h2>
        <p class="mb-3 text-white-50">Browse our range of routers, switches, wireless and fibre optic products.</p>
        <a href="{{ route('products.index') }}" class="btn btn-accent">Shop Networking Equipment</a>
    </div>
</div>
@endsection

@push('styles')
<style>
    .article-body h2 { margin-top:2rem; font-weight:800; font-size:1.35rem; }
    .article-body h3 { margin-top:1.5rem; font-weight:700; font-size:1.15rem; }
    .article-body ul, .article-body ol { margin-bottom:1.25rem; }
    .article-body li { margin-bottom:.5rem; }
</style>
@endpush
