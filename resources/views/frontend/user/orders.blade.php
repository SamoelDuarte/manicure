@extends('layouts.app')
@section('title', 'User Orders')
@section('content')
    <section class="breadcrumb-area pt-5 pb-5" style="background-color: #09c6a2">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <Meu>Pedidos</h2>
                <ul>
                    <li><a href="{{route('home')}}">Início</a></li>
                    <li> Meu Pedidos</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <livewire:frontend.user.orders-component />
            </div>
            <div class="col-lg-4">
                @include('partials.frontend.user.sidebar')
            </div>
        </div>
    </section>
@endsection
