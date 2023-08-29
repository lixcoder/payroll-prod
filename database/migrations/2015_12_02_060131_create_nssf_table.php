<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateNssfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_social_security', function(Blueprint $table)
		{
			$table->increments('id');
			$table->int('employee_contribution',11)->default('0.00');
			$table->int('employer_contribution',11)->default('0.00');
			$table->int('total_contribution',11)->default('0.00');
			$table->int('max_employee_nssf',11)->default('0.00');
			$table->int('max_employer_nssf',11)->default('0.00');
			$table->int('nssf_lower_earning',11)->default('0.00');
			$table->int('nssf_upper_earning',11)->default('0.00');
			$table->int('employer_nssf_upper_earning',11)->default('0.00');
			$table->integer('organization_id');
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
		Schema::drop('x_social_security');
	}

}
