@extends('layouts.app')

@section('title', 'Privacy Policy | Jupitaz')
@section('meta_description', 'Privacy policy for Jupitaz.')

@section('content')
<div class="container py-4" style="max-width:860px;">
    <nav aria-label="Breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Privacy Policy</li>
        </ol>
    </nav>

    <h1 class="fw-bold">Privacy Policy</h1>
    <p>This policy explains how Jupitaz handles personal information collected through this website.</p>

    <h2 class="h5 fw-bold mt-4">Information we collect</h2>
    <ul>
        <li>Contact details you provide when registering, placing an order or contacting us (such as name, email, phone number and delivery details).</li>
        <li>Order and enquiry history.</li>
    </ul>

    <h2 class="h5 fw-bold mt-4">How we use your information</h2>
    <ul>
        <li>To process and deliver your orders.</li>
        <li>To respond to enquiries and provide product guidance.</li>
        <li>To comply with any applicable legal obligations.</li>
    </ul>

    <h2 class="h5 fw-bold mt-4">Sharing your information</h2>
    <p>We only share information where necessary to fulfil your order (for example, with delivery partners) or where required by law. We do not sell your personal information.</p>

    <h2 class="h5 fw-bold mt-4">Contact</h2>
    <p>For privacy-related questions, please <a href="{{ route('page.contact') }}">contact us</a>.</p>
</div>
@endsection
