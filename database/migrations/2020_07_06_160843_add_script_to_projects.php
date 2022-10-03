<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScriptToProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->text('script')->nullable();
            $table->text('criteries')->nullable();
            $table->double('criterion_price')->default(0);
            $table->integer('criterion_month')->default(0);
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
            $table->dropColumn('script');
            $table->dropColumn('criteries');
            $table->dropColumn('criterion_price');
            $table->dropColumn('criterion_month');
        });
    }
}
