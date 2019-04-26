@extends('layouts.admin')
@push('styles')
    <link href='{{ asset('css/medium-editor.css') }}' rel='stylesheet'>
@endpush

@section('content')
   <div class="section-header">
      <h1>Permissions</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
         <div class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></div>
         <div class="breadcrumb-item active">Create permission</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Create permissions</h2>
      <p class="section-lead">Create sopmthing amazing</p>
      <div class="row">
            <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      <h4>Create the permissions</h4>
                      <div class="card-header-action">
                        <a class="align-right btn btn-danger btn-sm" href="{{ route('admin.roles.index') }}">Cancel</a>
                      </div>
                    </div>
                    <form action="{{ route('admin.permissions.store') }}" method="POST">
                        @csrf
                    <div class="card-body">
                           @inputLine(['type'=>'text','name'=>"model", 'label' => 'Model name'])    
                    </div>
                    <div class="card-footer text-left">
                       <div class="row justify-content-md-center">
                          <div class=" col col-md-6">
                              <button type="submit" class="btn btn-primary">Create post</button>
                          </div>
                       </div>
                     </div>
                  </form>
                  </div>
                </div>
      </div>
   </div>  

@endsection
