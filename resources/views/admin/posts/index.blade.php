@extends('layouts.admin')


@section('content')
   <div class="section-header">
      <h1>Posts <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-primary">Create</a></h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
         <div class="breadcrumb-item active">Posts</div>
      </div>
   </div>

  <div class="section-body">
    <h2 class="section-title">Posts</h2>
    <p class="section-lead">You can manage Post here</p>
    <div class="row">
      <div class="col-12">
          <div class="card">
              <div class="card-header">
                <h4>All Posts</h4>
              </div>
              <div class="card-body">
                <div class="float-left">
                  <select class="form-control selectric" tabindex="-1">
                    <option>Action For Selected</option>
                    <option>Move to Draft</option>
                    <option>Move to Pending</option>
                    <option>Delete Pemanently</option>
                  </select>
                </div>
                <div class="float-right">
                  <form>
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Search">
                      <div class="input-group-append">                                            
                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                      </div>
                    </div>
                  </form>
                </div>

                <div class="clearfix mb-3"></div>

                <div class="table-responsive">
                  <table class="table table-striped">
                    <tbody><tr>
                      <th class="text-center pt-2">
                        <div class="custom-checkbox custom-checkbox-table custom-control">
                          <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                          <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                        </div>
                      </th>
                      <th>Title</th>
                      <th>Category</th>
                      <th>Author</th>
                      <th>Comments</th>
                      <th>Created At</th>
                      <th>Status</th>
                    </tr>
                    @foreach ($posts as $post)
                    <tr>
                      <td>
                        <div class="custom-checkbox custom-control">
                          <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-2">
                          <label for="checkbox-2" class="custom-control-label">&nbsp;</label>
                        </div>
                      </td>
                      <td>{{$post->title}}
                        <div class="table-links">
                          <a href="{{ route('admin.posts.show', $post->id)}}">View</a>
                          <div class="bullet"></div>
                          <a href="{{ route('admin.posts.edit', $post->id)}}">Edit</a>
                          {{-- <div class="bullet"></div>
                          <a href="#" class="text-danger">Trash</a> --}}
                        </div>
                      </td>
                      <td>
                        <a href="#">Web Developer</a>, 
                        <a href="#">Tutorial</a>
                      </td>
                      <td>
                        <a href="#">
                          <img alt="image" src="{{$post->owner->gravatar()}}" class="rounded-circle" width="35" data-toggle="title" title=""> <div class="d-inline-block ml-1">{{$post->owner->name}}</div>
                        </a>
                      </td>
                      <td><span class="badge badge-light">{{ $post->comments->count()}}</span> comments</td>
                      <td>{{ $post->lastUpdate() }}</td>
                      <td><div class="badge badge-primary">Published</div></td>
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
