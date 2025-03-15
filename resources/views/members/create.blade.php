<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Tambah Member</h2>
        <form action="{{ route('members.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama_member" class="form-label">Nama Member</label>
                <input type="text" class="form-control" id="nama_member" name="nama_member" required>
            </div>

            <div class="mb-3">
                <label for="nomor_handphone" class="form-label">Nomor Handphone</label>
                <input type="number" class="form-control" id="nomor_handphone" name="nomor_handphone" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</body>
</html>
