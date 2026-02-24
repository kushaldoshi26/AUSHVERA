@extends('layouts.app')

@section('title', 'Contact — AUSHVERA')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/contact-premium.css') }}">
@endpush

@section('content')
    <section class="premium-contact-section">
        <div class="premium-contact-container">
            <div class="product-visual-left">
                <svg width="100%" height="700" viewBox="0 0 600 700" fill="none">
                    <rect width="600" height="700" fill="#F5EFE6"/>
                    <ellipse cx="150" cy="200" rx="80" ry="40" fill="#E8E3D8" opacity="0.5"/>
                    <ellipse cx="450" cy="300" rx="70" ry="35" fill="#E8E3D8" opacity="0.4"/>
                    <ellipse cx="200" cy="500" rx="60" ry="30" fill="#E8E3D8" opacity="0.45"/>
                    <ellipse cx="400" cy="520" rx="60" ry="18" fill="#C6A75E" opacity="0.2"/>
                    <rect x="350" y="470" width="100" height="50" rx="10" fill="#F5EFE6" stroke="#C6A75E" stroke-width="2"/>
                    <ellipse cx="400" cy="470" rx="50" ry="15" fill="#C6A75E" opacity="0.15"/>
                    <g>
                        <rect x="220" y="250" width="100" height="280" rx="10" fill="#0B1C2D"/>
                        <rect x="225" y="255" width="90" height="270" rx="8" fill="#071421"/>
                        <rect x="235" y="300" width="70" height="100" rx="5" fill="#C6A75E"/>
                        <circle cx="270" cy="330" r="15" stroke="#0B1C2D" stroke-width="2" fill="none"/>
                        <path d="M270 320 L266 330 L274 330 L270 320Z" fill="#0B1C2D"/>
                        <rect x="268" y="330" width="4" height="10" fill="#0B1C2D"/>
                        <text x="270" y="365" text-anchor="middle" fill="#0B1C2D" font-size="10" font-family="serif" letter-spacing="1">AUSHVERA</text>
                        <text x="270" y="380" text-anchor="middle" fill="#0B1C2D" font-size="7" font-family="serif" font-style="italic">Ashvattha™</text>
                        <rect x="235" y="230" width="70" height="25" rx="4" fill="#C6A75E"/>
                        <rect x="255" y="220" width="30" height="15" rx="3" fill="#C6A75E"/>
                        <rect x="235" y="260" width="20" height="80" rx="3" fill="#F5EFE6" opacity="0.1"/>
                    </g>
                    <path d="M150 350 Q140 370 150 390" stroke="#C6A75E" stroke-width="2" fill="none" opacity="0.4"/>
                    <ellipse cx="145" cy="370" rx="10" ry="20" fill="#C6A75E" opacity="0.3"/>
                </svg>
            </div>

            <div class="premium-form-box">
                <h1>Join the Journey</h1>
                <form class="premium-form">
                    <div class="premium-input-group">
                        <input type="text" placeholder="Name" required>
                    </div>
                    <div class="premium-input-group">
                        <input type="email" placeholder="Email" required>
                    </div>
                    <div class="premium-input-group">
                        <textarea placeholder="Message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="premium-button">SEND MESSAGE</button>
                </form>
            </div>
        </div>
    </section>
@endsection
