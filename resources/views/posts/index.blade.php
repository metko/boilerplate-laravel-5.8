@extends('layouts.app')
@section('title', 'Blog' )

@section('content')
   <div class="hero">
      <div class="container-nm">
         <h1>Blog</h1>
      </div>
   </div>

   <div class="container">
      @forelse($posts as $post)
         <article>
            <h2>{{$post->title}}</h2>
            <p>{{ $post->excerpt() }}</p>
            <a href="{{ $post->path() }}" class="button-small">Read more</a>
         </article>
         <hr>
         
      @empty   
         <h2>No posts for the moments</h2>
      @endforelse
   </div>
  
@endsection