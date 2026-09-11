@extends('layouts.app')

@section('title', 'Returns & Refunds | Jupitaz')
@section('meta_description', 'Returns and refunds policy for Jupitaz networking equipment orders in Kenya.')

@section('content')
<div class="container py-4" style="max-width:860px;">
    <nav aria-label="Breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Returns &amp; Refunds</li>
        </ol>
    </nav>

    <h1 class="fw-bold">Returns &amp; Refunds</h1>

    <h2 class="h5 fw-bold mt-4">Damaged or incorrect items</h2>
    <p>Please inspect your order on delivery. If an item arrives damaged or is not what you ordered, contact us as soon as possible so we can resolve the issue.</p>

    <h2 class="h5 fw-bold mt-4">Return conditions</h2>
    <ul>
        <li>Items should be returned in their original packaging and condition where possible.</li>
        <li>Return eligibility may depend on the product type and manufacturer policy.</li>
        <li>Certain items (for example, cut cable or custom-built assemblies) may not be returnable once prepared.</li>
    </ul>

    <h2 class="h5 fw-bold mt-4">How to request a return</h2>
    <p>Contact us with your order number and details of the issue. We will advise on the next steps and whether a refund or replacement applies.</p>

    <p class="text-muted small">Note: This page summarises our general approach. Specific terms may vary by product and manufacturer — please confirm with our team for your particular order.</p>
</div>
@endsection
