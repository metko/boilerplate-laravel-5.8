<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $post)
    {	
        return view('posts.show', compact('post'));
    }


    public function create()
    {	
        $this->authorize('create', Post::class);
    }


    public function store(Request $request)
    {   
        $this->authorize('create', Post::class);
        $attributes = request()->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $attributes["owner_id"] = auth()->user()->id;
        $post = Post::create($attributes);
        return redirect($post->path());
    }

    public function update(Post $post){
        $this->authorize('create', Post::class);
        $this->authorize('manage', $post);
        $attributes = request()->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
        $post->update($attributes);
        return redirect($post->path());
        
    }

    public function destroy(Post $post)
    {
        $this->authorize('create', Post::class);
        $this->authorize('manage', $post);

        $post->delete();
        return redirect('/posts');
    }
}
