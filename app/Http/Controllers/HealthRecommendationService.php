<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\AiRecommendation;
use Illuminate\Support\Facades\Http;

class HealthRecommendationService
{
    /**
     * Generate comprehensive health recommendations based on user profile
     */
    public function getOrCreateAIInsights(UserProfile $profile): array
    {
        // 1) Try to load the latest saved insights
        $record = AiRecommendation::where('user_profile_id', $profile->id)
                                  ->latest()
                                  ->first();

        // 2) If none exist, call OpenAI and persist
        if (! $record) {
            $aiResult = $this->getAIInsights($profile);

            if (! $aiResult['success']) {
                // Return the error so the controller/view can handle it
                return [
                    'success' => false,
                    'message' => $aiResult['message'],
                ];
            }

            $record = AiRecommendation::create([
                'user_profile_id' => $profile->id,
                'insights'        => $aiResult['insights'],
            ]);
        }

        // 3) Return the existing or newly‑created insights
        return [
            'success'  => true,
            'insights' => $record->insights,
        ];
    }

    /**
     * Generate all sections of recommendations, including AI insights.
     */
    public function generateRecommendations(UserProfile $profile): array
    {
        return [
            'physical_activity' => $this->getPhysicalActivityRecommendations($profile),
            'health_insights'   => $this->getHealthInsights($profile),
            'risk_factors'      => $this->analyzeRiskFactors($profile),
            // swap direct getAIInsights() for getOrCreateAIInsights()
            'ai_insights'       => $this->getOrCreateAIInsights($profile),
        ];
    }


    /**
     * Calculate basic health metrics from profile data
     */
    public function calculateHealthMetrics(UserProfile $profile)
    {
        $metrics = [];

        // Calculate age
        if ($profile->birth_date) {
            $metrics['age'] = Carbon::parse($profile->birth_date)->age;
        }

        // BMI calculation if height and weight are available
        if ($profile->height && $profile->weight) {
            // Height in meters (converting from cm)
            $heightInMeters = $profile->height / 100;
            $metrics['bmi'] = round($profile->weight / ($heightInMeters * $heightInMeters), 1);

            // BMI Classification
            $metrics['bmi_category'] = $this->getBMICategory($metrics['bmi']);
        }

        // Calculate estimated basal metabolic rate (BMR) using Harris-Benedict equation
        if ($profile->height && $profile->weight && $profile->birth_date) {
            $age = Carbon::parse($profile->birth_date)->age;

            if ($profile->gender == 'male') {
                $metrics['bmr'] = 88.362 + (13.397 * $profile->weight) +
                                 (4.799 * $profile->height) - (5.677 * $age);
            } elseif ($profile->gender == 'female') {
                $metrics['bmr'] = 447.593 + (9.247 * $profile->weight) +
                                 (3.098 * $profile->height) - (4.330 * $age);
            }

            if (isset($metrics['bmr'])) {
                $metrics['bmr'] = round($metrics['bmr']);
            }
        }

        return $metrics;
    }

