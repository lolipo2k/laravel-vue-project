<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPriceToFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fields', function (Blueprint $table) {
            $table->double('price')->default(0);
        });

        $fields = [
            "Автоматизированные сервисы", "400",
            "Топливо/нефтепродукты", "3600",
            "Автошколы", "2400",
            "Продажа авто и комплектующих", "2400",
            "Прокат авто", "2400",
            "Автоломбарды", "3600",
            "Автосервисы и мойки", "2400",
            "Аутсорсинг и аутстафинг персонала", "3600",
            "Банки/финансовые организации", "3600",
            "Бухгалтерские/финансовые/юридические/аудиторские услуги", "3600",
            "БЦ/ТЦ/коворкинги", "2400",
            "Гостиницы/пансионаты/санатории/хостелы/аренда апартаментов и квартир", "2400",
            "Доставка и продажа готовой еды", "2400",
            "Продажа цветов", "2400",
            "Стройматериалы", "2400",
            "Одежда и обувь", "2400",
            "Товары для детей", "2400",
            "Детские сады/школы/центры развития", "2400",
            "Медицинские центры", "2400",
            "Дезинфекция помещений", "3600",
            "Ж/Б и металлоконструкции", "2400",
            "Ворота и ограждения", "2400",
            "Кровельные и фасадные конструкции", "2400",
            "Застройщики", "3600",
            "Строительные работы", "2400",
            "Товары для животных", "2400",
            "Сельскохозяйственные товары", "2400",
            "Интернет/телевидение/сотовая связь", "2400",
            "Програмное обеспечение", "3600",
            "Интернет-реклама", "3600",
            "Информационные порталы и СМИ", "2400",
            "Исследования и консалтинг", "3600",
            "Кадровые агенства", "3600",
            "Канцелярские принадлежности", "2400",
            "Кафе/рестораны/кейтеринг", "2400",
            "Клининг", "2400",
            "Косметика/парфюмерия/бытовая химия", "2400",
            "Курьерские службы и транспортные компании", "2400",
            "Ландшафтная архитектура/благоустройство территории", "2400",
            "Мебель/сантехника и комплектующие", "2400",
            "Мед. техника/медецинские товары", "2400",
            "Продажа недвижимости", "3600",
            "Наружная реклама", "2400",
            "Торгово-выставочное/сенсорное оборудование", "2400",
            "Оборудование для промышленности", "3600",
            "Строительные инструменты", "2400",
            "Организация мероприятий", "2400",
            "Освещение и электротовары", "2400",
            "Охранные системы и системы безопасности", "2400",
            "Охранные предприятия", "2400",
            "Пищевая промышленность", "3600",
            "Полиграфические услуги/широкоформатная печать", "2400",
            "Продажа продуктов питания", "2400",
            "Проектирование/дизайн интерьеров", "2400",
            "Производство пластика и изделий из пластика", "3600",
            "Производство бумаги", "3600",
            "Производства и продажа упаковки", "3600",
            "Переработка мусора и ТБО", "3600",
            "Расходные материалы для салонов красоты", "2400",
            "Рекламные агенства полного цикла", "3600",
            "Салоны красоты", "2400",
            "Склады и складское оборудование", "3600",
            "Продажа и аренда спец.техники", "3600",
            "Спортивные залы/секции/фитнес", "2400",
            "Стандартизация и сертификация", "3600",
            "Страхование", "2400",
            "Сувениры и подарки", "2400",
            "Табачная и алкогольная продукция", "3600",
            "Ткани и текстиль", "2400",
            "Туристические агенства/туроператоры", "2400",
            "Управляющие компании", "3600",
            "Услуги перевода", "2400",
            "Системное администрирование", "2400",
            "Фото/видео съемка", "2400",
            "Обучение", "2400",
            "Ювелирные изделия и часы", "2400",
            "Яхты/продажа и обслуживание", "3600",
            "Доставка воды/фильтры для воды", "2400",
        ];

        foreach ($fields as $idx => $field) {
            if (!is_numeric($field)) {
                \App\Models\Taxonomy\Field::insert([
                    'name' => $field,
                    'price' => $fields[$idx + 1]
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fields', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
}