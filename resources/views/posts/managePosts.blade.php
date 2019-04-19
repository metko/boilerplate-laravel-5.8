@extends('layouts.app')
@section('title', 'Blog' )

@section('content')
   <div class="hero">
      <div class="container-nm">
         <h1>My posts</h1>
         <a href="{{ route('posts.create') }}" class="button-small">Create</a>
      </div>
   </div>

   <div class="container">
      @forelse($posts as $post)
         <article>
            <h2>{{$post->title}}  <span class="name"><strong> - {{$post->owner->name}}</strong></span> </h2>
            <p>{{ $post->excerpt() }}</p>
            <p>Created at: {{ $post->created_at->format('d/m/Y')}}</p>
            <a href="{{ $post->path() }}" class="button-small">See</a>
            <form action="{{ route('posts.destroy' , $post->id) }}" method='POST' style="display:inline">
                  @method('DELETE')
                  @csrf
                  <button type='submit' href="{{ $post->path() }}" class="button-small-outline">Delete</button>
            </form>
            
         </article>
         <hr>
         
      @empty   
         <h2>No posts for the moments</h2>
         <a href="{{ route('posts.create') }}" class="button-small">Create one</a>
      @endforelse
   </div>
  
@endsection