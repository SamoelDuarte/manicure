@extends('layouts.app')
@section('title', 'Homepage')
@section('content')
    <!-- promotion area start -->
    @if ($coupon)
        <!--<div class="p-1 text-white text-center" style="background-image: url('{{ asset('frontend/img/bg/12.jpg') }}')">
            Designer de unhas!
        </div>-->
    @endif
    <!-- promotion area end -->

    @include('partials.frontend.sliders')
    <!-- categories area start -->
    
    <div class="container">
   

        <div class="pb-50">
            <div class="section-title-furits text-center">
                {{-- <img src="{{ asset('frontend/img/icon-img/49.png') }}" alt=""> --}}
                <h2>NAVEGUE NOSSAS CATEGORIAS</h2>
            </div>
            <br>
            <section>
                <header class="text-center">
                    <p class="small text-muted small text-uppercase mb-1">COLEÇÕES CUIDADOSAMENTE CRIADAS</p>
                    {{-- <h2 class="h5 text-uppercase mb-4">NAVEGUE NOSSAS CATEGORIAS</h2> --}}
                    <section class="icons-container">

                    <div class="icons">
       <img src="https://cdn-icons-png.flaticon.com/512/80/80405.png" alt="">
        <div class="info">
            <h3>ESMALTERIA</h3>
            <span>Lorem ipsum</span>
        </div>
    </div>

  <div class="icons">
  <img src="https://cdn-icons-png.flaticon.com/512/2437/2437898.png" alt="">
        <div class="info">
            <h3>DESIGN NAIL</h3>
            <span>Lorem ipsum</span>
        </div>
    </div>

   <div class="icons">
        <img src="https://cdn-icons-png.flaticon.com/512/1941/1941105.png" alt="">
        <div class="info">
            <h3>PROFISSIONAL</h3>
            <span>Lorem ipsum</span>
        </div>
    </div>

   <div class="icons">
        <img src="https://static.thenounproject.com/png/3820068-200.png" alt="">
        <div class="info">
            <h3>MANICURE</h3>
            <span>Lorem ipsum</span>
        </div>
    </div>

    

