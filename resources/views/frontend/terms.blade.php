@extends('layouts.app')

@section('title', 'Terms & Conditions — AUSHVERA')

@push('styles')
<style>
    .terms-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 120px 2rem 80px;
        background: var(--cream);
    }
    
    .terms-header {
        text-align: center;
        margin-bottom: 60px;
    }
    
    .terms-header h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 48px;
        font-weight: 300;
        color: var(--charcoal);
        margin-bottom: 20px;
        letter-spacing: 2px;
    }
    
    .terms-header .divider {
        width: 60px;
        height: 1px;
        background: var(--gold);
        margin: 0 auto;
    }
    
    .terms-content {
        font-size: 16px;
        line-height: 1.8;
        color: var(--charcoal);
    }
    
    .terms-content h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 28px;
        font-weight: 400;
        color: var(--charcoal);
        margin-top: 40px;
        margin-bottom: 20px;
    }
    
    .terms-content h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 22px;
        font-weight: 400;
        color: var(--charcoal);
        margin-top: 30px;
        margin-bottom: 15px;
    }
    
    .terms-content p {
        margin-bottom: 16px;
        color: #5E5E5E;
    }
    
    .terms-content ul {
        margin: 20px 0;
        padding-left: 30px;
    }
    
    .terms-content li {
        margin-bottom: 10px;
        color: #5E5E5E;
    }
    
    .terms-intro {
        font-size: 17px;
        margin-bottom: 40px;
        padding: 30px;
        background: rgba(198, 164, 92, 0.05);
        border-left: 3px solid var(--gold);
    }
    
    @media (max-width: 768px) {
        .terms-container {
            padding: 100px 1.5rem 60px;
        }
        
        .terms-header h1 {
            font-size: 36px;
        }
        
        .terms-content h2 {
            font-size: 24px;
        }
    }
</style>
@endpush

