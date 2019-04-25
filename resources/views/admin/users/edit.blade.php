@extends('layouts.admin')

@section('content')
   <div class="section-header">
      <h1>Users</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
         <div class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></div>
         <div class="breadcrumb-item active">Edit</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Edit users {{ $user->name }}</h2>
      <p class="section-lead">You can edit the attributes of the user here</p>
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
                        <div class="card-footer text-center">
                           <div class="btn-group">
                                 <a class="btn btn-sm btn-primary" href="{{ route('admin.users.show', $user->id) }}">Profile</a>
                                 <a class="btn btn-sm btn-info" href="{{ route('admin.users.update.password', $user->id) }}">Update password</a>
                                 <form action="{{ route('admin.users.desactivate', $user->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-warning">Desactivate</button>
                                 </form>
                                 <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger btn-inline">Delete</button>
                                 </form>
                           </div>      
                        </div> 
                     </div>
            </div>
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
               <div class="card">
                     <div class="card-header">
                        <h4>Input Text</h4>
                     </div>
                     <form action="{{ route('admin.users.update', $user->id) }}" method='POST'>
                        @method('PATCH')
                        @csrf
                        <div class="card-body">
                           <div class="row">
                                 @input(['label'=>'Name', 'name' => 'name', 'value' => $user->name])
                                 @input(['label'=>'Email', 'name' => 'email', 'value' => $user->email, "type" => "email"])
                           </div>
                           <div class="row">
                                 @input(['label'=>'First name', 'name' => 'first_name', 'value' => $user->profile->first_name])
                                 @input(['label'=>'Last name', 'name' => 'last_name', 'value' => $user->profile->last_name])
                           </div>
                           <div class="row">
                                 @input(['label'=>'Location', 'name' => 'location', 'value' => $user->profile->location])
                                 @input(['label'=>'Bio', 'name' => 'bio', 'value' => $user->profile->bio, 'type' => 'textarea'])
                           </div>
                           <div class="row">
                                 @input(['label' => "Role", 'name' => 'roles[]', 'value' => $user->roles, 'model' => $roles, 'type' => 'checkbox', "label_class" => "d-block", 'size' => 12]) 
                           </div>

                           </div>
                        <div class="card-footer text-left">
                              <button type="submit" class="btn btn-primary">Submit</button>
                           </div>
                     </form>
               </div>
            </div>
      </div>
   </div>  

@endsection
