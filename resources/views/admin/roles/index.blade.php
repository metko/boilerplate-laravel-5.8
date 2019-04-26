@extends('layouts.admin')


@section('content')
   <div class="section-header">
      <h1>Roles 
        <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-primary">Create</a>
        <a href="{{ route('admin.permissions.create') }}" class="btn btn-sm btn-info">Create Permissions</a>
      </h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
         <div class="breadcrumb-item active">Roles</div>
      </div>
   </div>

  <div class="section-body">
    <h2 class="section-title">Posts</h2>
    <p class="section-lead">You can manage Post here</p>
    <div class="row">
      <div class="col-12">
          <div class="card">
              <div class="card-header">
                <h4>All Roles</h4>
              </div>
              <div class="card-body">
                <div class="float-right">
                  
                </div>

                <div class="clearfix mb-3"></div>

                <div class="table-responsive">
                  <table class="table table-striped">
                    <tbody><tr>
                      <th>Name</th>
                      <th>Level</th>
                      <th>Description</th>
                      <th>Users count</th>
                      <th>Actions</th>
                    </tr>
                    @foreach ($roles as $role)
                    <tr>
                      <td><strong>{{$role->name}}</strong></td>
                      <td><span class="badge badge-{{ $role->getClass() }}">{{ $role->level}}</span></td>
                      <td>{{ $role->description}}</td>
                      <td><span class="badge badge-light">{{ $role->users->count()}}</span> users</td>
                      <td><a href="{{ route('admin.roles.show', $role->id) }}">Edit</a></td>
                    </tr>
                    @endforeach
                    
                    
                    
                  </tbody></table>
                </div>
                <div class="float-right">
                  <nav>
                    <ul class="pagination">
                      <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                          <span aria-hidden="true">«</span>
                          <span class="sr-only">Previous</span>
                        </a>
                      </li>
                      <li class="page-item active">
                        <a class="page-link" href="#">1</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="#">2</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="#">3</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                          <span aria-hidden="true">»</span>
                          <span class="sr-only">Next</span>
                        </a>
                      </li>
                    </ul>
                  </nav>
                </div>
              </div>
            </div> 
      </div>
    </div>
  </div>  

@endsection
