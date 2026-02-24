// Auth utility functions
function checkAuthState() {
    const currentUser = JSON.parse(localStorage.getItem('currentUser'));
    const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
    const profileIcons = document.querySelectorAll('.nav-icon');
    
    profileIcons.forEach(profileIcon => {
        if (currentUser && isLoggedIn) {
            profileIcon.href = 'profile.html';
            profileIcon.title = currentUser.name;
        } else {
            profileIcon.href = '#';
            profileIcon.title = 'Sign In';
            profileIcon.addEventListener('click', function(e) {
                e.preventDefault();
                showAuthModal();
            });
        }
    });
}

function showAuthModal() {
    // Create and show login modal
    if (!document.getElementById('authModalOverlay')) {
        const modalHTML = `
            <div id="authModalOverlay" class="auth-modal-overlay">
                <div class="auth-modal-box">
                    <span class="close-modal" onclick="closeAuthModal()">&times;</span>
                    <div id="loginView" class="auth-view">
                        <h2>Welcome Back</h2>
                        <p class="auth-subtitle">Sign in to your account</p>
                        <form id="quickLoginForm" onsubmit="handleQuickLogin(event)">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="quickLoginEmail" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" id="quickLoginPassword" required>
                            </div>
                            <button type="submit" class="auth-btn">Sign In</button>
                        </form>
                        <p class="auth-link">Don't have an account? <a href="#" onclick="showRegisterView()">Sign Up</a></p>
                    </div>
                    <div id="registerView" class="auth-view" style="display:none;">
                        <h2>Create Account</h2>
                        <p class="auth-subtitle">Join the Aushvera journey</p>
                        <form id="quickRegisterForm" onsubmit="handleQuickRegister(event)">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" id="quickRegisterName" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="quickRegisterEmail" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" id="quickRegisterPassword" required minlength="6">
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" id="quickRegisterConfirm" required>
                            </div>
                            <button type="submit" class="auth-btn">Create Account</button>
                        </form>
                        <p class="auth-link">Already have an account? <a href="#" onclick="showLoginView()">Sign In</a></p>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }
    document.getElementById('authModalOverlay').style.display = 'flex';
}

function closeAuthModal() {
    const modal = document.getElementById('authModalOverlay');
    if (modal) modal.style.display = 'none';
}

function showLoginView() {
    document.getElementById('loginView').style.display = 'block';
    document.getElementById('registerView').style.display = 'none';
}

function showRegisterView() {
    document.getElementById('loginView').style.display = 'none';
    document.getElementById('registerView').style.display = 'block';
}

function handleQuickLogin(e) {
    e.preventDefault();
    const email = document.getElementById('quickLoginEmail').value;
    const password = document.getElementById('quickLoginPassword').value;
    
    const users = JSON.parse(localStorage.getItem('users')) || [];
    const user = users.find(u => u.email === email && u.password === password);
    
    if (user) {
        localStorage.setItem('currentUser', JSON.stringify(user));
        localStorage.setItem('isLoggedIn', 'true');
        window.location.href = 'profile.html';
    } else {
        alert('Invalid email or password');
    }
}

function handleQuickRegister(e) {
    e.preventDefault();
    const name = document.getElementById('quickRegisterName').value;
    const email = document.getElementById('quickRegisterEmail').value;
    const password = document.getElementById('quickRegisterPassword').value;
    const confirm = document.getElementById('quickRegisterConfirm').value;
    
    if (password !== confirm) {
        alert('Passwords do not match');
        return;
    }
    
    const users = JSON.parse(localStorage.getItem('users')) || [];
    
    if (users.find(u => u.email === email)) {
        alert('Email already registered');
        return;
    }
    
    const newUser = { name, email, password };
    users.push(newUser);
    localStorage.setItem('users', JSON.stringify(users));
    localStorage.setItem('currentUser', JSON.stringify(newUser));
    localStorage.setItem('isLoggedIn', 'true');
    
    window.location.href = 'profile.html';
}

// Run on page load
document.addEventListener('DOMContentLoaded', checkAuthState);
