<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_transaksi',
        'tanggal_transaksi',
        'total_harga',
        'diskon',
        'total_harga_setelah_diskon',
        'total_bayar',
        'kembalian',
        'member_id',
    ];

    public function member()
{
    return $this->belongsTo(Member::class, 'member_id');
}

}
