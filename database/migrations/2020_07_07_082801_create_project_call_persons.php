<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectCallPersons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_call_persons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->unsignedBigInteger('project_call_contact_id');
            $table->foreign('project_call_contact_id', 'project_call_contacts_foreign')->references('id')->on('project_call_contacts');
            $table->unsignedBigInteger('contact_person_id')->nullable();
            $table->foreign('contact_person_id')->references('id')->on('contact_persons');
            $table->string('phone', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('name')->nullable()->index();
            $table->string('position')->nullable()->index();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_call_persons');
    }
}
