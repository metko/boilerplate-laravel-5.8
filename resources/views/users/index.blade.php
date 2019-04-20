@extends('layouts.app')
@section('title', 'Profil' )

@section('content')
   <div class="hero">
      <div class="container-nm">
         <h1>Profil</h1>
      </div>
   </div>

   <div class="container">
         <div class="row">
               <div class="column column-25">
                  @include('users.sidebar', ['active' => 'informations'])
               </div>
               <div class="column column-75">
                  <div>
                     <strong>Username : </strong> {{ $user->name }}
                  </div>
                  <div>
                     <strong>First name : </strong> {{ $user->profile->first_name }}
                  </div>
                  <div>
                     <strong>Last name : </strong> {{ $user->profile->last_name }}
                  </div>
                  <div>
                     <strong>Localization : </strong> {{ $user->profile->location }}
                  </div>
                  <div>
                     <strong>Bio : </strong> {{ $user->profile->bio }}
                  </div>
                  <a href="{{ route('profile.edit') }}" class="button" style='margin-top: 10px'>Edit profile</a>
               </div>  
   </div>
  
@endsection