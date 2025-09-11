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
            $table->unsignedBigInteger('employee_id');   // FK → x_employee.id
            $table->unsignedBigInteger('court_order_id'); // FK → court_orders.id
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('balance', 12, 2)->nullable();
            $table->enum('status', ['active', 'suspended', 'completed'])->default('active');
            $table->timestamps();

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
