@extends('layouts.app')

@section('content')
   <div class="container">
      @forelse($posts as $post)
         {{$post->title}}
      @empty   
         <h2>No posts for the moments</h2>
      @endforelse
   </div>
  
@endsection