<?php

use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    /* search for title and content of post */

    /**
     * query the posts table where the title and content
     * contain the values of the variables
    //  */

    // $postTitle = 'delen';
    // $postContent = 'Est provident';
    // $query = DB::table('posts')
    //     ->where('title', 'like', "%$postTitle%")
    //     ->orWhere('content', 'like', "%$postContent%")
    //     ->get();

    // dump($query);

    /* FULLTEXT index */

    /**
     * Only results which contain this string will be fetched
     * including the title and the content
     */

    /* MySQL can perform boolean full-text searches using the IN BOOLEAN MODE modifier. With this modifier,
     certain characters have special meaning at the beginning or end of words in the search string. In the 
     following query, the + and - operators indicate that a word must be present or absent, respectively,
      for a match to occur. Thus, the query retrieves all the rows that contain the word "nostrum" but 
      that do not contain the word "maxime" */

    $searchTerm = '+nostrum -maxime';
    // $sortBy = 'updated_at';
    $sortBy = 'updated_at desc, title asc';
    $query = DB::table('posts')
        // ->where('title', 'like', "%$searchTerm%")
        // ->orWhere('content', 'like', "%$searchTerm%")
        /* laravel doesnt support full text searching, write sql query 
            run the following command in tinker
            DB::statement('ALTER TABLE posts ADD FULLTEXT fulltext_index_for_posts(title,content)')
        */
        ->whereRaw(
            "MATCH(title, content) AGAINST(? IN BOOLEAN MODE)",
            [$searchTerm]
        )
        ->when($sortBy, function ($q, $sortBy) {
            return $q->orderByRaw($sortBy);
        })
        ->get();

    Debugbar::info($query);

    // /* query single records in the database */

    // $postId = 2;

    // // fetches post with comments and all columns
    // $res = Post::with('comments')->find($postId);

    // $tagId = 1;

    // // $result = Tag::with(['posts' => function ($q) {
    // //     // only fetch the posts with tags and only the id and title columns
    // //     $q->select('posts.id', 'posts.title');
    // // }])->find($tagId);

    // $categoryId = 2;

    // $result = Category::with(['posts' => function ($q) {
    //     // only fetch the posts with tags and only the id and title columns
    //     $q->select('posts.id', 'posts.title', 'posts.category_id');
    // }])->find($categoryId);

    // $categories = Category::select('id', 'title')->orderBy('title')->get();

    // $mostPopularCategories = Category::select('id', 'title')
    //     ->withCount('comments')
    //     ->orderBy('comments_count', 'desc')
    //     ->take(3)->get();

    // $tags = Tag::select('id', 'name')->orderByDesc(
    //     DB::table(
    //         'post_tag'
    //     )
    //         ->selectRaw('count(tag_id) as tag_count')
    //         ->whereColumn('tags.id', 'post_tag.tag_id')
    //         ->orderBy('tag_count', 'desc')
    //         ->limit(1)
    // )->get();
    // /* get all the tags by id and name, order descending by tag count 
    // we count the same tag name by using the where column constraint, where the id column 
    // of the tags table is the same as the tag id column in the post_tag pivot table  */

    // $latestPosts = Post::select('id', 'title')->latest()->take(5)->withCount('comments')->get();

    // $mostPopularPosts = Post::select('id', 'title')->orderByDesc(
    //     Comment::selectRaw('count(post_id) as comment_count')
    //         // where post id column is the same as post id on the comments table
    //         ->whereColumn('posts.id', 'comments.post_id')
    //         ->orderBy('comment_count', 'desc')
    //         ->limit(1)
    // )->take(5)->withCount('comments')->get();

    // $posts = Post::select('id', 'title', 'content')->get();

    // $comments = Comment::select('id', 'content')->get();

    // $mostActiveUsers = User::select('id', 'name')->orderByDesc(
    //     Post::selectRaw('count(user_id) as post_count')
    //         ->whereColumn('user_id', 'posts.user_id')
    //         ->orderBy('post_count', 'desc')
    //         ->limit(1)
    // )->take(5)->withCount('posts')->get();

    // dump($query);

    return view('welcome');
});
