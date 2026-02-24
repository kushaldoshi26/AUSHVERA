const API_URL = 'http://localhost:8000/api';

async function handleLogin(e) {
    e.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    try {
        const response = await fetch(`${API_URL}/login`, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({email, password})
        });
        
        const data = await response.json();
        
        if (response.ok) {
            localStorage.setItem('user', JSON.stringify(data.user));
            localStorage.setItem('isLoggedIn', 'true');
            
            if (data.role === 'admin') {
                window.location.href = '/admin';
            } else {
                window.location.href = 'profile.html';
            }
        } else {
            alert(data.message || 'Login failed');
        }
    } catch (error) {
        alert('Connection error. Please try again.');
    }
}

async function handleRegister(e) {
    e.preventDefault();
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const phone = document.getElementById('phone')?.value;
    
    try {
        const response = await fetch(`${API_URL}/register`, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({name, email, password, phone})
        });
        
        const data = await response.json();
        
        if (response.ok) {
            alert('Registration successful! Please login.');
            window.location.href = 'login.html';
        } else {
            alert(data.message || 'Registration failed');
        }
    } catch (error) {
        alert('Connection error. Please try again.');
    }
}

async function fetchPincode(pincode) {
    if (pincode.length === 6) {
        try {
            const response = await fetch(`https://api.postalpincode.in/pincode/${pincode}`);
            const data = await response.json();
            if (data[0].Status === 'Success') {
                return {
                    city: data[0].PostOffice[0].District,
                    state: data[0].PostOffice[0].State,
                    country: 'India'
                };
            }
        } catch (error) {
            console.error('Pincode fetch error:', error);
        }
    }
    return null;
}
