@extends('layouts.admin')

@section('content')
   <div class="section-header">
      <h1>Users</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
         <div class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></div>
         <div class="breadcrumb-item active">{{ $user->name }}</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Users {{ $user->name }}</h2>
      <p class="section-lead">Information about user</p>
      <a class="btn btn-primary" href="{{ route('admin.users.edit', $user->id) }}">Edit</a>

      <div class="row">
            
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
               <div class="card">
                     {{ $user->name}}
                  
               </div>
            </div>
      </div>
   </div>  

@endsection
