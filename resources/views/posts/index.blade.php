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
            <h2>{{$post->title}}  <span class="name"><strong> - {{$post->owner->name}}</strong></span> </h2>
            <p>{{ $post->excerpt() }}</p>
            <p>Created at: {{ $post->created_at->format('d/m/Y')}}</p>
            <a href="{{ $post->path() }}" class="button-small">Read more</a>
            @can('update', $post)
               <a href="{{ route('posts.edit', $post->id) }}" class="button-small">manage</a>
            @endif
         </article>
         <hr>
         
      @empty   
         <h2>No posts for the moments</h2>
      @endforelse
   </div>
  
@endsection