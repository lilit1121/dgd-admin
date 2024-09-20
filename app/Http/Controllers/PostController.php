<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
//    public function showPosts()
//    {
//        $posts = Post::where('post_type', 'post')->paginate(33);
//        return response()->json($posts);
//    }


    public function showPosts(Request $request)
    {

        $search = $request->input('search');
        $query = Post::where('post_type', 'post');

        if ($search) {
            $query->where('post_title', 'like', '%' . $search . '%');
        }

        $posts = $query->paginate(3);

        // Return paginated results as JSON
        return response()->json($posts);
    }


    public function showPost($id)
    {
        $posts = Post::where('id', $id)->get();
        return response()->json($posts);
    }
}
