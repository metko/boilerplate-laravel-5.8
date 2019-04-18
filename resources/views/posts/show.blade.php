@extends('layouts.app')
@section('title', $post->title )

@section('content')

      <div class="hero">
            <div class="container-nm">
                  <h1>{{$post->title}}</h1>
            </div>
      </div>

      <div class="container">
            <p>{{$post->body}}</p>
            <hr>
            <h3>Comments</h3>
            @forelse ($post->comments as $comment)
                  <div class="card">
                        <p> {{ $comment->body}}</p>
                        By: {{ $comment->owner->name}}
                  </div>
            @empty
                  <h3>0 comments for the moments</h3>
            @endforelse
      </div>
     
@endsection