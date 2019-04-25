@extends('layouts.admin')
@push('styles')
    <link href='{{ asset('css/medium-editor.css') }}' rel='stylesheet'>
@endpush

@section('content')
   <div class="section-header">
      <h1>Users</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
         <div class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Post</a></div>
         <div class="breadcrumb-item active">Edit</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Edit posts</h2>
      <p class="section-lead">You can edit the post here</p>
      <div class="row">
            <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      <h4>Edit the post</h4>
                      <div class="card-header-action">
                           <a class="align-right btn btn-danger btn-sm" href="">Delete</a>
                      </div>
                    </div>
                    <form action="{{ route('admin.posts.update', $post->id ) }}" method="POST">
                        @csrf
                        @method('PATCH')
                    <div class="card-body">
                           @inputLine(['type'=>'text','name'=>"title", 'value' => $post->title, 'label' => 'Title'])    
                           @inputLine(['type'=>'textarea', 'name'=>"body", 'value' => $post->body, 'label' => "Body"])    
                    </div>
                    <div class="card-footer text-left">
                       <div class="row justify-content-md-center">
                          <div class=" col col-md-6">
                              <button type="submit" class="btn btn-primary">Edit post</button>
                          </div>
                       </div>
                     </div>
                  </form>
                  </div>
                </div>
      </div>
   </div>  

@endsection
