<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGraduatedScaleToXSocialSecurityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('x_social_security', function (Blueprint $table) {
            $table->string('graduated_scale')->nullable()->after('employer_nssf_upper_earning');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('x_social_security', function (Blueprint $table) {
            $table->dropColumn('graduated_scale');
        });
    }
}
