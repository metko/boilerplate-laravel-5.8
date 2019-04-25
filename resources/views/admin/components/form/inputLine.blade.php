@if ($type == 'text')
      <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ $label ?? $name }}</label>
            <div class="col-sm-12 col-md-7">
                  <input type="{{ $type ?? "text" }}" value="{{ $value ?? old($name) }}" name="{{$name}}"class="form-control">
                  @error($name)
                        <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
            </div>
            
      </div>   
@elseif($type == 'textarea')
      <div class="form-group mb-4 row">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{$label}}</label>
            <div class="col-sm-12 col-md-7">
                  <textarea id="medium-editor" type="{{ $type ?? "text" }}" name="{{$name}}"class="">{{ $value ?? old($name) }}</textarea>
                  @error($name)
                        <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
            </div>
      </div>
@else

@endif