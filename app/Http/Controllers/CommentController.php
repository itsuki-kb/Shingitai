<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    #store()  save the comment to database
    public function store(Request $request, $post_id)
    {
        $request->validate([
            'comment' => 'required|max:500'
        ]);

        $this->comment->user_id = Auth::user()->id;
        $this->comment->post_id = $post_id;
        $this->comment->content = $request->comment;
        $this->comment->save();

        return redirect()->back();
    }

    // Delete a comment
    public function delete($comment_id)
    {
        $delete_comment = $this->comment->findOrFail($comment_id);

        $delete_comment->delete();

        return redirect()->back();

    }

}
