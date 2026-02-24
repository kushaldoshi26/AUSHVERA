@extends('layouts.app')

@section('title', 'My Profile — AUSHVERA')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/profile-styles.css') }}">
@endpush

@section('content')
    <div class="account-container">
        <aside class="account-sidebar">
            <div class="sidebar-header">
                <span class="account-label">ACCOUNT</span>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ url('profile') }}" class="nav-item active">
                    <span class="nav-indicator"></span>
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/>
                    </svg>
                    <span class="nav-text">Profile Overview</span>
                </a>
                
                <a href="{{ url('orders') }}" class="nav-item">
                    <span class="nav-indicator"></span>
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M16 3h5v5M4 20L21 3M21 16v5h-5M15 15l6 6M4 4l5 5"/>
                    </svg>
                    <span class="nav-text">My Orders</span>
                </a>
                
                <a href="{{ url('addresses') }}" class="nav-item">
                    <span class="nav-indicator"></span>
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <span class="nav-text">Addresses</span>
                </a>
                
                <a href="{{ url('payment') }}" class="nav-item">
                    <span class="nav-indicator"></span>
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                        <line x1="1" y1="10" x2="23" y2="10"/>
                    </svg>
                    <span class="nav-text">Payment Methods</span>
                </a>
                
                <a href="{{ url('wishlist') }}" class="nav-item">
                    <span class="nav-indicator"></span>
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                    <span class="nav-text">Wishlist</span>
                </a>
                
                <a href="{{ url('security') }}" class="nav-item">
                    <span class="nav-indicator"></span>
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    <span class="nav-text">Security</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="footer-divider"></div>
                <a href="#" class="auth-link" id="authLink" onclick="handleAuthClick(event)">
                    <svg class="auth-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    <span id="authText">Login</span>
                </a>
            </div>
        </aside>
        
        <main class="account-main">
            <div class="content-header">
                <h1>Profile Overview</h1>
                <p class="content-subtitle">Manage your personal information and preferences</p>
            </div>
            
            <div class="content-cards">
                <div class="info-card">
                    <div class="card-header">
                        <h3>Personal Information</h3>
                        <button class="edit-btn" id="editBtn">Edit</button>
                    </div>
                    <div class="card-content" id="profileContent">
                        <div class="info-row">
                            <span class="info-label">Full Name</span>
                            <span class="info-value" id="displayName">Guest User</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email</span>
                            <span class="info-value" id="displayEmail">Not logged in</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Phone</span>
                            <span class="info-value" id="displayPhone">Not available</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Date of Birth</span>
                            <span class="info-value" id="displayDob">Not provided</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Gender</span>
                            <span class="info-value" id="displayGender">Not provided</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Address</span>
                            <span class="info-value" id="displayAddress">Not provided</span>
                        </div>
                    </div>
                    <form class="edit-form" id="editForm" style="display: none;">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" id="editName" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="editEmail" required>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="tel" id="editPhone" required>
                        </div>
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input type="date" id="editDob">
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            <select id="editGender">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea id="editAddress" rows="3"></textarea>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="save-btn">Save Changes</button>
                            <button type="button" class="cancel-btn" id="cancelEdit">Cancel</button>
                        </div>
                    </form>
                </div>
                
                <div class="info-card">
                    <div class="card-header">
                        <h3>Membership Status</h3>
                        <span class="status-badge">Premium</span>
                    </div>
                    <div class="card-content">
                        <div class="membership-info">
                            <p class="membership-text">You are a valued member of the Aushvera wellness community.</p>
                            <div class="membership-benefits">
                                <span class="benefit-item">• Exclusive access to new releases</span>
                                <span class="benefit-item">• Priority customer support</span>
                                <span class="benefit-item">• Special ritual guides</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="loginModal" class="auth-modal">
        <div class="modal-content">
            <span class="close-modal" id="closeLogin">&times;</span>
            <h2>Welcome Back</h2>
            <p class="modal-subtitle">Sign in to your Aushvera account</p>
            <form class="auth-form" id="loginForm">
                <input type="email" id="loginEmail" placeholder="Email Address" required>
                <input type="password" id="loginPassword" placeholder="Password" required>
                <button type="submit" class="auth-btn">Sign In</button>
            </form>
            <p class="switch-auth">Don't have an account? <a href="#" id="showSignup">Sign Up</a></p>
        </div>
    </div>

    <div id="signupModal" class="auth-modal">
        <div class="modal-content">
            <span class="close-modal" id="closeSignup">&times;</span>
            <div class="modal-logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="AUSHVERA Logo" style="width: 60px; height: 60px;">
                <h2 style="margin-top: 1rem;">AUSHVERA</h2>
            </div>
            <p class="modal-subtitle">Create your wellness account</p>
            <form class="auth-form" id="signupForm">
                <input type="text" id="signupFirstName" placeholder="First Name" required>
                <input type="text" id="signupLastName" placeholder="Last Name" required>
                <input type="email" id="signupEmail" placeholder="Email Address" required>
                <input type="tel" id="signupPhone" placeholder="Phone Number" required>
                <input type="password" id="signupPassword" placeholder="Password" required>
                <input type="date" id="signupDob" placeholder="Date of Birth">
                <select id="signupGender">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                <input type="text" id="signupPincode" placeholder="Pin Code" maxlength="6" required>
                <input type="text" id="signupCity" placeholder="City" readonly>
                <input type="text" id="signupState" placeholder="State" readonly>
                <textarea id="signupAddress" placeholder="Address" rows="2"></textarea>
                <button type="submit" class="auth-btn">Create Account</button>
            </form>
            <p class="switch-auth">Already have an account? <a href="#" id="showLogin">Sign In</a></p>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/api-config.js') }}"></script>
    <script>
        async function checkAdminRedirect() {
            const token = localStorage.getItem('auth_token');
            if (token) {
                try {
                    const response = await api.getUser();
                    if (response.data.role === 'admin') {
                        window.location.href = '{{ url('admin') }}';
                        return;
                    }
                } catch (error) {}
            }
        }
        checkAdminRedirect();
        
        async function handleAuthClick(e) {
            e.preventDefault();
            const token = localStorage.getItem('auth_token');
            
            if (token) {
                try {
                    await api.logout();
                } catch (error) {}
                localStorage.removeItem('auth_token');
                localStorage.removeItem('currentUser');
                alert('Logged out successfully!');
                window.location.reload();
            } else {
                const modal = document.getElementById('loginModal');
                if (modal) modal.classList.add('active');
            }
        }
    </script>
    <script src="{{ asset('profile-auth.js') }}"></script>
@endpush
