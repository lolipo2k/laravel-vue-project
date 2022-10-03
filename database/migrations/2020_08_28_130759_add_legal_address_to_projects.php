<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLegalAddressToProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->text('legal_address')->nullable();
            $table->string('legal_name')->nullable();
            $table->longtext('board')->nullable();
            $table->integer('leads')->default(0);
            $table->boolean('make_script')->default(false);
            $table->boolean('make_base')->default(false);
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
            $table->dropColumn('legal_address');
            $table->dropColumn('legal_name');
            $table->dropColumn('board');
            $table->dropColumn('leads');
            $table->dropColumn('make_script');
            $table->dropColumn('make_base');
        });
    }
}
