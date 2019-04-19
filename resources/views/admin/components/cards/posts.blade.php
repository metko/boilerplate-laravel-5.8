<div class="card">
   <div class="card-header">
      <h4>Latest Posts</h4>
      <div class="card-header-action">
            <a href="#" class="btn btn-outline-danger">Create</a>
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
            <a href="#" class="font-weight-600"><img src="{{$post->owner->gravatar() }}" alt="avatar" width="30" class="rounded-circle mr-1">{{ $post->owner->name }}</a>
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
