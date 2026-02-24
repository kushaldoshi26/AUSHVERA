@extends('layouts.app')

@section('title', 'Shopping Cart — AUSHVERA')

@push('styles')
<style>
    .cart-page {
        min-height: 100vh;
        padding: 10rem 3rem 6rem;
        background: var(--cream);
    }
    .cart-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    .cart-title {
        font-size: 3rem;
        color: var(--navy-deep);
        margin-bottom: 3rem;
        text-align: center;
    }
    .cart-empty {
        text-align: center;
        padding: 4rem 2rem;
    }
    .cart-empty p {
        font-size: 1.2rem;
        color: var(--navy-deep);
        opacity: 0.7;
        margin-bottom: 2rem;
    }
    .cart-items {
        background: white;
        border: 1px solid rgba(198, 167, 94, 0.2);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .cart-item-row {
        display: grid;
        grid-template-columns: 100px 1fr 150px 150px 100px;
        gap: 2rem;
        align-items: center;
        padding: 2rem 0;
        border-bottom: 1px solid rgba(198, 167, 94, 0.1);
    }
    .cart-item-row:last-child {
        border-bottom: none;
    }
    .cart-item-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border: 1px solid rgba(198, 167, 94, 0.2);
    }
    .cart-item-info h3 {
        font-size: 1.2rem;
        color: var(--navy-deep);
        margin-bottom: 0.5rem;
    }
    .cart-item-info p {
        color: var(--gold);
        font-size: 0.9rem;
    }
    .cart-qty {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .cart-qty button {
        width: 32px;
        height: 32px;
        border: 1px solid var(--gold);
        background: transparent;
        color: var(--gold);
        cursor: pointer;
        transition: all 0.3s;
    }
    .cart-qty button:hover {
        background: var(--gold);
        color: var(--navy-deep);
    }
    .cart-qty span {
        color: var(--navy-deep);
        font-weight: 500;
    }
    .cart-price {
        font-size: 1.2rem;
        color: var(--navy-deep);
        font-weight: 500;
    }
    .cart-remove {
        background: none;
        border: none;
        color: var(--navy-deep);
        opacity: 0.5;
        cursor: pointer;
        font-size: 1.5rem;
        transition: opacity 0.3s;
    }
    .cart-remove:hover {
        opacity: 1;
    }
    .cart-summary {
        background: var(--beige);
        padding: 2rem;
        border: 1px solid rgba(198, 167, 94, 0.2);
    }
    .cart-summary-row {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(198, 167, 94, 0.1);
    }
    .cart-summary-row:last-child {
        border-bottom: none;
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--navy-deep);
    }
    .cart-actions {
        display: flex;
        gap: 2rem;
        margin-top: 2rem;
    }
</style>
@endpush

