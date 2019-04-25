@if (session('success'))
   <div class="card-success alert alert-success">
      {{ session('success') }}
  </div>
@endif

@if (session('error'))
   <div class="card-error alert alert-danger">
      {{ session('error') }}
  </div>
@endif

@if (session('warning'))
   <div class="card-warning alert alert-warning">
      {{ session('warning') }}
   </div>
@endif

@if (session('info'))
   <div class="acard-info alert alert-info">
      {{ session('info') }}
   </div>
@endif



