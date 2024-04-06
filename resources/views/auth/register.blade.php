@extends('layouts.app')
@section('title', 'Registration')
@section('content')

    <div class="breadcrumb-area pt-5 pb-5" style="background-color: #09c6a2">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <h2>Cadastro</h2>
                <ul>
                    <li><a href="{{route('login')}}">login</a></li>
                    <li> Cadastro </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="register-area ptb-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-12 col-lg-6 col-xl-6 ml-auto mr-auto">
                    <div class="login">
                        <div class="login-form-container">
                            <div class="form-group">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first_name" class="text-small text-uppercase">{{ __('Nome') }}</label>
                                                <input id="first_name" type="text" class="form-control form-control-lg" name="first_name" value="{{ old('first_name') }}" placeholder="Nome">
                                                @error('first_name')<span class="text-danger" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="last_name" class="text-small text-uppercase">{{ __('Sobrenome') }}</label>
                                                <input id="last_name" type="text" class="form-control form-control-lg" name="last_name" value="{{ old('last_name') }}" placeholder="Sobrenome">
                                                @error('last_name')<span class="text-danger" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email" class="text-small text-uppercase">{{ __('CPF') }}</label>
                                                <input id="document" type="text" class="form-control form-control-lg cpf-cnpj" value="{{ old('document') }}" name="document" placeholder="seu CPF">
                                                @error('document')<span class="text-danger" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="username" class="text-small text-uppercase">{{ __('NickName') }}</label>
                                                <input id="username" type="text" class="form-control form-control-lg" name="username" value="{{ old('username') }}" placeholder="Nome para fazer Login">
                                                @error('username')<span class="text-danger" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email" class="text-small text-uppercase">{{ __('E-Mail') }}</label>
                                                <input id="email" type="email" class="form-control form-control-lg" value="{{ old('email') }}" name="email" placeholder="Seu E-mail">
                                                @error('email')<span class="text-danger" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="phone" class="text-small text-uppercase">{{ __('Telefone') }}</label>
                                                <input id="phone" type="text" class="form-control form-control-lg phone" name="phone" value="{{ old('phone') }}" placeholder="Telefone">
                                                @error('phone')<span class="text-danger" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="password" class="text-small text-uppercase">{{ __('Senha') }}</label>
                                                <input id="password" type="password" class="form-control form-control-lg" name="password" placeholder="Senha">
                                                @error('password')<span class="text-danger" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="password-confirm" class="text-small text-uppercase">{{ __('Confirmme sua Senha') }}</label>
                                                <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" placeholder="Confirme senha">
                                                @error('password-confirm')<span class="text-danger" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label text-small" for="remember">
                                                {{ __('Manter-me Conectado') }}
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-dark">
                                            {{ __('Salvar') }}
                                        </button>
                                        @if(Route::has('login'))
                                            <a class="btn btn-link text-small" href="{{ route('login') }}">
                                                {{ __('Já tenho conta ?') }}
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
