@extends('layouts.app')

@section('title', 'Networking Brands in Kenya | MikroTik, Ubiquiti, TP-Link | Jupitaz')
@section('meta_description', 'Shop networking equipment by brand in Kenya at Jupitaz. Browse MikroTik, Ubiquiti, TP-Link, D-Link, Tenda, Huawei, Grandstream and more.')

@section('content')
<div class="container py-4">
    <nav aria-label="Breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Brands</li>
        </ol>
    </nav>

    <h1 class="fw-bold">Networking Brands in Kenya</h1>
    <p class="text-muted" style="max-width:760px;">Browse networking equipment by manufacturer. From MikroTik and Ubiquiti for ISPs to TP-Link, D-Link and Tenda for homes and businesses.</p>

    <div class="row g-3 mt-2">
        @foreach($brands as $brand)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('brands.show', $brand->slug) }}" class="cat-tile h-100">
                    <span class="ico"><i class="bi bi-tag"></i></span>
                    <span class="fw-semibold text-dark">{{ $brand->name }}</span>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
