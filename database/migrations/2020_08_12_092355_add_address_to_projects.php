<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressToProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->text('real_address')->nullable();
            $table->string('ceo_fio')->nullable();
            $table->string('seo_position')->nullable();
            $table->string('seo_email')->nullable();
            $table->string('seo_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('real_address');
            $table->dropColumn('ceo_fio');
            $table->dropColumn('seo_position');
            $table->dropColumn('seo_email');
            $table->dropColumn('seo_phone');
        });
    }
}
