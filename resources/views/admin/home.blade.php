@extends('layouts.admin')

@section('content')
   <div class="section-header">
      <h1>Blank Page</h1>
   </div>

   <div class="section-body">
      <div class="row">
         <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
               <div class="card-icon bg-primary">
                  <i class="far fa-user"></i>
               </div>
               <div class="card-wrap">
                  <div class="card-header">
                     <h4>Total Admin</h4>
                  </div>
                  <div class="card-body">
                        {{$count['users']}}
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
               <div class="card-icon bg-danger">
                  <i class="far fa-newspaper"></i>
               </div>
               <div class="card-wrap">
                  <div class="card-header">
                     <h4>Posts</h4>
                  </div>
                  <div class="card-body">
                     {{$count['posts']}}
                  </div>   
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
               <div class="card-icon bg-warning">
                  <i class="far fa-file"></i>
               </div>
               <div class="card-wrap">
                  <div class="card-header">
                     <h4>Reports</h4>
                  </div>
                  <div class="card-body">
                     1,201
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
               <div class="card-icon bg-success">
                  <i class="fas fa-circle"></i>
               </div>
               <div class="card-wrap">
                  <div class="card-header">
                     <h4>Online Users</h4>
                  </div>
                  <div class="card-body">
                     47
                  </div>
               </div>
            </div>
         </div>
      </div>


      <div class="col-lg-7 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>Latest Posts</h4>
                <div class="card-header-action">
                  <a href="#" class="btn btn-primary">View All ({{$count['posts']}})</a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                       @forelse($posts as $post)
                      <tr>
                        <td>
                          {{ $post->title}}
                          <div class="table-links">
                            in <a href="#">Web Development</a>
                            <div class="bullet"></div>
                           <a href="{{ $post->path() }}" target='_blank'>View</a>
                          </div>
                        </td>
                        <td>
                        <a href="#" class="font-weight-600"><img src="../assets/img/avatar/avatar-1.png" alt="avatar" width="30" class="rounded-circle mr-1">{{ $post->owner->name }}</a>
                        </td>
                        <td>
                          <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger btn-action trigger--fire-modal-1" data-toggle="tooltip" title="" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')" data-original-title="Delete"><i class="fas fa-trash"></i></a>
                        </td>
                      </tr>
                      @empty
                           No posts yet
                      @endforelse
                      
                      
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
   </div>  

@endsection
