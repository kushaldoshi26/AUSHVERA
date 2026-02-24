// Check if user is logged in - FIXED
let isLoggedIn = false;
let userData = {};

// Check token validity on load
(function() {
    const token = localStorage.getItem('auth_token');
    if (token) {
        // Verify token is valid by checking user data
        const user = localStorage.getItem('currentUser');
        if (user) {
            try {
                userData = JSON.parse(user);
                isLoggedIn = true;
            } catch (e) {
                // Invalid user data, clear everything
                localStorage.removeItem('auth_token');
                localStorage.removeItem('currentUser');
                isLoggedIn = false;
                userData = {};
            }
        } else {
            // No user data, clear token
            localStorage.removeItem('auth_token');
            isLoggedIn = false;
        }
    }
})();

// DOM Elements
const authLink = document.getElementById('authLink');
const authText = document.getElementById('authText');
const loginModal = document.getElementById('loginModal');
const signupModal = document.getElementById('signupModal');
const closeLogin = document.getElementById('closeLogin');
const closeSignup = document.getElementById('closeSignup');
const showSignup = document.getElementById('showSignup');
const showLogin = document.getElementById('showLogin');
const loginForm = document.getElementById('loginForm');
const signupForm = document.getElementById('signupForm');

// Profile display elements
const displayName = document.getElementById('displayName');
const displayEmail = document.getElementById('displayEmail');
const displayPhone = document.getElementById('displayPhone');
const displayDob = document.getElementById('displayDob');
const displayGender = document.getElementById('displayGender');
const displayAddress = document.getElementById('displayAddress');

// Edit form elements
const editBtn = document.getElementById('editBtn');
const profileContent = document.getElementById('profileContent');
const editForm = document.getElementById('editForm');
const editName = document.getElementById('editName');
const editEmail = document.getElementById('editEmail');
const editPhone = document.getElementById('editPhone');
const editDob = document.getElementById('editDob');
const editGender = document.getElementById('editGender');
const editAddress = document.getElementById('editAddress');
const cancelEdit = document.getElementById('cancelEdit');

// Update profile display
function updateProfileDisplay() {
    if (isLoggedIn && userData.name) {
        displayName.textContent = userData.name;
        displayEmail.textContent = userData.email;
        displayPhone.textContent = userData.phone || 'Not provided';
        displayDob.textContent = userData.dob || 'Not provided';
        displayGender.textContent = userData.gender || 'Not provided';
        displayAddress.textContent = userData.address || 'Not provided';
    } else {
        displayName.textContent = 'Guest User';
        displayEmail.textContent = 'Not logged in';
        displayPhone.textContent = 'Not available';
        displayDob.textContent = 'Not provided';
        displayGender.textContent = 'Not provided';
        displayAddress.textContent = 'Not provided';
    }
}

// Update UI based on login status
function updateAuthUI() {
    const authText = document.getElementById('authText');
    
    if (isLoggedIn && userData.name) {
        if (authText) authText.textContent = 'Logout';
    } else {
        if (authText) authText.textContent = 'Login';
    }
    updateProfileDisplay();
}

// Initialize UI
updateAuthUI();

// Pin code lookup functionality
const signupPincode = document.getElementById('signupPincode');
const signupCity = document.getElementById('signupCity');
const signupState = document.getElementById('signupState');

if (signupPincode) {
    signupPincode.addEventListener('input', async (e) => {
        const pincode = e.target.value;
        if (pincode.length === 6) {
            try {
                const response = await fetch(`https://api.postalpincode.in/pincode/${pincode}`);
                const data = await response.json();
                if (data[0].Status === 'Success') {
                    const postOffice = data[0].PostOffice[0];
                    signupCity.value = postOffice.District;
                    signupState.value = postOffice.State;
                } else {
                    signupCity.value = '';
                    signupState.value = '';
                    alert('Invalid pin code');
                }
            } catch (error) {
                console.error('Error fetching pin code data:', error);
            }
        }
    });
}

