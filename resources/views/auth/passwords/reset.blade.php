{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
@extends('layouts.app')
@section('title', {{ __('Reset Password') }})
    
@section('content')
   

<div class="container">
        <form class="form" method="POST" action="{{ route('password.update') }}">
            <h2>{{ __('Reset Password') }}</h2>
            @csrf
                <fieldset>
                    <input type="hidden" name="token" value="{{ $token }}">


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

                    <div class="form-control">
                            <label for="nameField">{{ __('Confirm Password') }}</label>
                            <input type="password" id="password-confirm" name="password-confirm" class="{{ $errors->has('password-confirm') ? ' is-invalid' : '' }}">
                            @if ($errors->has('password-confirm'))
                                <span class="invalid-feedback" role="alert">
                                    <span>{{ $errors->first('password-confirm') }}</span>
                                </span>
                            @endif
                        </div>

                   <div class="form-actions">

                        <div class="form-actions-left">
                            <input class="button-primary" type="submit" value="{{ __('Reset Password') }}">
                        </div>
                               
                   </div> 
                  
                </fieldset>
        </form>
</div>

@endsection
