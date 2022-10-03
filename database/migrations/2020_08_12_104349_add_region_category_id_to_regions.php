<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRegionCategoryIdToRegions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fields', function (Blueprint $table) {
            $table->unsignedInteger('field_category_id')->nullable();
            $table->foreign('field_category_id')->references('id')->on('field_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fields', function (Blueprint $table) {
            $table->dropForeign('fields_field_category_id_foreign');
            $table->dropColumn('field_category_id');
        });
    }
}
