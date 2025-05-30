<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Topic;

use App\Models\VRContent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{
/**
     * Бүх категорийн жагсаалт
     */
    public function index()
    {
        $categories = Category::withCount('vrContents')->paginate(15);
        return view('vr-content.categories.index', compact('categories'));
    }

    /**
     * Тодорхой категорийн дэлгэрэнгүй хуудас
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $vrContents = VRContent::where('category_id', $category->id)
            ->where('status', 'published')
            ->paginate(12);

        return view('vr-content.categories.showItems', compact('category', 'vrContents'));
    }
    public function showVR($id)
{
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
     * ADMIN КОНТРОЛЛЕР ХЭСЭГ
     */
    public function adminIndex()
    {
        $categories = Category::withCount('vrContents')->get();
        return view('vr-content.categories.index', compact('categories'));
    }

    /**
     * Шинэ категори үүсгэх форм
     */
    public function adminCreate()
    {
        return view('vr-content.categories.create');
    }

    /**
     * Шинэ категори хадгалах
     */
    public function adminStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:categories,name',
            'description' => 'nullable|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        $category->save();

        return redirect()->route('categories.index')
            ->with('success', 'Категори амжилттай үүсгэгдлээ');
    }

    /**
     * Категори засварлах форм
     */
    public function adminEdit($id)
{
    $category = Category::findOrFail($id);
    return view('vr-content.categories.edit', compact('category'));
}


    /**
     * Категори шинэчлэх
     */
    public function adminUpdate(Request $request, $id)
{
    $category = Category::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255|unique:categories,name,' . $id,
        'description' => 'nullable|max:1000'
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $category->name = $request->name;
    $category->slug = Str::slug($request->name);
    $category->description = $request->description;
    $category->save();

    return redirect()->route('categories.index')
        ->with('success', 'Категори амжилттай шинэчлэгдлээ');
}


    /**
     * Категори устгах
     */
    public function adminDestroy($id)
{
    $category = Category::findOrFail($id);

    // Check if there are any related VRContents
    $contentCount = VRContent::where('category_id', $category->id)->count();

    if ($contentCount > 0) {
        return redirect()->back()
            ->with('error', 'Энэ категортой ' . $contentCount . ' VR контент байгаа тул устгах боломжгүй.');
    }

    $category->delete();

    return redirect()->route('categories.index')
        ->with('success', 'Категори амжилттай устгагдлаа');
}



public function indexALL()
    {
        $categories = Category::withCount(['topics', 'vrContents'])
            ->orderBy('name')
            ->get();

        return view('Forum.categories.index', [
            'categories' => $categories,
            'title' => 'Ангилалууд',
            'description' => 'Форум хэлэлцүүлэг болон VR загварууд'
        ]);
    }

    public function showALL($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // Get VR contents for this category
        $contents = VrContent::where('category_id', $category->id)
            ->with('category')
            ->latest()
            ->paginate(12);

        // Get other categories (excluding current one)
        $otherCategories = Category::where('id', '!=', $category->id)
            ->withCount('vrContents')
            ->having('vr_contents_count', '>', 0)
            ->orderBy('vr_contents_count', 'desc')
            ->limit(4)
            ->get();
        // Get forum topics for this category
        $topics = Topic::where('category_id', $category->id)
            ->with(['user', 'tags'])
            ->latest()
            ->paginate(10, ['*'], 'topics_page');
            $vrContents = VrContent::where('category_id', $category->id)
            ->latest()
            ->paginate(12, ['*'], 'vr_page');
            $categories = Category::withCount(['topics', 'vrContents'])
            ->orderBy('name')
            ->get();



        return view('Forum.categories.show', [
            'category' => $category,
            'contents' => $contents,
            'topics' => $topics,
            'vrContents' => $vrContents,
            'categories' => $categories,

            'otherCategories' => $otherCategories
        ]);

    }


}
