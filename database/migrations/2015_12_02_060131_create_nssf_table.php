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
			$table->integer('employee_contribution')->default('0');
			$table->integer('employer_contribution')->default('0');
			$table->integer('total_contribution')->default('0');
			$table->integer('max_employee_nssf')->default('0');
			$table->integer('max_employer_nssf')->default('0');
			$table->integer('nssf_lower_earning')->default('0');
			$table->integer('nssf_upper_earning')->default('0');
			$table->integer('employer_nssf_upper_earning')->default('0');
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
