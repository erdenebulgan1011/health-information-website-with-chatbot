<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

use Carbon\Carbon;


class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $events = [
            [
                'title' => 'Зүрхний өвчний урьдчилан сэргийлэх сургалт',
                'description' => 'Зүрхний өвчнөөс урьдчилан сэргийлэх, эрсдэлийг бууруулах талаар мэргэжилтнүүдийн зөвлөгөө.',
                'start_time' => Carbon::now()->addDays(5)->setHour(10)->setMinute(0),
                'end_time' => Carbon::now()->addDays(5)->setHour(12)->setMinute(0),
                'location' => 'Улаанбаатар, Эрүүл мэндийн төв',
                'url' => 'https://healthinfo.mn/heart-seminar',
            ],
            [
                'title' => 'Хүүхдийн эрүүл мэндийн өдөрлөг',
                'description' => 'Хүүхдийн эрүүл мэндийн талаар мэдээлэл, үнэгүй үзлэг, зөвлөгөө.',
                'start_time' => Carbon::now()->addDays(10)->setHour(9)->setMinute(0),
                'end_time' => Carbon::now()->addDays(10)->setHour(17)->setMinute(0),
                'location' => 'Улаанбаатар, Хүүхдийн төв эмнэлэг',
                'url' => 'https://healthinfo.mn/children-health-day',
            ],
            [
                'title' => 'Цусны даралт хэмжих өдөр',
                'description' => 'Иргэдэд үнэ төлбөргүй цусны даралт хэмжих, зөвлөгөө өгөх өдөр.',
                'start_time' => Carbon::now()->addDays(3)->setHour(9)->setMinute(0),
                'end_time' => Carbon::now()->addDays(3)->setHour(18)->setMinute(0),
                'location' => 'Улаанбаатар, Баянзүрх дүүргийн эмнэлэг',
                'url' => 'https://healthinfo.mn/blood-pressure-day',
            ],
            [
                'title' => 'Чихрийн шижингийн талаарх онлайн хэлэлцүүлэг',
                'description' => 'Чихрийн шижингийн эрт илрүүлэлт, оношлогоо, эмчилгээний талаар онлайн хэлэлцүүлэг.',
                'start_time' => Carbon::now()->addDays(15)->setHour(19)->setMinute(0),
                'end_time' => Carbon::now()->addDays(15)->setHour(20)->setMinute(30),
                'location' => 'Онлайн - Zoom',
                'url' => 'https://healthinfo.mn/diabetes-online-discussion',
            ],
            [
                'title' => 'Дархлаа дэмжих зөвлөгөө',
                'description' => 'Өвлийн улиралд дархлаагаа хэрхэн дэмжих талаар эмч нарын зөвлөгөө.',
                'start_time' => Carbon::now()->addDays(7)->setHour(14)->setMinute(0),
                'end_time' => Carbon::now()->addDays(7)->setHour(16)->setMinute(0),
                'location' => 'Улаанбаатар, Сүхбаатар дүүргийн Соёлын төв',
                'url' => 'https://healthinfo.mn/immunity-support',
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }

}
