<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function index()
    {
        PostResource::withoutWrapping();

        return Inertia::render('Page/Article/Index', [
            "posts" => PostResource::collection(Post::latest()->simplePaginate(12)),
        ]);
    }

    public function show(Post $post)
    {
        PostResource::withoutWrapping();

        $post->load([
            'image'
        ]);

        $meta = [
            "title"         => $post->title ?? '',
            "description"   => strip_tags(substr(substr($post->body, 0, 300), 0, strrpos(substr($post->body, 0, 300), ' ')) . '...'),
            "image"         => asset($post->image->url ?? 'images/article.jpg'),
            "url"           => route('article.show', $post->id),
        ];

        $meta_tags = "
        <meta name=\"title\" content=\"{$meta['title']}\" />
        <meta name=\"description\" content=\"{$meta['description']}\" />

        <meta property=\"og:type\" content=\"article\" />
        <meta property=\"og:title\" content=\"{$meta['title']}\" />
        <meta property=\"og:description\" content=\"{$meta['description']}\" />
        <meta property=\"og:image\" content=\"{$meta['image']}\" />
        <meta property=\"og:url\" content=\"{$meta['url']}\" />
        
        ";

        View::composer('app', function ($view) use ($meta, $meta_tags) {
            $view->with('meta', $meta_tags);
        });

        return Inertia::render('Page/Article/Show', [
            "post" => new PostResource($post)
        ]);
    }
}
