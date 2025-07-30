<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProcessTypeToTransactNontaxables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('x_transact_nontaxables', function (Blueprint $table) {
            $table->string('process_type')->after('financial_month_year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('x_transact_nontaxables', function (Blueprint $table) {
            $table->dropColumn('process_type');
        });
    }
}
