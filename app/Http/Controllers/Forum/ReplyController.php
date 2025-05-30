<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Topic;

use App\Models\Reply;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function topicReplies(Topic $topic)
    {

    // Eager load replies with their user relationships
    $topic->load(['replies.user', 'category']);

    // Or if you want pagination:
    $replies = $topic->replies()
                    ->with('user')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('Forum.admin.showReply', compact('topic', 'replies'));
    }


    public function store(Request $request, Topic $topic)
    {
        $request->validate([
            'content' => 'required|min:5',
            'parent_id' => 'nullable|exists:replies,id',
        ]);

        $reply = Reply::create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'topic_id' => $topic->id,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->back()->with('success', 'Хариулт амжилттай нэмэгдлээ.');
    }

    public function edit(Reply $reply)
    {
        $this->authorize('update', $reply);

        return view('replies.edit', compact('reply'));
    }

    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);

        $request->validate([
            'content' => 'required|min:5',
        ]);

        $reply->update([
            'content' => $request->content,
        ]);

        return redirect()->route('topics.show', $reply->topic->slug)
            ->with('success', 'Хариулт амжилттай шинэчлэгдлээ.');
    }

    public function destroy(Reply $reply)
    {
        // $this->authorize('delete', $reply);

        $topicSlug = $reply->topic->slug;
        $reply->delete();

        return redirect()->route('topics.show', $topicSlug)
            ->with('success', 'Хариулт амжилттай устгагдлаа.');
    }

    public function markAsBest(Reply $reply)
    {
        $topic = $reply->topic;
        // $this->authorize('update', $topic);

        // Reset any existing best answer
        $topic->replies()->update(['is_best_answer' => false]);

        // Mark this reply as best
        $reply->update(['is_best_answer' => true]);

        return redirect()->back()->with('success', 'Шилдэг хариултаар тэмдэглэгдлээ.');
    }
}

