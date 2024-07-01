<?php

namespace App\Http\Controllers\Blog;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use App\Http\Controllers\Controller;

class Blogcontroller extends Controller
{


    public function index()
    {
        $blog = Blog::get();
        return response()->json([
            'data' => $blog,
        ]);
    }
    public function store(BlogRequest $request)
    {

        // $request->validate([
        //     'subject' => 'required',
        //     'content' => 'required'
        // ]);
        $validatedata=$request->validated();

        $userId = auth()->id();

        $blog = Blog::create([
            'user_id' => $userId,
            'subject' => $validatedata['subject'],
            'content' => $validatedata['content']
        ]);

        return response()->json([
            'message' => 'the blog created sucssefuly!',
            'data' => $blog
        ], 201);
    }


    public function edit(BlogRequest $request, $id)
    {

        $validatedata=$request->validated();

        $userId = auth()->id();
        $blog = Blog::where('id', $id)->where('user_id', $userId)->first();

        if (!$blog) {
            return response()->json(['Not Found'], 404);
        }

        $blog->update( $validatedata);


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
        ], 200);
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
