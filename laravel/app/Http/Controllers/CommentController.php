<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;


class CommentController extends Controller
{
    public function index()
    {
        $items = DB::table('comments')
        ->join('users', 'users.id', '=', 'comments.user_id')
        ->join('posts', 'posts.id', '=', 'comments.post_id')
        ->select('comments.*', 'users.name')
        ->get();
        return response()->json([
        'data' => $items
        ], 200);
    }

    public function store(Request $request)
    {
        $item = Comment::create($request->all());
        return response()->json([
        'data' => $item
        ], 201);
    }

    public function show($id)
    {
        $item = Comment::with('user')
                        ->where('post_id', '=', $id)
                        ->get();
        if ($item) {
        return response()->json([
        'data' => $item
        ], 200);
        } else {
        return response()->json([
        'message' => 'Not found',
        ], 404);
        }
    }
}