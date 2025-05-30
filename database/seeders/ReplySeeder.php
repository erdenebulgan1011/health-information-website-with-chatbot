<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\Reply;
use App\Models\Like;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;


class ReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $replies = [
            // Replies for Topic 1 - Цусны даралт өндөр байгаа үед юу хийх вэ?
            [
                'topic_index' => 0,
                'content' => 'Цусны даралт өндөр үед дараах зүйлсийг хийхийг зөвлөж байна: 1. Давсны хэрэглээгээ бууруулах 2. Тогтмол дасгал хөдөлгөөн хийх 3. Стрессээ бууруулах 4. Тамхи татахгүй байх 5. Архи хэрэглэхгүй байх. Мөн яаралтай эмчид үзүүлэх хэрэгтэй шүү.',
                'is_best_answer' => true,
                'is_doctor' => true,
            ],
            [
                'topic_index' => 0,
                'content' => 'Миний ээж цусны даралт өндөртэй. Тэр саримсаг идэх, лимон усаар зайлах, өдөр бүр алхах зэргээр даралтаа тогтмол барьж чаддаг болсон.',
                'is_best_answer' => false,
                'is_doctor' => false,
            ],
            [
                'topic_index' => 0,
                'content' => 'Таны бичсэн даралтын хэмжээ хэт өндөр байна. Яаралтай эмчид үзүүлэх хэрэгтэй. Тэр хүртэл амарч, стрессгүй байхыг хичээгээрэй.',
                'is_best_answer' => false,
                'is_doctor' => false,
            ],

            // Replies for Topic 2 - Хоолны дараа ходоод өвддөг шалтгаан
            [
                'topic_index' => 1,
                'content' => 'Хоолны дараа ходоод өвдөх нь ходоодны шүүс ихэссэн, ходоодны шархлаа, дээрх булчирхайн үрэвсэл, цөсний чулуу зэрэг олон шалтгаантай байж болно. Та хоолоо удаан зажилж идэх, өөхтэй, хүнд хоол бага идэх, кофе, халуун ногоо зэргээс зайлсхийх хэрэгтэй. Мөн эмчид үзүүлэхийг зөвлөж байна.',
                'is_best_answer' => true,
                'is_doctor' => true,
            ],
            [
                'topic_index' => 1,
                'content' => 'Би ч гэсэн ийм асуудалтай байсан. Гантигийн уусмал (магний) ууж үзээрэй. Надад их сайн тусалсан. Мөн хоол идсэний дараа 30 минут алхах нь ходоод хоол боловсруулахад тусалдаг.',
                'is_best_answer' => false,
                'is_doctor' => false,
            ],

            // Replies for Topic 3 - Чихрийн шижинтэй хүн ямар жимс идэж болох вэ?
            [
                'topic_index' => 2,
                'content' => 'Чихрийн шижинтэй хүмүүс глюкозын индекс багатай жимс хэрэглэх хэрэгтэй. Үүнд: алим, гадил, чавга, гүзээлзгэнэ зэрэг орно. Усан үзэм, тарвас зэрэг чихэрлэг жимснээс зайлсхийх хэрэгтэй. Мөн жимсийг хэмжээтэй идэх нь чухал.',
                'is_best_answer' => true,
                'is_doctor' => true,
            ],
            [
                'topic_index' => 2,
                'content' => 'Миний эмээ чихрийн шижинтэй. Тэр өдөрт нэг жижиг алим идэх нь түүний цусан дахь сахарын хэмжээг тогтмол байлгахад тусалдаг. Мөн жимсийг цэвэрээр нь идэхээс илүү ногоотой хольж идэх нь цусны сахарыг бага зэрэг нэмэгдүүлдэг гэж эмч хэлсэн.',
                'is_best_answer' => false,
                'is_doctor' => false,
            ],
            [
                'topic_index' => 2,
                'content' => 'Та эмчийн зөвлөгөө авах хэрэгтэй. Хүн бүрийн биеийн онцлог өөр өөр байдаг. Мөн хоолны дараа цусны сахарын түвшинг хэмжиж, ямар жимс хэрхэн нөлөөлж байгааг хянах нь чухал.',
                'is_best_answer' => false,
                'is_doctor' => false,
            ],

            // Additional replies
            [
                'topic_index' => 3,
                'content' => 'Дасгал хийх үед ус уух нь маш чухал. Дасгалын өмнө 400-500 мл, дасгалын үеэр 30 минут тутамд 200-300 мл, дасгалын дараа алдсан шингэнээ нөхөхийн тулд 500-600 мл ус уух хэрэгтэй. Гэхдээ нэг дор их хэмжээний ус уухгүй байх хэрэгтэй.',
                'is_best_answer' => true,
                'is_doctor' => true,
            ],
            [
                'topic_index' => 4,
                'content' => 'D витамин авах хамгийн сайн арга бол нарны гэрэлд өдөрт 15-20 минут байх явдал юм. Мөн өөхөн загасанд D витамин их агуулагддаг. Мөн өндөг, сүү, тараг, интоор зэрэг хүнсэнд D витамин агуулагддаг. Гэхдээ эмчийн бичсэн нэмэлт бүтээгдэхүүнийг хэрэглэх нь хамгийн найдвартай арга юм.',
                'is_best_answer' => true,
                'is_doctor' => false,
            ],
            [
                'topic_index' => 5,
                'content' => 'Стрессийг бууруулах хэд хэдэн үр дүнтэй арга байдаг: 1. Гүн амьсгалын дасгал хийх 2. Биеийн тамирын дасгал хийх 3. Хангалттай унтах 4. Бүтээлч зүйл хийх 5. Найз нөхөд, гэр бүлтэйгээ цагийг өнгөрөөх. Мөн сэтгэл зүйчид хандах нь маш үр дүнтэй.',
                'is_best_answer' => false,
                'is_doctor' => false,
            ],
        ];

        $users = User::all();
        $topics = Topic::all();

        foreach ($replies as $reply) {
            $userId = $users->random()->id;

            // If marked as doctor's reply, use one of the doctor users
            if (isset($reply['is_doctor']) && $reply['is_doctor']) {
                $doctorUsers = User::where('email', 'like', 'doctor%@healthinfo.com')->get();
                if ($doctorUsers->count() > 0) {
                    $userId = $doctorUsers->random()->id;
                }
            }

            $topicId = $topics[$reply['topic_index']]->id;

            Reply::create([
                'content' => $reply['content'],
                'user_id' => $userId,
                'topic_id' => $topicId,
                'parent_id' => null,
                'is_best_answer' => $reply['is_best_answer'] ?? false,
                'created_at' => Carbon::now()->subDays(rand(0, 29))->subHours(rand(1, 23)),
            ]);
        }

        // Create some nested replies (comments to replies)
        $primaryReplies = Reply::where('parent_id', null)->get();

        foreach ($primaryReplies->random(5) as $parentReply) {
            $nestedRepliesCount = rand(1, 3);

            for ($i = 0; $i < $nestedRepliesCount; $i++) {
                Reply::create([
                    'content' => $this->getRandomNestedReplyContent(),
                    'user_id' => $users->random()->id,
                    'topic_id' => $parentReply->topic_id,
                    'parent_id' => $parentReply->id,
                    'is_best_answer' => false,
                    'created_at' => Carbon::parse($parentReply->created_at)->addHours(rand(1, 48)),
                ]);
            }
        }
    }

    /**
     * Get random content for nested replies.
     *
     * @return string
     */
    private function getRandomNestedReplyContent()
    {
        $contents = [
            'Маш их баярлалаа! Танд асуух зүйл байна, та надад илүү дэлгэрэнгүй тайлбарлаж өгөх боломжтой юу?',
            'Би танай зөвлөгөөг дагаж үзсэн. Үнэхээр их тусалсан. Баярлалаа!',
            'Энэ тал дээр санал нийлэхгүй байна. Би өөр туршлагатай. Миний хувьд тэгж туршаад үр дүнгүй байсан.',
            'Таны хэлсэн аргыг туршиж үзээд эргэж мэдээлье. Санал болгосонд баярлалаа.',
            'Таны хариулт их сонирхолтой байна. Та энэ талаар нэмэлт материал уншиж байсан уу?',
            'Би мөн адил асуудалтай тулгарч байсан. Таны хэлсэн зүйл их тустай байна.',
            'Эмчид үзүүлсэн үү? Тийм бол ямар эмчилгээ хийлгэсэн бэ?',
            'Хэдий хугацаанд энэ арга үр дүнгээ өгсөн бэ? Би удаан хугацаанд хийж байна.',
            'Баярлалаа, гэхдээ энэ эмчилгээ хүүхдэд тохиромжтой юу?',
            'Та ямар бүтээгдэхүүн хэрэглэдэг вэ? Тодорхой брэнд санал болгох уу?',
        ];

        return $contents[array_rand($contents)];
    }
}
