@extends('layouts.admin')


@section('content')
   <div class="section-header">
      <h1>Posts <a href="{{ route('admin.posts.edit', $post->id)}}" class="btn btn-sm btn-primary">Edit</a></h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
         <div class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Posts</a></div>
         <div class="breadcrumb-item active">{{$post->title }}</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">{{$post->title}}</h2>
      <p class="section-lead">You can manage Post here</p>
      <div class="row">
            <div class="col-12">
                  <div class="card">
                     <div class="card-body">
                           {!! $post->body !!}
                     </div>
                  </div>
            </div>
      </div>
   </div>  

@endsection
