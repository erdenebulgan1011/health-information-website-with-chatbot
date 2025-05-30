<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhysicalTest extends Controller
{
    //
    public function indexPAR()
    {
        return view('test.phy.parq.index');
    }

    public function submitPAR(Request $request)
    {
        $answers = $request->only([
            'question1', 'question2', 'question3', 
            'question4', 'question5', 'question6', 'question7'
        ]);
        
        $shouldConsultDoctor = in_array('Тийм', $answers);
        
        return redirect()
            ->route('parq.result')
            ->with('shouldConsultDoctor', $shouldConsultDoctor)
            ->with('answers', $answers);
    }

    public function resultPAR()
    {
        if (!session()->has('answers')) {
            return redirect('/');
        }
        
        $shouldConsultDoctor = session('shouldConsultDoctor');
        $answers = session('answers');
        
        return view('test.phy.parq.result', compact('shouldConsultDoctor', 'answers'));
    }
    public function index()
    {
        return view('test.phy.ipaq.index');
    }

    // Хариулт илгээж, үр дүнг харуулах
    // public function submit(Request $request)
    // {
    //     $validated = $request->validate([
    //         'question1' => 'required|string',
    //         'question2' => 'required|string',
    //         'question3' => 'required|string',
    //         'question4' => 'required|string',
    //         'question5' => 'required|string',
    //         'question6' => 'required|string',
    //         'question7' => 'required|string',
    //     ]);

    //     // Өгөгдлийг боловсруулж, дүн гаргах
    //     $total_score = $this->calculateActivityLevel($validated);

    //     // Үр дүнг харах
    //     return view('test.phy.ipaq.result', compact('total_score', 'validated'));
    // }

    // IPAQ score тооцох функц
    public function submit(Request $request)
{
    // Assuming you have the answers from the form submission
    $answers = $request->only([
        'question1', 'question2', 'question3', 'question4', 
        'question5', 'question6', 'question7'
    ]);

    // Calculate activity level
    $activityLevel = $this->calculateActivityLevel($answers);

    // Return the result to the view
    return view('test.phy.ipaq.result', [
        'activityLevel' => $activityLevel, 
        'score' => array_sum(array_map([$this, 'getScoreForAnswer'], $answers))  // Sum of the scores
    ]);
}


private function calculateActivityLevel($answers)
{
    // Тестийн оноог тооцох
    $score = 0;
    
    foreach ($answers as $key => $answer) {
        $score += $this->getScoreForAnswer($answer);
    }

    // Үр дүнгийн түвшинг тодорхойлох
    if ($score < 100) {
        $level = 'Идэвхгүй';
        $alert = 'danger';
        $description = 'Та маш бага идэвхтэй байна. Биеийн хүчний дасгал хийх нь таны эрүүл мэндэд хэрэгтэй. ';
        $description .= 'Иймээс бид танд өдөрт 30 минутаас 1 цагийн турш алхах, сууж байгаа байдал болон хооллолтын зуршлыг хянахыг зөвлөж байна. ';
        $description .= 'Хэрвээ та удаан сууж байгаа бол бага багаар хөдөлгөөн хийх, бичлэг хийх, эсвэл өөртөө дасгалын хуваарь гаргах хэрэгтэй. ';
        $description .= 'Бүх идэвхтэй байдлын түвшинд эмчтэй зөвлөлдөхийг зөвлөж байна.';
    } elseif ($score >= 100 && $score < 200) {
        $level = 'Дунд зэргийн идэвхтэй';
        $alert = 'warning';
        $description = 'Та дунд зэргийн идэвхтэй байна. Энэ нь таны биеийн хөдөлгөөний түвшин харьцангуй сайн байгааг харуулж байна. ';
        $description .= 'Гэхдээ илүү үр дүнтэй байхын тулд тогтмол дасгал хийх хэрэгтэй. ';
        $description .= 'Өдөрт 150 минутын биеийн тамирын дасгал хийхийг хичээгээрэй. ';
        $description .= 'Идэвхтэй байхдаа биеийн хүчний болон аеробик дасгалуудыг хийхийг зөвлөж байна. ';
        $description .= 'Та боломжтой бол дугуй унах, хөнгөхөн гүйлт хийх, эсвэл гэртээ дасгал хийх зэрэг төрлүүдийг оролдож үзнэ үү.';
    } else {
        $level = 'Идэвхтэй';
        $alert = 'success';
        $description = 'Таны физик идэвхтэй байдал өндөр байна. Та тогтмол, идэвхтэй амьдралын хэв маягтай хүн юм. ';
        $description .= 'Таны биеийн тамирын дасгалын хуваарь маш сайн бөгөөд үр дүнтэй байна. ';
        $description .= 'Танд аеробик болон хүчний дасгалын хослолыг хэрэглэхийг зөвлөж байна. ';
        $description .= 'Идэвхтэй байхын тулд дундаж гүйцэтгэлтэй дасгалууд болон биеийн хүчний дасгалуудыг тэнцвэртэй хослуулан хийх нь үр дүнтэй. ';
        $description .= 'Таны эрүүл мэндийн түвшинд ахиц гарч, эдгээр дасгалууд нь таны хөнгөн хөдөлгөөний хандлагыг сайжруулахад тусална.';
    }

    return [
        'level' => $level,
        'alert' => $alert,
        'description' => $description
    ];
}


private function getScoreForAnswer($answer)
{
    switch ($answer) {
        case 'Тийм':
            return 30; // Example: 30 minutes for "Yes"
        case 'Үгүй':
            return 0;
        default:
            return 0;
    }
}

private function getQuestions()
{
    return [
        '1. Та өдөртөө хэрхэн идэвхтэй байна вэ?',
        '2. Та өдөртөө хэр удаан сууж байна вэ?',
        '3. Та өдөрт хэр удаан зугаалга хийдэг вэ?',
        '4. Та ямар төрлийн физик дасгал хийдэг вэ?'
    ];
}




}
