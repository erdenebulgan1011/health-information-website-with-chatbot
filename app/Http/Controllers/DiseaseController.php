<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disease;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use Laravel\Pail\ValueObjects\Origin\Console;

class DiseaseController extends Controller {
    public function index(Request $request) {
        $letter = $request->input('letter');
    if ($letter) {
        $diseases = Disease::where('disease_name', 'LIKE', $letter . '%')->get();
    } else {
        $diseases = Disease::all();
    }
    return view('diseases.index', compact('diseases', 'letter'));
    }


    public function show($id) {
        $disease = Disease::findOrFail($id);
        return view('diseases.show', compact('disease'));
    }
    // Common Mongolian-English medical term dictionary
    private $translationDictionary = [
        // Common diseases
        'ханиад' => 'cold',
        'томуу' => 'flu',
        'цочмог' => 'acute',
        'архаг' => 'chronic',
        'халуурах' => 'fever',
        'өвдөлт' => 'pain',
        'хөөх' => 'cough',
        'суулгах' => 'diarrhea',
        'бөөлжих' => 'vomiting',
        'толгой өвдөх' => 'headache',
        'хэвлий өвдөх' => 'abdominal pain',
        'харшил' => 'allergy',
        'цусны даралт' => 'blood pressure',
        'зүрх' => 'heart',
        'уушги' => 'lung',
        'элэг' => 'liver',
        'бөөр' => 'kidney',
        'ходоод' => 'stomach',
        'гэдэс' => 'intestine',
        'тархи' => 'brain',
        'арьс' => 'skin',
        'шээс' => 'urine',
        'цус' => 'blood',
        'сүрьеэ' => 'tuberculosis',
        'чихрийн шижин' => 'diabetes',
        'хавдар' => 'cancer',
        'харшил' => 'allergy',
        'үрэвсэл' => 'inflammation',
        'халдвар' => 'infection',
        'өвчин' => 'disease',
        'эмчилгээ' => 'treatment',
        'эм' => 'medicine',
        'мэс засал' => 'surgery',
        'шинж тэмдэг' => 'symptom',
        'оношилгоо' => 'diagnosis',
        'эмнэлэг' => 'hospital',
        'эмч' => 'doctor',
        'сувилагч' => 'nurse',
        'хамшинж' => 'syndrome'
    ];
    public function search(Request $request)
    {
        // Get the search query from the request
        $search = $request->input('search');

        if (empty($search)) {
            return redirect()->route('diseases.index');
        }

        \Log::info('Original search query: ' . $search);

        // Translate Mongolian query to English using our dictionary-based approach
        $translatedQuery = $this->translateWithDictionary($search);

        // If no direct match found, try the API as fallback
        if ($translatedQuery === $search) {
            $apiTranslation = $this->translateMongolianToEnglish($search);
            if ($apiTranslation) {
                $translatedQuery = $apiTranslation;
            }
        }

        \Log::info('Searching with translated query: ' . $translatedQuery);

        // Search in English database
        $diseases = Disease::query()
        ->where('disease_name', 'LIKE', "%{$translatedQuery}%")
        ->orWhere('common_symptom', 'LIKE', "%{$translatedQuery}%")
        ->orderByRaw(
            "CASE WHEN disease_name LIKE ? THEN 0 ELSE 1 END",
            ["%{$translatedQuery}%"]
        )  // Prioritize name matches
        ->orderBy('disease_name')    // Secondary sort
        ->get();

        \Log::info('Found ' . $diseases->count() . ' results');

        return view('diseases.index', [
            'diseases' => $diseases,
            'search' => $search
        ]);
    }

    /**
     * Translate using our dictionary-based approach
     */
    private function translateWithDictionary($text)
    {
        $text = mb_strtolower(trim($text));

        // Check for exact match
        if (isset($this->translationDictionary[$text])) {
            \Log::info('Dictionary translation found: "' . $text . '" -> "' . $this->translationDictionary[$text] . '"');
            return $this->translationDictionary[$text];
        }

        // Check for partial matches (for multi-word terms)
        foreach ($this->translationDictionary as $mongolian => $english) {
            if (str_contains($text, $mongolian)) {
                \Log::info('Partial dictionary match found: "' . $mongolian . '" in "' . $text . '" -> "' . $english . '"');
                return $english;
            }
        }

        // No match found
        \Log::info('No dictionary match found for: "' . $text . '"');
        return $text;
    }

    /**
     * Translate text from Mongolian to English using ChatGPT API as fallback
     * with improved prompting
     */
    private function translateMongolianToEnglish($text)
    {
        try {
            \Log::info('Attempting API translation for: ' . $text);

            if (empty(env('OPENAI_API_KEY'))) {
                \Log::error('OpenAI API key is not set in .env file');
                return null;
            }

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a specialized medical translator for Mongolian to English. Your task is to translate Mongolian medical terms, disease names, or symptoms to their exact English medical equivalents. For example, "ханиад" translates to "cold" (the illness), "томуу" translates to "flu". Provide ONLY the direct English translation, nothing else. If uncertain, provide the closest medical term.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $text
                    ]
                ],
                'temperature' => 0.1, // Lower temperature for more deterministic responses
                'max_tokens' => 50
            ]);

            if ($response->failed()) {
                \Log::error('API request failed: ' . $response->status() . ' - ' . $response->body());
                return null;
            }

            $data = $response->json();

            if (isset($data['choices'][0]['message']['content'])) {
                $translated = trim($data['choices'][0]['message']['content']);
                \Log::info('API translation: "' . $text . '" -> "' . $translated . '"');
                return $translated;
            } else {
                \Log::error('Unexpected API response format: ' . json_encode($data));
                return null;
            }

        } catch (\Exception $e) {
            \Log::error('Translation error: ' . $e->getMessage());
            return null;
        }
    }






    public function getDiseases(Request $request) {
        if ($request->ajax()) {
            $data = Disease::select(['id', 'disease_name', 'common_symptom', 'treatment']);
            return DataTables::of($data)
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.diseases.edit', $row->id).'" class="btn btn-sm btn-warning">Edit</a>
                        <form action="'.route('admin.diseases.destroy', $row->id).'" method="POST" class="d-inline">
                            '.csrf_field().'
                            '.method_field("DELETE").'
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }



    public function Adminindex() {
        $diseases = Disease::paginate(10);
        return view('diseases.admin.index', compact('diseases'));
    }
    public function create() {
        return view('diseases.admin.create');
    }

    public function store(Request $request) {
        $request->validate([
            'disease_name' => 'required|string|max:255',
            'common_symptom' => 'nullable|string',
            'treatment' => 'nullable|string',
        ]);

        Disease::create($request->all());

        return redirect()->route('admin.diseases.index')->with('success', 'Disease added successfully');
    }

    public function edit($id) {
        $disease = Disease::findOrFail($id);
        return view('admin.diseases.edit', compact('disease'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'disease_name' => 'required|string|max:255',
            'common_symptom' => 'nullable|string',
            'treatment' => 'nullable|string',
        ]);

        $disease = Disease::findOrFail($id);
        $disease->update($request->all());

        return redirect()->route('admin.diseases.index')->with('success', 'Disease updated successfully');
    }

    public function destroy($id) {
        $disease = Disease::findOrFail($id);
        $disease->delete();

        return redirect()->route('admin.diseases.index')->with('success', 'Disease deleted successfully');
    }

}
