<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home-page') }}">
            <i class="fas fa-store"></i> Marketplace
        </a>
        <a href="{{ route('home-page') }}" class="btn btn-light">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</nav>

<div class="container mt-4">
    <h3 class="mb-4"><i class="fas fa-shopping-bag"></i> Riwayat Pesanan Saya</h3>

    @if($orders->count() > 0)
        <div class="row">
            @foreach($orders as $order)
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="text-primary">{{ $order->product->product_name ?? 'Produk Dihapus' }}</h5>
                                <span class="badge bg-success">Selesai</span>
                            </div>
                            <p class="mb-1">
                                <strong>Jumlah:</strong> {{ $order->total_item }} item
                            </p>
                            <p class="mb-1">
                                <strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </p>
                            <p class="mb-1">
                                <strong>Alamat:</strong> {{ $order->address }}
                            </p>
                            @if($order->notes)
                                <p class="mb-1">
                                    <strong>Catatan:</strong> {{ $order->notes }}
                                </p>
                            @endif
                            <p class="mb-0 text-muted small">
                                {{ $order->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle fa-2x mb-3"></i>
            <h5>Belum Ada Pesanan</h5>
            <p>Anda belum melakukan pemesanan apapun.</p>
            <a href="{{ route('home-page') }}" class="btn btn-primary">Lihat Produk</a>
        </div>
    @endif
</div>
</body>
</html>