    /**
     * Get personalized physical activity recommendations
     */
    private function getPhysicalActivityRecommendations(UserProfile $profile)
{
    $metrics = $this->calculateHealthMetrics($profile);
    $age = $metrics['age'] ?? null;
    $recommendations = [];

    // Ерөнхий зөвлөмж
    $recommendations[] = "Давтамжтай биеийн хөдөлгөөн таны эрүүл мэндийг сайжруулж, архаг өвчний эрсдэлийг бууруулдаг.";

    // Насны дагуу зөвлөмжүүд
    if ($age !== null) {
        if ($age < 18) {
            $recommendations[] = "Залуу (18-аас доош): өдөр бүр дор хаяж 60 минут дунд зэргийн болон эрч хүчтэй биеийн хөдөлгөөн.";
        } elseif ($age >= 18 && $age < 65) {
            $recommendations[] = "Насанд хүрэгчид: долоо хоногт дор хаяж 150 минут дунд зэргийн эсвэл 75 минут эрч хүчтэй дасгал хийхийг зорь.";
            $recommendations[] = "Долоо хоногт дор хаяж 2 удаа булчинг чангаруулах дасгалуудыг хийнэ үү.";
        } else {
            $recommendations[] = "Ахмад настнууд (65+): тэнцвэрийн дасгал болон булчинг чангаруулах зэрэг олон бүрэлдэхүүн хэсэг бүхий биеийн хөдөлгөөнд анхаар.";
            $recommendations[] = "Дасгалыг өөрийн бэлтгэл, эрүүл мэндийн нөхцөлд тохируулан гүйцэтгэнэ үү.";
        }
    }

    // BMI-ийн дагуу зөвлөмжүүд
    if (isset($metrics['bmi'])) {
        if ($metrics['bmi'] < 18.5) {
            $recommendations[] = "Булчингийн массыг нэмэгдүүлэхийн тулд хүчний дасгалыг туршаад үзнэ үү.";
        } elseif ($metrics['bmi'] >= 25 && $metrics['bmi'] < 30) {
            $recommendations[] = "Жингээ зохицуулахын тулд аэробик дасгал болон хүчний дасгалыг хослуулан хийхийг зөвлөж байна.";
        } elseif ($metrics['bmi'] >= 30) {
            $recommendations[] = "Усан дасгал эсвэл алхалт зэрэг нам нөлөөтэй дасгалаас эхлэж,";
            $recommendations[] = "эрүүл мэнд сайжрахын хирээр дасгалын эрч хүчээ аажмаар нэмэгдүүлнэ үү.";
        }
    }

    // Тамхины хэрэглээний дагуу зөвлөмжүүд
    if ($profile->is_smoker) {
        $recommendations[] = "Тамхи татах нь дасгалын чадварыг бууруулдаг. Тамхинаас гарах хөтөлбөрийг дасгалын ачааллаа аажмаар нэмэгдүүлэхтэй хослуулан үзнэ үү.";
    }

    // Архаг өвчний нөхцөлд
    if ($profile->has_chronic_conditions) {
        $recommendations[] = "Архаг өвчтэй бол шинэ дасгалыг эхлэхээсээ өмнө эрүүл мэндийн мэргэжилтэнтэй зөвлөлдөөрэй.";
        $recommendations[] = "Тодорхой нөхцөлөөс хамааран нам нөлөөтэй дасгал илүү тохиромжтой байж болно.";
    }

    return $recommendations;
}


    /**
     * Get general health insights based on profile
     */
    private function getHealthInsights(UserProfile $profile)
    {
        $metrics = $this->calculateHealthMetrics($profile);
        $insights = [];

        // BMI insights
        if (isset($metrics['bmi'])) {
            $insights[] = "Таны биеийн жингийн индекс (BMI) нь {$metrics['bmi']} бөгөөд ангилал нь '{$metrics['bmi_category']}' байна.";

            if ($metrics['bmi'] < 18.5) {
                $insights[] = "Хэт хөнгөн байх нь хоол тэжээлийн дутагдал эсвэл бусад эрүүл мэндийн асуудлыг илтгэж болно.";
            } elseif ($metrics['bmi'] >= 25 && $metrics['bmi'] < 30) {
                $insights[] = "Илүүдэл жинтэй байх нь зүрхний өвчин, 2-р төрлийн чихрийн шижин зэрэг эрсдлийг нэмэгдүүлнэ.";
            } elseif ($metrics['bmi'] >= 30) {
                $insights[] = "Таргалалт нь зүрх судасны өвчин, чихрийн шижин болон бусад архаг өвчний эрсдлийг ихээр нэмэгдүүлдэг.";
            } else {
                $insights[] = "Таны жин нь хэвийн хүрээнд байгаа тул олон өвчний эрсдлийг бууруулдаг.";
            }
        }

        // Age-related insights
        if (isset($metrics['age'])) {
            if ($metrics['age'] >= 40) {
                $insights[] = "40 наснаас хойш тогтмол эрүүл мэндийн үзлэгийн ач холбогдол нэмэгддэг.";

                if ($metrics['age'] >= 50) {
                    $insights[] = "Шулуун гэдэсний хорт хавдар, зүрх судасны эрүүл мэнд болон ясны нягтыг шалгах үзлэгүүдийг авч үзэхийг зөвлөж байна.";
                }
            }
        }


        // Smoking insights
        if ($profile->is_smoker) {
            $insights[] = "Тамхи татах нь хорт хавдар, зүрхний өвчин, амьсгалын замын асуудал зэрэг олон эрүүл мэндийн эрсдэлийг нэмэгдүүлдэг.";
            $insights[] = "Тамхинаас гарах нь аливаа насанд шууд болон урт хугацааны эрүүл мэндийн ашиг тусаа өгдөг.";
        }

        if ($profile->has_chronic_conditions) {
            $insights[] = "Архаг өвчнүүдийг тогтмол хянах болон зохицуулах нь ерөнхий эрүүл мэндэд чухал.";
            $insights[] = "Эмийн зааврыг баримтлах, амьдралын хэв маягийг өөрчлөх болон эрүүл мэндийн мэргэжилтнүүдтэй тогтмол уулзахыг зөвлөж байна.";
        }


        return $insights;
    }

