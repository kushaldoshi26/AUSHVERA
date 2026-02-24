@extends('layouts.admin')
@section('title', 'Reviews')
@section('page-title', 'Reviews Management')

@section('content')
<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>User</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="reviewsTable">
            <tr><td colspan="7" class="text-center">Loading...</td></tr>
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
async function loadReviews() {
    try {
        const token = api.getToken();
        const response = await fetch('{{ url("/api/admin/reviews") }}', {
            headers: { 'Authorization': `Bearer ${token}` }
        });
        const data = await response.json();
        const reviews = data.reviews || data.data || [];
        const tbody = document.getElementById('reviewsTable');
        
        if (reviews.length > 0) {
            tbody.innerHTML = reviews.map(r => `
                <tr>
                    <td>${r.id}</td>
                    <td>${r.product?.name || 'N/A'}</td>
                    <td>${r.user?.name || 'N/A'}</td>
                    <td>${'⭐'.repeat(r.rating)}</td>
                    <td>${r.comment ? r.comment.substring(0, 50) + '...' : 'No comment'}</td>
                    <td><span class="badge badge-${r.is_approved ? 'delivered' : 'pending'}">${r.is_approved ? 'Approved' : 'Pending'}</span></td>
                    <td>
                        ${!r.is_approved ? `<button class="btn btn-success" onclick="approveReview(${r.id})">Approve</button>` : ''}
                        <button class="btn btn-danger" onclick="deleteReview(${r.id})">Delete</button>
                    </td>
                </tr>
            `).join('');
        } else {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center">No reviews found</td></tr>';
        }
    } catch (error) {
        console.error('Error loading reviews:', error);
        document.getElementById('reviewsTable').innerHTML = '<tr><td colspan="7" class="text-center">No reviews found</td></tr>';
    }
}

async function approveReview(id) {
    try {
        const token = api.getToken();
        const response = await fetch(`{{ url("/api/admin/reviews") }}/${id}/toggle`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({ is_approved: true })
        });
        
        if (response.ok) {
            alert('Review approved');
            loadReviews();
        } else {
            alert('Failed to approve review');
        }
    } catch (error) {
        alert('Error approving review');
    }
}

async function deleteReview(id) {
    if (!confirm('Delete this review?')) return;
    
    try {
        const token = api.getToken();
        await fetch(`{{ url("/api/admin/reviews") }}/${id}`, {
            method: 'DELETE',
            headers: { 'Authorization': `Bearer ${token}` }
        });
        alert('Review deleted');
        loadReviews();
    } catch (error) {
        alert('Error deleting review');
    }
}

loadReviews();
</script>
@endpush
