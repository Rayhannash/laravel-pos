<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Riwayat Transaksi</h2>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">Buat Transaksi</a>
        <a href="{{ route('dashboard.index') }}" class="btn btn-primary">Kembali</a>
        <div class="table-responsive">
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>No. Transaksi</th>
                        <th>Tanggal</th>
                        <th>Member</th>
                        <th>Total Harga</th>
                        <th>Total Bayar</th>
                        <th>Kembalian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->nomor_transaksi }}</td>
                        <td>{{ $transaction->tanggal_transaksi }}</td>
                        <td>{{ $transaction->member_id ?? 'Umum' }}</td>
                        <td>Rp {{ number_format($transaction->total_harga, 2) }}</td>
                        <td>Rp {{ number_format($transaction->total_bayar, 2) }}</td>
                        <td>Rp {{ number_format($transaction->kembalian, 2) }}</td>
                        <td>
                        <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah yakin untuk menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</body>
</html>
