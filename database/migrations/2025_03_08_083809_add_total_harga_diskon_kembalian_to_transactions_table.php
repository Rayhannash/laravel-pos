<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('total_harga', 10, 2)->after('tanggal_transaksi');
            $table->decimal('diskon', 10, 2)->nullable()->after('total_harga');
            $table->decimal('kembalian', 10, 2)->nullable()->after('total_bayar');
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['total_harga', 'diskon', 'kembalian']);
        });
    }
};