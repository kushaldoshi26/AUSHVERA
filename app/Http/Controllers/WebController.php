<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function home()
    {
        $products = Product::take(4)->get();
        return view('frontend.home', compact('products'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function philosophy()
    {
        return view('frontend.philosophy');
    }

    public function ritual()
    {
        return view('frontend.ritual');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function product()
    {
        return view('frontend.product');
    }

    public function products()
    {
        $products = Product::all();
        return view('frontend.products', compact('products'));
    }

    public function cart()
    {
        return view('frontend.cart');
    }

    public function profile()
    {
        return view('frontend.profile');
    }

    public function orders()
    {
        return view('frontend.orders');
    }

    public function wishlist()
    {
        return view('frontend.wishlist');
    }

    public function addresses()
    {
        return view('frontend.addresses');
    }

    public function payment()
    {
        return view('frontend.payment');
    }

    public function security()
    {
        return view('frontend.security');
    }

    public function terms()
    {
        return view('frontend.terms');
    }

    public function adminDashboard() { return view('admin.dashboard'); }
    public function adminProducts() { return view('admin.products'); }
    public function adminOrders() { return view('admin.orders'); }
    public function adminUsers() { return view('admin.users'); }
    public function adminInventory() { return view('admin.inventory'); }
    public function adminPricing() { return view('admin.pricing'); }
    public function adminBanners() { return view('admin.banners'); }
    public function adminCoupons() { return view('admin.coupons'); }
    public function adminReviews() { return view('admin.reviews'); }
    public function adminCategories() { return view('admin.categories'); }
    public function adminAnalytics() { return view('admin.analytics'); }
    public function adminLoginHistory() { return view('admin.login-history'); }
    public function adminActivityLogs() { return view('admin.activity-logs'); }
    public function adminManagement() { return view('admin.management'); }
    public function adminRegister() { return view('admin.register'); }
}
