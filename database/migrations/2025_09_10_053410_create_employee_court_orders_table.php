<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeCourtOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_court_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedInteger('employee_id');   // FK → x_employee.id
            $table->unsignedBigInteger('court_order_id'); // FK → court_orders.id

            // 🔹 Deduction fields merged directly here
            $table->enum('deduction_type', ['fixed', 'percentage'])->default('fixed');
            $table->decimal('deduction_value', 10, 2)->default(0.00);
            $table->decimal('max_deduction', 10, 2)->nullable();
            $table->enum('apply_on', ['gross', 'net'])->default('gross');

            // 🔹 Dates
            $table->date('start_date');
            $table->date('end_date')->nullable();

            // 🔹 Tracking
            $table->decimal('balance', 12, 2)->nullable();
            $table->enum('status', ['active', 'suspended', 'completed'])->default('active');
            $table->timestamps();

            // 🔹 Foreign keys
            $table->foreign('employee_id')
                  ->references('id')->on('x_employee')
                  ->onDelete('cascade');

            $table->foreign('court_order_id')
                  ->references('id')->on('court_orders')
                  ->onDelete('cascade');

            $table->index(['organization_id', 'employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_court_orders');
    }
}
