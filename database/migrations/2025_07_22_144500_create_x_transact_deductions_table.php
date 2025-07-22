<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXTransactDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_transact_deductions', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->integer('organization_id');
            $table->integer('employee_deduction_id');
            $table->string('deduction_name');
            $table->integer('deduction_id');
            $table->decimal('deduction_amount', 10, 2);
            $table->string('financial_month_year');
            $table->string('process_type');
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
        Schema::dropIfExists('x_transact_deductions');
    }
}
