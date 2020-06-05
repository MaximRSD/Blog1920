<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Comment;
use App\Post;

class CommentController extends Controller
{
    public function store($postid){
        $post = Post::findOrFail($postid);
        if (request('txtComment') != null){
        
        $comment = new Comment();
        $comment->comment = request('txtComment');
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $post->id;
        $comment->save();
        return redirect()->route('post.show', $post->slug);
        } else {
            return redirect()->route('post.show', $post->slug);
        }
    }
//SO naar Jermoski
    public function destroy($commentid){
        $comment = Comment::findOrFail($commentid);
        if (Auth::user()->can('delete', $comment)) {
            $comment->delete();
            return redirect()->route('post.show', $comment->post->slug);
        }
        abort(403, 'This action is unauthorized.');
    }
}
