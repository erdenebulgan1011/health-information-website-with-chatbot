<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Recommendation;
use App\Models\Resource;
use App\Models\Response;
use App\Models\TestCategory;
use App\Models\TestSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Carbon\Carbon;


class MentalHealthController extends Controller
{
    public function index()
    {
        $questions = $this->getQuestions();
        return view('test.phq9.index', compact('questions'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'answers' => 'required|array|size:9',
            'answers.*' => 'required|integer|between:0,3',
        ]);

        $score = array_sum($validated['answers']);
        
        return redirect()->route('phq9.result', ['score' => $score]);
    }

    public function result($score)
    {
        $interpretation = $this->getInterpretation($score);
        return view('test.phq9.result', compact('score', 'interpretation'));
    }

    private function getQuestions()
    {
        return [
            1 => 'Аливаа зүйлд сонирхолгүй болох эсвэл дур сонирхол буурах',
            2 => 'Гунигтай, сэтгэлээр унасан эсвэл найдваргүй санагдах',
            3 => 'Унтахад хүндрэлтэй байх, эсвэл хэтэрхий их унтах',
            4 => 'Ядрах эсвэл энерги дутмаг байх',
            5 => 'Хоолны дуршил буурах эсвэл хэт их идэх',
            6 => 'Өөрийгөө муу хүн гэж бодох, эсвэл өөртөө, гэр бүлдээ гологдсон мэт санагдах',
            7 => 'Анхаарлаа төвлөрүүлэхэд хүндрэлтэй байх (жишээ нь сонин унших, зурагт үзэх)',
            8 => 'Хэт удаан хөдөлгөөнтэй байх эсвэл эсрэгээрээ хэт хөдөлгөөнтэй байх',
            9 => 'Үхэхийг хүсэх эсвэл өөртөө гэм хор хүргэх бодол төрөх',
        ];
    }

    private function getInterpretation($score)
    {
        if ($score >= 0 && $score <= 4) {
            return [
                'severity' => 'Байхгүй/бага',
                'treatment' => 'Шаардлагагүй',
                'alert' => 'info'
                        ];
        } elseif ($score >= 5 && $score <= 9) {
            return [
                'severity' => 'Хөнгөн',
                'treatment' => 'Хяналттай байдал; дахин үнэлгээ хийнэ',
                'alert' => 'success'
                        ];
        } elseif ($score >= 10 && $score <= 14) {
            return [
                'severity' => 'Дунд зэрэг',
                'treatment' => 'Эмчилгээний төлөвлөгөө; зөвлөгөө, эмчилгээ, дахин шалгалтыг анхаарах',
                'alert' => 'warning'
                        ];
        } elseif ($score >= 15 && $score <= 19) {
            return [
                'severity' => 'Нэлээд хүнд',
                'treatment' => 'Идэвхтэй эмчилгээ (эмчилгээ болон/эсвэл сэтгэл засал)',
                'alert' => 'danger'
                        ];
        } else {
            return [
                'severity' => 'Хүнд',
                'treatment' => 'Яаралтай эмчилгээ, сэтгэлзүйн мэргэжилтэн рүү илгээх шаардлагатай',
                'alert' => 'danger'
                        ];
        }
    }




    public function indexAudit()
    {
        $questions = $this->getQuestionsAudit();
        return view('test.auditc.index', compact('questions'));
    }

    public function submitAudit(Request $request)
    {
        $validated = $request->validate([
            'answers' => 'required|array|size:3',
            'answers.*' => 'required|integer|between:0,4',
            'gender' => 'required|in:male,female',
        ]);

        $score = array_sum($validated['answers']);
        $gender = $validated['gender'];

        return redirect()->route('auditc.result', [
            'score' => $score,
            'gender' => $gender,
            'question1_score' => $validated['answers'][0]
        ]);
    }

    public function resultAudit(Request $request)
    {
        $score = $request->score;
        $gender = $request->gender;
        $question1_score = $request->question1_score;
        
        $interpretation = $this->getInterpretationAudit($score, $gender, $question1_score);
        
        return view('test.auditc.result', compact('score', 'interpretation', 'gender'));
    }

    private function getQuestionsAudit()
    {
        return [
            1 => [
                'question' => 'Та архи агуулсан ундаа хэр олон уудаг вэ?',
                'options' => [
                    0 => 'Огт уудаггүй',
                    1 => 'Сардаа нэгээс бага',
                    2 => 'Сард 2–4 удаа',
                    3 => 'Долоо хоногт 2–3 удаа',
                    4 => 'Долоо хоногт 4 болон түүнээс олон удаа'
                ]
            ],
            2 => [
                'question' => 'Архи уудаг өдрүүдэд дунджаар хэдэн хундага уудаг вэ?',
                'options' => [
                    0 => '1 эсвэл 2',
                    1 => '3 эсвэл 4',
                    2 => '5 эсвэл 6',
                    3 => '7–9',
                    4 => '10 болон түүнээс дээш'
                ]
            ],
            3 => [
                'question' => 'Нэг удаад зургаан хундага болон түүнээс дээш архи уух нь хэр олон тохиолддог вэ?',
                'options' => [
                    0 => 'Огт үгүй',
                    1 => 'Сараас бага',
                    2 => 'Сардаа нэг удаа',
                    3 => 'Долоо хоног бүр',
                    4 => 'Өдөр бүр эсвэл бараг өдөр бүр'
                ]
            ]
        ];
        
    }

