<div class="card">
      <div class="card-header">
         <h4>Latest Users</h4>
         <div class="card-header-action">
            <a href="#" class="btn btn-outline-danger">Create</a>
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
               <th>Action</th>
               </tr>
            </thead>
            <tbody>
               @forelse($users as $user)
               <tr>
               <td>
                  {{ $user->name}}
                  <div class="table-links">
                  <a href="#" target='_blank'>View</a>
                  </div>
               </td>
               <td>
               <a href="#" class="font-weight-600"><img src="{{ $user->gravatar() }}" alt="avatar" width="30" class="rounded-circle mr-1">{{ $user->name }}</a>
               </td>
               <td>
                  <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fas fa-pencil-alt"></i></a>
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
   