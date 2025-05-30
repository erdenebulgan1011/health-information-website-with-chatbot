<?php
namespace App\Http\Controllers;

use App\Models\VRContent;
use App\Models\VRContentSuggestion;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class VRContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   /**
     * Бүх VR контентыг харуулах
     */
    public function index()
{
    $vrContents = VRContent::paginate(20);
    return view('vr-content.index', compact('vrContents'));
}
public function Map()
{
    return view('map');
}
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

    /**
     * Админ дээр бүх VR контентыг харуулах
     */
    public function adminIndex()
    {
        $vrContents = VRContent::paginate(20);
        return view('vr-content.index', compact('vrContents'));
    }

    public function create()
{
    $categories = Category::all();
    return view('vr-content.create', compact('categories'));
}






    /**
     * Шинэ VR контент хадгалах
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'sketchfab_uid' => 'required|unique:vr_contents',
        'category_id' => 'required|exists:categories,id',
        'status' => 'required|in:draft,published',
        'featured' => 'sometimes|boolean'
    ]);

    // Handle featured checkbox
    $validated['featured'] = $request->has('featured');

    try {
        VRContent::create($validated);
        return redirect()->route('vr.index')
            ->with('success', 'VR content created successfully');
    } catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Error creating content: '.$e->getMessage());
    }
}

    /**
     * VR контент засварлах форм
     */
    public function edit($id)
{
    $vrContent = VRContent::findOrFail($id);
    $categories = Category::all();
    return view('vr-content.edit', compact('vrContent', 'categories'));
}

public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'title' => 'required|max:255',
        'description' => 'required',
        'sketchfab_uid' => 'required|unique:vr_contents,sketchfab_uid,'.$id,
        'category_id' => 'required|exists:categories,id', // Correct field name
        'status' => 'required|in:draft,published',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $vrContent = VRContent::findOrFail($id);
    $vrContent->update([
        'title' => $request->title,
        'description' => $request->description,
        'sketchfab_uid' => $request->sketchfab_uid,
        'category_id' => $request->category_id, // Update category_id correctly
        'status' => $request->status,
    ]);

    return redirect()->route('vr.index')->with('success', 'Амжилттай шинэчлэгдлээ!');
}


    /**
     * VR контент устгах
     */
    public function destroy($id)
    {
        $vrContent = VRContent::findOrFail($id);
        $vrContent->delete();

        return redirect()->route('vr.index')->with('success', 'VR контент устгагдлаа');
    }




        /**
     * Create suggestion form for users
     */
    public function createSuggest(Request $request)
    {
        $categories = Category::all();
        $selectedCategoryId = $request->query('category');

        return view('vr-content.suggestion.create-suggestion', compact('categories', 'selectedCategoryId'));
    }

    /**
     * Store the user suggestion
     */
    public function storeSuggest(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'sketchfab_uid' => 'required|unique:vr_contents,sketchfab_uid|unique:vr_content_suggestions,sketchfab_uid',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Add user_id to validated data
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        try {
            VRContentSuggestion::create($validated);
            return redirect()->route('vr.index')
                ->with('success', 'Таны санал амжилттай илгээгдлээ. Админ хянаж байна.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Алдаа гарлаа: '.$e->getMessage());
        }
    }

    /**
     * Admin view of all suggestions
     */
    public function adminSuggestions()
    {
        $suggestions = VRContentSuggestion::with(['category', 'user'])
            ->latest()
            ->paginate(20);

        return view('vr-content.admin.admin-suggestions', compact('suggestions'));
    }

    /**
     * Admin reviews a specific suggestion
     */
    public function reviewSuggestion($id)
    {
        $suggestion = VRContentSuggestion::with(['category', 'user'])
            ->findOrFail($id);

        return view('vr-content.suggestion.review-suggestion', compact('suggestion'));
    }

    /**
     * Admin approves or rejects a suggestion
     */
    public function processSuggestion(Request $request, $id)
    {
        $validated = $request->validate([
            'decision' => 'required|in:approve,reject',
            'admin_notes' => 'nullable|string',
        ]);

        $suggestion = VRContentSuggestion::findOrFail($id);

        if ($validated['decision'] == 'approve') {
            // Create new VR content
            VRContent::create([
                'title' => $suggestion->title,
                'description' => $suggestion->description,
                'sketchfab_uid' => $suggestion->sketchfab_uid,
                'category_id' => $suggestion->category_id,
                'status' => 'published',
                'featured' => false
            ]);

            // Update suggestion status
            $suggestion->status = 'approved';
            $suggestion->admin_notes = $validated['admin_notes'];
            $suggestion->save();

            return redirect()->route('vr.admin.suggestions')
                ->with('success', 'Санал амжилттай батлагдаж, шинэ VR контент нэмэгдлээ.');
        } else {
            // Just mark as rejected
            $suggestion->status = 'rejected';
            $suggestion->admin_notes = $validated['admin_notes'];
            $suggestion->save();

            return redirect()->route('vr.admin.suggestions')
                ->with('success', 'Санал амжилттай цуцлагдлаа.');
        }
    }
    /**
 * Delete a suggestion
 */
