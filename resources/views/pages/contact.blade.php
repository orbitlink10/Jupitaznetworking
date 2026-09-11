@extends('layouts.app')

@section('title', 'Contact Us | Jupitaz')
@section('meta_description', 'Contact Jupitaz for networking equipment, fibre optic, wireless and ISP products in Kenya.')
@section('robots', 'noindex, follow')

@section('content')
<div class="container py-4" style="max-width:860px;">
    <nav aria-label="Breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Contact Us</li>
        </ol>
    </nav>

    <h1 class="fw-bold">Contact Us</h1>
    <p class="text-muted">Questions about a product, pricing, availability or delivery? Get in touch.</p>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4">
                <h2 class="h5 fw-bold mb-3">Contact Details</h2>
                <ul class="list-unstyled d-grid gap-3 mb-0">
                    @if($supportPhone)
                        <li><i class="bi bi-telephone-fill text-primary me-2"></i>{{ $supportPhone }}</li>
                    @endif
                    @if($supportEmail)
                        <li><i class="bi bi-envelope-fill text-primary me-2"></i>{{ $supportEmail }}</li>
                    @endif
                    @if($supportWhatsapp)
                        <li><i class="bi bi-whatsapp text-success me-2"></i><a href="https://wa.me/{{ preg_replace('/\D/', '', $supportWhatsapp) }}" target="_blank" rel="noopener">Chat on WhatsApp</a></li>
                    @endif
                    @if($supportAddress)
                        <li><i class="bi bi-geo-alt-fill text-primary me-2"></i>{{ $supportAddress }}</li>
                    @endif
                </ul>
                @if(!$supportPhone && !$supportEmail && !$supportWhatsapp && !$supportAddress)
                    <p class="text-muted mb-0">Contact details will be published here shortly. Please use the form below in the meantime.</p>
                @endif
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4">
                <h2 class="h5 fw-bold mb-3">Send a Message</h2>
                <form action="{{ route('page.contact.submit') }}" method="post">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Name *</label><input type="text" name="name" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" required></div>
                        <div class="col-12"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control"></div>
                        <div class="col-12"><label class="form-label">Message *</label><textarea name="message" rows="5" class="form-control" required></textarea></div>
                    </div>
                    <button type="submit" class="btn btn-brand mt-3">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
