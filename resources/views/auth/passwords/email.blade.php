@extends('layouts.app')
@section('title',  __('Reset Password')  )

@section('content')


<div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form class="form" method="POST" action="{{ route('password.email') }}">
            <h2>{{ __('Reset Password') }}</h2>
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

                   <div class="form-actions">
                        <div class="form-actions-left">
                            <input class="button-primary" type="submit" value="{{ __('Login') }}">
                        </div>
                   </div> 
                  
                 
                </fieldset>
        </form>
</div>
@endsection
