<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHospitalInsuranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('x_hospital_insurance', function (Blueprint $table) {
            // Drop all existing columns
            $table->dropColumn('rate');
            $table->dropColumn('income_from');
            $table->dropColumn('income_to');

            // Add new columns
            $table->decimal('shif_rate', 5, 4)->default(2.75)->comment('SHIF rate as percentage');
            $table->decimal('minimum_amount', 8, 2)->default(300)->comment('Minimum SHIF contribution');
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
            $table->dropColumn('rate');
            $table->dropColumn('minimum_amount');
        });
    }
}
