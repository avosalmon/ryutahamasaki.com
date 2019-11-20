<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Wink\WinkPost;

class BlogController extends Controller
{
    public function index()
    {
        $posts = WinkPost::with('tags')
            ->live()
            ->orderBy('publish_date', 'DESC')
            ->paginate(10);

        return view('blog.index', [
            'posts' => $posts
        ]);
    }

    public function show(string $slug)
    {
        $post = WinkPost::with('tags')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('blog.show', [
            'post' => $post
        ]);
    }
}