// Edit button click handler
editBtn.addEventListener('click', () => {
    if (!isLoggedIn) {
        alert('Please login to edit your profile.');
        loginModal.classList.add('active');
        return;
    }
    
    editName.value = userData.name || '';
    editEmail.value = userData.email || '';
    editPhone.value = userData.phone || '';
    editDob.value = userData.dob || '';
    editGender.value = userData.gender || '';
    editAddress.value = userData.address || '';
    
    profileContent.style.display = 'none';
    editForm.style.display = 'flex';
    editBtn.textContent = 'Editing...';
    editBtn.disabled = true;
});

// Cancel edit
cancelEdit.addEventListener('click', () => {
    profileContent.style.display = 'block';
    editForm.style.display = 'none';
    editBtn.textContent = 'Edit';
    editBtn.disabled = false;
});

// Save edited profile
editForm.addEventListener('submit', (e) => {
    e.preventDefault();
    
    userData.name = editName.value;
    userData.email = editEmail.value;
    userData.phone = editPhone.value;
    userData.dob = editDob.value;
    userData.gender = editGender.value;
    userData.address = editAddress.value;
    
    localStorage.setItem('currentUser', JSON.stringify(userData));
    updateProfileDisplay();
    
    profileContent.style.display = 'block';
    editForm.style.display = 'none';
    editBtn.textContent = 'Edit';
    editBtn.disabled = false;
    
    alert('Profile updated successfully!');
});



// Close modals
closeLogin.addEventListener('click', () => {
    loginModal.classList.remove('active');
});

closeSignup.addEventListener('click', () => {
    signupModal.classList.remove('active');
});

// Close modal on outside click
window.addEventListener('click', (e) => {
    if (e.target === loginModal) {
        loginModal.classList.remove('active');
    }
    if (e.target === signupModal) {
        signupModal.classList.remove('active');
    }
});

// Switch between login and signup
showSignup.addEventListener('click', (e) => {
    e.preventDefault();
    loginModal.classList.remove('active');
    signupModal.classList.add('active');
});

showLogin.addEventListener('click', (e) => {
    e.preventDefault();
    signupModal.classList.remove('active');
    loginModal.classList.add('active');
});

// Handle login form submission
loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;
    
    try {
        const response = await api.login(email, password);
        localStorage.setItem('auth_token', response.data.token);
        localStorage.setItem('currentUser', JSON.stringify(response.data.user));
        
        userData = response.data.user;
        isLoggedIn = true;
        
        if (userData.role === 'admin') {
            window.location.href = '/admin';
        } else {
            updateAuthUI();
            loginModal.classList.remove('active');
            loginForm.reset();
            alert('Login successful!');
        }
    } catch (error) {
        alert(error.message || 'Login failed');
    }
});

// Handle signup form submission
signupForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const firstName = document.getElementById('signupFirstName').value;
    const lastName = document.getElementById('signupLastName').value;
    const email = document.getElementById('signupEmail').value;
    const phone = document.getElementById('signupPhone').value;
    const password = document.getElementById('signupPassword').value;
    const dob = document.getElementById('signupDob').value;
    const gender = document.getElementById('signupGender').value;
    const pincode = document.getElementById('signupPincode').value;
    const city = document.getElementById('signupCity').value;
    const state = document.getElementById('signupState').value;
    const address = document.getElementById('signupAddress').value;
    
    try {
        const response = await api.register({
            name: `${firstName} ${lastName}`,
            email,
            password,
            password_confirmation: password,
            phone,
            dob,
            gender,
            pincode,
            city,
            state,
            address
        });
        
        alert('Account created successfully! Please login.');
        signupModal.classList.remove('active');
        loginModal.classList.add('active');
        signupForm.reset();
    } catch (error) {
        alert(error.message || 'Registration failed');
    }
});
