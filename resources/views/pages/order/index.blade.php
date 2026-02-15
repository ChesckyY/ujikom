@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pesanan</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered myTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pemesan</th>
                        <th>Email Pemesan</th>
                        <th>Alamat Pemesan</th>
                        <th>Catatan</th>
                        <th>Nama Produk</th>
                        <th>Total Pesanan</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->address }}</td>
                            <td>{{ $order->notes ?? '-' }}</td>
                            <td>{{ $order->product->product_name }}</td>
                            <td>{{ $order->total_item }}</td>
                            <td>{{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection