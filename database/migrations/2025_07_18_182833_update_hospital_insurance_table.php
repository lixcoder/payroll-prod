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
            // Add new columns
            $table->decimal('shif_rate', 5, 4)->default(2.75)->comment('SHIF rate as percentage');
            $table->decimal('minimum_amount', 8, 2)->default(300)->comment('Minimum SHIF contribution');
        });

        // Drop columns only if they exist
        if (Schema::hasColumn('x_hospital_insurance', 'rate')) {
            Schema::table('x_hospital_insurance', function (Blueprint $table) {
                $table->dropColumn('rate');
            });
        }

        if (Schema::hasColumn('x_hospital_insurance', 'income_from')) {
            Schema::table('x_hospital_insurance', function (Blueprint $table) {
                $table->dropColumn('income_from');
            });
        }

        if (Schema::hasColumn('x_hospital_insurance', 'income_to')) {
            Schema::table('x_hospital_insurance', function (Blueprint $table) {
                $table->dropColumn('income_to');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('x_hospital_insurance', function (Blueprint $table) {
            if (!Schema::hasColumn('x_hospital_insurance', 'rate')) {
                $table->decimal('rate', 8, 2)->nullable();
            }

            if (Schema::hasColumn('x_hospital_insurance', 'minimum_amount')) {
                $table->dropColumn('minimum_amount');
            }

            if (Schema::hasColumn('x_hospital_insurance', 'shif_rate')) {
                $table->dropColumn('shif_rate');
            }
        });
    }
}
