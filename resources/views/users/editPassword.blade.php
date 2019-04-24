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
                  @include('users.sidebar', ['active' => 'password'])
               </div>
               <div class="column column-75">
                  @include('flash')
                  <h3>Edit password</h3>
                     <form action="{{ route('profile.update.password') }}" method="POST">
                     @csrf
                     @method('PATCH')
                     <fieldset>

                        <div class="form-control">
                              <label for="nameField">{{ __('Old password') }}</label>
                              <input  type="password" id="email" name="old_password" class="{{ $errors->has('old_password') ? ' is-invalid' : '' }}">
                              @if ($errors->has('old_password'))
                                    <span class="invalid-feedback" role="alert">
                                       <span>{{ $errors->first('old_password') }}</span>
                                    </span>
                              @endif
                           </div>

                        <div class="form-control">
                           <label for="nameField">{{ __('Password') }}</label>
                           <input  type="password" id="email" name="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}">
                           @if ($errors->has('password'))
                                 <span class="invalid-feedback" role="alert">
                                    <span>{{ $errors->first('password') }}</span>
                                 </span>
                           @endif
                        </div>

                        <div class="form-control">
                              <label for="nameField">{{ __('Password confirmation') }}</label>
                              <input  type="password" id="password_confirmation" name="password_confirmation" class="{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                              @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback" role="alert">
                                       <span>{{ $errors->first('password_confirmation') }}</span>
                                    </span>
                              @endif
                        </div>

                        <button class="button-small" href="">Update</a>
                     </fieldset>
                  </form>
               </div>  
   </div>
  
@endsection