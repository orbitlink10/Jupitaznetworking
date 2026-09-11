@extends('layouts.app')

@section('title', 'Delivery Information | Jupitaz')
@section('meta_description', 'Delivery information for networking equipment orders from Jupitaz in Kenya.')

@section('content')
<div class="container py-4" style="max-width:860px;">
    <nav aria-label="Breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Delivery Information</li>
        </ol>
    </nav>

    <h1 class="fw-bold">Delivery Information</h1>
    <p>We aim to get your networking equipment to you quickly and safely. Delivery options, cost and timelines depend on your location, the size of your order and product availability.</p>

    <h2 class="h5 fw-bold mt-4">Delivery areas</h2>
    <p>Delivery is available within Nairobi and to major towns across Kenya. Please contact us to confirm delivery to your specific location before placing an order.</p>

    <h2 class="h5 fw-bold mt-4">Delivery times</h2>
    <p>Delivery times vary by product availability and destination. We will confirm an estimated delivery date when we contact you to confirm your order.</p>

    <h2 class="h5 fw-bold mt-4">Delivery charges</h2>
    <p>Delivery charges depend on the delivery location and the size and weight of your order. Final delivery costs are confirmed at checkout or when we contact you.</p>

    <p class="text-muted small">Note: Specific delivery fees and timelines should be confirmed with our team. Contact us for the most up-to-date information for your area.</p>
</div>
@endsection
