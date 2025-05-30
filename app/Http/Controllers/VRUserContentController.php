<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\VRContent;
use Illuminate\Http\Request;

class VRUserContentController extends Controller
{
    /**
     * Эрүүл мэндийн VR контентын нүүр хуудас
     * Онцлох болон шинэ загваруудыг харуулна
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $featuredContent = VRContent::where('featured', true)
            ->where('status', 'published')
            ->with('category')
            ->limit(3)
            ->get();

        $categories = Category::withCount(['vrContents' => function($query) {
                $query->where('status', 'published');
            }])
            ->orderByDesc('vr_contents_count')
            ->limit(4)
            ->get();

        $newContent = VRContent::where('status', 'published')
            ->with('category')
            ->latest()
            ->limit(4)
            ->get();

            $modelPath = '/models/night_sky_visible_spectrum_monochromatic.glb'; // Example path

        return view('vr-content.user.home', [
            'featuredContent' => $featuredContent,
            'categories' => $categories,
            'newContent' => $newContent,
            'modelPath' => $modelPath
        ]);
    }


    /**
     * Онцлох загваруудыг харуулах
     *
     * @return \Illuminate\View\View
     */

     public function featured() {
        // Get all categories for filter dropdown
        $categories = Category::all();

        // Build query for featured content
        $query = VRContent::where('featured', true)
            ->where('status', 'published')
            ->with('category');

        // Apply category filter if selected
        if (request()->has('category') && request('category') != '') {
            $query->where('category_id', request('category'));
        }

        // Apply sorting filter
        $sort = request('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        // Get paginated results
        $featuredContents = $query->paginate(12)->appends(request()->query());

        return view('vr-content.user.all', [
            'contents' => $featuredContents,
            'contentType' => 'featured',
            'categories' => $categories
        ]);
    }

    public function newModels() {
        // Get all categories for filter dropdown
        $categories = Category::all();

        // Build query for new content
        $query = VRContent::where('status', 'published')
            ->with('category');

        // Apply category filter if selected
        if (request()->has('category') && request('category') != '') {
            $query->where('category_id', request('category'));
        }

        // Apply sorting filter
        $sort = request('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        // Get paginated results with the most recent content first
        $newContents = $query->paginate(12)->appends(request()->query());

        return view('vr-content.user.all', [
            'contents' => $newContents,
            'contentType' => 'new',
            'categories' => $categories
        ]);
    }


    /**
     * Ангилал бүрийн VR контентуудыг харуулах
     *
     * @param string $slug Ангилалын slug
     * @return \Illuminate\View\View
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // Эрэмбэлэх сонголтууд
        $sort = request('sort', 'latest');

        $contentsQuery = VRContent::where('category_id', $category->id)
            ->where('status', 'published');

        // Эрэмбэлэх
        switch ($sort) {
            case 'oldest':
                $contentsQuery->oldest();
                break;
            case 'name_asc':
                $contentsQuery->orderBy('title', 'asc');
                break;
            case 'name_desc':
                $contentsQuery->orderBy('title', 'desc');
                break;
            default:
                $contentsQuery->latest();
                break;
        }

        $contents = $contentsQuery->paginate(12);

        // Бусад ангилалууд
        $otherCategories = Category::where('id', '!=', $category->id)
            ->withCount('vrContents')
            ->take(4)
            ->get();

        return view('vr-content.user.category', compact('category', 'contents', 'otherCategories'));
    }


    /**
     * VR контентын дэлгэрэнгүй хуудас
     *
     * @param string $id VR контентын ID
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $vrContent = VRContent::where('id', $id)
            ->where('status', 'active')
            ->with(['category', 'details'])
            ->firstOrFail();

        // Ижил ангилалын бусад контент
        $relatedContents = VRContent::where('category_id', $vrContent->category_id)
            ->where('id', '!=', $vrContent->id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        return view('vr-content.show', compact('vrContent', 'relatedContents'));
    }
    public function showVR($id)
{
    // dd('Inside show function, ID:', $id);

    $vrContent = VRContent::with(['category', 'details'])
        ->findOrFail($id);

    $relatedContent = VRContent::where('category_id', $vrContent->category_id)
        ->where('id', '!=', $id)
        ->where('status', 'published')
        ->limit(5)
        ->get();

    $categories = Category::limit(10)->get();

    return view('vr-content.user.show', compact('vrContent', 'relatedContent', 'categories'));
}

    /**
     * Шинэ VR загваруудыг харуулах
     *
     * @return \Illuminate\View\View
     */


    /**
     * Хайлтын функц
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */



    public function search(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
        $sort = $request->input('sort', 'latest');

        $source = $request->input('source', 'new'); // Default to 'new' if not specified

        $contents = VrContent::query()
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('title', 'LIKE', '%'.$query.'%')
                             ->orWhere('description', 'LIKE', '%'.$query.'%');
                });
            })
            ->when($category, function ($q) use ($category) {
                $q->where('category_id', $category);
            })
            ->with('category')
            ->orderBy($this->getSortColumn($sort), $this->getSortDirection($sort))
            ->paginate(10);

        return view('vr-content.user.all', [
            'contents' => $contents,
            'categories' => Category::all(),
            'currentCategory' => $category,
            'currentSort' => $sort,
            'currentQuery' => $query,

            'contentType' => $source, // Use the source as the content type
        ]);
    }
    private function getSortColumn($sort)
{
    return match ($sort) {
        'name_asc', 'name_desc' => 'title',
        default => 'created_at',
    };
}

private function getSortDirection($sort)
{
    return match ($sort) {
        'oldest' => 'asc',
        'name_desc' => 'desc',
        default => 'desc',
    };
}
}
