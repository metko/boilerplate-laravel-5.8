@extends('layouts.app')
@section('title', 'Edit profile' )

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
                  @include('flash')
                  <h3>Edit profile</h3>
                     <form action="{{ route('profile.update') }}" method="POST">
                     @csrf
                     @method('PATCH')
                     <fieldset>

                        <div class="form-control">
                           <label for="nameField">{{ __('Username') }}</label>
                           <input value='{{ $user->name }}' type="text" id="name" name="name" class="{{ $errors->has('name') ? ' is-invalid' : '' }}">
                           @if ($errors->has('name'))
                                 <span class="invalid-feedback" role="alert">
                                    <span>{{ $errors->first('name') }}</span>
                                 </span>
                           @endif
                        </div>

                        <div class="form-control">
                           <label for="nameField">{{ __('Email') }}</label>
                           <input value='{{ $user->email }}' type="text" id="email" name="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}">
                           @if ($errors->has('email'))
                                 <span class="invalid-feedback" role="alert">
                                    <span>{{ $errors->first('email') }}</span>
                                 </span>
                           @endif
                        </div>

                        <div class="form-control">
                              <label for="nameField">{{ __('First name') }}</label>
                              <input value='{{ $user->profile->first_name }}' type="text" id="first_name" name="first_name" class="{{ $errors->has('first_name') ? ' is-invalid' : '' }}">
                              @if ($errors->has('first_name'))
                                    <span class="invalid-feedback" role="alert">
                                       <span>{{ $errors->first('first_name') }}</span>
                                    </span>
                              @endif
                           </div>

                        <div class="form-control">
                              <label for="nameField">{{ __('Last name') }}</label>
                              <input value='{{ $user->profile->last_name }}' type="text" id="last_name" name="last_name" class="{{ $errors->has('last_name') ? ' is-invalid' : '' }}">
                              @if ($errors->has('last_name'))
                                    <span class="invalid-feedback" role="alert">
                                       <span>{{ $errors->first('last_name') }}</span>
                                    </span>
                              @endif
                           </div>

                        <div class="form-control">
                           <label for="nameField">{{ __('Location') }}</label>
                           <input value='{{ $user->profile->location }}' type="text" id="location" name="location" class="{{ $errors->has('location') ? ' is-invalid' : '' }}">
                           @if ($errors->has('location'))
                                 <span class="invalid-feedback" role="alert">
                                    <span>{{ $errors->first('location') }}</span>
                                 </span>
                           @endif
                        </div>
                        <div class="form-control">
                           <label for="nameField">{{ __('Bio') }}</label>
                           <textarea  type="text" id="bio" name="bio" class="{{ $errors->has('bio') ? ' is-invalid' : '' }}">{{ $user->profile->bio }}</textarea>
                           @if ($errors->has('bio'))
                                 <span class="invalid-feedback" role="alert">
                                    <span>{{ $errors->first('bio') }}</span>
                                 </span>
                           @endif
                        </div>

                        <button class="button-small" href="">Update</a>
                     </fieldset>
                     <a href="Delete" class="button-small-outline">Delete Account</a>
                  </form>
               </div>  
   </div>
  
@endsection