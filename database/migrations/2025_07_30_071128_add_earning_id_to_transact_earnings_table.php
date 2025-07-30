<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEarningIdToTransactEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('x_transact_earnings', function (Blueprint $table) {
            $table->unsignedInteger('earning_id')->after('employee_id');

            // Add foreign key constraint
            $table->foreign('earning_id')
                ->references('id')
                ->on('x_earnings')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('x_transact_earnings', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['earning_id']);

            // Then drop the column
            $table->dropColumn('earning_id');
        });
    }
}
