<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTargetToInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedInteger('for_rate')->default(0);
            $table->unsignedInteger('for_leads')->default(0);
            $table->unsignedInteger('for_contacts')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('for_rate');
            $table->dropColumn('for_leads');
            $table->dropColumn('for_contacts');
        });
    }
}
