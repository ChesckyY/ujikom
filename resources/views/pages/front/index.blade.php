@extends('layouts.front')

@section('content')

<div class="container mt-4">
    <h3>Portal Marketplace</h3>

    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img 
                        src="{{ asset('storage/' . $product->product_image) }}" 
                        class="card-img-top"
                    >

                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            {{ $product->product_name }}
                        </h5>

                        <p class="card-text text-muted">
                            {{ $product->category->category_name }}
                        </p>

                        <h6 class="font-weight-bold">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </h6>

                        <button 
                            class="btn btn-sm btn-outline-primary w-100 mt-2"
                            data-bs-toggle="modal"
                            data-bs-target="#modalDetail{{ $product->id }}"
                        >
                            Detail
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal Detail Produk -->
            <div class="modal fade" id="modalDetail{{ $product->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Detail Produk</h5>
                            <button 
                                type="button" 
                                class="btn-close" 
                                data-bs-dismiss="modal"
                            ></button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <img 
                                        src="{{ asset('storage/' . $product->product_image) }}" 
                                        class="img-fluid border"
                                    >
                                </div>

                                <div class="col-md-6">
                                    <h3>{{ $product->product_name }}</h3>

                                    <p>{{ $product->category->category_name }}</p>

                                    <p>Jumlah Stok : {{ $product->stock }}</p>

                                    <h2 class="text-dark">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </h2>

                                    <hr>

                                    <h6>Deskripsi Produk</h6>
                                    <p>{{ $product->product_description }}</p>

                                    <button class="btn btn-primary float-end">Pesan Produk
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        @endforeach
    </div>
</div>

@endsection
