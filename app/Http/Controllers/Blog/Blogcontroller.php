<?php

namespace App\Http\Controllers\Blog;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogReesource;
use App\Http\Traits\ApiHandler;
class Blogcontroller extends Controller
{

    use ApiHandler;

    public function index()
    {
        $blog =BlogReesource::collection(Blog::orderByDesc('created_at')->get()) ;

        foreach ($blogs as $blog) {
            $blog->increment('views');
        }

        return $this->successMessage( $blog, 'Blog retrieved successfuly!');
    }



    public function store(BlogRequest $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $validatedata=$request->validated();

        //// Get the authenticated user's ID
        $userId = auth()->id();

         $blog = Blog::create([
            'user_id' => $userId,
            'subject' => $validatedata['subject'],
            'content' => $validatedata['content']
        ]);

        return $this->successMessage(new BlogReesource($blog), 'Blog stored successfuly!');

    }


    public function edit(BlogRequest $request, Blog $blog)
    {
        $validatedata = $request->validated();

        // $userId = auth()->id();

        if (!auth()->check()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // if (!$blog) {
        //     return response()->json(
        //         [
        //             'message' => 'Not Found'
        //         ]
        //     );
        // }

        if (auth()->id() != $blog->user_id) {
            return $this->errorMessage('Unauthorized');
        }

        $blog->update($validatedata);
        return $this->successMessage(new BlogReesource($blog), 'Blog apdeated successfuly!');
    }


    public function delete(Blog $blog)
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        if (auth()->id() != $blog->user_id) {
            return $this->errorMessage('Unauthorized');
        }


        $blog->delete();
        return $this->successMessage(new BlogReesource($blog), 'The blog was deleted successfully!!');

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
        return new BlogReesource($blog);
    }


    public function byLike()
    {
        $blogs = Blog::leftJoin('likes', 'blogs.id', '=', 'likes.blog_id')
        ->selectRaw('blogs.*, count(likes.id) as likes_count')
        ->groupBy('blogs.id')
        ->orderByDesc('likes_count')
        ->get();
        // foreach ($blogs as $blog) {
        //     Blog::where('id', $blog->id)->increment('views');
        // }
    
        return response()->json([
            'data' => $blogs,
        ]);

    }
        public function byViews()
        {
            $blogs = Blog::orderByDesc('views')->get();
        
            foreach ($blogs as $blog) {
                $blog->increment('views');
            }
        
            $blogResources = BlogResource::collection($blogs);
        
            return $this->successMessage($blogResources, 'Blogs retrieved successfully!');
        }
                
            }


