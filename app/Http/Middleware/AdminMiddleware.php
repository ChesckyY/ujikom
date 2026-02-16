<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Daftar email admin - sesuaikan dengan email Anda
        $adminEmails = ['cheskyyusuf57@gmail.com'];
        
        // Cek apakah user login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }
        
        // Cek apakah email user ada di daftar admin
        if (in_array(Auth::user()->email, $adminEmails)) {
            return $next($request);
        }
        
        // Jika bukan admin, redirect ke halaman utama
        return redirect()->route('home-page')->with('error', 'Anda tidak memiliki akses ke halaman admin!');
    }
}