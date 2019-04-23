<div class="container-nm">
   <nav class="nav">
         <div>
               <strong><a href="{{ route('homepage') }}">{{ config('app.name') }}</a></strong>
         </div>
         <div>
               <ul>
                  <li><a href="{{ route('posts.index') }}">Blog</a></li>
                  @writer
                         <li><a href="{{ route('manage.posts') }}">My posts</a></li>
                  @endwriter
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
                            
                              {{ auth::user()->name }}

                              <a class="" href="{{ route('profile.index') }}">
                                    {{ __('Profil') }}
                              </a>
                              <a class="" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                              </a>

                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                              </form>
                        </li>
                  @endguest
            </ul>
         </div>
      </nav>
</div>
