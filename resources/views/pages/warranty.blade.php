@extends('layouts.app')

@section('title', 'Warranty Information | Jupitaz')
@section('meta_description', 'Warranty information for networking equipment purchased from Jupitaz in Kenya.')

@section('content')
<div class="container py-4" style="max-width:860px;">
    <nav aria-label="Breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Warranty Information</li>
        </ol>
    </nav>

    <h1 class="fw-bold">Warranty Information</h1>

    <p>Most networking equipment is covered by a manufacturer warranty. Warranty terms and duration vary by brand and product type.</p>

    <h2 class="h5 fw-bold mt-4">What is typically covered</h2>
    <ul>
        <li>Manufacturing defects and hardware faults under normal use.</li>
        <li>Replacement or repair according to the manufacturer's warranty policy.</li>
    </ul>

    <h2 class="h5 fw-bold mt-4">What is typically not covered</h2>
    <ul>
        <li>Damage from misuse, incorrect installation or power surges.</li>
        <li>Physical damage or damage caused by unauthorised modification.</li>
    </ul>

    <p>To confirm the warranty that applies to a specific product, contact us before or after purchase with the product model.</p>

    <p class="text-muted small">Note: Warranty is provided by the manufacturer. Please confirm the exact warranty terms for your product with our team.</p>
</div>
@endsection
