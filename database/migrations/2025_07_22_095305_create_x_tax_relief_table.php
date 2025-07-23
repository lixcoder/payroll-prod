<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXTaxReliefTable extends Migration
{

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('x_tax_relief', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2)->default(0.00)->comment('Personal relief amount in KES');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('x_tax_relief');
    }
}
