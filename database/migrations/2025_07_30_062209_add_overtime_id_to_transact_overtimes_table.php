<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOvertimeIdToTransactOvertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('x_transact_overtimes', function (Blueprint $table) {
            $table->integer('overtime_id')->unsigned()->after('employee_id');

            // Add foreign key if needed
            $table->foreign('overtime_id')
                ->references('id')
                ->on('x_overtimes')
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
        Schema::table('x_transact_overtimes', function (Blueprint $table) {
            $table->dropForeign(['overtime_id']);
            $table->dropColumn('overtime_id');
        });
    }
}
