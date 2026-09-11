@extends('layouts.app')

@section('title', 'About Us | Jupitaz — Networking Equipment in Kenya')
@section('meta_description', 'Jupitaz is a Kenyan networking equipment supplier specialising in routers, switches, wireless, fibre optic, structured cabling, CCTV and ISP products.')

@section('content')
<div class="container py-4" style="max-width:860px;">
    <nav aria-label="Breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">About Us</li>
        </ol>
    </nav>

    <h1 class="fw-bold">About Jupitaz</h1>
    <p class="lead">A specialist networking equipment supplier for homes, businesses, installers and internet service providers in Kenya.</p>

    <p>Jupitaz supplies networking and ICT infrastructure products across Kenya. Our catalogue focuses on the equipment that keeps networks running: routers, network switches, wireless access points, wireless CPE and point-to-point links, fibre optic equipment, structured cabling, network cabinets, power over Ethernet (PoE) devices, CCTV and IP telephony.</p>

    <h2 class="h4 fw-bold mt-4">What we offer</h2>
    <ul>
        <li><strong>Networking</strong> — wired and wireless routers, switches and access points for home, office and enterprise networks.</li>
        <li><strong>Fibre optic</strong> — cables, patch cords, pigtails, PLC splitters, connectors, ODFs and FTTH installation tools.</li>
        <li><strong>Wireless</strong> — indoor and outdoor access points, CPEs, sector antennas and point-to-point links.</li>
        <li><strong>Structured cabling</strong> — Cat5e, Cat6 and Cat6a cabling, patch panels, RJ45 connectors and faceplates.</li>
        <li><strong>ISP equipment</strong> — MikroTik routers, OLTs and ONUs, wireless CPE and fibre tools for WISPs and FTTH deployments.</li>
        <li><strong>CCTV &amp; security</strong> — IP cameras, NVRs and related network video equipment.</li>
    </ul>

    <h2 class="h4 fw-bold mt-4">Our focus</h2>
    <p>We are a networking-first store rather than a general marketplace. That means our product data, categories and guidance are built around the way technicians, IT administrators, installers and ISPs actually buy equipment in Kenya — by brand, model number and technical specification.</p>

    <p>We aim to give customers clear product information, transparent pricing and practical guidance so they can choose the right equipment for their project, whether that is a single home router or a full FTTH rollout.</p>

    <p>For product availability, pricing or technical guidance, please <a href="{{ route('page.contact') }}">contact us</a>.</p>
</div>
@endsection
