<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDuplicateProductTypeFromProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Hapus kolom product_type yang tidak diperlukan.
            $table->dropColumn('produck_type'); // Pastikan ini adalah kolom yang perlu dihapus.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Tambahkan kembali kolom product_type jika diperlukan untuk rollback.
            $table->string('produck_type')->after('product_type');
        });
    }
}
