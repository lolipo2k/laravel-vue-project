<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_experience', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });

        $experience = [
            ['name' => 'продажи',],
            ['name' => 'входящие звонки',],
            ['name' => 'исходящие звонки',],
            ['name' => 'холодные звонки',],
            ['name' => 'работа с физ. лицами',],
            ['name' => 'работа с юр. лицами',],
        ];

        foreach ($experience as $exp) {
            $wx = new \App\Models\Taxonomy\WorkExperience;
            $wx->name = $exp['name'];
            $wx->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_experience');
    }
}
