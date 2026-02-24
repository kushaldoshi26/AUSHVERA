// Check authentication on page load
document.addEventListener('DOMContentLoaded', function() {
    checkAuth();
    initializeProfile();
    initializeNavigation();
});

// Check if user is logged in
function checkAuth() {
    const currentUser = JSON.parse(localStorage.getItem('currentUser'));
    const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
    
    if (!currentUser || !isLoggedIn) {
        openLoginModal();
        return false;
    }
    
    loadUserData(currentUser);
    return true;
}

// Load user data into profile
function loadUserData(user) {
    const initials = user.name.split(' ').map(n => n[0]).join('').toUpperCase();
    document.getElementById('userInitials').textContent = initials;
    document.getElementById('userName').textContent = user.name;
    document.getElementById('userEmail').textContent = user.email;
    document.getElementById('fullName').textContent = user.name;
    document.getElementById('email').textContent = user.email;
}

// Initialize profile sections navigation
function initializeNavigation() {
    const navItems = document.querySelectorAll('.nav-item[data-section]');
    const sections = document.querySelectorAll('.content-section');
    
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const targetSection = this.getAttribute('data-section');
            const related = this.getAttribute('data-related');
            
            navItems.forEach(nav => nav.classList.remove('active'));
            this.classList.add('active');
            
            sections.forEach(section => section.classList.remove('active'));
            if (related) {
                // show all related sections (comma-separated ids)
                related.split(',').map(s => s.trim()).forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.classList.add('active');
                });
            } else if (targetSection) {
                const el = document.getElementById(targetSection);
                if (el) el.classList.add('active');
            }
        });
    });
    
    document.querySelectorAll('.link-view-all').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetSection = this.getAttribute('data-section');
            const related = this.getAttribute('data-related');
            const targetNav = document.querySelector(`.nav-item[data-section="${targetSection}"]`);
            if (targetNav) targetNav.click();
            // if link provides related sections directly, trigger their nav if present
            if (related) {
                related.split(',').map(s => s.trim()).forEach(id => {
                    const nav = document.querySelector(`.nav-item[data-section="${id}"]`);
                    if (nav) nav.click();
                });
            }
        });
    });
}

// Initialize profile features
function initializeProfile() {
    const cartCount = JSON.parse(localStorage.getItem('cartCount')) || 0;
    const cartCountElement = document.querySelector('.cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = cartCount;
        cartCountElement.style.display = cartCount > 0 ? 'flex' : 'none';
    }
}

// Login Modal Functions
function openLoginModal() {
    document.getElementById('loginModal').style.display = 'flex';
}

function closeLoginModal() {
    document.getElementById('loginModal').style.display = 'none';
}

function handleLogin(e) {
    e.preventDefault();
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;
    
    const users = JSON.parse(localStorage.getItem('users')) || [];
    const user = users.find(u => u.email === email && u.password === password);
    
    if (user) {
        localStorage.setItem('currentUser', JSON.stringify(user));
        localStorage.setItem('isLoggedIn', 'true');
        closeLoginModal();
        loadUserData(user);
        location.reload();
    } else {
        alert('Invalid email or password');
    }
}

// Register Modal Functions
function openRegisterModal() {
    document.getElementById('registerModal').style.display = 'flex';
}

function closeRegisterModal() {
    document.getElementById('registerModal').style.display = 'none';
}

function handleRegister(e) {
    e.preventDefault();
    const name = document.getElementById('registerName').value;
    const email = document.getElementById('registerEmail').value;
    const password = document.getElementById('registerPassword').value;
    const confirmPassword = document.getElementById('registerConfirmPassword').value;
    
    if (password !== confirmPassword) {
        alert('Passwords do not match');
        return;
    }
    
    const users = JSON.parse(localStorage.getItem('users')) || [];
    
    if (users.find(u => u.email === email)) {
        alert('Email already registered');
        return;
    }
    
    const newUser = { 
        name, 
        email, 
        password,
        memberSince: new Date().toLocaleDateString('en-US', { month: 'long', year: 'numeric' })
    };
    users.push(newUser);
    localStorage.setItem('users', JSON.stringify(users));
    localStorage.setItem('currentUser', JSON.stringify(newUser));
    localStorage.setItem('isLoggedIn', 'true');
    
    closeRegisterModal();
    loadUserData(newUser);
    location.reload();
}

// Switch between modals
function switchToRegister() {
    closeLoginModal();
    openRegisterModal();
}

function switchToLogin() {
    closeRegisterModal();
    openLoginModal();
}

// Logout function
function logout() {
    if (confirm('Are you sure you want to logout?')) {
        localStorage.removeItem('currentUser');
        localStorage.setItem('isLoggedIn', 'false');
        window.location.href = 'index.html';
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const loginModal = document.getElementById('loginModal');
    const registerModal = document.getElementById('registerModal');
    
    if (event.target === loginModal) {
        closeLoginModal();
        window.location.href = 'index.html';
    }
    if (event.target === registerModal) {
        closeRegisterModal();
        window.location.href = 'index.html';
    }
}
