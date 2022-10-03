<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFreezedToBaseRecordStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('base_record_status', function (Blueprint $table) {
            $table->boolean('freezed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('base_record_status', function (Blueprint $table) {
            $table->dropColumn('freezed');
        });
    }
}
