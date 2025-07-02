<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGrossTaxToXTransactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('x_transact', function (Blueprint $table) {
            $table->decimal('gross_tax', 15, 2)->nullable()->after('taxable_income');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('x_transact', function (Blueprint $table) {
            $table->dropColumn('gross_tax');
        });
    }
}
