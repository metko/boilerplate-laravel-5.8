@extends('layouts.app')
@section('title', $post->title )

@section('content')

      <div class="hero">
            <div class="container-nm">
                  <h1>{{$post->title}}</h1>
                  <span> <strong>{{$post->owner->name}}</strong></span>
            </div>
      </div>

      <div class="container">
            <p>{{$post->body}}</p>
            <hr>
            <h3>{{ $post->comments->count() }} comments</h3>
            <div class="comments">
                  @forelse ($post->comments as $comment)
                        <div class="card">
                              <div class="content">
                                    <span class="name">{{ $comment->owner->name}}</span>
                                  
                                    @if (Auth::user()->can('manage', $comment))
                                          <form class="form-edit-comment" action="{{ route('posts.comments.update', $comment->id) }}" method="POST">
                                                @csrf
                                                @method("PATCH")
                                                <textarea name="body" id="body" cols="30" rows="10">{{ $comment->body}}</textarea>
                                                <button type="submit" class="button-small-outline">Update</button>
                                          </form>
                                         
                                    @else
                                          <span class="body">{{ $comment->body}}</span>
                                    @endif
                              </div>
                              @can('manage', $comment)
                                    <div class="actions">
                                          <form class="form-edit-comment" action="{{ route('posts.comments.destroy', $comment->id) }}" method="POST">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="button-small">Delete</button>
                                          </form>
                                          
                                    </div>
                              @endcan
                        </div>
                  @empty
                        <h3>0 comments for the moments</h3>
                  @endforelse
            </div>
            
      </div>
     
@endsection