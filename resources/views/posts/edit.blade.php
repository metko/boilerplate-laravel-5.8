@extends('layouts.app')
@section('title', 'Create post' )
@push('style')
    <link href='{{ asset('css/medium-editor.css') }}' rel='stylesheet'>
@endpush

@section('content')

      
<div class="container">
        @include('flash')
      <form class="form" method="POST" action="{{ route('posts.update', $post->id) }}">
          <h2>{{ __('Edit '). $post->title }} </h2>
          @csrf
          @method('PATCH')
              <fieldset>

                  <div class="form-control">
                      <label for="nameField">{{ __('Title') }}</label>
                      <input value='{{ $post->title }}' type="text" id="title" name="title" class="{{ $errors->has('title') ? ' is-invalid' : '' }}">
                      @if ($errors->has('title'))
                          <span class="invalid-feedback" role="alert">
                              <span>{{ $errors->first('title') }}</span>
                          </span>
                      @endif
                  </div>
                  <div class="form-control">
                      <label for="nameField">{{ __('Content') }}</label>
                        <textarea id="medium-editor" name="body" cols="30" rows="10" class="{{ $errors->has('title') ? ' is-invalid' : '' }}"> {{ $post->body }}</textarea>     
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
      <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="margin-top: 10px; display: flex; justify-content:center">
            @csrf
            @method('DELETE')
            <button  type="submit" class="button-small-outline">Delete</button>
    </form>

</div>

@endsection