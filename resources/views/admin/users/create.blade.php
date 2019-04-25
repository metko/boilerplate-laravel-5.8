@extends('layouts.admin')


@section('content')
   <div class="section-header">
      <h1>Users</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
         <div class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></div>
         <div class="breadcrumb-item active">Create</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Create users</h2>
      <p class="section-lead">You can create the creditentials of the new user here</p>
      <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
               <div class="card">
                     <div class="card-header">
                        <h4>User Infos</h4>
                     </div>
                     <form action="{{ route('admin.users.store') }}" method='POST'>
                        @csrf
                        <div class="card-body">
                           <div class="row">
                              @input(['label'=>'Name', 'name' => 'name', 'value' => old('name'), 'size' => '4'])
                              @input(['label'=>'Email', 'name' => 'email', 'value' => old('email'), "type" => "email", 'size' => '8'])
                           </div>
                           <div class="row">
                                 @input(['label'=>'Password', 'name' => 'password', 'value' => old('password'), "type" => "password"])
                                 @input(['label'=>'Confirm password', 'name' => 'password_confirmation', 'value' => old('password_confirmation'), "type" => "password"])
                           </div>
                           <div class="row">
                                 @input(['label' => "Role", 'name' => 'roles[]', 'value' => $user->roles, 'model' => $roles, 'type' => 'checkbox', "label_class" => "d-block"]) 
                                 @input(['label' => "Active", 'name' => 'activated', 'value' => $user->activated,  'type' => 'radio']) 
                           </div>    
                        </div>  
                        <div class="card-header">
                              <h4>User Profile</h4>
                           </div> 
                        <div class="card-body">
                           <div class="row">
                                 @input(['label'=>'First name', 'name' => 'first_name', 'value' => old('first_name') , "size" => 4])
                                 @input(['label'=>'Last Name', 'name' => 'last_name', 'value' => old('last_name'), "size" => 4])
                                 @input(['label'=>'Location', 'name' => 'location', 'value' => old('location'), "size" => 4])
                           </div>
                            <div class="row">
                                 @input(['label'=>'Bio', 'name' => 'bio', 'value' => old('bio'), "type" => "textarea", "size" => 12])   
                            </div>
                        </div>
                           <div class="card-footer text-left">
                                 <button type="submit" class="btn btn-primary">Create user</button>
                           </div> 
                     </form>
               </div>
            </div>
      </div>
   </div>  

@endsection