    /**
     * Analyze risk factors based on profile data
     */
    private function analyzeRiskFactors(UserProfile $profile)
    {
        $metrics = $this->calculateHealthMetrics($profile);
        $riskFactors = [];

    // BMI-тай холбоотой эрсдлүүд
    if (isset($metrics['bmi']) && $metrics['bmi'] >= 30) {
            $riskFactors[] = [
                'factor'     => 'Таргалалт',
                'risk_level' => 'Өндөр',
                'description'=> 'Зүрхний өвчин, чихрийн шижин болон зарим төрлийн хавдрын эрсдэлийг нэмэгдүүлнэ'
            ];
        } elseif (isset($metrics['bmi']) && $metrics['bmi'] >= 25) {
            $riskFactors[] = [
                'factor'     => 'Илүүдэл жин',
                'risk_level' => 'Дунд зэрэг',
                'description'=> 'Зүрх судасны өвчин зэрэг олон эрүүл мэндийн асуудалд нөлөөлж болно'
            ];
        }


        // Тамхины хэрэглэстэй холбоотой эрсдлүүд
    if ($profile->is_smoker) {
        $riskFactors[] = [
            'factor'     => 'Тамхидалт',
            'risk_level' => 'Өндөр',
            'description'=> 'Хавдар, зүрхний өвчин, тархины цус харвалт болон амьсгалын замын асуудлыг ихээр нэмэгдүүлдэг'
        ];
    }

    // Насны дагуух эрсдлүүд
    if (isset($metrics['age']) && $metrics['age'] >= 65) {
        $riskFactors[] = [
            'factor'     => 'Ахмад нас',
            'risk_level' => 'Дунд зэрэг',
            'description'=> 'Архаг өвчнүүд болон оюуны бууралттай холбоотой эрсдэлийг нэмэгдүүлдэг'
        ];
    }

        /// Хүйсийн тусгай эрсдлийн шалгалт
if ($profile->gender == 'male' && isset($metrics['age']) && $metrics['age'] >= 45) {
    $riskFactors[] = [
        'factor'      => '45 ба түүнээс дээш насны эрэгтэй',
        'risk_level'  => 'Дунд зэрэг',
        'description' => 'Залуухан эрэгтэйчүүдтэй харьцуулахад зүрхний өвчний эрсдэл нэмэгддэг'
    ];
} elseif ($profile->gender == 'female' && isset($metrics['age']) && $metrics['age'] >= 55) {
    $riskFactors[] = [
        'factor'      => '55 ба түүнээс дээш насны эмэгтэй',
        'risk_level'  => 'Дунд зэрэг',
        'description' => 'Менопаузын дараах эмэгтэйчүүдэд зүрх- судасны эрсдэл нэмэгддэг'
    ];
}


        return $riskFactors;
    }

