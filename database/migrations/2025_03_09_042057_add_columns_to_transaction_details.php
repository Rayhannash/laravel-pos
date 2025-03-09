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
        Schema::table('transaction_details', function (Blueprint $table) {
            // Tambahkan foreign key jika belum ada
            if (!in_array('transaction_id', Schema::getColumnListing('transaction_details'))) {
                $table->unsignedBigInteger('transaction_id')->after('id');
                $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            }

            if (!in_array('product_id', Schema::getColumnListing('transaction_details'))) {
                $table->unsignedBigInteger('product_id')->after('transaction_id');
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
            $table->dropForeign(['product_id']);
        });
    }
};
