// Auth Module for Frontend Integration
// Save this as: auth-module.js

const API_BASE = 'http://localhost:8000/api';

class AuthModule {
  constructor() {
    this.token = localStorage.getItem('auth_token');
    this.user = JSON.parse(localStorage.getItem('auth_user') || 'null');
  }

  // Set authorization header
  getAuthHeaders() {
    return {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${this.token}`
    };
  }

  // Register user
  async register(userData) {
    try {
      const response = await fetch(`${API_BASE}/register`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(userData)
      });

      const data = await response.json();

      if (data.success) {
        this.token = data.data.token;
        this.user = data.data.user;
        
        localStorage.setItem('auth_token', this.token);
        localStorage.setItem('auth_user', JSON.stringify(this.user));
        
        return { success: true, data: data.data };
      } else {
        return { success: false, errors: data.errors, message: data.message };
      }
    } catch (error) {
      return { success: false, message: error.message };
    }
  }

  // Login user
  async login(email, password) {
    try {
      const response = await fetch(`${API_BASE}/login`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ email, password })
      });

      const data = await response.json();

      if (data.success) {
        this.token = data.data.token;
        this.user = data.data.user;
        
        localStorage.setItem('auth_token', this.token);
        localStorage.setItem('auth_user', JSON.stringify(this.user));
        
        return { success: true, data: data.data };
      } else {
        return { success: false, errors: data.errors, message: data.message };
      }
    } catch (error) {
      return { success: false, message: error.message };
    }
  }

  // Get current user
  async getCurrentUser() {
    if (!this.token) return null;

    try {
      const response = await fetch(`${API_BASE}/user`, {
        headers: this.getAuthHeaders()
      });

      const data = await response.json();

      if (data.success) {
        this.user = data.data;
        localStorage.setItem('auth_user', JSON.stringify(this.user));
        return data.data;
      }
      return null;
    } catch (error) {
      console.error('Error fetching user:', error);
      return null;
    }
  }

  // Logout
  async logout() {
    try {
      await fetch(`${API_BASE}/logout`, {
        method: 'POST',
        headers: this.getAuthHeaders()
      });
    } catch (error) {
      console.error('Logout error:', error);
    }

    this.token = null;
    this.user = null;
    localStorage.removeItem('auth_token');
    localStorage.removeItem('auth_user');
  }

  // Check if user is logged in
  isAuthenticated() {
    return !!this.token;
  }

  // Get token
  getToken() {
    return this.token;
  }

  // Get user
  getUser() {
    return this.user;
  }
}

// Cart Module
class CartModule {
  constructor(auth) {
    this.auth = auth;
  }

  // Get cart
  async getCart() {
    try {
      const response = await fetch(`${API_BASE}/cart`, {
        headers: this.auth.getAuthHeaders()
      });

      const data = await response.json();

      if (data.success) {
        return { success: true, data: data.data };
      } else {
        return { success: false, message: data.message };
      }
    } catch (error) {
      return { success: false, message: error.message };
    }
  }

  // Add to cart
  async addItem(productId, quantity = 1) {
    try {
      const response = await fetch(`${API_BASE}/cart/add`, {
        method: 'POST',
        headers: this.auth.getAuthHeaders(),
        body: JSON.stringify({ product_id: productId, quantity })
      });

      const data = await response.json();

      if (data.success) {
        return { success: true, data: data.data, message: data.message };
      } else {
        return { success: false, message: data.message };
      }
    } catch (error) {
      return { success: false, message: error.message };
    }
  }

  // Update cart item
  async updateItem(itemId, quantity) {
    try {
      const response = await fetch(`${API_BASE}/cart/items/${itemId}`, {
        method: 'PUT',
        headers: this.auth.getAuthHeaders(),
        body: JSON.stringify({ quantity })
      });

      const data = await response.json();

      if (data.success) {
        return { success: true, data: data.data, message: data.message };
      } else {
        return { success: false, message: data.message };
      }
    } catch (error) {
      return { success: false, message: error.message };
    }
  }

  // Remove from cart
  async removeItem(itemId) {
    try {
      const response = await fetch(`${API_BASE}/cart/items/${itemId}`, {
        method: 'DELETE',
        headers: this.auth.getAuthHeaders()
      });

      const data = await response.json();

      if (data.success) {
        return { success: true, message: data.message };
      } else {
        return { success: false, message: data.message };
      }
    } catch (error) {
      return { success: false, message: error.message };
    }
  }

  // Clear cart
  async clearCart() {
    try {
      const response = await fetch(`${API_BASE}/cart/clear`, {
        method: 'DELETE',
        headers: this.auth.getAuthHeaders()
      });

      const data = await response.json();

      if (data.success) {
        return { success: true, message: data.message };
      } else {
        return { success: false, message: data.message };
      }
    } catch (error) {
      return { success: false, message: error.message };
    }
  }

  // Get cart count
  async getCartCount() {
    try {
      const response = await fetch(`${API_BASE}/cart/count`, {
        headers: this.auth.getAuthHeaders()
      });

      const data = await response.json();

      if (data.success) {
        return data.data.count;
      }
      return 0;
    } catch (error) {
      console.error('Error fetching cart count:', error);
      return 0;
    }
  }
}

// Initialize modules
const auth = new AuthModule();
const cart = new CartModule(auth);

// Export for use
window.auth = auth;
window.cart = cart;

// Usage Examples:
/*

// 1. Register
await auth.register({
  name: 'John Doe',
  email: 'john@example.com',
  password: 'password123',
  password_confirmation: 'password123'
});

// 2. Login
await auth.login('john@example.com', 'password123');

// 3. Get current user
const user = await auth.getCurrentUser();

// 4. Add to cart
await cart.addItem(1, 2); // product_id, quantity

// 5. Get cart
const cartData = await cart.getCart();

// 6. Update cart item
await cart.updateItem(1, 5); // itemId, quantity

// 7. Remove from cart
await cart.removeItem(1);

// 8. Get cart count
const count = await cart.getCartCount();

// 9. Logout
await auth.logout();

*/
