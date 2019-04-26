@extends('layouts.admin')


@section('content')
   <div class="section-header">
      <h1>Roles <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-primary">Create</a></h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
         <div class="breadcrumb-item active">Roles</div>
      </div>
   </div>

  <div class="section-body">
   <h2 class="section-title">Role {{ $role->name }}</h2>
    <p class="section-lead">You can attributes permissions to this role</p>
    <div class="row">
      <div class="col-12">
          <div class="card">
              <div class="card-header">
                <h4>Roles</h4>
              </div>
              <form action="{{ route('admin.permissions.update', $role->id ) }}" method="POST">
               @csrf
               @method('PATCH')
              <div class="card-body">
                <div class="float-right">
                  
                </div>

                <div class="clearfix mb-3"></div>

                <div class="table-responsive">
                  <table class="table table-striped">
                    <tbody><tr>
                      <th>Model</th>
                      <th>All</th>
                      <th>View</th>
                      <th>Create</th>
                      <th>Update</th>
                      <th>Delete</th>
                      
                    </tr>
                   
                    @foreach ($arr as $model => $actions)
                    <tr>
                        <td><strong>{{ $model }}</strong></td>
                        <td>
                             <div class="form-group mb-0 col-12">
                                <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="{{$model}}.all" class="custom-control-input" id="all" data-com.agilebits.onepassword.user-edited="yes">
                                   <label class="custom-control-label" for="all"></label> 
                                </div>
                             </div>
                        </td>
                        @foreach ($actions as $id)
                        <td>
                              <div class="form-group mb-0 col-12">
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="permissions[{{$id}}]" value='1'
                                     {{$role->permissions->contains('id', $id) ? "checked" : "" }} 
                                     class="custom-control-input" id="{{ $model."[".$id."]" }}" 
                                     {{ $role->permissions->contains('slug', 'post.view' ? "disabled checked" : "")}}
                                     data-com.agilebits.onepassword.user-edited="yes">
                                    <label class="custom-control-label" for="{{ $model."[".$id."]" }}"></label> 
                                 </div>
                              </div>
                         </td> 
                        @endforeach
                        
                      </tr>
                    @endforeach
                     
                  </tbody>
               </table>
                </div>
                <div class="">
                  <button type="submit" class="btn btn-primary" href="">Edit</button>
                </div>
              </div>
            </form>
            </div> 
      </div>
    </div>
  </div>  

@endsection
