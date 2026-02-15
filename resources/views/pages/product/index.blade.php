@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Produk</h1>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<section class="content">
    <div class="card">
        <div class="card-header">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                Tambah Data
            </button>
        </div>

        <div class="card-body">
            <table class="table table-bordered myTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $key => $product)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->category->category_name }}</td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>{{ $product->product_description }}</td>
                            <td>
                                <img 
                                    src="{{ asset('storage/' . $product->product_image) }}" 
                                    width="100" 
                                    alt="Gambar Produk"
                                >
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <label>Nama Produk</label>
                    <input 
                        type="text" 
                        name="product_name" 
                        class="form-control mb-2" 
                        placeholder="Masukkan Nama Produk"
                    >

                    <label>Kategori Produk</label>
                    <select name="category_id" class="form-control mb-2">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">
                                {{ $cat->category_name }}
                            </option>
                        @endforeach
                    </select>

                    <label>Harga</label>
                    <input 
                        type="number" 
                        name="price" 
                        class="form-control mb-2" 
                        placeholder="Masukkan Harga"
                    >

                    <label>Stock</label>
                    <input 
                        type="number" 
                        name="stock" 
                        class="form-control mb-2" 
                        placeholder="Masukkan Stock"
                    >

                    <label>Gambar Produk</label>
                    <input 
                        type="file" 
                        name="product_image" 
                        class="form-control mb-2"
                    >

                    <label>Deskripsi Produk</label>
                    <textarea 
                        name="product_description" 
                        class="form-control" 
                        rows="3"
                    ></textarea>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection