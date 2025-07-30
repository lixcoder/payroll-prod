<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveInsuranceReliefFromXTransactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('x_transact', function (Blueprint $table) {
            $table->dropColumn('insurance_relief');
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
            $table->decimal('insurance_relief', 15, 2)->nullable()->after('gross_tax');
        });
    }
}
