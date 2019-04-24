@extends('layouts.admin')

@section('content')
   <div class="section-header">
      <h1>Users</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
         <div class="breadcrumb-item active">Users</div>
      </div>
   </div>

   <div class="section-body">
      

      <div class="row">
            
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                  @include('admin.components.cards.users_full')
            </div>
      </div>
   </div>  

@endsection
