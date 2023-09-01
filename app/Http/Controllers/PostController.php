<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::query();

        return Inertia::render('Post/Index', [
            'data' => [
                'posts'     => PostResource::collection($posts->paginate()->appends(request()->input())),
                'filters'   => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Post/Create', [
            'data' => $this->data(new Post())
        ]);
    }

    public function store(Request $request)
    {
        $post = Post::create($this->validatedData($request) + [
            'user_id' => Auth::id(),
        ]);

        return redirect()
            ->route('posts.show', $post->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Post $post)
    {
        // return
        $post->load([
            'image',
        ]);

        return Inertia::render('Post/Show', [
            'data' => [
                'post' => $this->formatedData($post)
            ]
        ]);
    }

    public function edit(Post $post)
    {
        return Inertia::render('Post/Edit', [
            'data' => $this->data($post)
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $post->update($this->validatedData($request, $post->id));

        return redirect()
            ->route('posts.show', $post->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($post)
    {
        return [
            'post' => $this->formatedData($post),
        ];
    }

    protected function formatedData($post)
    {
        PostResource::withoutWrapping();

        return new PostResource($post);
    }

    protected function getFilterProperty()
    {
        return [
            //
        ];
    }

    protected function validatedData($request, $id = '')
    {
        return $request->validate([
            'title' => [
                'required',
                'string',
            ],
            'description' => [],
            // 'author_id' => [],
            'body' => [
                'required',
                'string',
            ],
        ]);
    }

}