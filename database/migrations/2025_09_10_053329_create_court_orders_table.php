<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourtOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('court_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->string('order_number')->unique();

            // 🔹 Use TEXT for flexible description
            $table->text('description')->nullable();

            // 🔹 Combined enums
            $table->enum('order_type', ['garnishment', 'attachment', 'deduction'])->default('deduction');
            $table->enum('rate_type', ['fixed', 'percentage'])->default('fixed');

            // 🔹 Amounts
            $table->decimal('rate_amount', 10, 2)->default(0);   // main amount
            $table->decimal('amount', 10, 2)->nullable();        // optional amount
            $table->decimal('percentage', 5, 2)->nullable();     // optional %

            // 🔹 Dates
            $table->date('effective_date');
            $table->date('expiry_date')->nullable();
            $table->date('end_date')->nullable(); // extra end date

            // 🔹 Tracking
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            // 🔹 Indexes
            $table->index('organization_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('court_orders');
    }
}
