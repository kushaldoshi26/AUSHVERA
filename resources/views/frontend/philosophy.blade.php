@extends('layouts.app')

@section('title', 'Philosophy — AUSHVERA')

@push('styles')
<style>
    :root {
        --cream: #E8DED0;
        --charcoal: #1C1C1C;
        --text-muted: #5E5E5E;
        --gold: #C6A45C;
        --navy: #2C3E50;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        background: var(--cream);
        font-family: 'Inter', sans-serif;
        color: var(--charcoal);
    }
    
    .philosophy-hero {
        padding: 120px 3rem 100px;
        text-align: center;
        background: var(--cream);
        position: relative;
    }
    
    .philosophy-hero::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 200px;
        background: linear-gradient(to bottom, transparent, rgba(198,164,92,0.02));
        pointer-events: none;
    }
    
    .philosophy-hero .small-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 16px;
        font-weight: 300;
        color: var(--charcoal);
        letter-spacing: 10px;
        margin-top: 40px;
        margin-bottom: 20px;
        text-transform: uppercase;
    }
    
    .philosophy-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 52px;
        font-weight: 300;
        color: var(--charcoal);
        letter-spacing: 8px;
        margin-bottom: 36px;
        text-transform: uppercase;
    }
    
    .philosophy-hero .subtitle {
        font-family: 'Cormorant Garamond', serif;
        font-size: 20px;
        font-style: italic;
        color: var(--charcoal);
        margin-bottom: 32px;
        letter-spacing: 0.5px;
        font-weight: 300;
    }
    
    .hero-divider {
        width: 60px;
        height: 1px;
        background: var(--gold);
        margin: 0 auto 40px;
    }
    
    .philosophy-hero .statement {
        font-size: 16px;
        color: var(--charcoal);
        max-width: 700px;
        margin: 0 auto 50px;
        line-height: 1.8;
        letter-spacing: 0.3px;
        font-weight: 300;
    }
    
    .statement-divider {
        width: 200px;
        height: 1px;
        background: var(--gold);
        margin: 0 auto;
    }
    
    .philosophy-content {
        padding: 100px 3rem;
        background: var(--cream);
    }
    
    .philosophy-grid {
        max-width: 1100px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 120px;
        position: relative;
    }
    
    .philosophy-grid::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 0;
        bottom: 0;
        width: 1px;
        background: rgba(198,164,92,0.3);
        transform: translateX(-50%);
    }
    
    .principle-item {
        margin-bottom: 80px;
    }
    
    .principle-header {
        display: flex;
        align-items: baseline;
        gap: 16px;
        margin-bottom: 20px;
    }
    
    .principle-number {
        font-family: 'Cormorant Garamond', serif;
        font-size: 48px;
        color: var(--gold);
        font-weight: 300;
        line-height: 1;
    }
    
    .principle-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 24px;
        font-weight: 400;
        font-style: italic;
        color: var(--charcoal);
        letter-spacing: 0.5px;
    }
    
    .principle-text p {
        font-size: 14px;
        line-height: 1.9;
        color: var(--charcoal);
        letter-spacing: 0.3px;
        font-weight: 300;
        margin-bottom: 16px;
    }
    
    .principle-text em {
        font-style: italic;
    }
    
    .closing-section {
        padding: 100px 3rem 140px;
        text-align: center;
        background: var(--cream);
    }
    
    .closing-section h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 32px;
        font-weight: 300;
        color: var(--charcoal);
        margin-bottom: 32px;
        letter-spacing: 1px;
    }
    
    .closing-section p {
        font-size: 14px;
        line-height: 1.9;
        color: var(--charcoal);
        max-width: 700px;
        margin: 0 auto 8px;
        letter-spacing: 0.3px;
        font-weight: 300;
    }
    
    .closing-section em {
        font-style: italic;
    }
    
    @media (max-width: 968px) {
        .philosophy-grid {
            grid-template-columns: 1fr;
            gap: 60px;
        }
        
        .philosophy-grid::before {
            display: none;
        }
        
        .philosophy-hero h1 {
            font-size: 36px;
        }
    }
</style>
@endpush

@section('content')
    <main>
        <section class="philosophy-hero">
            <div class="small-title">
            <p>THE</p>
            </div>
            <h1>AUSHVERA PHILOSOPHY</h1>
            <p class="subtitle">Rooted in Wisdom. Guided by Discipline.</p>
            <div class="hero-divider"></div>
            <p class="statement">At Aushvera, philosophy is not decoration — it is direction.</p>
            <div class="statement-divider"></div>
        </section>

        <section class="philosophy-content">
            <div class="philosophy-grid">
                <div class="philosophy-column">
                    <div class="principle-item">
                        <div class="principle-header">
                            <span class="principle-number">1</span>
                            <h3 class="principle-title">Nature is Intelligent</h3>
                        </div>
                        <div class="principle-text">
                            <p>For centuries, botanical knowledge has guided human well-being. Plants were not trends; they were foundations.</p>
                            <p>We believe that nature carries <em>shell</em> balance. Every formulation begins with honoring that balance rather than overpowering it.</p>
                            <p>We do not chase complexity.</p>
                            <p>We protect simplicity.</p>
                        </div>
                    </div>

                    <div class="principle-item">
                        <div class="principle-header">
                            <span class="principle-number">2</span>
                            <h3 class="principle-title">Discipline is Luxury</h3>
                        </div>
                        <div class="principle-text">
                            <p>Luxury is not excess. It is precision.</p>
                            <p>From ingredient sourcing to final packaging, we operate with restraint and intention.</p>
                            <p>Every decision — what to include, what to exclude, how to present — reflects careful thought.</p>
                            <p>We believe that refinement is a discipline, not a decoration.</p>
                        </div>
                    </div>
                </div>

                <div class="philosophy-column">
                    <div class="principle-item">
                        <div class="principle-header">
                            <span class="principle-number">3</span>
                            <h3 class="principle-title">Discipline is Luxury</h3>
                        </div>
                        <div class="principle-text">
                            <p>Luxury is not excess. It is precision.</p>
                            <p>From ingredient sourcing to final packaging, we operate with restraint and intention. Every decision — what to include, what to exclude, how to present — reflects careful thought.</p>
                            <p>We believe that refinement is a discipline, not a decoration.</p>
                        </div>
                    </div>

                    <div class="principle-item">
                        <div class="principle-header">
                            <span class="principle-number">4</span>
                            <h3 class="principle-title">Modern Living. Timeless Principles</h3>
                        </div>
                        <div class="principle-text">
                            <p>Today's lifestyle demands efficiency.</p>
                            <p>But efficiency should not erase heritage.</p>
                            <p>Aushvera exists to bridge this space — where ancient plant wisdom meets contemporary standards of quality, hygiene, and presentation.</p>
                            <p>We carry tradition forward — not backward.</p>
                        </div>
                    </div>

                    <div class="principle-item">
                        <div class="principle-header">
                            <span class="principle-number">5</span>
                            <h3 class="principle-title">Wellness as a Ritual</h3>
                        </div>
                        <div class="principle-text">
                            <p>We believe wellness is not a product.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="closing-section">
            <h2>A Philosophy That Endures</h2>
            <p>Aushvera stands for thoughtful creation, botanical respect and disciplined refinement.</p>
            <p>We are building more than formulations. We are <em>building a legacy</em></p>
            <p>rooted in patience and guided by principle.</p>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let cartCount = cart.reduce((sum, item) => sum + item.quantity, 0);
        document.querySelector('.cart-count').textContent = cartCount;
        document.querySelector('.cart-count').style.display = cartCount > 0 ? 'flex' : 'none';
    </script>
@endpush
