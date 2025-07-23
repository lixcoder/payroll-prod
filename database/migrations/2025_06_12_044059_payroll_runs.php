<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PayrollRuns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_runs', function (Blueprint $table){
            $table -> id();
            $table -> unsignedBigInteger('organization_id');
            $table -> date('start_date');
            $table -> date('end_date');
            $table -> enum('cycle', ['monthly','weekly']);
            $table -> boolean('is_processed')->default(false);
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_runs');
    }
}
