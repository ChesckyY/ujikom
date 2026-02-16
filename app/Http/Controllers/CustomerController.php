<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Menampilkan profil customer
     */
    public function profile()
    {
        $user = Auth::user();
        return view('pages.customer.profile', compact('user'));
    }

    /**
     * Menampilkan riwayat pesanan customer
     */
    public function orders()
    {
        $orders = Order::where('email', Auth::user()->email)->with('product')->latest()->get();
        
        return view('pages.customer.orders', compact('orders'));
    }
}