    private function getInterpretationAudit($score, $gender, $question1_score)
    {
        $isAllFromQuestion1 = ($score == $question1_score);
        $isPositive = ($gender == 'male' && $score >= 4) || ($gender == 'female' && $score >= 3);
        
        $result = [
            'score' => $score,
            'isPositive' => $isPositive,
            'threshold' => ($gender == 'male') ? 4 : 3,
            'allFromQuestion1' => $isAllFromQuestion1
        ];
        
        if ($isPositive) {
            $result['status'] = 'Positive';
            $result['alert'] = 'warning';
            
            if ($isAllFromQuestion1) {
                $result['message'] = 'All points are from Question 1. The patient may be drinking below recommended limits. The medical provider should review the patient\'s alcohol intake during the past few months.';
            } else {
                $result['message'] = 'This score is consistent with hazardous drinking or active alcohol use disorders.';
            }
        } else {
            $result['status'] = 'Negative';
            $result['alert'] = 'success';
            $result['message'] = 'This score is consistent with drinking within recommended limits.';
        }
        
        return $result;
    }



    public function indexPTSD()
{
    // Get the list of questions for PTSD
    $questions = $this->getQuestionsPTSD();
    // Return the view with the questions to be displayed
    return view('test.PC-PTSD-5.index', compact('questions'));
}

public function submitPTSD(Request $request)
{
    // Validate the input answers for each question
    $validated = $request->validate([
        'q1' => 'required|boolean',
        'q2' => 'required|boolean',
        'q3' => 'required|boolean',
        'q4' => 'required|boolean',
        'q5' => 'required|boolean',
    ]);

    // Calculate the score by summing the boolean values (true = 1, false = 0)
    $score = array_sum($validated);
    
    // Check if the result is positive (score >= 3)
    $result = $score >= 3;
    
    // Get the interpretation based on score and result
    $interpretation = $this->getInterpretationPTSD($validated, $score, $result);
    
    // Get the list of questions to display in the result view
    $questions = $this->getQuestionsPTSD();

    // Format the questions (only name and question)
    $formattedQuestions = [];
    foreach ($questions as $index => $question) {
        $formattedQuestions[] = [
            'name' => $question['name'],  // The name of the question (q1, q2, etc.)
            'question' => $question['question']  // The text of the question itself
        ];
    }

    // Return the result view with the interpretation and formatted questions
    return view('test.PC-PTSD-5.result', [
        'interpretation' => $interpretation,
        'questions' => $formattedQuestions
    ]);
}

private function getQuestionsPTSD()
{
    // Return the PTSD-related questions in an array format
    return [
        1 => [
            'question' => 'Үйл явдлын талаар хар дарсан зүүд зүүдэлсэн эсвэл хүсээгүй үедээ тэр үйл явдлын талаар бодож байсан уу?',
            'name' => 'q1'
        ],
        2 => [
            'question' => 'Үйл явдал(ууд)-ын талаар бодохгүй байхыг хичээсэн эсвэл танд үйл явдлыг сануулсан нөхцөл байдлаас зайлсхийхийн тулд аргаа барсан уу?',
            'name' => 'q2'
        ],
        3 => [
            'question' => 'Байнга харуулд, сонор сэрэмжтэй байсан уу эсвэл амархан цочирдсон уу?',
            'name' => 'q3'
        ],
        4 => [
            'question' => 'Хүмүүс, үйл ажиллагаа, хүрээлэн буй орчноосоо салж, мэдээ алдав уу?',
            'name' => 'q4'
        ],
        5 => [
            'question' => 'Та өөрийгөө буруутай гэж бодож эсвэл үйл явдал(ууд) эсвэл үйл явдлын учруулсан асуудалд өөрийгөө болон бусдыг буруутгахаа зогсоож чадахгүй байна уу?',
            'name' => 'q5'
        ]
    ];
}

private function getInterpretationPTSD($answers, $score, $isPositive)
{
    // Prepare the result for interpretation
    $result = [
        'score' => $score,
        'isPositive' => $isPositive,
        'threshold' => 3,  // The threshold for a positive result
        'answers' => $answers,
        'positive_answers' => array_filter($answers, function($answer) {
            return $answer == true;  // Count the number of positive (true) answers
        })
    ];
    
    // If the result is positive (score >= 3)
    if ($isPositive) {
        $result['status'] = 'Эерэг';  // Positive status
        $result['alert'] = 'warning';  // Set alert color to yellow (warning)
        $result['message'] = '3 ба түүнээс дээш оноо ('.count($result['positive_answers']).') авсан нь PTSD-ийн шинж тэмдэг илэрч болзошгүйг харуулж байна.';
        $result['recommendation'] = 'Мэргэжлийн тусламж хүсэхийг зөвлөж байна.';
    } else {
        $result['status'] = 'Сөрөг';  // Negative status
        $result['alert'] = 'success';  // Set alert color to green (success)
        $result['message'] = '3-аас бага оноо ('.count($result['positive_answers']).') авсан нь PTSD-ийн шинж тэмдэг илэрээгүйг харуулж байна.';
        $result['recommendation'] = 'Хэрэв танд санаа зовнил байгаа бол мэргэжилтнүүдтэй зөвлөлдөх нь зүйтэй.';
    }
    
    return $result;
}




public function indexGAD7()
{
    $questions = $this->getQuestionsGAD7();
    return view('test.gad7.index', compact('questions'));
}

public function submitGAD7(Request $request)
{
    $validated = $request->validate([
        'answers' => 'required|array|size:7',
        'answers.*' => 'required|integer|between:0,3',
    ]);

    $score = array_sum($validated['answers']);
    
    return redirect()->route('gad7.result', ['score' => $score]);
}

public function resultGAD7($score)
{
    $interpretation = $this->getInterpretationGAD7($score);
    $performanceData = $this->getPerformanceDataGAD7();
    
    return view('test.gad7.result', compact('score', 'interpretation', 'performanceData'));
}

private function getQuestionsGAD7()
{
    return [
        1 => 'Сандарсан, түгшүүртэй эсвэл ирмэг дээр байгаа мэдрэмж',
        2 => 'Санаа зоволтыг зогсоож, хянах чадваргүй байх',
        3 => 'Янз бүрийн зүйлд хэт их санаа зовдог',
        4 => 'Тайвшрахад асуудал гардаг',
        5 => 'Маш тайван бус байх тул зүгээр суух нь хэцүү байдаг',
        6 => 'Амархан уур уцаартай эсвэл уур уцаартай болдог',
        7 => 'Ямар нэг аймшигтай зүйл тохиолдох вий гэсэн айдас',
    ];
}

private function getInterpretationGAD7($score)
{
    if ($score >= 0 && $score <= 4) {
        return [
            'severity' => 'Хамгийн бага түгшүүртэй',
            'description' => 'Та энэ үед ерөнхийдөө бага зэргийн түгшүүрийн шинж тэмдэг илэрч байна.',
            'alert' => 'info'
        ];
    } elseif ($score >= 5 && $score <= 9) {
        return [
            'severity' => 'Бага зэргийн түгшүүр',
            'description' => 'Та энэ үед хөнгөн хэлбэрийн түгшүүрийн шинж тэмдэг илэрч байна.',
            'alert' => 'success'
        ];
    } elseif ($score >= 10 && $score <= 14) {
        return [
            'severity' => 'Дунд зэргийн түгшүүртэй',
            'description' => 'Та энэ үед дунд зэргийн түгшүүрийн шинж тэмдэг илэрч байна. Эмнэлгийн мэргэжилтэнтэй зөвлөлдөхийг зөвлөж байна.',
            'alert' => 'warning'
        ];
    } else {
        return [
            'severity' => 'Хүнд айдас',
            'description' => 'Та энэ үед хүнд хэлбэрийн түгшүүрийн шинж тэмдэг илэрч байна. Эмнэлгийн тусламж авахыг зөвлөж байна.',
            'alert' => 'danger'
        ];
    }
}

private function getPerformanceDataGAD7()
{
    return [
        [
            'condition' => 'Ерөнхий түгшүүрийн эмгэг',
            'sensitivity' => '89%',
            'specificity' => '82%',
            'ratio' => '5.1'
        ],
        [
            'condition' => 'Паник эмгэг',
            'sensitivity' => '74%',
            'specificity' => '81%',
            'ratio' => '3.9'
        ],
        [
            'condition' => 'Нийгмийн түгшүүрийн эмгэг',
            'sensitivity' => '72%',
            'specificity' => '80%',
            'ratio' => '3.6'
        ],
        [
            'condition' => 'Гэмтлийн дараах стрессийн эмгэг',
            'sensitivity' => '66%',
            'specificity' => '81%',
            'ratio' => '3.5'
        ],
        [
            'condition' => 'Аливаа түгшүүрийн эмгэг',
            'sensitivity' => '68%',
            'specificity' => '88%',
            'ratio' => '5.5'
        ]
    ];
}








public function showGad2Test()
{
    // GAD-2 тестийн хуудсыг харуулах
    return view('test.GAD-2.index');
}

public function showCageTest()
{
    // CAGE тестийн хуудсыг харуулах
    return view('test.CAGE.index');
}

public function processGad2Test(Request $request)
{
    // GAD-2 тестийн өгөгдлийг баталгаажуулах
    $validated = $request->validate([
        'gad_1' => 'required|integer|between:0,3',
        'gad_2' => 'required|integer|between:0,3',
    ]);

    // GAD-2 оноог тооцоолох
    $gadScore = $validated['gad_1'] + $validated['gad_2'];
    $gadResult = $gadScore >= 3 ? 'Эмнэлзүйн ач холбогдолтой' : 'Эмнэлзүйн ач холбогдолгүй';

    return view('test.GAD-2.result', [
        'gadScore' => $gadScore,
        'gadResult' => $gadResult,
    ]);
}

public function processCageTest(Request $request)
{
    // CAGE тестийн өгөгдлийг баталгаажуулах
    $validated = $request->validate([
        'cage_1' => 'required|boolean',
        'cage_2' => 'required|boolean',
        'cage_3' => 'required|boolean',
        'cage_4' => 'required|boolean',
    ]);

    // CAGE оноог тооцоолох
    $cageScore = $validated['cage_1'] + $validated['cage_2'] + $validated['cage_3'] + $validated['cage_4'];
    $cageResult = $cageScore >= 2 ? 'Эмнэлзүйн ач холбогдолтой' : 'Эмнэлзүйн ач холбогдолгүй';

    return view('test.CAGE.result', [
        'cageScore' => $cageScore,
        'cageResult' => $cageResult,
    ]);
}
public function indexadhd()
{
    return view('test.adhd-test.index');
}

/**
 * Process the submitted test form.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function submitadhd(Request $request)
{
    // Validate all questions are answered
    $validatedData = $request->validate([
        'q1' => 'required|integer|min:0|max:4',
        'q2' => 'required|integer|min:0|max:4',
        'q3' => 'required|integer|min:0|max:4',
        'q4' => 'required|integer|min:0|max:4',
        'q5' => 'required|integer|min:0|max:4',
        'q6' => 'required|integer|min:0|max:4',
        'q7' => 'required|integer|min:0|max:4',
        'q8' => 'required|integer|min:0|max:4',
        'q9' => 'required|integer|min:0|max:4',
        'q10' => 'required|integer|min:0|max:4',
        'q11' => 'required|integer|min:0|max:4',
        'q12' => 'required|integer|min:0|max:4',
        'q13' => 'required|integer|min:0|max:4',
        'q14' => 'required|integer|min:0|max:4',
        'q15' => 'required|integer|min:0|max:4',
        'q16' => 'required|integer|min:0|max:4',
        'q17' => 'required|integer|min:0|max:4',
        'q18' => 'required|integer|min:0|max:4',
    ]);

    // Calculate scores - convert string values to integers
    // Section A: Questions 1-6 (Inattention/Organization)
    $sectionAScore = 0;
    for ($i = 1; $i <= 6; $i++) {
        $sectionAScore += (int)$request->input('q' . $i);
    }

    // Section B: Questions 7-18 (Hyperactivity/Impulsivity)
    $sectionBScore = 0;
    for ($i = 7; $i <= 18; $i++) {
        $sectionBScore += (int)$request->input('q' . $i);
    }

    // Total score
    $totalScore = $sectionAScore + $sectionBScore;

    // Determine interpretation
    if ($totalScore < 20) {
        $interpretation = "ADHD шинж тэмдэг бага байна";
        $scoreClass = "score-low";
        $explanation = "Таны оноо бага байгаа нь ADHD-тай холбоотой шинж тэмдгүүд танд бага зэрэг илэрч байгааг харуулж байна. Гэхдээ та мэргэжлийн эмнэлгийн ажилтантай ярилцах нь зүйтэй гэж бодвол зөвлөгөө авах хэрэгтэй.";
    } elseif ($totalScore < 40) {
        $interpretation = "ADHD шинж тэмдэг дунд зэрэг байна";
        $scoreClass = "score-medium";
        $explanation = "Таны оноо дунд зэрэг байгаа нь ADHD-тай холбоотой зарим шинж тэмдгүүд танд илэрч байгааг харуулж байна. Эдгээр шинж тэмдгүүд таны өдөр тутмын амьдралд нөлөөлж байгаа бол мэргэжлийн эмнэлгийн ажилтантай ярилцахыг зөвлөж байна.";
    } else {
        $interpretation = "ADHD шинж тэмдэг өндөр байна";
        $scoreClass = "score-high";
        $explanation = "Таны оноо өндөр байгаа нь ADHD-тай холбоотой шинж тэмдгүүд танд илэрч байгааг харуулж байна. Бид танд мэргэжлийн эрүүл мэндийн ажилтнаас үнэлгээ авахыг зөвлөж байна. Зөвхөн мэргэжлийн эмч л ADHD-г оношлох боломжтой.";
    }

    // Debug - optional for troubleshooting
    // dd($sectionAScore, $sectionBScore, $totalScore);

    return view('test.adhd-test.result', [
        'totalScore' => $totalScore,
        'sectionAScore' => $sectionAScore, 
        'sectionBScore' => $sectionBScore,
        'interpretation' => $interpretation,
        'scoreClass' => $scoreClass,
        'explanation' => $explanation
    ]);

}
    public function aboutadhd()
    {
        return view('test.adhd-test.about', [
            'source' => 'World Health Organization Adult ADHD Self-Report Scale (ASRS)',
            'reference' => 'Kessler, R.C., Adler, L., Ames, M., Demler, O., Faraone, S., Hiripi, E., Howes, M.J., Jin, R., Secnik, K., Spencer, T., Ustun, T.B., Walters, E.E. (2005). The World Health Organization Adult ADHD Self-Report Scale (ASRS).',
            'information' => 'Энэхүү тест нь ADHD шинж тэмдгийг илрүүлэх зорилготой скрининг хэрэгсэл юм. Хариултыг "Хэзээ ч" (0 оноо) -оос "Маш олон удаа" (4 оноо) хүртэл 5 түвшинд үнэлдэг. А хэсэг нь анхаарал төвлөрөлт/зохион байгуулалтын асуудлыг хамардаг бол Б хэсэг нь хэт идэвхтэй/түрэмгий шинж чанарыг хамардаг.'
        ]);
    }
    public function indexDASS()
    {
        $questions = $this->getQuestionsDASS();
        return view('test.dass21.index', compact('questions'));
    }

    public function calculateDASS(Request $request)
    {
        $answers = $request->except('_token');
        
        // Define which questions belong to which subscale
        $depression = [3, 5, 10, 13, 16, 17, 21];
        $anxiety = [2, 4, 7, 9, 15, 19, 20];
        $stress = [1, 6, 8, 11, 12, 14, 18];
        
        // Calculate scores
        $depressionScore = 0;
        $anxietyScore = 0;
        $stressScore = 0;
        
        foreach ($answers as $question => $score) {
            $questionNumber = (int)str_replace('q', '', $question);
            
            if (in_array($questionNumber, $depression)) {
                $depressionScore += (int)$score;
            } elseif (in_array($questionNumber, $anxiety)) {
                $anxietyScore += (int)$score;
            } elseif (in_array($questionNumber, $stress)) {
                $stressScore += (int)$score;
            }
        }
        
        // Multiply by 2 as per DASS-21 scoring instructions
        $depressionScore *= 2;
        $anxietyScore *= 2;
        $stressScore *= 2;
        
        // Determine severity levels
        $depressionSeverity = $this->getDepressionSeverityDASS($depressionScore);
        $anxietySeverity = $this->getAnxietySeverityDASS($anxietyScore);
        $stressSeverity = $this->getStressSeverityDASS($stressScore);
        
        return view('test.dass21.result', compact(
            'depressionScore', 
            'anxietyScore', 
            'stressScore',
            'depressionSeverity',
            'anxietySeverity',
            'stressSeverity'
        ));
    }
    
    private function getDepressionSeverityDASS($score)
    {
        if ($score >= 28) return ['level' => 'Маш хүнд', 'class' => 'danger'];
        if ($score >= 21) return ['level' => 'Хүнд', 'class' => 'warning'];
        if ($score >= 14) return ['level' => 'Дунд зэрэг', 'class' => 'info'];
        if ($score >= 10) return ['level' => 'Хөнгөн', 'class' => 'success'];
        return ['level' => 'Хэвийн', 'class' => 'primary'];
    }
    
    private function getAnxietySeverityDASS($score)
    {
        if ($score >= 20) return ['level' => 'Маш хүнд', 'class' => 'danger'];
        if ($score >= 15) return ['level' => 'Хүнд', 'class' => 'warning'];
        if ($score >= 10) return ['level' => 'Дунд зэрэг', 'class' => 'info'];
        if ($score >= 8) return ['level' => 'Хөнгөн', 'class' => 'success'];
        return ['level' => 'Хэвийн', 'class' => 'primary'];
    }
    
    private function getStressSeverityDASS($score)
    {
        if ($score >= 34) return ['level' => 'Маш хүнд', 'class' => 'danger'];
        if ($score >= 26) return ['level' => 'Хүнд', 'class' => 'warning'];
        if ($score >= 19) return ['level' => 'Дунд зэрэг', 'class' => 'info'];
        if ($score >= 15) return ['level' => 'Хөнгөн', 'class' => 'success'];
        return ['level' => 'Хэвийн', 'class' => 'primary'];
    }
    
    private function getQuestionsDASS()
    {
        return [
            1 => 'Би тайвширахад хэцүү байсан',
            2 => 'Би амны хуурайшилтыг мэдэрсэн',
            3 => 'Би ямар ч эерэг мэдрэмжийг мэдрэх боломжгүй мэт санагдсан',
            4 => 'Би амьсгал авахад хүндрэлтэй байсан (жишээ нь, хэт хурдан амьсгалах, бие махбодийн хүчин зүтгэлгүйгээр амьсгаадах)',
            5 => 'Би ямар нэгэн зүйл хийх санаачлагыг гаргахад хэцүү байсан',
            6 => 'Би нөхцөл байдалд хэт их хариу үйлдэл үзүүлэх хандлагатай байсан',
            7 => 'Би чичирч байсан (жишээ нь, гарт)',
            8 => 'Би их мэдрэлийн эрч хүчийг ашиглаж байгаа мэт санагдсан',
            9 => 'Би айж, тэнэг харагдаж болох нөхцөл байдлын талаар санаа зовж байсан',
            10 => 'Надад тэсэн ядан хүлээх зүйл байхгүй мэт санагдсан',
            11 => 'Би өөрийгөө бухимдсан байгааг олж мэдсэн',
            12 => 'Би тайвширахад хэцүү байсан',
            13 => 'Би гуньж, уйтгартай байсан',
            14 => 'Би хийж байсан зүйлээ үргэлжлүүлэхэд саад болох ямар ч зүйлийг тэвчихгүй байсан',
            15 => 'Би тэсэн ядан хүлээхийн хавьд байгаа мэт санагдсан',
            16 => 'Би юуны ч талаар урам зориг авах чадваргүй байсан',
            17 => 'Би хүн шиг үнэ цэнэгүй гэж мэдэрсэн',
            18 => 'Би бага зэрэг мэдрэмтгий байсан гэж бодсон',
            19 => 'Би бие махбодийн хүчин зүтгэлгүйгээр зүрхний цохилтоо мэдэрсэн (жишээлбэл, зүрхний цохилт хурдсах, зүрх цохилохоо больсон мэт санагдах)',
            20 => 'Би шалтгаангүйгээр айж байсан',
            21 => 'Би амьдрал утга учиргүй гэж бодсон',
        ];
    }
    public function indexESS()
    {
        $questions = $this->getQuestionsESS();
        return view('test.ess.index', compact('questions'));
    }

    public function calculateESS(Request $request)
    {
        $answers = $request->except('_token');
        
        // Calculate total score
        $totalScore = 0;
        foreach ($answers as $question => $score) {
            $totalScore += (int)$score;
        }
        
        // Determine severity level
        $severity = $this->getSeverityESS($totalScore);
        
        return view('test.ess.result', compact('totalScore', 'severity', 'answers'));
    }
    
    private function getSeverityESS($score)
    {
        if ($score >= 16) return ['level' => 'Хэт их нойрмоглох', 'class' => 'danger', 'description' => 'Таньд хэт их нойрмоглох байдал байна. Эмнэлгийн тусламж авахыг зөвлөж байна.'];
        if ($score >= 13) return ['level' => 'Дунд зэргийн хэт их нойрмог байдал', 'class' => 'warning', 'description' => 'Таньд дунд зэргийн хэт их нойрмог байдал байна. Эмнэлгийн тусламж авахыг зөвлөж байна.'];
        if ($score >= 11) return ['level' => 'Бага зэргийн хэт их нойрмог байдал', 'class' => 'info', 'description' => 'Таньд бага зэргийн хэт их нойрмог байдал байна. Эмнэлгийн тусламж авахыг зөвлөж байна.'];
        if ($score >= 6) return ['level' => 'Илүү их хэвийн нойрмог байдал', 'class' => 'success', 'description' => 'Таны нойрмог байдал хэвийн хэмжээнд байна.'];
        return ['level' => 'Өдөрт нойрмоглох нь хэвийн хэмжээнээс бага байна', 'class' => 'primary', 'description' => 'Таны нойрмог байдал хэвийн хэмжээнээс бага байна.'];
    }
    
    private function getQuestionsESS()
    {
        return [
            1 => 'Суух, унших',
            2 => 'ТВ үзэж байна',
            3 => 'Олон нийтийн газар (жишээ нь, театр, хурал) идэвхгүй суух',
            4 => 'Нэг цагийн турш завсарлагагүйгээр машинд зорчигчийн хувьд',
            5 => 'Үдээс хойш амрахаар хэвтэж байна',
            6 => 'Хэн нэгэнтэй суугаад ярилцаж байна',
            7 => 'Үдийн хоолны дараа чимээгүй суух (архигүй)',
            8 => 'Машинд, замын хөдөлгөөнд хэдэн минут зогссон',
        ];
    }




}

/**
 * Show information about the ADHD test, its sources and interpretation
 *
 * @return \Illuminate\Http\Response
 */
// public function aboutadhd()
// {
//     return view('adhd-test.about', [
//         'source' => 'World Health Organization Adult ADHD Self-Report Scale (ASRS)',
//         'reference' => 'Kessler, R.C., Adler, L., Ames, M., Demler, O., Faraone, S., Hiripi, E., Howes, M.J., Jin, R., Secnik, K., Spencer, T., Ustun, T.B., Walters, E.E. (2005). The World Health Organization Adult ADHD Self-Report Scale (ASRS).',
//         'information' => 'Энэхүү тест нь ADHD шинж тэмдгийг илрүүлэх зорилготой скрининг хэрэгсэл юм. Хариултыг "Хэзээ ч" (0 оноо) -оос "Маш олон удаа" (4 оноо) хүртэл 5 түвшинд үнэлдэг. А хэсэг нь анхаарал төвлөрөлт/зохион байгуулалтын асуудлыг хамардаг бол Б хэсэг нь хэт идэвхтэй/түрэмгий шинж чанарыг хамардаг.'
//     ]);
// }




