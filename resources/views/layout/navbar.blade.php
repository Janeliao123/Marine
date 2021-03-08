<!-- Navbar -->
<nav class="navbar navbar-default">
    <div class="">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{url('/')}}"><p class="brand-logo">
          <strong>&nbsp;&nbsp;M&nbsp;A&nbsp;R&nbsp;I&nbsp;N&nbsp;&nbsp;E&nbsp;&nbsp;&nbsp;
          </strong></p></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="{{ url('/discussion') }}" >討論區</a></li>
          <li><a href="{{ url('/rank') }}" >排行榜</a></li>
          <li><a href="{{ url('/caculation') }}" >挑戰區</a></li>
          <!-- Authentication Links -->
          @if (Auth::guard('admin')->guest() && Auth::guest())
            <li><a class="nav-link" href="{{ route('login') }}">{{ __('學生登入') }}</a></li>
            <li><a class="nav-link" href="{{ route('admin.login') }}">{{ __('教師登入') }}</a></li>
          @elseif(Auth::guard('admin')->check())
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                     {{ Auth::guard('admin')->user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ url('/admin') }}">
                      {{ __('後臺管理') }}
                  </a>
                  <br>

                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('登出') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
          @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ url('/userpage') }}">
                      {{ __('個人頁面') }}
                  </a>
                  <br>
                  <a class="dropdown-item" href="{{ url('/userhw') }}">
                      {{ __('作業專區') }}
                  </a>
                  <br>

                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('登出') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
          @endif

        </ul>
      </div>
    </div>
  </nav>