</section>
                </header>

                <div class="row">
                    <div class="col-md-4 mb-4 mb-md-0 sombra-esquerda-baixo">
                    <section class="galery">
        <div class="product-list">
            <div class="product">
                <img src="path/to/image1.jpg" alt="Produto 1">
                <h2>Produto 1</h2>
                <p class="price">R$ 49,99</p>
                <button>Comprar</button>
            </div>
            <div class="product">
                <img src="path/to/image2.jpg" alt="Produto 2">
                <h2>Produto 2</h2>
                <p class="price">R$ 79,99</p>
                <button>Comprar</button>
            </div>
            <div class="product">
                <img src="path/to/image3.jpg" alt="Produto 3">
                <h2>Produto 3</h2>
                <p class="price">R$ 99,99</p>
                <button>Comprar</button>
            </div>
            <div class="product">
                <img src="path/to/image3.jpg" alt="Produto 4">
                <h2>Produto 3</h2>
                <p class="price">R$ 99,99</p>
                <button>Comprar</button>
            </div>
            <div class="product">
                <img src="path/to/image3.jpg" alt="Produto 5">
                <h2>Produto 3</h2>
                <p class="price">R$ 99,99</p>
                <button>Comprar</button>
            </div>

            <div class="product">
                <img src="path/to/image1.jpg" alt="Produto 1">
                <h2>Produto 1</h2>
                <p class="price">R$ 49,99</p>
                <button>Comprar</button>
            </div>
            <div class="product">
                <img src="path/to/image2.jpg" alt="Produto 2">
                <h2>Produto 2</h2>
                <p class="price">R$ 79,99</p>
                <button>Comprar</button>
            </div>
            <div class="product">
                <img src="path/to/image3.jpg" alt="Produto 3">
                <h2>Produto 3</h2>
                <p class="price">R$ 99,99</p>
                <button>Comprar</button>
            </div>
          
        </div>
                    </section>
    </div>
                    </div>
                    <!--<div class="col-md-4 sombra-esquerda-baixo">
                    <div class="gallery">
        <div class="gallery-item">
            <img src="https://studioandreaaronne.com.br/wp-content/uploads/2023/07/273912377-372031824314185-6626888513630609174-n-1676653877.jpg" alt="Image 1">
        </div>
        <div class="gallery-item">
            <img src="https://studioandreaaronne.com.br/wp-content/uploads/2023/07/273912377-372031824314185-6626888513630609174-n-1676653877.jpg" alt="Image 2">
        </div>
        
        <!-- Add more gallery items as needed 
    </div>
                    </div>-->
                </div>
            </section>
        </div>
    </div>
    <!-- categories area end -->

    <!-- banner area start -->
    <div class="fruits-choose-area pb-65 bg-img mt-5"
        style="background-image:url(https://img.freepik.com/fotos-premium/esmalte-vermelho-e-verde-derramado-de-garrafa-com-pano-de-fundo-de-espaco-branco-copia_23-2148194799.jpg)">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-xl-9 col-12">
                    <div class="fruits-choose-wrapper-all">
                        <div class="fruits-choose-title mt-5">
                            <h2>Por que nos escolheu ?</h2>
                        </div>
                        <div class="fruits-choose-wrapper">
                            <div class="single-fruits-choose">
                                <div class="fruits-choose-serial">
                                    <h3>01</h3>
                                </div>
                                <div class="fruits-choose-content">
                                    <h4>Entregas Facilitadas</h4>
                                    <p>Garantimos entregas rápidas e eficientes, utilizando a mesma logística confiável do Mercado Livre.</p>
                                </div>
                            </div>
                            <div class="single-fruits-choose">
                                <div class="fruits-choose-serial">
                                    <h3>02</h3>
                                </div>
                                <div class="fruits-choose-content">
                                    <h4>Preços Ótimos de Entrega</h4>
                                    <p>Oferecemos preços competitivos para garantir que suas entregas sejam acessíveis e convenientes.</p>
                                </div>
                            </div>
                            <div class="single-fruits-choose">
                                <div class="fruits-choose-serial">
                                    <h3>03</h3>
                                </div>
                                <div class="fruits-choose-content">
                                    <h4>Facilidade de Compra e Suporte Eficiente</h4>
                                    <p>heckout fácil, suporte via WhatsApp para localização de pedidos e variedade de produtos novos e usados.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- banner area end -->

    <!-- TRENDING PRODUCTS -->
    <div class="container">
        <livewire:frontend.product.top-trending-products />
    </div>

    <!-- services area start -->
    <div class="fruits-services ptb-200">
        <div class="fruits-services-wrapper">
            <div class="single-fruits-services">
                <div class="fruits-services-img">
                    <img src="{{ asset('img/logo2.png') }}" alt="">
                </div>
                <div class="fruits-services-content">
                    <h4>ENTREGA RÁPIDA</h4>
                    <p>Logística eficiente para garantir entregas rápidas. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
            </div>
            <div class="single-fruits-services">
                <div class="fruits-services-img">
                    <img src="{{ asset('img/logo2.png') }}" alt="">
                </div>
                <div class="fruits-services-content">
                    <h4>GARANTIA DE SATISFAÇÃO</h4>
                    <p>Produtos de qualidade com garantia de satisfação. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
            </div>
            <div class="single-fruits-services">
                <div class="fruits-services-img">
                    <img src="{{ asset('img/logo2.png') }}" alt="">
                </div>
                <div class="fruits-services-content">
                    <h4>SUPORTE 24/7</h4>
                    <p>Suporte online 24 horas por dia, 7 dias por semana. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
            </div>
        </div>
    </div>

    <main>
    <ul class='slider'>
        <li class='item' style="background-image: url('https://wallpapers.com/images/high/nail-background-1242-x-1226-r7g6xmcphmgbt2ww.webp')">
            <div class='content'>
                <h2 class='title'>"Lossless Youths"</h2>
                <p class='description'> Lorem ipsum, dolor sit amet consectetur
                    adipisicing elit. Tempore fuga voluptatum, iure corporis inventore
                    praesentium nisi. Id laboriosam ipsam enim. </p>
                <button>Read More</button>
            </div>
        </li>
        <li class='item' style="background-image: url('https://wallpapers.com/images/high/nail-background-5oayxj8nufs96ssv.webp')">
            <div class='content'>
                <h2 class='title'>"Estrange "</h2>
                <p class='description'> Lorem ipsum, dolor sit amet consectetur
                    adipisicing elit. Tempore fuga voluptatum, iure corporis inventore
                    praesentium nisi. Id laboriosam ipsam enim. </p>
                <button>Read More</button>
            </div>
        </li>
        <li class='item' style="background-image: url('https://wallpapers.com/images/high/nail-background-5sv3cufplu8kl5t1.webp')">
            <div class='content'>
                <h2 class='title'>"The Gate Keeper"</h2>
                <p class='description'> Lorem ipsum, dolor sit amet consectetur
                    adipisicing elit. Tempore fuga voluptatum, iure corporis inventore
                    praesentium nisi. Id laboriosam ipsam enim. </p>
                <button>Read More</button>
            </div>
        </li>
        <li class='item' style="background-image: url('https://wallpapergod.com/images/hd/nails-2111X1408-wallpaper-ayjxovit5i8lv6cm.jpeg')">
            <div class='content'>
                <h2 class='title'>"Last Trace Of Us"</h2>
                <p class='description'>
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore fuga voluptatum, iure corporis inventore praesentium nisi. Id laboriosam ipsam enim.
                </p>
                <button>Read More</button>
            </div>
        </li>
        <li class='item' style="background-image: url('https://wallpapers.com/images/high/nail-background-2000-x-1333-8l40fxep26qs5khy.webp')">
            <div class='content'>
                <h2 class='title'>"Urban Decay"</h2>
                <p class='description'>
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore fuga voluptatum, iure corporis inventore praesentium nisi. Id laboriosam ipsam enim.
                </p>
                <button>Read More</button>
            </div>
        </li>
        <li class='item' style="background-image: url('https://wallpapers.com/images/high/nail-background-1920-x-1080-ouclxjspgzm5tbky.webp')">
            <div class='content'>
                <h2 class='title'>"The Migration"</h2>
                <p class='description'> Lorem ipsum, dolor sit amet consectetur
                    adipisicing elit. Tempore fuga voluptatum, iure corporis inventore
                    praesentium nisi. Id laboriosam ipsam enim. </p>
                <button>Read More</button>
            </div>
        </li>
    </ul>
    <nav class='nav'>
        <ion-icon class='btn prev' name="arrow-back-outline"></ion-icon>
        <ion-icon class='btn next' name="arrow-forward-outline"></ion-icon>
    </nav>
</main>



<script>
    const slider = document.querySelector('.slider');

    function activate(e) {
        const items = document.querySelectorAll('.item');
        e.target.matches('.next') && slider.append(items[0])
        e.target.matches('.prev') && slider.prepend(items[items.length - 1]);
    }

    document.addEventListener('click', activate, false);
</script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
    <!-- services area end -->
@endsection