    /**
     * Get BMI category based on BMI value
     */
    private function getBMICategory($bmi)
{
    if ($bmi < 18.5) {
        return 'Жин багатай';
    } elseif ($bmi >= 18.5 && $bmi < 25) {
        return 'Хэвийн жин';
    } elseif ($bmi >= 25 && $bmi < 30) {
        return 'Илүүдэл жин';
    } else {
        return 'Таргалалт';
    }
}


Public function getAIInsights(UserProfile $profile)
{
    try {
        // Prepare user profile data for AI analysis
        $userData    = $this->prepareUserDataForAI($profile);
        $healthData  = json_encode($userData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        // Define prompt templates with clear instructions
        $systemPrompt = implode("\n", [
            'Та хэрэглэгчийн профайлын өгөгдөлд тулгуурлан эрүүл мэндийн талаарх хувийн мэдээллийг өгдөг эрүүл мэндийн шинжилгээний туслах юм.',
            'Энэ нь ерөнхий зөвлөгөө бөгөөд эмчийн үнэлгээг орлож болохгүй.',
            'Дараах бүтэцтэйгээр хариулна уу:',
            '"# Хэрэглэгчийн эрүүл мэндийн хувийн мэдээлэл ба зөвлөмж:" гэсний дараа дугаарлагдсан 5-7 зөвлөмж, тус бүр нэг гарчигтай, тайлбар болон зөвлөмжтэй.',
            'Эмнэлгийн түүхэнд дурдагдсан өвчин, эм, эмчилгээтэй холбоотой зөвлөмжийг тусгайлан өгнө үү.'
        ]);

        $userPrompt = "Дараах хэрэглэгчийн эрүүл мэндийн профайл болон эмнэлгийн түүх дээр үндэслэн эрүүл мэндийн хувийн мэдээлэल, зөвлөмжийг өгнө үү:\n"
                      . $healthData;

        // Call OpenAI Chat Completions API
        $response = Http::timeout(30)
            ->withHeaders([
                'Authorization' => 'Bearer ' . config('services.openai.key'),
                'Content-Type'  => 'application/json',
            ])
            ->post('https://api.openai.com/v1/chat/completions', [
                'model'       => config('services.openai.model', 'gpt-4.1-mini'),
                'messages'    => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user'  , 'content' => $userPrompt],
                ],
                'temperature' => 0.3,
                'max_tokens'  => 700,
            ]);

        // Handle errors or empty content
        if (! $response->successful()) {
            $errorData = $response->json();
            Log::error('OpenAI API error', [
                'user_id' => $profile->user_id,
                'status'  => $response->status(),
                'error'   => $errorData,
            ]);

            return [
                'success' => false,
                'message' => 'Хувийн мэдээлэл авахад алдаа гарлаа: '
                           . ($errorData['error']['message'] ?? 'Unknown API error'),
            ];
        }

        $result  = $response->json();
        $content = data_get($result, 'choices.0.message.content');

        if (empty($content)) {
            Log::warning('Empty content received from OpenAI API', [
                'user_id'  => $profile->user_id,
                'response' => $result,
            ]);

            return [
                'success' => false,
                'message' => 'Хувийн мэдээлэл боловсруулахад алдаа гарлаа. Дараа дахин оролдоно уу.',
            ];
        }
        AiRecommendation::create([
            'user_profile_id' => $profile->id,
            'insights'        => $content,
        ]);


        return [
            'success'  => true,
            'insights' => $content,
        ];
    } catch (\Exception $e) {
        Log::error('Exception in getAIInsights', [
            'user_id' => $profile->user_id ?? 'unknown',
            'message' => $e->getMessage(),
            'trace'   => $e->getTraceAsString(),
        ]);

        return [
            'success' => false,
            'message' => 'Системийн алдаа гарлаа: ' . $e->getMessage(),
        ];
    }
}



