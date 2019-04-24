<div class="card">
      <div class="card-header">
         <h4>All Users</h4>
         <div class="card-header-action">
            <a href="{{ route('admin.users.create') }}" class="btn btn-outline-danger">Create</a>
            <a href="#" class="btn btn-primary">View All ({{$count['users']}})</a>
         </div>
      </div>
      <div class="card-body p-0">
         <div class="table-responsive">
         <table class="table table-striped mb-0">
            <thead>
               <tr>
               <th>Name</th>
               <th>Email</th>
               <th>Role</th>
               <th>Action</th>
               </tr>
            </thead>
            <tbody>
               @forelse($users as $user)
               <tr>
               <td>
                  <a href="#" class="font-weight-600"><img src="{{ $user->gravatar() }}" alt="avatar" width="30" class="rounded-circle mr-1">{{ $user->name }}</a>
               </td>
               <td>
                     {{$user->email}}
               </td>
               <td>
                     @include('admin.partials.roles')
               </td>
               <td>
                  <a href="" class="btn btn-info btn-action mr-1" data-toggle="tooltip" title="" data-original-title="See">
                     <i class="fas fa-user-alt"></i>
                  </a>
                  <a href="{{ route('admin.users.edit', $user->id)}}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="" data-original-title="Edit">
                     <i class="fas fa-pencil-alt"></i>
                  </a>
                  <a class="btn btn-danger btn-action trigger--fire-modal-1" data-toggle="tooltip" title="" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')" data-original-title="Delete"><i class="fas fa-trash"></i></a>
               </td>
               </tr>
               @empty
                  No User yet
               @endforelse
               
               
               
            </tbody>
         </table>
         </div>
      </div>
   </div>
   