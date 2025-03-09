<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('transactions', function (Blueprint $table) {
        $table->decimal('total_harga', 10, 2)->after('tanggal_transaksi');
        $table->decimal('diskon', 10, 2)->nullable()->after('total_harga');
        $table->decimal('total_harga_setelah_diskon', 10, 2)->after('diskon');
    });
}

public function down()
{
    Schema::table('transactions', function (Blueprint $table) {
        $table->dropColumn(['total_harga', 'diskon', 'total_harga_setelah_diskon']);
    });
}
};
