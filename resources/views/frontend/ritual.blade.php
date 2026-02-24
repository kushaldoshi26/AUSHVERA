@extends('layouts.app')

@section('title', 'The Ritual — AUSHVERA')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Inter:wght@400;500&display=swap" rel="stylesheet">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: #F5EFE6;
        color: #5E5E5E;
        line-height: 1.8;
        font-size: 17px;
        position: relative;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400"><filter id="noise"><feTurbulence type="fractalNoise" baseFrequency="0.9" numOctaves="4" stitchTiles="stitch"/></filter><rect width="400" height="400" filter="url(%23noise)" opacity="0.03"/></svg>');
        pointer-events: none;
        z-index: 1;
    }

    main {
        position: relative;
        z-index: 2;
    }

    h1, h2, h3 {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 300;
        color: #1C1C1C;
        letter-spacing: 1px;
    }

    em {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
    }

    .hero {
        text-align: center;
        padding: 140px 40px 120px;
        max-width: 900px;
        margin: 0 auto;
    }

    .hero h1 {
        font-size: 68px;
        margin-bottom: 24px;
        text-transform: uppercase;
        letter-spacing: 3px;
    }

    .hero .tagline {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 32px;
        color: #1C1C1C;
        margin-bottom: 40px;
    }

    .hero p {
        max-width: 700px;
        margin: 0 auto 40px;
        font-size: 17px;
    }

    .divider {
        width: 60px;
        height: 1px;
        background-color: #C6A45C;
        margin: 0 auto;
    }

    .section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 120px 40px;
    }

    .two-column {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
    }

    .section-number {
        font-family: 'Cormorant Garamond', serif;
        font-size: 72px;
        color: #C6A45C;
        opacity: 0.4;
        font-weight: 300;
        margin-bottom: 16px;
    }

    .section-title {
        font-size: 38px;
        margin-bottom: 32px;
    }

    .section-text p {
        margin-bottom: 24px;
    }

    .section-image {
        width: 100%;
        height: 500px;
        object-fit: cover;
        border-radius: 4px;
    }

    .step-section {
        padding: 80px 0;
    }

    .step-section:first-of-type {
        padding-top: 0;
    }

    .reverse {
        direction: rtl;
    }

    .reverse > * {
        direction: ltr;
    }

    .practice-list {
        list-style: none;
        margin: 32px 0;
    }

    .practice-list li {
        padding: 12px 0;
        padding-left: 24px;
        position: relative;
    }

    .practice-list li::before {
        content: '•';
        position: absolute;
        left: 0;
        color: #C6A45C;
        font-size: 20px;
    }

    .practice-quote {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 20px;
        color: #1C1C1C;
        margin-top: 40px;
    }

    .final-section {
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
        padding: 120px 40px;
    }

    .final-section h2 {
        font-size: 40px;
        margin-bottom: 32px;
    }

    .final-section p {
        margin-bottom: 24px;
    }

    .final-divider {
        width: 60px;
        height: 1px;
        background-color: #C6A45C;
        margin: 40px auto 0;
    }

    @media (max-width: 968px) {
        .two-column {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .reverse {
            direction: ltr;
        }

        .hero h1 {
            font-size: 48px;
        }

        .hero .tagline {
            font-size: 24px;
        }

        .section-title {
            font-size: 32px;
        }

        .section {
            padding: 80px 24px;
        }
    }
</style>
@endpush

@section('content')
    <style>
        nav {
            background: #0B1C2D;
        }
    </style>
    <main>
        <section class="hero">
            <h1>THE RITUAL</h1>
            <p class="tagline">Not a Routine. A Return.</p>
            <p>In a world that moves quickly, ritual brings us back to stillness. The Aushvera ritual is not about complexity. It is about presence. A simple moment. Done consistently. Done consciously.</p>
            <div class="divider"></div>
        </section>

        <section class="section">
            <div class="two-column">
                <div>
                    <div class="section-number">1</div>
                    <h2 class="section-title">Why Ritual Matters</h2>
                    <div class="section-text">
                        <p>Wellness is not built in dramatic shifts. It is shaped through daily discipline. A ritual transforms an action into intention. It creates pause in a busy day.</p>
                        <p>It anchors the mind before the world begins — or after it settles. Aushvera is designed to become part of that rhythm.</p>
                    </div>
                </div>
                <div>
                    <img src="https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=800&q=80" alt="Herbal tea on linen" class="section-image">
                </div>
            </div>
        </section>

        <section class="section step-section">
            <div class="two-column">
                <div>
                    <div class="section-number">2</div>
                    <h2 class="section-title">Step 1 — Prepare</h2>
                    <div class="section-text">
                        <p>Pour warm water or milk into a clean cup. Choose a quiet moment — morning clarity or evening stillness.</p>
                    </div>
                </div>
                <div>
                    <img src="https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=800&q=80" alt="Glass cup preparation" class="section-image">
                </div>
            </div>
        </section>

        <section class="section step-section">
            <div class="two-column reverse">
                <div>
                    <img src="https://images.unsplash.com/photo-1587080266227-677cc2a4e76e?w=800&q=80" alt="Dropper bottle" class="section-image">
                </div>
                <div>
                    <div class="section-number">3</div>
                    <h2 class="section-title">Step 2 — Add</h2>
                    <div class="section-text">
                        <p>Add one measured dropper of Ashvattha™. Watch the infusion blend gently.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section step-section">
            <div class="two-column">
                <div>
                    <div class="section-number">4</div>
                    <h2 class="section-title">Step 3 — Pause</h2>
                    <div class="section-text">
                        <p>Before sipping, take one slow breath. Allow the aroma and warmth to ground you.</p>
                    </div>
                </div>
                <div>
                    <img src="https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=800&q=80" alt="Moment of pause" class="section-image">
                </div>
            </div>
        </section>

        <section class="section step-section">
            <div class="two-column reverse">
                <div>
                    <img src="https://images.unsplash.com/photo-1576092768241-dec231879fc3?w=800&q=80" alt="Sipping tea" class="section-image">
                </div>
                <div>
                    <div class="section-number">5</div>
                    <h2 class="section-title">Step 4 — Sip</h2>
                    <div class="section-text">
                        <p>Drink slowly. No rush. No distraction. Let the moment belong to you.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="two-column">
                <div>
                    <h2 class="section-title">When to Practice</h2>
                    <ul class="practice-list">
                        <li>Early morning before starting your day</li>
                        <li>Evening wind down ritual</li>
                        <li>Before meditation or journaling</li>
                        <li>During moments that require clarity and calm</li>
                    </ul>
                    <p class="practice-quote">Consistency is more powerful than intensity.</p>
                </div>
                <div>
                    <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=800&q=80" alt="Tea beside journal" class="section-image">
                </div>
            </div>
        </section>

        <section class="final-section">
            <h2>The Discipline of Daily Practice</h2>
            <p>Ritual is not about perfection. It is about return. Each time you pause, prepare, and sip — you are choosing presence over pace.</p>
            <p>This is not a trend. This is a practice. And practice, over time, becomes transformation.</p>
            <div class="final-divider"></div>
        </section>
    </main>
@endsection
