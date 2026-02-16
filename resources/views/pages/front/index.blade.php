<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home-page') }}">
            <i class="fas fa-store"></i> Marketplace
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    @php
                        // Daftar email admin (sama dengan di middleware)
                        $adminEmails = ['cheskyyusuf57@gmail.com'];
                        $isAdmin = in_array(Auth::user()->email, $adminEmails);
                    @endphp
                    
                    @if($isAdmin)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-crown"></i> Dashboard Admin
                        </a>
                    </li>
                    @endif
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('customer.profile') }}">
                                    <i class="fas fa-id-card"></i> Profil Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('customer.orders') }}">
                                    <i class="fas fa-shopping-bag"></i> Pesanan Saya
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Content -->
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <h3 class="mb-4">Produk Tersedia</h3>

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <img 
                        src="{{ asset('storage/' . $product->product_image) }}" 
                        class="card-img-top" 
                        alt="{{ $product->product_name }}"
                    >
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ $product->product_name }}</h5>
                        <p class="text-muted mb-2">{{ $product->category->category_name }}</p>
                        <h6 class="fw-bold text-dark">Rp {{ number_format($product->price, 0, ',', '.') }}</h6>
                        <p class="text-{{ $product->stock > 0 ? 'success' : 'danger' }} mb-2">
                            Stok: {{ $product->stock }}
                        </p>
                        
                        @if($product->stock > 0)
                            <button 
                                class="btn btn-primary w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#modalOrder{{ $product->id }}"
                            >
                                <i class="fas fa-shopping-cart"></i> Pesan
                            </button>
                        @else
                            <button class="btn btn-secondary w-100" disabled>
                                Stok Habis
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal Order (sama seperti sebelumnya) -->
            <div class="modal fade" id="modalOrder{{ $product->id }}" tabindex="-1">
                <!-- ... isi modal tetap sama ... -->
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Belum ada produk tersedia.
                </div>
            </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>