    /**
     * Prepare user data in a format suitable for AI analysis
     */
    private function prepareUserDataForAI(UserProfile $profile)
    {
        $metrics = $this->calculateHealthMetrics($profile);

        // return [
        //     'age' => $metrics['age'] ?? 'unknown',
        //     'gender' => $profile->gender ?? 'unknown',
        //     'bmi' => $metrics['bmi'] ?? 'unknown',
        //     'bmi_category' => $metrics['bmi_category'] ?? 'unknown',
        //     'is_smoker' => $profile->is_smoker ? 'yes' : 'no',
        //     'has_chronic_conditions' => $profile->has_chronic_conditions ? 'yes' : 'no',
        // ];
         $userData = [
        'basic_info' => [
            'age' => $metrics['age'] ?? 'unknown',
            'gender' => $profile->gender ?? 'unknown',
            'height' => $profile->height ?? 'unknown',
            'weight' => $profile->weight ?? 'unknown',
            'bmi' => $metrics['bmi'] ?? 'unknown',
            'bmi_category' => $metrics['bmi_category'] ?? 'unknown',
            'bmr' => $metrics['bmr'] ?? 'unknown',
        ],
        'lifestyle_factors' => [
            'is_smoker' => $profile->is_smoker ? 'yes' : 'no',
            'has_chronic_conditions' => $profile->has_chronic_conditions ? 'yes' : 'no',
        ],
        'medical_history_details' => !empty($profile->medical_history)
            ? $profile->medical_history
            : 'Эмнэлгийн түүх бичигдээгүй байна',
    ];

    }
    private function formatInsights(string $response): array
{
    // Convert text response to structured data
    return [
        'summary' => Str::before($response, "\n\n"),
        'recommendations' => array_slice(explode("\n- ", $response), 1)
    ];
}

}






//     private function getAIInsights(UserProfile $profile)
// {
//     try {
//         // Шаардлагатай талбаруудыг шалгах
//         if (!$profile->birth_date || !$profile->height || !$profile->weight) {
//             throw new \InvalidArgumentException("Профайлын үндсэн мэдээлэл бүрэн бус байна");
//         }

//         $userData = $this->prepareUserDataForAI($profile);
//         $healthData = json_encode($userData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

//         $response = Http::timeout(25)->withHeaders([
//             'Authorization' => 'Bearer ' . config('services.deepseek.api_key'),
//             'Content-Type' => 'application/json',
//             'Accept-Encoding' => 'gzip'
//         ])->post(config('services.deepseek.endpoint'), [
//             'model' => config('services.deepseek.reasoner_model'),
//             'messages' => [
//                 [
//                     'role' => 'system',
//                     'content' => "Тоон өгөгдөлд тулгуурлан 3 хэсэгт хуваан хариулна уу:
//                     1. Гол асуудлууд (буллит цэг)
//                     2. Эрсдлийн шинжилгээ (шалтгаан-үр дагавар)
//                     3. Бодитой зөвлөмж"
//                 ],
//                 [
//                     'role' => 'user',
//                     'content' => "Дараах өгөгдөлд дүн шинжилгээ хийж, зөвлөмж өгнө үү:\n$healthData"
//                 ]
//             ],
//             'temperature' => 0.4,
//             'max_tokens' => 800
//         ]);

//         // Алдааны нарийвчилсан мэдээлэл
//         if ($response->failed()) {
//             $errorData = $response->json();

//             Log::error('DeepSeek API алдаа', [
//                 'Status код' => $response->status(),
//                 'Хариу' => $errorData,
//                 'Профайл ID' => $profile->id,
//                 'Хүсэлт' => $healthData
//             ]);

//             return [
//                 'success' => false,
//                 'message' => 'Алдааны мэдээлэл: '.($errorData['error']['message'] ?? 'Тодорхойгүй алдаа'),
//                 'error_code' => $response->status()
//             ];
//         }

//         $result = $response->json();

//         if (empty($result['choices'][0]['message']['content'])) {
//             Log::warning('Хоосон хариу', ['Профайл' => $profile->id]);
//             return [
//                 'success' => false,
//                 'message' => 'AI-с хоосон хариу ирлээ'
//             ];
//         }

//         return [
//             'success' => true,
//             'insights' => $this->formatInsights($result['choices'][0]['message']['content'])
//         ];

//     } catch (\Illuminate\Http\Client\ConnectionException $e) {
//         Log::critical('Холболтын алдаа', [
//             'Профайл ID' => $profile->id,
//             'Алдаа' => $e->getMessage()
//         ]);
//         return [
//             'success' => false,
//             'message' => 'API серверт хүрэхгүй байна (таймаут 25 сек)'
//         ];

