@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Kategori Produk</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">Tambah Kategori</button>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped myTable">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Kategori</th>
                            <th style="width: 150px;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($categories as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->category_name }}</td>
                                <td>
                                    <form action="{{ route('category.destroy', $item->id) }}" method="POST"onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</section>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="modal-tambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Tambah Kategori Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('category.store') }}" method="POST">
                @csrf

                <div class="modal-body">
                    <div class="form-group">
                        <label for="category_name">Nama Kategori</label>
                        <input 
                            type="text" 
                            name="category_name" 
                            id="category_name"
                            class="form-control" 
                            placeholder="Contoh: Smartphone, Laptop"
                            required
                        >
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection