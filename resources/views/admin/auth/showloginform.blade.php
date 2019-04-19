@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="row">
      <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="login-brand">
          <img src="../assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
        </div>

        <div class="card card-primary">
          <div class="card-header"><h4>{{ __('Login') }}</h4></div>

          <div class="card-body">
            <form method="POST" action="{{ route('admin.login') }}" class="needs-validation" novalidate="">
                @csrf
                <div class="form-group">
                <label for="email">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="form-control" value='{{ old('email') }}' name="email" tabindex="1" required autofocus>
                @if ($errors->has('email'))   
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                
              </div>

              <div class="form-group">
                <div class="d-block">
                    <label for="password" class="control-label">{{ __('Password') }}</label>
                    @if (Route::has('password.request'))
                        <div class="float-right">
                            <a href="{{ route('password.request') }}" class="text-small">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    @endif
                </div>
                <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                @if ($errors->has('password'))   
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
              </div>

              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me" {{ old('remember') ? 'checked' : '' }}>
                  <label class="custom-control-label" for="remember-me">{{ __('Remember Me') }}</label>
                </div>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                  Login
                </button>
              </div>
            </form>
            <div class="text-center mt-4 mb-3">
              <div class="text-job text-muted">Login With Social</div>
            </div>
            <div class="row sm-gutters">
              <div class="col-6">
                <a class="btn btn-block btn-social btn-facebook">
                  <span class="fab fa-facebook"></span> Facebook
                </a>
              </div>
              <div class="col-6">
                <a class="btn btn-block btn-social btn-twitter">
                  <span class="fab fa-twitter"></span> Twitter
                </a>
              </div>
            </div>

          </div>
        </div>
        <div class="mt-5 text-muted text-center">
          Don't have an account? <a href="auth-register.html">Create One</a>
        </div>
        <div class="simple-footer">
          Copyright &copy; Stisla 2018
        </div>
      </div>
    </div>
  </div>
@endsection