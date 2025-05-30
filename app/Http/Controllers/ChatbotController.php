<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function processMessage(Request $request)
{
    $request->validate([
        'messages' => 'required|array',
    ]);

    try {
        // Extract and preserve the system message
        $messages = $request->input('messages');
        $systemMessage = null;
        foreach ($messages as $key => $msg) {
            if ($msg['role'] === 'system') {
                $systemMessage = $msg;
                unset($messages[$key]);
                break;
            }
        }

        // Get only the last 4 user/assistant messages
        $recent = array_slice(array_values($messages), -4);

        // Re‑insert system message if present
        if ($systemMessage) {
            array_unshift($recent, $systemMessage);
        }

        // Call OpenAI Chat Completions API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.openai.key'),
            'Content-Type'  => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4-turbo', // or 'gpt-4' if you have access
            'messages'    => $recent,
            'temperature' => 0.7,
            'max_tokens'  => 1000,
            // 'stream'    => false,   // streaming requires a different handler
        ]);

        Log::debug('OpenAI API Request:', ['messages' => $recent]);
        Log::debug('OpenAI API Response:', $response->json());

        if (!$response->successful()) {
            Log::error('OpenAI API Error: ' . $response->body());
            throw new \Exception("OpenAI Error: " . $response->body());
        }

        // Return the raw JSON from OpenAI
        return response()->json($response->json());

    } catch (\Exception $e) {
        Log::error("Chatbot Error: " . $e->getMessage());
        return response()->json([
            'error' => $e->getMessage(),
        ], 500);
    }

}
}
//     public function processMessage(Request $request)
//     {
//         $request->validate(['messages' => 'required|array']);

//         try {
//             // Extract only the last few messages to keep context manageable
//             $messages = $request->input('messages');

//             // Keep the system message at the beginning
//             $systemMessage = null;
//             foreach ($messages as $key => $message) {
//                 if ($message['role'] === 'system') {
//                     $systemMessage = $message;
//                     unset($messages[$key]);
//                     break;
//                 }
//             }

//             // Get the last 4 messages (or fewer if there aren't 4)
//             $recentMessages = array_slice(array_values($messages), -4);

//             // Put the system message back at the beginning
//             if ($systemMessage) {
//                 array_unshift($recentMessages, $systemMessage);
//             }

//             // ✅ Updated: Direct DeepSeek API Call
//             $response = Http::withHeaders([
//                 'Authorization' => 'Bearer ' . config('services.deepseek.api_key'), // Store API key in config
//                 'Content-Type' => 'application/json',
//             ])->post('https://api.deepseek.com/v1/chat/completions', [ // DeepSeek's official API endpoint
//                 'model' => 'deepseek-chat', // Model name (check latest in docs)
//                 'messages' => $recentMessages,
//                 'temperature' => 0.7,
//                 'max_tokens' => 500,
//                 'stream' => false,
//                 'stop' => ["\n\n"]
//             ]);

//             Log::debug('DeepSeek API Request:', ['messages' => $recentMessages]);
//             Log::debug('DeepSeek API Response:', $response->json());

//             if (!$response->successful()) {
//                 Log::error('API Error: ' . $response->body());
//                 throw new \Exception("API Error: " . $response->body());
//             }

//             return $response->json();

//         } catch (\Exception $e) {
//             Log::error("Chatbot Error: " . $e->getMessage());
//             return response()->json([
//                 'error' => $e->getMessage()
//             ], 500);
//         }
//     }
// }
// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Log;

// class ChatbotController extends Controller
// {
//     /**
//      * Handle the chatbot message and get a response from the Deepseek API
//      *
//      * @param Request $request
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function processMessage(Request $request)
//     {
//         $request->validate(['messages' => 'required|array']);

//         try {
//             // Extract only the last few messages to keep context manageable
//             $messages = $request->input('messages');

//             // Always keep the system message at the beginning
//             $systemMessage = null;
//             foreach ($messages as $key => $message) {
//                 if ($message['role'] === 'system') {
//                     $systemMessage = $message;
//                     unset($messages[$key]);
//                     break;
//                 }
//             }

//             // Get the last 4 messages (or fewer if there aren't 4)
//             $recentMessages = array_slice(array_values($messages), -4);

//             // Put the system message back at the beginning
//             if ($systemMessage) {
//                 array_unshift($recentMessages, $systemMessage);
//             }

//             $response = Http::withHeaders([
//                 'Authorization' => 'Bearer ' . config('services.openrouter.api_key'),
//                 'HTTP-Referer' => config('app.url'),
//                 'X-Title' => config('app.name'),
//             ])->post('https://openrouter.ai/api/v1/chat/completions', [
//                 'model' => 'deepseek/deepseek-v3-base:free',
//                 'messages' => $recentMessages,
//                 'temperature' => 0.7,
//                 'max_tokens' => 500, // Increased max tokens
//                 'stream' => false,
//                 'stop' => ["\n\n"] // Stop at double newlines to prevent run-on responses
//             ]);

//             Log::debug('OpenRouter Request:', ['messages' => $recentMessages]);
//             Log::debug('OpenRouter API Response:', $response->json());

//             if (!$response->successful()) {
//                 Log::error('API Error: ' . $response->body());
//                 throw new \Exception("API Error: " . $response->body());
//             }

//             return $response->json();

//         } catch (\Exception $e) {
//             Log::error("Chatbot Error: " . $e->getMessage());
//             return response()->json([
//                 'error' => $e->getMessage()
//             ], 500);
//         }
//     }
// }
