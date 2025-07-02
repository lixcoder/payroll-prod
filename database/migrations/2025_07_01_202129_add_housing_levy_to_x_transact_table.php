<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHousingLevyToXTransactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('x_transact', function (Blueprint $table) {
            $table->decimal('housing_levy', 15, 2)->nullable()->after('insurance_relief');
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
            $table->dropColumn('housing_levy');
        });
    }
}
