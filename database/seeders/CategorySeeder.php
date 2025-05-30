<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    DB::table('categories')->insert([
        ['name' => 'Нүд', 'slug' => 'eye', 'description' => 'Нүдний эрүүл мэнд', 'icon' => '👁️'],
        ['name' => 'Зүрх', 'slug' => 'heart', 'description' => 'Зүрх судасны эмгэг', 'icon' => '❤️'],
        ['name' => 'Зүрх судасны систем', 'slug' => 'heart-system', 'description' => 'Зүрх судасны өвчин эмгэгүүд', 'icon' => '🫀'],
        ['name' => 'Мэдрэлийн систем', 'slug' => 'nervous', 'description' => 'Мэдрэлийн системийн эмгэгүүд', 'icon' => '🧠'],
        ['name' => 'Яс булчингийн систем', 'slug' => 'skeletal', 'description' => 'Яс, үе мөч, булчингийн эмгэгүүд', 'icon' => '🦴'],
        ['name' => 'Амьсгалын систем', 'slug' => 'respiratory', 'description' => 'Уушги, амьсгалын замын өвчнүүд', 'icon' => '🫁'],
        ['name' => 'Эрүүл хооллолт', 'slug' => 'nutrition', 'description' => 'Зөв хооллолт, хоол тэжээлийн зөвлөгөө', 'icon' => '🥗'],
        ['name' => 'Дасгал хөдөлгөөн', 'slug' => 'exercise', 'description' => 'Биеийн тамир, дасгал хөдөлгөөний зөвлөмж', 'icon' => '🏃'],
        ['name' => 'Стресс, сэтгэцийн эрүүл мэнд', 'slug' => 'mental-health', 'description' => 'Сэтгэцийн эрүүл мэндийг дэмжих зөвлөгөө', 'icon' => '🧘'],
        ['name' => 'Халдварт өвчнөөс урьдчилан сэргийлэх', 'slug' => 'infectious-disease-prevention', 'description' => 'Халдварт өвчнөөс сэргийлэх арга замууд', 'icon' => '🦠'],
        ['name' => 'Архаг өвчний менежмент', 'slug' => 'chronic-disease-management', 'description' => 'Архаг өвчинтэй амьдрах зөвлөмж', 'icon' => '⚕️'],
        ['name' => 'Эх, хүүхдийн эрүүл мэнд', 'slug' => 'maternal-child-health', 'description' => 'Жирэмсэн эхчүүд болон хүүхдийн эрүүл мэнд', 'icon' => '👶'],
        ['name' => 'Хоол боловсруулах систем', 'slug' => 'digestive', 'description' => 'Ходоод гэдэсний замын өвчнүүд', 'icon' => '�胃'],
        ['name' => 'Шээс бэлгийн систем', 'slug' => 'urogenital', 'description' => 'Бөөр, давсаг, бэлгийн эрхтний эрүүл мэнд', 'icon' => '🫘'],
        ['name' => 'Дотоод шүүрлийн систем', 'slug' => 'endocrine', 'description' => 'Дотоод шүүрлийн булчирхай, даавар, чихрийн шижин', 'icon' => '🦲'],
        ['name' => 'Арьс', 'slug' => 'skin', 'description' => 'Арьсны эрүүл мэнд ба өвчин', 'icon' => '🧴'],
        ['name' => 'Дархлааны систем', 'slug' => 'immune', 'description' => 'Дархлааны систем, харшил, аутоиммун өвчнүүд', 'icon' => '🛡️'],
        ['name' => 'Настны эрүүл мэнд', 'slug' => 'elderly-health', 'description' => 'Өндөр настны эрүүл мэндийн асуудлууд', 'icon' => '👵'],
        ['name' => 'Өсвөр насныхны эрүүл мэнд', 'slug' => 'adolescent-health', 'description' => 'Өсвөр насны хүүхдүүдийн эрүүл мэнд', 'icon' => '🧑'],
        ['name' => 'Эрэгтэйчүүдийн эрүүл мэнд', 'slug' => 'mens-health', 'description' => 'Эрэгтэйчүүдэд тохиолддог эрүүл мэндийн асуудлууд', 'icon' => '♂️'],
        ['name' => 'Эмэгтэйчүүдийн эрүүл мэнд', 'slug' => 'womens-health', 'description' => 'Эмэгтэйчүүдэд тохиолддог эрүүл мэндийн асуудлууд', 'icon' => '♀️'],
        ['name' => 'Унтаарын эмгэг', 'slug' => 'sleep-disorders', 'description' => 'Нойр, унтааны эмгэгүүд', 'icon' => '😴'],
        ['name' => 'Хорт зуршил', 'slug' => 'addiction', 'description' => 'Тамхи, архи, мансууруулах бодис, донтолт', 'icon' => '🚭'],
        ['name' => 'Хөгжлийн бэрхшээл', 'slug' => 'disability', 'description' => 'Хөгжлийн бэрхшээлтэй хүмүүсийн эрүүл мэнд', 'icon' => '♿'],
        ['name' => 'Гэр бүлийн эрүүл мэнд', 'slug' => 'family-health', 'description' => 'Гэр бүлийн эрүүл мэндийн асуудлууд', 'icon' => '👪'],
        ['name' => 'Эмийн зөв хэрэглээ', 'slug' => 'medication-use', 'description' => 'Эмийн зөв хэрэглээний талаарх мэдээлэл', 'icon' => '💊'],
        ['name' => 'Вакцин, дархлаажуулалт', 'slug' => 'vaccination', 'description' => 'Вакцин, дархлаажуулалтын талаарх мэдээлэл', 'icon' => '💉'],
        ['name' => 'Анхны тусламж', 'slug' => 'first-aid', 'description' => 'Яаралтай үед үзүүлэх анхны тусламж', 'icon' => '🩹'],
        ['name' => 'Уламжлалт анагаах ухаан', 'slug' => 'traditional-medicine', 'description' => 'Монгол уламжлалт анагаах ухаан', 'icon' => '🌿'],
    ]);
}


}
