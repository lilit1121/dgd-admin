<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function showPosts()
    {
        $posts = Post::where('post_type', 'post')->paginate(20);
        return response()->json($posts);
    }

    public function showPost($id)
    {
        $posts = Post::where('id', $id)->get();
        return response()->json($posts);
    }
}