public function editSuggestion($id)
{
    $suggestion = VRContentSuggestion::findOrFail($id);
    $categories = Category::all();

    return view('vr-content.admin.edit-suggestion', compact('suggestion', 'categories'));
}

/**
 * Update a suggestion
 */
public function updateSuggestion(Request $request, $id)
{
    $validated = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'sketchfab_uid' => 'required|unique:vr_contents,sketchfab_uid|unique:vr_content_suggestions,sketchfab_uid,'.$id,
        'category_id' => 'required|exists:categories,id',
        'status' => 'required|in:pending,approved,rejected',
        'admin_notes' => 'nullable|string',
    ]);

    $suggestion = VRContentSuggestion::findOrFail($id);
    $suggestion->update($validated);

    return redirect()->route('vr.admin.suggestions')
        ->with('success', 'Санал амжилттай шинэчлэгдлээ.');
}

/**
 * Change status of a suggestion
 */
public function changeStatus(Request $request, $id)
{
    $validated = $request->validate([
        'status' => 'required|in:pending,approved,rejected',
        'admin_notes' => 'nullable|string',
    ]);

    $suggestion = VRContentSuggestion::findOrFail($id);

    // If status is changing from approved to something else
    // and the content was previously created, handle that
    if ($suggestion->status == 'approved' && $validated['status'] != 'approved') {
        // Find and delete the associated VR content if it exists
        $vrContent = VRContent::where('sketchfab_uid', $suggestion->sketchfab_uid)->first();
        if ($vrContent) {
            $vrContent->delete();
        }
    }

    // If status is changing to approved and was previously not approved
    if ($validated['status'] == 'approved' && $suggestion->status != 'approved') {
        // Create new VR content
        VRContent::create([
            'title' => $suggestion->title,
            'description' => $suggestion->description,
            'sketchfab_uid' => $suggestion->sketchfab_uid,
            'category_id' => $suggestion->category_id,
            'status' => 'published',
            'featured' => false
        ]);
    }

    $suggestion->status = $validated['status'];
    $suggestion->admin_notes = $validated['admin_notes'] ?? $suggestion->admin_notes;
    $suggestion->save();

    return redirect()->route('vr.admin.suggestions')
        ->with('success', 'Саналын төлөв амжилттай шинэчлэгдлээ.');
}


public function destroySuggestion($id)
{
    $suggestion = VRContentSuggestion::findOrFail($id);

    // If suggestion was approved, also delete the associated VR content
    if ($suggestion->status == 'approved') {
        $vrContent = VRContent::where('sketchfab_uid', $suggestion->sketchfab_uid)->first();
        if ($vrContent) {
            $vrContent->delete();
        }
    }

    $suggestion->delete();

    return redirect()->route('vr.admin.suggestions')
        ->with('success', 'Санал амжилттай устгагдлаа.');
}
public function bulkAction(Request $request)
{
    Log::info('Bulk action called with data: ' . json_encode($request->all()));

    $validated = $request->validate([
        'action' => 'required|in:approve,reject,delete',
        'suggestion_ids' => 'required|array',
        'suggestion_ids.*' => 'required|exists:vr_content_suggestions,id',
        'admin_notes' => 'nullable|string',
    ]);

    $count = 0;

    foreach ($validated['suggestion_ids'] as $id) {
        $suggestion = VRContentSuggestion::findOrFail($id);

        switch ($validated['action']) {
            case 'approve':
                if ($suggestion->status != 'approved') {
                    // Create new VR content
                    VRContent::create([
                        'title' => $suggestion->title,
                        'description' => $suggestion->description,
                        'sketchfab_uid' => $suggestion->sketchfab_uid,
                        'category_id' => $suggestion->category_id,
                        'status' => 'published',
                        'featured' => false
                    ]);

                    $suggestion->status = 'approved';
                    $suggestion->admin_notes = $validated['admin_notes'] ?? $suggestion->admin_notes;
                    $suggestion->save();
                    $count++;
                }
                break;

            case 'reject':
                if ($suggestion->status == 'approved') {
                    // Find and delete the associated VR content if it exists
                    $vrContent = VRContent::where('sketchfab_uid', $suggestion->sketchfab_uid)->first();
                    if ($vrContent) {
                        $vrContent->delete();
                    }
                }

                $suggestion->status = 'rejected';
                $suggestion->admin_notes = $validated['admin_notes'] ?? $suggestion->admin_notes;
                $suggestion->save();
                $count++;
                break;

            case 'delete':
                if ($suggestion->status == 'approved') {
                    // Find and delete the associated VR content if it exists
                    $vrContent = VRContent::where('sketchfab_uid', $suggestion->sketchfab_uid)->first();
                    if ($vrContent) {
                        $vrContent->delete();
                    }
                }

                $suggestion->delete();
                $count++;
                break;
        }
    }

    $actionMessages = [
        'approve' => 'батлагдлаа',
        'reject' => 'цуцлагдлаа',
        'delete' => 'устгагдлаа',
    ];

    return redirect()->route('vr.admin.suggestions')
        ->with('success', $count . ' санал амжилттай ' . $actionMessages[$validated['action']] . '.');
}


}
