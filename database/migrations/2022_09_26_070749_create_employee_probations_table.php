<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeProbationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_probations', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->string('start_date');
            $table->string('end_date');
            $table->boolean('confirmed')->default(false);
            $table->string('confirmed_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_probations');
    }
}
