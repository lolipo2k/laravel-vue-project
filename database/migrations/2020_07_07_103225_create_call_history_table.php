<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedBigInteger('related_call_history_id')->nullable();
            $table->foreign('related_call_history_id')->references('id')->on('call_history');
            $table->unsignedBigInteger('project_call_contact_id');
            $table->foreign('project_call_contact_id')->references('id')->on('project_call_contacts');
            $table->text('comment')->nullable();
            $table->timestamp('planned_at')->nullable();
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
        Schema::dropIfExists('call_history');
    }
}
