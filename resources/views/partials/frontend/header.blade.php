<header class="ptb-50">
    <div class="header-bottom wrapper-padding-2 res-header-sm sticker header-sticky-3 furits-header">
        <div class="container-fluid">
            <div class="header-bottom-wrapper ">
                <div class="logo-2 ptb-35 menu-hover">
                    <a href="#"><img src="https://static.thenounproject.com/png/2717920-200.png" alt="" width="95px" height="95px"></a>
                </div>
                <div class="menu-style-2 handicraft-menu menu-hover">
                    <nav>
                        <ul>
                        
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li>
                                <a href="{{route('shop.index')}}">
                                    Produtos
                                </a>
                            </li>
                            <ul class="single-dropdown">
                                <li>
                                    <a href="{{route('contact.index')}}">Contato</a>
                                </li>
                                @guest
                                    <li>
                                        <a href="{{route('login')}}">Login</a>
                                    </li>
                                    @if (route('register'))
                                        <li>
                                            <a href="{{route('register')}}">Registro</a>
                                        </li>
                                    @endif
                                @endguest
                                <li>
                                    <a href="{{route('cart.index')}}">Carrinho</a>
                                </li>
                            </ul>
                            <li>
                                <a href="javascript:void(0);">Categorias</a>
                                <ul class="single-dropdown">
                                    @foreach($shop_categories_menu as $global_category)
                                        <li>
                                            <a href="{{ route('shop.index', $global_category->slug) }}">
                                                {{ $global_category->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);">Páginas</a>
                                <ul class="single-dropdown">
                                    @include('partials.frontend.pages')
                                </ul>
                            </li>
                            <li>
                                <a href="{{route('contact.index')}}">Contato</a>
                            </li>
                            <li>
                                <a href="{{route('schedule.index')}}">Agenda</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="furits-login-cart">
                    <div class="furits-login menu-hover">
                        <ul>
                            @guest
                                <li><a href="{{route('login')}}">Login</a></li>
                                <li><a href="{{route('register')}}">Registro</a></li>
                            @else
                                <li>
                                    <livewire:frontend.header.notification-component />
                                </li>

                                <li>
                                    <a href="javascript:void(0);" style="color: #578a01;">Minha Conta</a>
                                    <ul class="single-dropdown">
                                        @role('admin')
                                        <li>
                                            <a href="{{ route('admin.index') }}" style="color: #578a01;">
                                                Administrção
                                            </a>
                                        @endrole
                                        @auth
                                            <li><a href="{{ route('user.dashboard') }}" style="color: #578a01;">Dashboard</a>
                                            </li>
                                        @endauth
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #578a01;">
                                                {{ __('Logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endguest
                        </ul>
                    </div>
                    <livewire:frontend.header.cart-component />
                </div>
            </div>
            <div class="row">
                <div class="mobile-menu-area d-md-block col-md-12 col-lg-12 col-12 d-lg-none d-xl-none">
                    <div class="mobile-menu">
                        <nav id="mobile-menu-active">
                            <ul class="menu-overflow">
                                <li><a href="{{route('home')}}">HOME</a></li>
                                <li><a href="{{route('shop.index')}}">Produtos</a></li>
                                <li><a href="#">Categorias</a>
                                    <ul>
                                        <li>
                                        @foreach($shop_categories_menu as $global_category)
                                            <li>
                                                <a href="{{ route('shop.index', $global_category->slug) }}">
                                                    {{ $global_category->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li><a href="{{route('contact.index')}}">Contato</a></li>
                                <li><a href="{{route('schedule.index')}}">Agenda</a></li>
                                @guest
                                    <li>
                                        <a href="{{route('login')}}">Login</a>
                                    </li>
                                    <li>
                                        <a href="{{route('register')}}">Registro</a>
                                    </li>
                                @else
                                    @role('admin')
                                        <li><a href="{{ route('admin.index') }}">Administração</a>
                                    @endrole
                                    @role('supervisor')
                                        <li><a href="{{ route('admin.index') }}">Administração</a>
                                    @endrole
                                    <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                @endguest
                                @include('partials.frontend.pages')
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="breadcrumb-area pt-50">

    <div class="container-fluid">
        <div class="furniture-bottom-wrapper">
            <div class="furniture-login">
            </div>
            <div class="furniture-search">
                <form>
                    <div class="form-input">
                        <input id="search" type="text"
                               value="{{ old('keyword', request()->keyword) }}"
                               placeholder="Pesquisa por produto...">
                    </div>
                </form>
            </div>
            <div class="furniture-wishlist">
                <livewire:frontend.header.wishlist-component />
                <li><a href="#"></a></li>
                <li><a href="#"></a></li>
            </div>
        </div>
    </div>
</div>
