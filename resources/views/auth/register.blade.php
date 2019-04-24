@extends('layouts.app')
@section('title',  __('Register') )

@section('content')


<div class="container">
        @include('flash')
        <form class="form" method="POST" action="{{ route('register') }}">
            <h2>{{ __('Register') }}</h2>
            @csrf
                <fieldset>

                    <div class="form-control">
                        <label for="nameField">{{ __('Name') }}</label>
                        <input value='{{ old('name') }}' type="text" id="name" name="name" class="{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <span>{{ $errors->first('name') }}</span>
                            </span>
                        @endif
                    </div>

                    <div class="form-control">
                        <label for="nameField">{{ __('E-Mail Address') }}</label>
                        <input type="email" value='{{ old('email') }}' id="email" name="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}">
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
                        <input type="password" id="password-confirm" name="password_confirmation" class="{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                        @if ($errors->has('password_confirmation'))
                            <span class="invalid-feedback" role="alert">
                                <span>{{ $errors->first('password_confirmation') }}</span>
                            </span>
                        @endif
                    </div>

                   <div class="form-actions">

                        <div class="form-actions-left">
                            <input class="button-primary" type="submit" value="{{ __('Register') }}">
                        </div>          
                   </div>       
                </fieldset>
        </form>
</div>
@endsection
