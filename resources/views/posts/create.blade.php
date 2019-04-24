@extends('layouts.app')
@section('title', 'Create post' )

@section('content')

      
<div class="container">
      <form class="form" method="POST" action="{{ route('posts.store') }}">
          <h2>{{ __('Create post') }} </h2>
          @csrf
              <fieldset>

                  <div class="form-control">
                      <label for="nameField">{{ __('Title') }}</label>
                      <input value='{{ old('title') }}' type="text" id="title" name="title" class="{{ $errors->has('title') ? ' is-invalid' : '' }}">
                      @if ($errors->has('title'))
                          <span class="invalid-feedback" role="alert">
                              <span>{{ $errors->first('title') }}</span>
                          </span>
                      @endif
                  </div>

                  <div class="form-control">
                      <label for="nameField">{{ __('Content') }}</label>
                        <textarea name="body" id="" cols="30" rows="10" class="{{ $errors->has('title') ? ' is-invalid' : '' }}"> {{ old('body') }}</textarea>     
                        @if ($errors->has('body'))
                           <span class="invalid-feedback" role="alert">
                                 <span>{{ $errors->first('body') }}</span>
                           </span>
                        @endif
                  </div>

                 <div class="form-actions">

                      <div class="form-actions-left">
                          <input class="button-primary" type="submit" value="{{ __('Save') }}">
                      </div>

                      
                             
                 </div> 
              </fieldset>
      </form>
</div>

@endsection