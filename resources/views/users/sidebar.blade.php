<ul class="sidebar" >
   <li>
      @if($active == 'informations')
      Informations
      @else
         <a href='{{ route('profile.index') }}'>Informations</a>
      @endif
   </li>
   <li>
      @if($active == 'password')
         Password
      @else
         <a href='{{ route('profile.edit.password') }}'>Password</a>
      @endif
   </li>
   <li>
      <a href=""
         onclick="event.preventDefault();
         document.getElementById('logout-form').submit();">
         {{ __('Logout') }}
      </a>  
   </li>

   <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
   </form>
</ul>