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
      </div>
     
@endsection