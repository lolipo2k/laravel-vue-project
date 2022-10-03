<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionCategoriesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        $categories = [
            'Авто и запчасти',
            'Продукты питания и алкоголь',
            'Мебель, сантехника и бытовая техника',
            'ГСМ, нефть, бензин',
            'Компьютерная и цифровая техника, ПО',
            'Медицина и фармацевтика',
            'Строительные материалы, оборудование, ЖБИ, металлопрокат',
            'Оборудование для промышленности',
            'Оптовая торговля',
            'Сельское хозяйство',
            'Сертификация',
            'Системы безопасности',
            'Текстиль, Одежда, Обувь',
            'Телекоммуникации и интернет',
            'Товары для бизнеса',
            'Услуги для бизнеса',
            'Торговый представитель',
            'Услуги для населения',
            'Финансовые услуги',
            'Франчайзинг',
            'Ювелирные изделия',
            'Товары народного потребления',
        ];

        foreach ($categories as $category) {
            \App\Models\Taxonomy\FieldsCategory::create([
                'name' => $category
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('field_categories');
    }
}
