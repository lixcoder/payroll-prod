<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeeAllowanceIdAndProcessTypeToXTransactAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('x_transact_allowances', function (Blueprint $table) {
            $table->integer('employee_allowance_id')->after('employee_id');
            $table->string('process_type')->after('allowance_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('x_transact_allowances', function (Blueprint $table) {
            $table->dropColumn('employee_allowance_id');
            $table->dropColumn('process_type');
        });
    }
}
