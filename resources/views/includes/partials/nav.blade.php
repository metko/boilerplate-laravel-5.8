<div class="container-nm">
   <nav class="nav">
         <div>
               <strong><a href="{{ route('homepage') }}">{{ config('app.name') }}</a></strong>
         </div>
         <div>
               <ul>
                  <li><a href="#">Blog</a></li>
               </ul>
           </div>
            <div class="nav-links-right">
            <ul>
                  @guest
                        <li>
                              <a class="button-small nm" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                              <li>
                                    <a class="button-small-outline nm" href="{{ route('register') }}">{{ __('Register') }}</a>
                              </li>
                        @endif
                  @else
                        <li class="nav-item dropdown">
                              <a >
                                    {{ Auth::user()->name }}
                              </a>

                              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                          @csrf
                                    </form>
                              </div>
                        </li>
                  @endguest
            </ul>
         </div>
      </nav>
</div>
