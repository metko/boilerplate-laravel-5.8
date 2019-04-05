@extends('layouts.app')
@section('title',  __('Login')  )

@section('content')
   

<div class="container">
        <form class="form" method="POST" action="{{ route('login') }}">
            <h2>{{ __('Login') }} </h2>
            @csrf
                <fieldset>

                    <div class="form-control">
                        <label for="nameField">{{ __('E-Mail Address') }}</label>
                        <input type="email" id="email" name="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}">
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <span>{{ $errors->first('email') }}</span>
                            </span>
                        @endif
                    </div>

                    <div class="form-control">
                        <label for="nameField">{{ __('Password') }}</label>
                        <input type="password" id="password" name="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}">
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <span>{{ $errors->first('password') }}</span>
                            </span>
                        @endif
                    </div>

                   <div class="form-actions">

                        <div class="form-actions-left">
                            <input class="button-primary" type="submit" value="{{ __('Login') }}">
                        </div>

                        <div class="form-actions-right">
                            <input  type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="label-inline" for="confirmField"> {{ __('Remember Me') }}</label>
                        </div>
                               
                   </div> 
                  
                  @if (Route::has('password.request'))
                    <hr>
                    <div class="text-center">
                            <a class="button-small button-clear" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                            </a>
                    </div>
                    
                 @endif
                </fieldset>
        </form>
</div>

@endsection
