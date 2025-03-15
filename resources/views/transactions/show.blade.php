@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Detail Transaksi</h2>
    <p><strong>No. Transaksi:</strong> {{ $transaction->nomor_transaksi }}</p>
    <p><strong>Tanggal:</strong> {{ $transaction->tanggal_transaksi }}</p>
    <p><strong>Member:</strong> {{ $transaction->member->nama_member ?? 'Umum' }}</p>
    <p><strong>Total Harga:</strong> Rp {{ number_format($transaction->total_harga, 2) }}</p>
    <p><strong>Total Bayar:</strong> Rp {{ number_format($transaction->total_bayar, 2) }}</p>
    <p><strong>Kembalian:</strong> Rp {{ number_format($transaction->kembalian, 2) }}</p>
    <a href="{{ route('transactions.index') }}" class="btn btn-primary">Kembali</a>
</div>
@endsection
