<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNssfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('x_social_security', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn([
                'employee_contribution',
                'employer_contribution',
                'total_contribution',
                'max_employee_nssf',
                'max_employer_nssf',
                'nssf_lower_earning',
                'nssf_upper_earning',
                'employer_nssf_upper_earning'
            ]);

            // Add new columns for current NSSF structure
            $table->decimal('lower_earnings_limit', 10, 2)->default(8000)->comment('NSSF Lower Earnings Limit');
            $table->decimal('upper_earnings_limit', 10, 2)->default(72000)->comment('NSSF Upper Earnings Limit');
            $table->decimal('rate_tier1', 5, 2)->default(6.00)->comment('NSSF Tier 1 rate as percentage');
            $table->decimal('rate_tier2', 5, 2)->default(6.00)->comment('NSSF Tier 2 rate as percentage');
        });
    }

    public function down()
    {
        Schema::table('x_social_security', function (Blueprint $table) {
            $table->dropColumn(['lower_earnings_limit', 'upper_earnings_limit', 'rate_tier1', 'rate_tier2']);
            // Add back old columns if needed
            $table->decimal('employee_contribution', 8, 2)->nullable();
            $table->decimal('employer_contribution', 8, 2)->nullable();
            $table->decimal('total_contribution', 8, 2)->nullable();
            $table->decimal('max_employee_nssf', 8, 2)->nullable();
            $table->decimal('max_employer_nssf', 8, 2)->nullable();
            $table->decimal('nssf_lower_earning', 8, 2)->nullable();
            $table->decimal('nssf_upper_earning', 8, 2)->nullable();
            $table->decimal('employer_nssf_upper_earning', 8, 2)->nullable();
        });
    }
}
