<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TopicsTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('topics')->insert([
            [
                'title' => 'Зүрх судасны өвчний урьдчилан сэргийлэлт',
                'slug' => Str::slug('Зүрх судасны өвчний урьдчилан сэргийлэлт'),
                'content' => 'Зүрх судасны өвчнөөс хэрхэн сэргийлэх талаархи зөвлөмжүүд.',
                'user_id' => 1,
                'category_id' => 1,
                'views' => 0,
                'is_pinned' => false,
                'is_locked' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Чихрийн шижинтэй амьдрах зөвлөмж',
                'slug' => Str::slug('Чихрийн шижинтэй амьдрах зөвлөмж'),
                'content' => 'Чихрийн шижинтэй хүмүүсийн өдөр тутмын амьдралын зөвлөмжүүд.',
                'user_id' => 1,
                'category_id' => 2,
                'views' => 0,
                'is_pinned' => false,
                'is_locked' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Дархлааг дэмжих хоол хүнс',
                'slug' => Str::slug('Дархлааг дэмжих хоол хүнс'),
                'content' => 'Дархлааг сайжруулахад тустай хоол хүнсний жагсаалт.',
                'user_id' => 1,
                'category_id' => 3,
                'views' => 0,
                'is_pinned' => true,
                'is_locked' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
