@extends('layouts.app')

@section('title', 'Frequently Asked Questions | Jupitaz')
@section('meta_description', 'Answers to common questions about buying networking equipment from Jupitaz in Kenya.')

@section('content')
<div class="container py-4" style="max-width:860px;">
    <nav aria-label="Breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">FAQ</li>
        </ol>
    </nav>

    <h1 class="fw-bold">Frequently Asked Questions</h1>

    <div class="accordion mt-4" id="faq">
        <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#f1">How do I place an order?</button></h2>
            <div id="f1" class="accordion-collapse collapse show" data-bs-parent="#faq"><div class="accordion-body">Browse the catalogue, add products to your cart, then proceed to checkout and enter your contact and delivery details. Our team will contact you to confirm pricing, availability and delivery.</div></div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f2">Why do some products show "Call for Price"?</button></h2>
            <div id="f2" class="accordion-collapse collapse" data-bs-parent="#faq"><div class="accordion-body">Prices can change based on availability and order size. For products where we ask you to call for price, contact us and we will confirm the current price for your requirement.</div></div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f3">Do you deliver outside Nairobi?</button></h2>
            <div id="f3" class="accordion-collapse collapse" data-bs-parent="#faq"><div class="accordion-body">Yes. Delivery can be arranged to major towns across Kenya. Delivery cost and timelines depend on your location and order size.</div></div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f4">Do you supply equipment for ISPs and WISPs?</button></h2>
            <div id="f4" class="accordion-collapse collapse" data-bs-parent="#faq"><div class="accordion-body">Yes. We list ISP equipment including MikroTik routers, OLTs and ONUs, PLC splitters, wireless CPE, sector antennas and fibre tools. See our ISP Equipment category for the current range.</div></div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f5">Can I get technical help choosing a product?</button></h2>
            <div id="f5" class="accordion-collapse collapse" data-bs-parent="#faq"><div class="accordion-body">Yes. Contact us with your requirement and we can help you choose the right router, switch, access point or fibre solution.</div></div>
        </div>
    </div>
</div>
@endsection
