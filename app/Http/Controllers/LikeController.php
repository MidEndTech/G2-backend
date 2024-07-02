<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function likeBlog($blogId)
    {
        $userId = auth()->id();
        if (is_null($userId)) {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        $blog = Blog::findOrFail($blogId);
        $like = new Like();
        $like->user_id = $userId;
        $like->blog_id = $blog->id;
        $like->save();

        return response()->json(['status' => 'liked']);
    }

    public function unlikeBlog($blogId)
    {
        $userId = Auth::id();
        if (is_null($userId)) {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        $blog = Blog::findOrFail($blogId);
        $like = Like::where('user_id', $userId)->where('blog_id', $blog->id)->first();
        if ($like) {
            $like->delete();
            return response()->json(['status' => 'unliked']);
        }

        return response()->json(['status' => 'not_found']);
    }
}
