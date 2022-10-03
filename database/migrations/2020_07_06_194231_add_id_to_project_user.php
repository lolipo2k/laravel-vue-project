<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdToProjectUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_user', function (Blueprint $table) {
            $table->dropPrimary('PRIMARY');
            $table->unique(['project_id', 'user_id'], 'project_user');
        });

        Schema::table('project_user', function (Blueprint $table) {
            $table->bigIncrements('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_user', function (Blueprint $table) {
            $table->dropColumn('id');
        });
        Schema::table('project_user', function (Blueprint $table) {
            $table->dropUnique('project_user');
            $table->primary(['project_id', 'user_id']);
        });
    }
}
