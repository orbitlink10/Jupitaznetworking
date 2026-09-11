@extends('layouts.app')

@section('title', 'Networking Guides & Articles | Jupitaz')
@section('meta_description', 'Practical networking guides for Kenyan businesses, installers and ISPs — routers, switches, wireless and fibre optic equipment.')

@section('content')
<div class="container py-4">
    <nav aria-label="Breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Blog</li>
        </ol>
    </nav>

    <h1 class="fw-bold">Networking Guides</h1>
    <p class="text-muted" style="max-width:720px;">Practical guides to help you choose and use networking, wireless and fibre optic equipment in Kenya.</p>

    <div class="row g-4 mt-2">
        @foreach($posts as $post)
            <div class="col-md-6">
                <a href="{{ route('blog.show', $post['slug']) }}" class="card border-0 shadow-sm h-100 text-decoration-none text-dark">
                    <div class="card-body p-4">
                        <span class="badge text-bg-light border mb-2">{{ $post['category'] }}</span>
                        <h2 class="h5 fw-bold">{{ $post['title'] }}</h2>
                        <p class="text-muted mb-2">{{ $post['excerpt'] }}</p>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($post['date'])->format('d M Y') }}</small>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
