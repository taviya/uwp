<header class="header">
    <div class="header-middle sticky-header" data-sticky-options="{'mobile': true}">
        <div class="container">
            <div class="header-left col-lg-2 w-auto pl-0">
                <button class="mobile-menu-toggler text-primary mr-2" type="button">
                    <i class="fas fa-bars"></i>
                </button>
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ asset('assets/images/logo.png') }}" width="111" height="44" alt="Porto Logo">
                </a>
            </div>
            <div class="header-right w-lg-max">
                <div class="header-icon header-search header-search-inline header-search-category w-lg-max text-right mt-0">
                    
                </div>
                @auth
                    <div class="header-contact d-none d-lg-flex pl-4 pr-4">
                        <h6>
                            <a href="{{ route('question-ans.index') }}" class="text-dark font1">Add Question</a>
                        </h6>
                    </div>
                @endauth
                @guest
                @if (Route::has('login'))
                <a href="{{ route('login') }}" class="header-icon" title="login"><i class="icon-user-2"></i></a>
                @endif
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </div>
        </div>
    </div>
</header>