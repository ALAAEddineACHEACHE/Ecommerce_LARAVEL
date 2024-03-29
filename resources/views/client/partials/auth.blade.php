  <!-- Authentication Links -->

  <ul>
      @guest

          @if (Route::has('login'))
              <li class="nav-item">
                  <a title="se connecter" class="nav-link"
                      href="{{ route('login') }}">{{ __('S\'identifier') }}</a>
              </li>
          @endif

          @if (Route::has('register'))
              <li class="nav-item">
                  <a title="s'enregistrer pour un nouveau compte" class="nav-link"
                      href="{{ route('register') }}">{{ __('S\'inscrire') }}</a>
              </li>

          @endif

      @else

          <li class="nav-item">
              <a title="Se déconnecter" class="nav-link" href="{{ route('logout') }}" onclick="logout();">
                  {{ __('Se déconnecter') }}
                  @include('client.partials.logoutscript')
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
          </li>
          <li class="nav-item">
              <a title="mes commandes" class="nav-link" href="{{ route('myorders') }}">Mes commandes
              </a>
          </li>
      </ul>

  @endguest