@section('content')
<div class="terms-container">
    <div class="terms-header">
        <h1>Terms & Conditions</h1>
        <div class="divider"></div>
    </div>
    
    <div class="terms-content">
        <div class="terms-intro">
            <p>Welcome to Aushvera GlobalBiz LLP ("Aushvera", "Company", "we", "our", "us").</p>
            <p>By accessing or using our website, purchasing our products, or engaging with us as a customer, retailer, distributor, or business partner, you agree to be bound by the following Terms & Conditions.</p>
            <p><strong>If you do not agree, please discontinue use of this website.</strong></p>
        </div>

        <h2>1. Company Information</h2>
        <p>This website is operated by:</p>
        <p><strong>Aushvera GlobalBiz LLP</strong><br>
        India<br>
        Email: aushveraglobalbiz1718@gmail.com</p>
        <p>All products and services are offered subject to these Terms.</p>

        <h2>2. Eligibility</h2>
        <p>By using this website, you confirm that:</p>
        <ul>
            <li>You are at least 18 years of age.</li>
            <li>You are legally capable of entering into binding agreements.</li>
            <li>Any information you provide is accurate and complete.</li>
        </ul>

        <h2>3. Product Nature & Disclaimer</h2>
        <p>Aushvera products are botanical wellness products.</p>
        <p>They are:</p>
        <ul>
            <li>Not pharmaceutical drugs</li>
            <li>Not intended to diagnose, treat, cure, or prevent any disease</li>
            <li>Not a substitute for medical advice, diagnosis, or treatment</li>
        </ul>
        <p>Customers are advised to:</p>
        <ul>
            <li>Consult a qualified medical professional before use if pregnant, nursing, under medication, or having medical conditions.</li>
            <li>Discontinue use if any adverse reaction occurs.</li>
            <li>Individual results may vary.</li>
        </ul>
        <p>The Company shall not be liable for misuse, improper storage, or failure to follow usage instructions.</p>

        <h2>4. Orders & Payments (B2C)</h2>
        <ul>
            <li>All orders are subject to availability and confirmation.</li>
            <li>Prices are listed in INR unless otherwise stated.</li>
            <li>We reserve the right to modify pricing at any time without prior notice.</li>
            <li>Orders may be canceled if payment is not successfully processed.</li>
            <li>We reserve the right to refuse or cancel orders at our discretion.</li>
        </ul>

        <h2>5. Shipping & Delivery</h2>
        <ul>
            <li>Delivery timelines are estimates and not guaranteed.</li>
            <li>Delays caused by logistics providers, natural events, or unforeseen circumstances are beyond our control.</li>
            <li>Risk of loss transfers to the customer upon delivery.</li>
        </ul>

        <h2>6. Returns & Refunds</h2>
        <p>Due to the nature of wellness consumable products:</p>
        <ul>
            <li>Opened or used products are not eligible for return.</li>
            <li>Returns are accepted only for damaged or defective products reported within 48 hours of delivery.</li>
            <li>Proof (images/video) may be required.</li>
            <li>Refunds, if approved, will be processed within a reasonable time frame.</li>
            <li>The Company reserves full discretion in approving returns.</li>
        </ul>

        <h2>7. B2B Terms (Retailers, Cafés, Resellers, Corporate Buyers)</h2>
        <p>All B2B transactions are subject to separate commercial agreements where applicable.</p>
        <p>Unless otherwise agreed in writing:</p>
        <ul>
            <li>Minimum Order Quantity (MOQ) may apply.</li>
            <li>Wholesale pricing is confidential.</li>
            <li>Payment terms must be honored as per invoice.</li>
            <li>Delayed payments may attract interest or suspension of supply.</li>
            <li>Products cannot be resold below agreed Minimum Retail Price (MRP) without written approval.</li>
        </ul>
        <p>B2B partners are responsible for:</p>
        <ul>
            <li>Proper storage conditions</li>
            <li>Accurate representation of product information</li>
            <li>Compliance with local laws and resale regulations</li>
        </ul>
        <p>Aushvera reserves the right to terminate B2B relationships at its discretion.</p>

        <h2>8. Intellectual Property</h2>
        <p>All content on this website including:</p>
        <ul>
            <li>Logos</li>
            <li>Brand name "Aushvera"</li>
            <li>Product names</li>
            <li>Designs</li>
            <li>Text</li>
            <li>Images</li>
            <li>Packaging concepts</li>
        </ul>
        <p>Are the intellectual property of Aushvera GlobalBiz LLP.</p>
        <p>Unauthorized reproduction, copying, or commercial use is strictly prohibited and may result in legal action.</p>

        <h2>9. Limitation of Liability</h2>
        <p>To the maximum extent permitted by law:</p>
        <p>Aushvera shall not be liable for:</p>
        <ul>
            <li>Indirect, incidental, or consequential damages</li>
            <li>Loss of profits or business</li>
            <li>Health issues arising from misuse</li>
            <li>Delays in delivery</li>
            <li>Force majeure events</li>
        </ul>
        <p>Our total liability shall not exceed the amount paid for the product purchased.</p>

        <h2>10. Website Use Restrictions</h2>
        <p>Users agree not to:</p>
        <ul>
            <li>Misuse the website</li>
            <li>Attempt unauthorized access</li>
            <li>Copy content</li>
            <li>Use false identity</li>
            <li>Engage in fraudulent transactions</li>
        </ul>
        <p>Violation may result in account suspension and legal action.</p>

        <h2>11. Privacy</h2>
        <ul>
            <li>Personal information submitted through this website is governed by our Privacy Policy.</li>
            <li>We do not sell customer data.</li>
        </ul>

        <h2>12. Force Majeure</h2>
        <p>The Company shall not be liable for delays or failure due to events beyond reasonable control including but not limited to:</p>
        <ul>
            <li>Natural disasters</li>
            <li>Government restrictions</li>
            <li>Supply chain disruptions</li>
            <li>Pandemic-related issues</li>
        </ul>

        <h2>13. Governing Law & Jurisdiction</h2>
        <ul>
            <li>These Terms shall be governed by the laws of India.</li>
            <li>Any disputes shall be subject to the exclusive jurisdiction of courts located in Gujarat, India.</li>
        </ul>

        <h2>14. Modification of Terms</h2>
        <ul>
            <li>We reserve the right to update or modify these Terms at any time.</li>
            <li>Continued use of the website after changes constitutes acceptance of revised Terms.</li>
        </ul>
    </div>
</div>
@endsection
