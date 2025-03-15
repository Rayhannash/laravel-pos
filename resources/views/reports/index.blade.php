<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Laporan Penjualan</h2>
        <form action="{{ route('reports.filter') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="tanggal" class="form-label">Pilih Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">Kembali</a>
        </form>

        @if(isset($transactions))
            <h4 class="mt-4">Hasil Laporan Tanggal : {{ $tanggal }}</h4>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>No. Transaksi</th>
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                        <th>Diskon</th>
                        <th>Total Setelah Diskon</th>
                        <th>Total Bayar</th>
                        <th>Kembalian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->nomor_transaksi }}</td>
                        <td>{{ $transaction->tanggal_transaksi }}</td>
                        <td>Rp {{ number_format($transaction->total_harga) }}</td>
                        <td>Rp {{ number_format($transaction->diskon) }}</td>
                        <td>Rp {{ number_format($transaction->total_harga_setelah_diskon) }}</td>
                        <td>Rp {{ number_format($transaction->total_bayar) }}</td>
                        <td>Rp {{ number_format($transaction->kembalian) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada transaksi pada tanggal ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <h4>Total Pemasukan : Rp {{ number_format($total_pemasukan, 0, ',', '.') }}</strong></h4>
        @endif
    </div>
</body>
</html>
