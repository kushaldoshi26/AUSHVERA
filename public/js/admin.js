const AdminApp = {
    async logout() {
        try { await api.logout(); } catch(e) {}
        localStorage.removeItem('auth_token');
        localStorage.removeItem('currentUser');
        window.location.href = 'profile.html';
    },

    async checkAdmin() {
        const token = api.getToken();
        if (!token) {
            window.location.href = 'profile.html';
            return false;
        }
        
        try {
            const response = await api.getUser();
            if (response.data.role !== 'admin') {
                alert('Access denied. Admin only.');
                window.location.href = 'index.html';
                return false;
            }
            return true;
        } catch (error) {
            window.location.href = 'profile.html';
            return false;
        }
    },

    setActiveNav(page) {
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === page) {
                link.classList.add('active');
            }
        });
    },

    showModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.add('active');
    },

    hideModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.remove('active');
    },

    showLoading(elementId) {
        const el = document.getElementById(elementId);
        if (el) el.innerHTML = '<tr><td colspan="100" class="text-center">Loading...</td></tr>';
    },

    showError(elementId, message) {
        const el = document.getElementById(elementId);
        if (el) el.innerHTML = `<tr><td colspan="100" class="text-center" style="color: var(--danger);">${message}</td></tr>`;
    },

    showEmpty(elementId, message) {
        const el = document.getElementById(elementId);
        if (el) el.innerHTML = `<tr><td colspan="100" class="text-center">${message}</td></tr>`;
    },

    formatDate(dateString) {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    },

    formatCurrency(amount) {
        return '₹' + parseFloat(amount).toFixed(2);
    },

    initSidebar() {
        document.querySelectorAll('.nav-section-title').forEach(title => {
            title.addEventListener('click', function() {
                const section = this.parentElement;
                section.classList.toggle('collapsed');
            });
        });
    }
};

document.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal')) {
        e.target.classList.remove('active');
    }
});

document.addEventListener('DOMContentLoaded', () => {
    AdminApp.initSidebar();
});
