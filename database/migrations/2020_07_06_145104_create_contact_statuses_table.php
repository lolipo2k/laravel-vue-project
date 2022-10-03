<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        $statuses = [
            "Недозвон",
            "Не пройден секретарь",
            "Отказ от общения",
            "Дорого",
            "Нет потребности",
            "Не ЦА",
            "Лид",
            "Горячий перезвон",
        ];

        foreach ($statuses as $status) {
            \App\Models\Projects\ContactStatus::insert(['name' => $status]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_statuses');
    }
}
