<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLeadsCreatedToProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->integer('leads_created')->default(0);
            $table->timestamp('active_to')->nullable();
            $table->timestamp('payed_to')->nullable();
            $table->text('comment')->nullable();
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
            $table->dropColumn('leads_created');
            $table->dropColumn('active_to');
            $table->dropColumn('payed_to');
            $table->dropColumn('comment');
        });
    }
}
