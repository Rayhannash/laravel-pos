<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;  // Aktifkan soft delete

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'harga',
        'satuan',
        'stok'
    ];

    protected $dates = ['deleted_at']; // Kolom soft delete
}
