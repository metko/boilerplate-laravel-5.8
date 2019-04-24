@if (session('success'))
   <div class="card-success">
      {{ session('success') }}
  </div>
@endif

@if (session('error'))
   <div class="card-error">
      {{ session('error') }}
  </div>
@endif

@if (session('warning'))
   <div class="card-warning">
      {{ session('warning') }}
   </div>
@endif

@if (session('info'))
   <div class="acard-info ">
      {{ session('info') }}
   </div>
@endif



