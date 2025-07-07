<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $request->item_id,
            'content' => $request->content,
        ]);

        return redirect()->route('items.show', $request->item_id)->with('success', 'コメントを投稿しました');
    }
}
