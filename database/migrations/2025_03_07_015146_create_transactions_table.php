<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi')->unique();
            $table->date('tanggal_transaksi');
            $table->decimal('total_harga', 10, 2);
            $table->decimal('diskon', 10, 2)->default(0);
            $table->decimal('total_harga_setelah_diskon', 10, 2);
            $table->decimal('total_bayar', 10, 2);
            $table->decimal('kembalian', 10, 2);
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->timestamps();
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