//     } catch (\InvalidArgumentException $e) {
//         Log::warning('Профайлын алдаа', [
//             'Профайл ID' => $profile->id,
//             'Алдаа' => $e->getMessage()
//         ]);
//         return [
//             'success' => false,
//             'message' => 'Профайлын бүрэн бус мэдээлэл: '.$e->getMessage()
//         ];

//     } catch (\Exception $e) {
//         Log::error('Системийн алдаа', [
//             'Профайл ID' => $profile->id,
//             'Алдаа' => $e->getMessage(),
//             'Stack trace' => $e->getTraceAsString()
//         ]);

//         return [
//             'success' => false,
//             'message' => config('app.debug')
//                 ? 'Системийн алдаа: '.$e->getMessage()
//                 : 'Дотоод алдаа гарлаа. Админтай холбогдно уу'
//         ];
//     }
// }




// private function getAIInsights(UserProfile $profile)
// {
//     try {
//         // Prepare user profile data for AI analysis
//         $userData = $this->prepareUserDataForAI($profile);
//         $healthData = json_encode($userData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

//         // Define prompt templates with clear instructions
//         $systemPrompt = 'Та хэрэглэгчийн профайлын өгөгдөлд тулгуурлан эрүүл мэндийн талаарх хувийн мэдээллийг өгдөг эрүүл мэндийн шинжилгээний туслах юм. ' .
//                          'Энэ нь ерөнхий зөвлөгөө бөгөөд эмчийн үнэлгээг орлож болохгүй. ' .
//                          'Дараах бүтэцтэйгээр хариулна уу: "# Хэрэглэгчийн эрүүл мэндийн хувийн мэдээлэл ба зөвлөмж:" гэсний дараа дугаарлагдсан 5 зөвлөмж, тус бүр нэг гарчигтай, тайлбар болон зөвлөмжтэй.';

//         $userPrompt = "Дараах хэрэглэгчийн эрүүл мэндийн профайл дээр үндэслэн эрүүл мэндийн 5 хувийн мэдээлэл, зөвлөмжийг өгнө үү:\n" . $healthData;

//         // Call DeepSeek API with increased token limit
//         $response = Http::timeout(30)->withHeaders([
//             'Authorization' => 'Bearer ' . config('services.deepseek.api_key'),
//             'Content-Type' => 'application/json',
//         ])->post('https://api.deepseek.com/v1/chat/completions', [
//             'model' => config('services.deepseek.model'),
//             'messages' => [
//                 [
//                     'role' => 'system',
//                     'content' => $systemPrompt
//                 ],
//                 [
//                     'role' => 'user',
//                     'content' => $userPrompt
//                 ]
//             ],
//             'temperature' => 0.3,
//             'max_tokens' => 500, // Increased token limit to ensure complete responses
//         ]);

//         // Process response with better error handling
//         if ($response->successful()) {
//             $result = $response->json();
//             $content = $result['choices'][0]['message']['content'] ?? null;

//             if (!$content) {
//                 \Log::warning('Empty content received from DeepSeek API', [
//                     'user_id' => $profile->user_id,
//                     'response' => $result
//                 ]);
//                 return [
//                     'success' => false,
//                     'message' => 'Хувийн мэдээлэл боловсруулахад алдаа гарлаа. Дараа дахин оролдоно уу.',
//                 ];
//             }

//             return [
//                 'success' => true,
//                 'insights' => $content,
//             ];
//         } else {
//             $errorData = $response->json();
//             \Log::error('DeepSeek API error', [
//                 'user_id' => $profile->user_id,
//                 'status' => $response->status(),
//                 'error' => $errorData
//             ]);

//             return [
//                 'success' => false,
//                 'message' => 'Хувийн мэдээлэл авахад алдаа гарлаа: ' .
//                     ($errorData['error']['message'] ?? 'Unknown API error'),
//             ];
//         }
//     } catch (\Exception $e) {
//         \Log::error('Exception in getAIInsights', [
//             'user_id' => $profile->user_id ?? 'unknown',
//             'message' => $e->getMessage(),
//             'trace' => $e->getTraceAsString()
//         ]);

//         return [
//             'success' => false,
//             'message' => 'Системийн алдаа гарлаа: ' . $e->getMessage(),
//         ];
//     }
// }
