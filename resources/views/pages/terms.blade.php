@extends('layouts.app')

@section('title', 'Terms & Conditions | Jupitaz')
@section('meta_description', 'Terms and conditions for using the Jupitaz website.')

@section('content')
<div class="container py-4" style="max-width:860px;">
    <nav aria-label="Breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Terms &amp; Conditions</li>
        </ol>
    </nav>

    <h1 class="fw-bold">Terms &amp; Conditions</h1>

    <h2 class="h5 fw-bold mt-4">Use of this website</h2>
    <p>By using this website you agree to these terms. The content is provided for general information and is subject to change without notice.</p>

    <h2 class="h5 fw-bold mt-4">Product information and pricing</h2>
    <p>Product names, specifications and images are provided in good faith. Pricing and availability are confirmed when we contact you about your order. Where a product is listed as "Call for Price", the final price will be confirmed with you directly.</p>

    <h2 class="h5 fw-bold mt-4">Orders</h2>
    <p>Submitting an order through this website is a request that we contact you to confirm availability, pricing and delivery. An order is not a binding sale until confirmed.</p>

    <h2 class="h5 fw-bold mt-4">Limitation of liability</h2>
    <p>We are not liable for any indirect or consequential loss arising from the use of this website or from products purchased, except as required by law.</p>

    <p class="text-muted small">Note: These are general terms. Please contact us for any specific questions.</p>
</div>
@endsection
