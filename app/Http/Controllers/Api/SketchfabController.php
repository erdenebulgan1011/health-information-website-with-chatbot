<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SketchfabController extends Controller
{
    protected $apiBaseUrl = 'https://api.sketchfab.com/v3';
    
    /**
     * Sketchfab-аас моделиуд хайх
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $categories = $request->get('categories', 'medical');
        $count = $request->get('count', 24);
        
        // Хэрэглэгчийн хайлтын үр дүнг кэшлэх (5 минут)
        $cacheKey = 'sketchfab_search_' . md5($query . $categories . $count);
        
        return Cache::remember($cacheKey, 300, function () use ($query, $categories, $count) {
            $response = Http::get($this->apiBaseUrl . '/search', [
                'q' => $query,
                'categories' => $categories,
                'count' => $count,
                'sort_by' => '-relevance',
                'type' => 'models',
                'downloadable' => 'false',
                'staffpicked' => 'true',
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return [
                'results' => [],
                'error' => 'API хүсэлт амжилтгүй болсон: ' . $response->status()
            ];
        });
    }
    
    /**
     * Тодорхой моделийн мэдээлэл авах
     */
    public function getModel($uid)
    {
        // Моделийн мэдээллийг кэшлэх (1 цаг)
        $cacheKey = 'sketchfab_model_' . $uid;
        
        return Cache::remember($cacheKey, 3600, function () use ($uid) {
            $response = Http::get($this->apiBaseUrl . '/models/' . $uid);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return [
                'error' => 'API хүсэлт амжилтгүй болсон: ' . $response->status()
            ];
        });
    }
}
