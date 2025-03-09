<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-4">
        <h2>Buat Transaksi</h2>
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <h4>Tambah Produk</h4>
            <div id="product-list">
                <div class="product-item mb-3">
                    <label class="form-label">Produk</label>
                    <select name="products[0][id]" class="form-control product-select" required>
                        @foreach ($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->nama_produk }} - Rp {{ number_format($product->harga, 2) }}
                        </option>
                        @endforeach
                    </select>
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="products[0][quantity]" class="form-control quantity-input" min="1" required>
                </div>
            </div>
            <button type="button" id="add-product" class="btn btn-success">Tambah Produk</button>

            <div class="mb-3 mt-3">
                <label for="total_harga" class="form-label">Total Harga</label>
                <input type="number" class="form-control" id="total_harga" name="total_harga" readonly>
            </div>

            <div class="mb-3">
                <label for="member_id" class="form-label">Member (Opsional)</label>
                <select class="form-control" id="member_id" name="member_id">
                    <option value="">Pilih Member (Opsional)</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}">{{ $member->nama }} - {{ $member->nomor_telepon }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="total_harga_diskon" class="form-label">Total Harga Setelah Diskon</label>
                <input type="number" class="form-control" id="total_harga_diskon" name="total_harga_diskon" readonly>
            </div>

            <div class="mb-3">
                <label for="total_bayar" class="form-label">Total Bayar</label>
                <input type="number" class="form-control" id="total_bayar" name="total_bayar" required>
            </div>

            <div class="mb-3">
                <label for="kembalian" class="form-label">Kembalian</label>
                <input type="number" class="form-control" id="kembalian" name="kembalian" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
            <a href="{{ route('dashboard.index') }}" class="btn btn-primary">Kembali</a>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            let productIndex = 1;

            $("#add-product").click(function() {
                let newProduct = `
    <div class="product-item mb-3">
        <label class="form-label">Produk</label>
        <select name="products[${productIndex}][id]" class="form-control product-select" required>
            @foreach ($products as $product)
                @if ($product->stok > 0)
                    <option value="{{ $product->id }}" data-price="{{ $product->harga }}" data-stock="{{ $product->stok }}">
                        {{ $product->nama_produk }} - Rp {{ number_format($product->harga, 2) }}
                    </option>
                @else
                    <option disabled>
                        {{ $product->nama_produk }} - Stok Habis
                    </option>
                @endif
            @endforeach
        </select>
        <label class="form-label">Jumlah</label>
        <input type="number" name="products[${productIndex}][quantity]" class="form-control quantity-input" min="1" required>
    </div>`;

                $("#product-list").append(newProduct);
                productIndex++;
            });

            $(document).on('change', '.product-select, .quantity-input', function() {
                let totalHarga = 0;
                $(".product-item").each(function() {
                    let price = $(this).find(".product-select option:selected").data("price");
                    let quantity = $(this).find(".quantity-input").val();
                    totalHarga += (price * quantity) || 0;
                });
                $("#total_harga").val(totalHarga);

                let memberId = $("#member_id").val();
                let diskon = memberId ? 0.05 * totalHarga : 0;
                let totalSetelahDiskon = totalHarga - diskon;
                $("#total_harga_diskon").val(totalSetelahDiskon);
            });

            $("#member_id").on("input", function() {
                $(".product-select, .quantity-input").trigger("change");
            });

            $("#total_bayar").on("input", function() {
                let totalBayar = parseFloat($(this).val()) || 0;
                let totalHargaDiskon = parseFloat($("#total_harga_diskon").val()) || parseFloat($("#total_harga").val());
                let kembalian = totalBayar - totalHargaDiskon;
                $("#kembalian").val(kembalian);
            });

            $(document).on('input', '.quantity-input', function() {
                let selectedOption = $(this).closest('.product-item').find('.product-select option:selected');
                let stock = selectedOption.data('stock');
                let quantity = parseInt($(this).val());

                if (quantity > stock) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Stok Tidak Cukup!',
                        text: 'Jumlah yang dimasukkan melebihi stok yang tersedia.',
                    });
                    $(this).val(stock);
                }
            });
        });
    </script>
    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
        });
    </script>
    @endif
</body>
</html>
