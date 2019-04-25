@extends('layouts.admin')

@section('content')
   <div class="section-header">
      <h1>Users       <a class="btn btn-primary btn-sm" href="{{ route('admin.users.edit', $user->id) }}">Edit</a></h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
         <div class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></div>
         <div class="breadcrumb-item active">{{ $user->name }}</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Users {{ $user->name }}</h2>
      <p class="section-lead">Information about user</p>

      <div class="row">
            
            <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                  <div class="card profile-widget">
                        <div class="profile-widget-header">
                           <img alt="image" src="{{$user->gravatar()}}" class="rounded-circle profile-widget-picture">
                           <div class="profile-widget-items">
                              <div class="profile-widget-item">
                              <div class="profile-widget-item-label">Posts</div>
                              <div class="profile-widget-item-value">{{$user->posts->count()}}</div>
                              </div>
                              <div class="profile-widget-item">
                              <div class="profile-widget-item-label">Comments</div>
                              <div class="profile-widget-item-value">{{$user->comments->count()}}</div>
                              </div>
                              <div class="profile-widget-item">
                              <div class="profile-widget-item-label">Following</div>
                              <div class="profile-widget-item-value">2,1K</div>
                              </div>
                           </div>
                        </div>
                        <div class="profile-widget-description">
                           <div class="profile-widget-name">{{$user->name}} <div class="text-muted d-inline font-weight-normal"><div class="slash"></div> Web developer</div></div>
                           Ujang maman is a superhero name in <b>Indonesia</b>, especially in my family. He is not a fictional character but an original hero in my family, a hero for his children and for his wife. So, I use the name as a user in this template. Not a tribute, I'm just bored with <b>'John Doe'</b>.
                        </div>
                           
                  </div>
            </div>
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                  <div class="card">
                        <div class="card-header">
                          <h4>Latest user's posts </h4>
                        </div>
                        <div class="card-body">
                          <ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder">
                           @forelse ($user->posts as $post)
                           <li class="media">
                                 <img alt="image" class="mr-3 rounded-circle" width="50" src="{{ $user->gravatar() }}">
                                 <div class="media-body mt-3 "style="flex: .4">
                                    <div class="text-job">{{ $post->title }}</div>
                                 </div>
                                 <div class="media-progressbar" >
                                   <div class="progress-text">{{ $post->body }}</div>
                                   
                                 </div>
                                 <div class="media-cta">
                                    <a href="{{ $post->path('admin') }}" class="btn btn-sm btn-outline-primary">See</a>
                                   <a href="#" class="btn btn-sm btn-outline-info">Edit</a>
                                   <a href="#" class="btn btn-sm btn-outline-danger">Delete</a>
                                 </div>
                               </li>
                           @empty
                              <li class="media">
                                    <p>0 posts yet.</p>
                              </li>
                           @endforelse
                           
                            
                          </ul>
                        </div>
                  </div>
                  <div class="card">
                        <div class="card-header">
                          <h4>Latest user's comments </h4>
                        </div>
                        <div class="card-body">
                          <ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder">
                           @forelse ($user->comments as $comment)
                           <li class="media">
                                 <div class="media-body mt-3 "style="flex: .4">
                                    <div class="text-job">{{ $comment->post->title }}</div>
                                 </div>
                                 <div class="media-progressbar" >
                                   <div class="progress-text">{{$comment->body }}</div>
                                 </div>
                                 <div class="media-cta">
                                   <a href="#" class="btn btn-sm btn-info">Edit</a>
                                   <a href="#" class="btn btn-sm btn-danger">Edit</a>
                                 </div>
                               </li>
                           @empty
                              <li class="media">
                                    <p>0 posts yet.</p>
                              </li>
                           @endforelse
                           
                            
                          </ul>
                        </div>
                  </div>
            </div>


      </div>
   </div>  

@endsection
