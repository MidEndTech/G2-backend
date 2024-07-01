<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class Blogcontroller extends Controller
{


    public function index()
    {
        $blog = Blog::get();
        return response()->json([
            'data' => $blog,
        ]);
    }
    public function store(Request $request)
    {

        $request->validate([
            'subject' => 'required',
            'content' => 'required'
        ]);

        $userId = auth()->id();

        $blog = Blog::create([
            'user_id' => $userId,
            'subject' => $request->subject,
            'content' => $request->content
        ]);

        return response()->json([
            'message' => 'the blog created sucssefuly!',
            'data' => $blog
        ], 201);
    }


    public function edit(Request $request, $id)
    {
        $blogData = $request->validate([
            'subject' => 'required',
            'content' => 'required'
        ]);


        $userId = auth()->id();
        $blog = Blog::where('id', $id)->where('user_id', $userId)->first();

        if (!$blog) {
            return response()->json(['Not Found'], 404);
        }

        $blog->update($blogData);


        return response()->json([
            'data' => $blog,
            'message' => 'the blog apdeated sucssefuly!'
        ]);
    }


    public function delete($id)
    {

        $userId = auth()->id();
        $blog = Blog::where('id', $id)->where('user_id', $userId)->first();

        if (!$blog) {
            return response()->json(['Not Found'], 404);
        }

        $blog->delete();
        return response()->json([
            'message' => 'the blog deleted sucssefuly!'
        ]);
    }


    
    // show a specific blog post belonging to a user
    public function show($id)
    {
        $userId = auth()->id();


        $blog = Blog::where('id', $id)->where('user_id', $userId)->first();
        if (!$blog) {
            return response()->json([
                'message' => 'Blog not found or you do not have permission to access it.'
            ], 404);
        }
        return response()->json([
            'data' => $blog,
        ]);
    }
}
