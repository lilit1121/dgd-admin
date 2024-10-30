<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{


    public function showPosts(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $sort = $request->input('sort', 'desc');

        $query = Post::where('post_type', 'post');

        if ($search) {
            $query->where('post_title', 'like', '%' . $search . '%');
        }

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $posts = $query->orderBy('created_at', $sort)->paginate(33);

        return response()->json($posts);
    }


    public function showPost($id)
    {
        $posts = Post::where('id', $id)->get();
        return response()->json($posts);
    }
}
