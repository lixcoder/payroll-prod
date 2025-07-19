<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameRateColumnInXHospitalInsuranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('x_hospital_insurance', function (Blueprint $table) {
            $table->renameColumn('shif_rate', 'rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('x_hospital_insurance', function (Blueprint $table) {
            $table->renameColumn('rate', 'shif_rate');
        });
    }
}