@section('content')
    <section class="cart-page">
        <div class="cart-container">
            <h1 class="cart-title">Shopping Cart</h1>
            
            <div id="cart-content">
                <!-- Cart will be dynamically loaded -->
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/api-config.js') }}"></script>
    <script>
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let cartCount = cart.reduce((sum, item) => sum + item.quantity, 0);
        
        const cartCountElement = document.querySelector('.cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = cartCount;
            cartCountElement.style.display = cartCount > 0 ? 'flex' : 'none';
        }
        
        function renderCart() {
            const cartContent = document.getElementById('cart-content');
            
            if (cart.length === 0) {
                cartContent.innerHTML = '<div class="cart-empty"><p>Your cart is empty</p><a href="{{ url('product') }}" class="btn-outline">Shop Now</a></div>';
                return;
            }
            
            let itemsHTML = '<div class="cart-items">';
            let subtotal = 0;
            
            cart.forEach((item, index) => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                
                itemsHTML += `
                    <div class="cart-item-row">
                        <img src="${item.image}" alt="${item.name}" class="cart-item-img">
                        <div class="cart-item-info">
                            <h3>${item.name}</h3>
                            <p>${item.description}</p>
                        </div>
                        <div class="cart-qty">
                            <button onclick="updateQuantity(${index}, -1)">−</button>
                            <span>${item.quantity}</span>
                            <button onclick="updateQuantity(${index}, 1)">+</button>
                        </div>
                        <div class="cart-price">₹${itemTotal.toFixed(0)}</div>
                        <button class="cart-remove" onclick="removeItem(${index})">×</button>
                    </div>
                `;
            });
            
            itemsHTML += '</div>';
            itemsHTML += `
                <div class="cart-summary">
                    <div class="cart-summary-row">
                        <span>Subtotal</span>
                        <span id="subtotal">₹${subtotal.toFixed(0)}</span>
                    </div>
                    <div class="cart-summary-row" style="border-bottom: 1px solid rgba(198, 167, 94, 0.1);">
                        <div style="display: flex; gap: 10px; width: 100%;">
                            <input type="text" id="couponCode" placeholder="Enter coupon code" style="flex: 1; padding: 10px; border: 1px solid rgba(198, 167, 94, 0.3);">
                            <button onclick="applyCoupon()" style="padding: 10px 20px; background: var(--gold); color: var(--navy-deep); border: none; cursor: pointer;">Apply</button>
                        </div>
                    </div>
                    <div class="cart-summary-row" id="discountRow" style="display: none; color: green;">
                        <span>Discount (<span id="discountLabel"></span>)</span>
                        <span id="discountAmount">-₹0</span>
                    </div>
                    <div class="cart-summary-row">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>
                    <div class="cart-summary-row">
                        <span>Total</span>
                        <span id="totalAmount">₹${subtotal.toFixed(0)}</span>
                    </div>
                </div>
                <div class="cart-actions">
                    <a href="{{ url('/') }}" class="btn-outline">Continue Shopping</a>
                    <button class="btn-gold" onclick="proceedToCheckout()">Proceed to Checkout</button>
                </div>
            `;
            
            cartContent.innerHTML = itemsHTML;
        }
        
        function updateQuantity(index, change) {
            cart[index].quantity += change;
            if (cart[index].quantity < 1) {
                removeItem(index);
                return;
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            renderCart();
        }
        
        function removeItem(index) {
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            renderCart();
        }
        
        function updateCartCount() {
            const count = cart.reduce((sum, item) => sum + item.quantity, 0);
            localStorage.setItem('cartCount', count);
        }

        function proceedToCheckout() {
            const user = localStorage.getItem('user');
            if (user) {
                window.location.href = '{{ url('checkout') }}';
            } else {
                alert('Please login to continue');
                window.location.href = '{{ url('profile') }}';
            }
        }

        let appliedCoupon = null;

        async function applyCoupon() {
            const code = document.getElementById('couponCode').value.toUpperCase().trim();
            if (!code) {
                alert('Please enter a coupon code');
                return;
            }

            try {
                const response = await fetch('{{ url('/api/coupons/validate') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ code: code })
                });

                const data = await response.json();

                if (response.ok && data.valid) {
                    appliedCoupon = data.coupon;
                    calculateTotal();
                    alert('Coupon applied successfully!');
                } else {
                    alert(data.message || 'Invalid coupon code');
                }
            } catch (error) {
                alert('Error applying coupon');
            }
        }

        function calculateTotal() {
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            let discount = 0;

            if (appliedCoupon) {
                if (appliedCoupon.type === 'percentage') {
                    discount = (subtotal * appliedCoupon.value) / 100;
                } else {
                    discount = appliedCoupon.value;
                }

                document.getElementById('discountRow').style.display = 'flex';
                document.getElementById('discountLabel').textContent = appliedCoupon.code;
                document.getElementById('discountAmount').textContent = `-₹${discount.toFixed(0)}`;
            }

            const total = subtotal - discount;
            document.getElementById('totalAmount').textContent = `₹${total.toFixed(0)}`;
        }
        
        renderCart();
    </script>
@endpush
