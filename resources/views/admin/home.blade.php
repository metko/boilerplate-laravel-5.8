@extends('layouts.admin')

@section('content')
   <div class="section-header">
      <h1>Dashboard</h1>
      <div class="section-header-breadcrumb">
         {{-- <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
         <div class="breadcrumb-item"><a href="#">Parent Page</a></div> --}}
         <div class="breadcrumb-item">Dashboard</div>
      </div>
   </div>

   <div class="section-body">
      @include('admin.components.cards.infos')

      <div class="row">
            <div class="col-lg-7 col-md-12 col-12 col-sm-12">
                  @include('admin.components.cards.posts')
               </div>
               <div class="col-lg-5 col-md-12 col-12 col-sm-12">
                     @include('admin.components.cards.users')
               </div>
      </div>
   </div>  

@endsection