    /**
     * Display a listing of available mental health tests
     */
//     public function index()
//     {
//         // Fetch active test categories
//         $categories = TestCategory::where('is_active', true)
//             ->select('id', 'name', 'slug', 'description', 'icon')
//             ->get();
        
//         // Return Inertia view with categories
//         return Inertia::render('MentalHealth/Index', [
//             'categories' => $categories
//         ]);
        
//     }



//     /**
//      * Show the test for a specific category
//      */
//     public function showTest($category)
//     {
//         $category = TestCategory::where('slug', $category)->firstOrFail();
//         $questions = Question::where('test_category_id', $category->id)
//             ->orderBy('weight', 'desc')
//             ->get();
//         return Inertia::render('MentalHealth/Test', [
//             'category' => $category,
//             'questions' => $questions
//         ]);
//     }
    
//     /**
//      * Process test submission and show results
//      */
//     public function processTest(Request $request, $slug)
//     {
//         $category = TestCategory::where('slug', $slug)->firstOrFail();
//         $userId = 1; 

//         // Validate test answers
//         $validator = Validator::make($request->all(), [
//             'answers' => 'required|array',
//             'answers.*' => 'required'
//         ]);
        
//         if ($validator->fails()) {
//             return redirect()->back()
//                 ->withErrors($validator)
//                 ->withInput();
//         }
        
//         // Create test session
//         $session = TestSession::create([
//             'user_id' => $userId,
//             'test_category_id' => $category->id
//         ]);
        
//         $totalScore = 0;
//         $responses = [];
        
//         foreach ($request->answers as $questionId => $answer) {
//             $question = Question::findOrFail($questionId);
//             $score = $this->calculateScore($question, $answer);
//             $totalScore += $score;
            
//             // Save response
//             $response = Response::create([
//                 'test_session_id' => $session->id,  // Use the session ID that was just created

//                 'question_id' => $questionId,
//                 'response_value' => $answer,
//                 'score' => $score
//             ]);
            
//             $responses[] = $response;
//         }
        
//         // Calculate results
//         $results = $this->analyzeResults($category, $totalScore, $responses);
//         // Save results to session
//         $session->update([
//             'completed_at' => now(),
//             'results' => $results
//         ]);
        
//         // Get recommendations based on results
//         $recommendations = $this->getRecommendations($category, $results);
        
//         // Get related resources
//         $resources = $this->getRelatedResources($results);
        
//         return Inertia::render('MentalHealth/Results', [
//             'session' => $session,
//             'results' => $results,
//             'recommendations' => $recommendations,
//             'resources' => $resources,
//             'historyData' => $this->getUserTestHistory($userId, $category->id)
//         ]);
//     }
//  /**
//      * View user's test history
//      */
//     public function testHistory()
//     {
//         $userId = 1; 

//         $sessions = TestSession::with('testCategory')
//             ->where('user_id', $userId  )
//             ->whereNotNull('completed_at')
//             ->orderBy('completed_at', 'desc')
//             ->paginate(10);
            
//         return Inertia::render('MentalHealth/History', [
//             'sessions' => $sessions
//         ]);
//     }
    
//     /**
//      * View specific test results
//      */
//     public function viewResults(TestSession $session)
//     {
//         // Ensure user can only view their own results
//         if ($session->user_id !== "1"      ) {
//             abort(403);
//         }
        
//         $category = $session->testCategory;
//         $results = json_decode($session->results, true);
//         $recommendations = $this->getRecommendations($category, $results);
//         $resources = $this->getRelatedResources($results);
        
//         return Inertia::render('MentalHealth/Results', [
//             'session' => $session,
//             'results' => $results,
//             'recommendations' => $recommendations,
//             'resources' => $resources,
//             'historyData' => $this->getUserTestHistory($session->user_id, $category->id)
//         ]);
//     }
    
//     /**
//      * Calculate score for a question based on answer
//      */
//     private function calculateScore($question, $answer)
//     {
//         // Different scoring logic based on question type
//         switch ($question->question_type) {
//             case 'scale':
//                 return intval($answer);
//             case 'multiple_choice':
//                 $options = json_decode($question->options, true);
//                 foreach ($options as $option) {
//                     if ($option['value'] == $answer) {
//                         return $option['score'];
//                     }
//                 }
//                 return 0;
//             case 'boolean':
//                 return $answer === 'true' ? 1 : 0;
//             default:
//                 return 0;
//         }
//     }
    
//     /**
//      * Analyze test results based on category
//      */
//     private function analyzeResults($category, $totalScore, $responses)
//     {
//         // Analysis logic varies by test category
//         $results = [];
        
//         switch ($category->slug) {
//             case 'stress':
//                 $results = [
//                     'level' => $this->calculateStressLevel($totalScore),
//                     'areas' => $this->identifyProblemAreas($responses),
//                     'total_score' => $totalScore
//                 ];
//                 break;
                
//             case 'depression':
//                 $results = [
//                     'severity' => $this->calculateDepressionSeverity($totalScore),
//                     'risk_factors' => $this->identifyRiskFactors($responses),
//                     'total_score' => $totalScore
//                 ];
//                 break;
                
//             case 'anxiety':
//                 $results = [
//                     'level' => $this->calculateAnxietyLevel($totalScore),
//                     'triggers' => $this->identifyAnxietyTriggers($responses),
//                     'total_score' => $totalScore
//                 ];
//                 break;
                
//             case 'sleep':
//                 $results = [
//                     'quality' => $this->calculateSleepQuality($totalScore),
//                     'issues' => $this->identifySleepIssues($responses),
//                     'total_score' => $totalScore
//                 ];
//                 break;
                
//             default:
//                 $results = [
//                     'score' => $totalScore,
//                     'total_score' => $totalScore
//                 ];
//         }
        
//         return $results;
//     }
    
//     /**
//      * Calculate stress level based on total score
//      */
//     private function calculateStressLevel($totalScore)
//     {
//         if ($totalScore <= 10) {
//             return 'low';
//         } elseif ($totalScore <= 20) {
//             return 'moderate';
//         } elseif ($totalScore <= 30) {
//             return 'high';
//         } else {
//             return 'severe';
//         }
//     }
    
//     /**
//      * Calculate depression severity based on total score
//      */
//     private function calculateDepressionSeverity($totalScore)
//     {
//         if ($totalScore <= 5) {
//             return 'minimal';
//         } elseif ($totalScore <= 10) {
//             return 'mild';
//         } elseif ($totalScore <= 15) {
//             return 'moderate';
//         } elseif ($totalScore <= 20) {
//             return 'moderately_severe';
//         } else {
//             return 'severe';
//         }
//     }
    
//     /**
//      * Calculate anxiety level based on total score
//      */
//     private function calculateAnxietyLevel($totalScore)
//     {
//         if ($totalScore <= 5) {
//             return 'minimal';
//         } elseif ($totalScore <= 10) {
//             return 'mild';
//         } elseif ($totalScore <= 15) {
//             return 'moderate';
//         } else {
//             return 'severe';
//         }
//     }
    
//     /**
//      * Calculate sleep quality based on total score
//      */
//     private function calculateSleepQuality($totalScore)
//     {
//         if ($totalScore <= 5) {
//             return 'good';
//         } elseif ($totalScore <= 10) {
//             return 'fair';
//         } elseif ($totalScore <= 15) {
//             return 'poor';
//         } else {
//             return 'very_poor';
//         }
//     }
    
//     /**
//      * Identify problem areas based on responses
//      */
//     private function identifyProblemAreas($responses)
//     {
//         $areas = [];
//         $workStressScore = 0;
//         $relationshipStressScore = 0;
//         $financialStressScore = 0;
//         $healthStressScore = 0;
        
//         foreach ($responses as $response) {
//             $question = $response->question;
            
//             // Check question tags or content to categorize
//             if (strpos($question->question_text, 'work') !== false || 
//                 strpos($question->question_text, 'job') !== false) {
//                 $workStressScore += $response->score;
//             }
            
//             if (strpos($question->question_text, 'relationship') !== false || 
//                 strpos($question->question_text, 'family') !== false) {
//                 $relationshipStressScore += $response->score;
//             }
            
//             if (strpos($question->question_text, 'money') !== false || 
//                 strpos($question->question_text, 'financial') !== false) {
//                 $financialStressScore += $response->score;
//             }
            
//             if (strpos($question->question_text, 'health') !== false || 
//                 strpos($question->question_text, 'physical') !== false) {
//                 $healthStressScore += $response->score;
//             }
//         }
        
//         // Determine high stress areas
//         if ($workStressScore > 5) {
//             $areas[] = 'work';
//         }
        
//         if ($relationshipStressScore > 5) {
//             $areas[] = 'relationships';
//         }
        
//         if ($financialStressScore > 5) {
//             $areas[] = 'financial';
//         }
        
//         if ($healthStressScore > 5) {
//             $areas[] = 'health';
//         }
        
//         return $areas;
//     }
    
//     /**
//      * Identify risk factors based on depression responses
//      */
//     private function identifyRiskFactors($responses)
//     {
//         $riskFactors = [];
        
//         foreach ($responses as $response) {
//             $question = $response->question;
//             $score = $response->score;
            
//             // Check for suicidal thoughts
//             if (strpos(strtolower($question->question_text), 'suicide') !== false || 
//                 strpos(strtolower($question->question_text), 'harm yourself') !== false) {
//                 if ($score > 0) {
//                     $riskFactors[] = 'suicidal_ideation';
//                 }
//             }
            
//             // Check for appetite changes
//             if (strpos(strtolower($question->question_text), 'appetite') !== false || 
//                 strpos(strtolower($question->question_text), 'eating') !== false) {
//                 if ($score > 1) {
//                     $riskFactors[] = 'appetite_changes';
//                 }
//             }
            
//             // Check for sleep issues
//             if (strpos(strtolower($question->question_text), 'sleep') !== false) {
//                 if ($score > 1) {
//                     $riskFactors[] = 'sleep_disturbance';
//                 }
//             }
            
//             // Check for energy levels
//             if (strpos(strtolower($question->question_text), 'energy') !== false || 
//                 strpos(strtolower($question->question_text), 'tired') !== false) {
//                 if ($score > 1) {
//                     $riskFactors[] = 'fatigue';
//                 }
//             }
//         }
        
//         return $riskFactors;
//     }
    
//     /**
//      * Identify anxiety triggers based on responses
//      */
//     private function identifyAnxietyTriggers($responses)
//     {
//         $triggers = [];
//         $socialScore = 0;
//         $healthScore = 0;
//         $performanceScore = 0;
//         $uncertaintyScore = 0;
        
//         foreach ($responses as $response) {
//             $question = $response->question;
//             $score = $response->score;
            
//             // Social anxiety
//             if (strpos(strtolower($question->question_text), 'social') !== false || 
//                 strpos(strtolower($question->question_text), 'people') !== false) {
//                 $socialScore += $score;
//             }
            
//             // Health anxiety
//             if (strpos(strtolower($question->question_text), 'health') !== false || 
//                 strpos(strtolower($question->question_text), 'illness') !== false) {
//                 $healthScore += $score;
//             }
            
//             // Performance anxiety
//             if (strpos(strtolower($question->question_text), 'perform') !== false || 
//                 strpos(strtolower($question->question_text), 'fail') !== false) {
//                 $performanceScore += $score;
//             }
            
//             // Uncertainty
//             if (strpos(strtolower($question->question_text), 'uncertain') !== false || 
//                 strpos(strtolower($question->question_text), 'future') !== false) {
//                 $uncertaintyScore += $score;
//             }
//         }
        
//         // Determine trigger areas
//         if ($socialScore > 5) {
//             $triggers[] = 'social';
//         }
        
//         if ($healthScore > 5) {
//             $triggers[] = 'health';
//         }
        
//         if ($performanceScore > 5) {
//             $triggers[] = 'performance';
//         }
        
//         if ($uncertaintyScore > 5) {
//             $triggers[] = 'uncertainty';
//         }
        
//         return $triggers;
//     }
    
//     /**
//      * Identify sleep issues based on responses
//      */
//     private function identifySleepIssues($responses)
//     {
//         $issues = [];
        
//         foreach ($responses as $response) {
//             $question = $response->question;
//             $score = $response->score;
            
//             // Falling asleep
//             if (strpos(strtolower($question->question_text), 'fall asleep') !== false) {
//                 if ($score > 1) {
//                     $issues[] = 'falling_asleep';
//                 }
//             }
            
//             // Staying asleep
//             if (strpos(strtolower($question->question_text), 'stay asleep') !== false || 
//                 strpos(strtolower($question->question_text), 'waking up') !== false) {
//                 if ($score > 1) {
//                     $issues[] = 'staying_asleep';
//                 }
//             }
            
//             // Early waking
//             if (strpos(strtolower($question->question_text), 'early') !== false && 
//                 strpos(strtolower($question->question_text), 'wake') !== false) {
//                 if ($score > 1) {
//                     $issues[] = 'early_waking';
//                 }
//             }
            
//             // Sleep quality
//             if (strpos(strtolower($question->question_text), 'quality') !== false || 
//                 strpos(strtolower($question->question_text), 'refreshed') !== false) {
//                 if ($score > 1) {
//                     $issues[] = 'poor_quality';
//                 }
//             }
//         }
        
//         return $issues;
//     }
    
//     /**
//      * Get recommendations based on test results
//      */
//     private function getRecommendations($category, $results)
//     {
//         // Get condition based on test category
//         $condition = '';
        
//         if (isset($results['level'])) {
//             $condition = $results['level'];
//         } elseif (isset($results['severity'])) {
//             $condition = $results['severity'];
//         } elseif (isset($results['quality'])) {
//             $condition = $results['quality'];
//         }
        
//         // Get relevant recommendations based on test results
//         return Recommendation::where('test_category_id', $category->id)
//             ->where('condition', $condition)
//             ->get();
//     }
    
//     /**
//      * Get related resources based on test results
//      */
//     private function getRelatedResources($results)
//     {
//         $tags = [];
        
//         // Add condition as tag
//         if (isset($results['level'])) {
//             $tags[] = $results['level'];
//         } elseif (isset($results['severity'])) {
//             $tags[] = $results['severity'];
//         } elseif (isset($results['quality'])) {
//             $tags[] = $results['quality'];
//         }
        
//         // Add problem areas as tags
//         if (isset($results['areas'])) {
//             $tags = array_merge($tags, $results['areas']);
//         }
        
//         // Add risk factors as tags
//         if (isset($results['risk_factors'])) {
//             $tags = array_merge($tags, $results['risk_factors']);
//         }
        
//         // Add triggers as tags
//         if (isset($results['triggers'])) {
//             $tags = array_merge($tags, $results['triggers']);
//         }
        
//         // Add issues as tags
//         if (isset($results['issues'])) {
//             $tags = array_merge($tags, $results['issues']);
//         }
        
//         // Get resources with matching tags
//         return Resource::where(function ($query) use ($tags) {
//             foreach ($tags as $tag) {
//                 $query->orWhereRaw('JSON_CONTAINS(tags, ?)', ['"' . $tag . '"']);
//             }
//         })
//         ->limit(5)
//         ->get();
//     }
    
//     /**
//      * Get user's previous test results for comparison
//      */
//     private function getUserTestHistory($userId, $categoryId)
//     {
//         // Get user's previous test results for comparison
//         return TestSession::where('user_id', $userId)
//             ->where('test_category_id', $categoryId)
//             ->whereNotNull('completed_at')
//             ->orderBy('completed_at')
//             ->limit(10)
//             ->get()
//             ->map(function($session) {

//                 $completedAt = Carbon::parse($session->completed_at);

//                 $results = is_string($session->results) ? json_decode($session->results, true) : $session->results;

//                 return [

//                     'date' => $completedAt->format('Y-m-d'),  // Now you can call format() on Carbon instance


//                     'score' => $results['total_score'] ?? 0
//                 ];
//             });
//     }
// }