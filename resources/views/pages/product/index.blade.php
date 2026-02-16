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
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Sukses!</h5>
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                <i class="fas fa-plus"></i> Tambah Data
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
                        <th width="150">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $key => $product)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->category->category_name }}</td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>{{ Str::limit($product->product_description, 50) }}</td>
                            <td>
                                <img 
                                    src="{{ asset('storage/' . $product->product_image) }}" 
                                    width="100" 
                                    alt="Gambar Produk"
                                    style="height: 80px; object-fit: cover;"
                                >
                            </td>
                            <td>
                                <button 
                                    class="btn btn-sm btn-primary" 
                                    data-toggle="modal" 
                                    data-target="#modalEdit{{ $product->id }}"
                                    title="Edit"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button 
                                    class="btn btn-sm btn-danger" 
                                    data-toggle="modal" 
                                    data-target="#modalHapus{{ $product->id }}"
                                    title="Hapus"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit Produk -->
                    <div class="modal fade" id="modalEdit{{ $product->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            {{-- Perbaiki route di sini --}}
                            <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Data Produk</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <label>Nama Produk</label>
                                        <input 
                                            type="text" 
                                            name="product_name" 
                                            class="form-control mb-2" 
                                            placeholder="Masukkan Nama Produk"
                                            value="{{ $product->product_name }}"
                                            required
                                        >

                                        <label>Kategori Produk</label>
                                        <select name="category_id" class="form-control mb-2" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
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
                                            value="{{ $product->price }}"
                                            required
                                        >

                                        <label>Stock</label>
                                        <input 
                                            type="number" 
                                            name="stock" 
                                            class="form-control mb-2" 
                                            placeholder="Masukkan Stock"
                                            value="{{ $product->stock }}"
                                            required
                                        >

                                        <label>Gambar Produk</label>
                                        <input 
                                            type="file" 
                                            name="product_image" 
                                            class="form-control mb-2"
                                        >
                                        <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                                        
                                        @if($product->product_image)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $product->product_image) }}" width="100" alt="Current Image">
                                            </div>
                                        @endif

                                        <label>Deskripsi Produk</label>
                                        <textarea 
                                            name="product_description" 
                                            class="form-control" 
                                            rows="3"
                                            required
                                        >{{ $product->product_description }}</textarea>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Hapus Produk -->
                    <div class="modal fade" id="modalHapus{{ $product->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Konfirmasi Hapus</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menghapus produk <strong>{{ $product->product_name }}</strong>?</p>
                                    <p class="text-danger"><small>Data yang sudah dihapus tidak dapat dikembalikan.</small></p>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    {{-- Perbaiki route di sini juga --}}
                                    <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Produk</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <label>Nama Produk</label>
                    <input 
                        type="text" 
                        name="product_name" 
                        class="form-control mb-2" 
                        placeholder="Masukkan Nama Produk"
                        required
                    >

                    <label>Kategori Produk</label>
                    <select name="category_id" class="form-control mb-2" required>
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
                        required
                    >

                    <label>Stock</label>
                    <input 
                        type="number" 
                        name="stock" 
                        class="form-control mb-2" 
                        placeholder="Masukkan Stock"
                        required
                    >

                    <label>Gambar Produk</label>
                    <input 
                        type="file" 
                        name="product_image" 
                        class="form-control mb-2"
                        required
                        accept="image/*"
                    >

                    <label>Deskripsi Produk</label>
                    <textarea 
                        name="product_description" 
                        class="form-control" 
                        rows="3"
                        required
                    ></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection