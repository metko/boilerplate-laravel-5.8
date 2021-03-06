<div class="card">
      <div class="card-header">
         <h4>Latest Users</h4>
         <div class="card-header-action">
            <a href="{{ route('admin.users.create') }}" class="btn btn-outline-danger">Create</a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">View All ({{$count['users']}})</a>
         </div>
      </div>
      <div class="card-body p-0">
         <div class="table-responsive">
         <table class="table table-striped mb-0">
            <thead>
               <tr>
               <th>Name</th>
               <th>Email</th>
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
                     {{ $user->email}}
               </td>
               <td>
    
                  <div class="btn-group mb-3 btn-group-sm" role="group" aria-label="Basic example">
                        <a href="{{route('admin.users.show', $user->id)}}"  class="btn btn-primary">Show</a>
                        <a href="{{route('admin.users.edit', $user->id)}}"  class="btn btn-info">Edit</a>
                      </div>
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
   