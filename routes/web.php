<?php

use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $categories = Category::select('id', 'title')->orderBy('title')->get();

    $tags = Tag::select('id', 'name')->orderByDesc(
        DB::table(
            'post_tag'
        )
            ->selectRaw('count(tag_id) as tag_count')
            ->whereColumn('tags.id', 'post_tag.tag_id')
            ->orderBy('tag_count', 'desc')
            ->limit(1)
    )->get();
    /* get all the tags by id and name, order descending by tag count 
    we count the same tag name by using the where column constraint, where the id column 
    of the tags table is the same as the tag id column in the post_tag pivot table  */

    $latestPosts = Post::select('id', 'title')->latest()->take(5)->withCount('comments')->get();

    $posts = Post::select('id', 'title', 'content')->get();

    $comments = Comment::select('id', 'content')->get();

    dump($latestPosts);

    return view('welcome');
});
