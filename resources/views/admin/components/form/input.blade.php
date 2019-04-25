@empty($type)
   @php
      $type = 'text'; 
   @endphp
@endempty

<div class="form-group col-sm-12 col-md-{{ $size ?? 6}} col-12">
      <label class="{{ $label_class ?? ""}}">{{ $label ?? ucfirst($name)}}</label>
        
      @if($type == "textarea")
            
         <textarea type="textarea" class="form-control {{ $errors->has($name) ? ' is-invalid' : '' }}" name="{{$name}}">{{ $value}}</textarea>
      
      @elseif($type == "checkbox")

            @foreach ($model as $m)
               <div class="custom-control custom-checkbox" style="display:inline;">
                     <input name="{{$name}}" {{ $value->contains($m) ? 'checked' : "" }} 
                     class="custom-control-input" 
                     type="checkbox" 
                     id="role.{{$m->name}}" 
                     value="{{ $m->slug }}" >
                     <label  class="custom-control-label"  
                           for="role.{{$m->name}}" 
                           {{ ! $loop->last ? "style=margin-right:15px" : ''}}> 
                           {{$m->name}}
                  </label>
               </div>
            @endforeach
            @error('roles')
                  <span class="invalid-feedback">{{ $message }}</span>
            @enderror

         @elseif($type == "radio")
         <div>
               <label class="custom-switch mt-2" style="padding-left: 0">
                 <input type="checkbox" name="{{$name}}" {{ $value ? "checked" : "" }} class="custom-switch-input" data-com.agilebits.onepassword.user-edited="yes">
                 <span class="custom-switch-indicator"></span>
                 <span class="custom-switch-description">I agree with terms and conditions</span>
               </label>
         </div>
         @else

            <input value="{{ $value}}" type="{{ $type ?? 'text' }}" class="form-control {{ $input_class ?? '' }} {{ $errors->has($name) ? ' is-invalid' : '' }}" name="{{$name}}">

         @endif
         
         @error($name)
            <span class="invalid-feedback">{{ $message }}</span>
         @enderror

      
   </div>