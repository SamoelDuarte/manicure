@extends('layouts.admin')
<style>
    .display-mobile {
        position: relative;
        width: 300px;
        height: 600px;
        margin: 0 auto;
        border: 1px solid #030202;
        /* Borda do card */
        padding: 10px;
        /* Espaçamento interno */
        width: 300px;
        /* Largura fixa, semelhante à de um celular */
        height: 600px;
        /* Altura maior para aspecto vertical */
        margin: 0 auto;
        /* Centraliza o card */
        background-color: #ffffff;
        /* Cor de fundo */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        /* Sombra para efeito 3D */
        /* Outros estilos do card */
    }

    .title-section {
        display: flex;
        /* Flexbox para alinhar a linha e o texto */
        align-items: center;
        /* Centraliza verticalmente */
        margin-bottom: 20px;
        /* Espaço abaixo do título */
        position: sticky;
        z-index: 1;
    }

    .discription-section {
        display: flex;
        /* Flexbox para alinhar a linha e o texto */
        align-items: center;
        /* Centraliza verticalmente */
        margin-bottom: 20px;
        /* Espaço abaixo do título */
        position: sticky;
        z-index: 1;
    }

    .title-line {
        width: 5px;
        height: 87px;
        background-color: #000;
        margin-right: 10px;
        box-shadow: -4px 3px 5px rgb(0 0 0 / 85%);
    }

    .description-section {
        display: flex;
        margin-bottom: 20px;
        position: sticky;
        z-index: 1;
    }

    .description-text {
        margin-top: 7px;
    }

    .description-text h6 {
        font-size: 10px;
        color: black;
    }

    .description-line {
        width: 5px;
        height: 85px;
        margin-top: 8px;
        background-color: #000;
        margin-right: 4px;
        box-shadow: -4px 3px 5px rgb(0 0 0 / 85%);
    }

    .title-text h4 {
        font-family: fantasy;
        text-shadow: -2px 4px 4px rgb(22 21 21 / 50%);
        color: #120f0f;
    }

    .title-text h6 {
        color: #120f0f;
    }

    .form-post {
        /* Garante que o popup fique acima de outros elementos */
        background-color: white;
        border: 1px solid #ccc;
        /* Ajuste a posição conforme necessário */
    }

    .form-post label {
        width: 83px
    }

    .image-options label {
        margin-right: 10px;
        cursor: pointer;
    }

    .image-options label img {
        width: 50px;
        /* Ajuste conforme necessário */
        height: auto;
        border: 2px solid transparent;
    }

    .image-options label input[type="radio"] {
        display: none;
    }

    .image-options label input[type="radio"]:checked+img {
        border-color: blue;
        /* Cor da borda quando selecionado */
    }

    .settings {
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .display-mobile {
        /* ... seus outros estilos ... */
        background-size: cover;
        /* Faz com que a imagem cubra todo o elemento */
        background-position: center;
        /* Centraliza a imagem no elemento */
        background-repeat: no-repeat;
        /* Impede a repetição da imagem */
    }

    .section-img-grande {
        height: 260px;
        position: relative;
        z-index: 1;
    }

    .section-img-grande img {
        box-shadow: rgb(0, 0, 0) -11px 5px 17px;
        /* Esconder a imagem inicialmente */
        display: none;
        width: 100%;
        /* Faz a imagem ocupar toda a largura do container */
        height: auto;
        /* Mantém a proporção da imagem */
    }

    .section-two-img-and-price img {
        box-shadow: rgb(0, 0, 0) -11px 5px 17px;
    }

    .section-img-grande img[src] {
        /* Mostra a imagem quando um src for definido */
        display: block;
        height: 260px;
    }

    .shadow-controls {
        margin-top: 20px;
    }

    .shadow-controls label {
        display: block;
        margin-bottom: 10px;
    }

    /* Garanta que o input range tenha espaço suficiente */
    .shadow-controls input[type="range"] {
        width: 100%;
    }

    .background-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        /* Gradiente linear de cima para baixo */
        background: linear-gradient(to bottom, #C38888 0%, #suaCorInferior 100%);
        z-index: 0;
        /* Mantém o overlay atrás do conteúdo */
    }

    /* Estilos para os controles */
    .overlay-controls label {
        display: block;
        margin-bottom: 10px;
    }

    .overlay-controls input[type="range"] {
        width: 100%;
    }

    .section-two-img-and-price {
        margin-top: 6px;
        display: flex;
        position: relative;
    }

    .img1,
    .img2 {
        width: 80px;
        height: 83px;
        box-shadow: -3px 3px 3px rgb(0 0 0 / 31%);
        position: relative;
    }

    .img1 {
        margin-right: 11px;
    }

    .product-info {
        display: flex;
        flex-direction: column;
        margin-top: 10px;
    }

    .priceValue {
        font-size: 11px;
    }

    .product-price {
        font-weight: bold;
        font-size: 24px;
        font-family: 'Arial', sans-serif;
        color: #d35400;
        position: absolute;
        bottom: 12px;
        right: -2px;
        text-shadow: -3px 3px 2px rgb(0 0 0 / 30%);
    }

    .valorde {
        font-weight: bold;
        font-size: 12px;
        font-family: 'Arial', sans-serif;
        color: #208620;
        position: absolute;
        bottom: 48px;
        right: -2px;
        text-shadow: -3px 3px 2px rgb(0 0 0 / 30%);
        text-decoration: line-through;
    }

    .price-edit {
        margin-top: 5px;
    }

    .alinha-titulo {
        display: flex;
        flex-direction: row;
        align-content: space-around;
        align-items: center;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .section-title {
        color: #46a06e;
        font-family: fantasy;
    }

    .icone-sombra {
        font-size: 25px;
        width: 28px;
        height: 28px;
    }

    /* Estilo para a imagem de preview */
    .imagePreview {
        width: 100px;
        /* ou o tamanho que você preferir */
        height: 100px;
        /* ou o tamanho que você preferir */
        border: 1px solid #ddd;
        /* uma borda simples para indicar o campo */
        background-color: #f8f8f8;
        /* uma cor de fundo para o placeholder da imagem */
        display: block;
        /* para aplicar largura e altura */
    }

    .bordas {
        background: white;
        padding: 14px;
        border-radius: 15px;
        border: solid;
    }

    .grade {
        display: flex;
        flex-wrap: nowrap;
        justify-content: space-evenly;
    }

    /* Estilos adicionais, se necessário */
</style>
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="display-mobile" style="background-image: url('/img/N4.png') ">
                    <div class="background-overlay"></div>
                    <div class="title-section">
                        <div class="title-line"></div>
                        <div class="title-text">
                            <h4>Título Principal<br>Continuação do Título</h4>
                            <h6>Subtítulo</h6>
                        </div>
                    </div>

                    <div class="section-imgs">
                        <div class="section-img-grande">
                            <img src="/img/N1.png" alt="">
                        </div>
                        <div class="section-two-img-and-price">
                            <img class="img1" src="/img/N2.png" alt="">
                            <img class="img2" src="/img/N3.png" alt="">
                            <div class="product-info">
                                <div class="valorde">
                                    <span id="priceValorde">100,00</span>
                                </div>
                                <div class="product-price">
                                    <span class="priceValue">R$</span><span id="priceValue">100,00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section-description">
                        <div class="description-section">
                            <div class="description-line"></div>
                            <div class="description-text">
                                <h6>
                                    Claro, aqui está uma descrição de exemplo para um produto fictício de eletrônico:

                                    Descrição do Produto Eletrônico Modelo XZ100:

                                    O Modelo XZ100 é a última palavra em tecnologia e design no mundo dos eletrônicos. Com
                                    sua interface de usuár</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Outros conteúdos do card aqui -->
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="sessao-titulo bordas">
                            <label class="section-title ">Sessão Titulo</label>
                            <div class="row">
                                <!-- Coluna da esquerda -->
                                <div class="col-md-12">
                                    <div class="alinha-titulo">
                                        <div>
                                            <label for="titleInput">Titulo</label>
                                            <input type="text" id="titleInput" placeholder="Editar Título">
                                            <input type="color" id="titleColor" value="#000000">
                                        </div>

                                        <div>
                                            <label for="subtitleInput">SubTitulo</label>
                                            <input type="text" id="subtitleInput" placeholder="Editar Subtítulo">
                                            <input type="color" id="subtitleColor" value="#000000">
                                        </div>

                                    </div>
                                    <!-- Conteúdo alinhado à esquerda -->
                                </div>
                                <!-- Coluna da direita -->

                            </div>
                        </div>
                        <div class="bordas">
                            <label class="section-title">Sessão Imagens Produto e Valor</label>
                            <div class="row grade">
                                <div>
                                    <label for="">Grande</label>
                                    <img src="/img/N1.png" class="imagePreview" id="imagePreviewLarge"
                                        alt="Upload Image Large" style="cursor:pointer;" />
                                    <input type="file" id="imageUpload" accept="image/*" style="display:none;">
                                </div>
                                <div>
                                    <label for="">Pequena-1</label>
                                    <img src="/img/N2.png" class="imagePreview" id="imagePrevi1" alt="Upload Image Large"
                                        style="cursor:pointer;" />
                                    <input type="file" id="image1Upload" accept="image/*" style="display:none;">
                                </div>
                                <div>
                                    <label for="">Pequena-2</label>
                                    <img src="/img/N3.png" class="imagePreview" id="imagePrevi2" alt="Upload Image Large"
                                        style="cursor:pointer;" />
                                    <input type="file" id="image2Upload" accept="image/*" style="display:none;">
                                </div>

                                <div class="col-md-6">

                                    <label><i class="fa fa-arrows-alt-h icone-sombra"></i><input type="range"
                                            id="imgShadowX" min="-20" max="20" value="10"></label>
                                    <label><i class="fa fa-arrows-alt-v icone-sombra"></i><input type="range"
                                            id="imgShadowY" min="-20" max="20" value="10"></label>


                                </div>
                                <div class="col-md-6">
                                    <label><i class="fa fa-circle icone-sombra" style="filter: blur(4px);"></i><input
                                            type="range" id="imgShadowBlur" min="0" max="40"
                                            value="10"></label>
                                    <label>Cor da Sombra: <input type="color" id="imgShadowColor"
                                            value="#000000"></label>
                                </div>

                                <div class="col-md-12 alinha-titulo">
                                    <div class="form-group">
                                        <label for="">Valor de :</label>
                                        <input type="text" id="inputValorDe" value="100,00" />
                                        <input type="color" id="priceDeColor" value="#208620">

                                    </div>
                                    <div class="form-group">
                                        <label for="">Por</label>
                                        <input type="text" id="priceInput" value="100,00" />
                                        <input type="color" id="pricePorColor" value="#d35400">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class=" bordas">
                            <label class="section-title ">Sessão Linha Lateral Titulo</label>
                            <div class="row">
                                <!-- Coluna da esquerda -->
                                <div class="col-md-7">
                                    <label> <i class="fa fa-arrows-alt-h icone-sombra"></i><input type="range"
                                            id="shadowX" min="-10" max="10" value="3"></label>

                                    <label><i class="fa fa-arrows-alt-v icone-sombra"></i><input type="range"
                                            id="shadowY" min="-10" max="10" value="5"></label>

                                    <label><i class="fa fa-circle icone-sombra" style="filter: blur(4px);"></i><input
                                            type="range" id="shadowBlur" min="0" max="10"
                                            value="5"></label>


                                </div>
                                <div class="col-md-5">
                                    <label><input type="color" id="shadowColor" value="#0E0B0B">Sombra</label>
                                    <labal><input type="color" id="colorPicker">Linha</label>

                                </div>
                            </div>
                        </div>

                        <div class="bordas">
                            <label class="section-title ">Sessão Descrição Produto</label>
                            <div class="alinha-titulo" <label>Descrição</label>
                                <input type="text" id="descriptionInput" placeholder="Editar Descrição">
                                <input type="color" id="descriptionColor" value="#000000">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><i class="fa fa-arrows-alt-h icone-sombra"></i><input type="range"
                                            id="shadowXDescription" min="-10" max="10"
                                            value="3"></label>
                                    <label><i class="fa fa-arrows-alt-v icone-sombra"></i><input type="range"
                                            id="shadowYDescription" min="-10" max="10"
                                            value="5"></label>
                                    <label><i class="fa fa-circle icone-sombra" style="filter: blur(4px);"></i><input
                                            type="range" id="shadowBlurDescription" min="0" max="10"
                                            value="5"></label>
                                </div>
                                <div class="col-md-6 alinha-titulo">
                                    <label>Cor da Sombra: <input type="color" id="shadowColorDescription"
                                            value="#0E0B0B"></label>
                                    <labal>Cor Linha </label>
                                        <input type="color" id="colorPickerDescription">
                                </div>
                            </div>
                        </div>
                        <div class="bordas">
                            <label class="section-title">Fundo</label>
                            <div class="row">
                                <div class="col-md-6">

                                    <!-- A imagem que ao clicar irá abrir o input de arquivo -->
                                    <img src="/img/N4.png" class="imagePreview" id="imagePreview" alt="Upload Image"
                                        style="cursor:pointer;" />

                                    <!-- O input de arquivo escondido -->
                                    <input type="file" id="backgroundImageUpload" accept="image/*"
                                        style="display:none;" />
                                </div>
                                <div class="col-md-6">
                                    <label><input type="color" id="overlayTopColor" value="#C38888"></label>
                                    <label><input type="color" id="overlayBottomColor" value="#FFFFFF"></label>
                                    <label>Transparência<input type="range" id="overlayOpacity" min="0"
                                            max="100" value="20"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Evento para a Imagem Grande
        document.getElementById('imagePreviewLarge').addEventListener('click', function() {
            document.getElementById('imageUpload').click();
        });

        // Evento para a Imagem Pequena 1
        document.getElementById('imagePrevi1').addEventListener('click', function() {
            document.getElementById('image1Upload').click();
        });


        // Evento para a Imagem Pequena 2
        document.getElementById('imagePrevi2').addEventListener('click', function() {
            document.getElementById('image2Upload').click();
        });


        // JavaScript para abrir o input de arquivo ao clicar na imagem
        document.getElementById('imagePreview').addEventListener('click', function() {
            document.getElementById('backgroundImageUpload').click();
        });

        // JavaScript para mostrar o preview da imagem selecionada
        document.getElementById('backgroundImageUpload').addEventListener('change', function(event) {
            if (event.target.files && event.target.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                };

                reader.readAsDataURL(event.target.files[0]);
            }
        });

        document.getElementById('priceDeColor').addEventListener('input', function() {
            document.getElementById('priceValorde').style.color = this.value;
        });

        document.getElementById('pricePorColor').addEventListener('input', function() {
            document.getElementById('priceValue').style.color = this.value;
        });


        document.getElementById('priceInput').addEventListener('input', function() {
            // Atualiza o valor de forma assíncrona conforme o usuário digita
            document.getElementById('priceValue').textContent = this.value;
        });

        document.getElementById('inputValorDe').addEventListener('input', function() {
            // Atualiza o valor de forma assíncrona conforme o usuário digita
            document.getElementById('priceValorde').textContent = this.value;
        });


        document.getElementById('priceInput').addEventListener('blur', function() {
            // Esconde o input e exibe o span quando o input perde o foco
            document.querySelector('.product-price').style.display = 'block';
            document.querySelector('.price-edit').style.display = 'none';
        });


        document.getElementById('colorPickerDescription').addEventListener('input', function() {
            var selectedColor = this.value;
            document.querySelector('.description-line').style.backgroundColor = selectedColor;
        });

        // Atualiza a cor da linha conforme a escolha no seletor de cor
        document.getElementById('colorPicker').addEventListener('input', function() {
            var selectedColor = this.value;
            document.querySelector('.title-line').style.backgroundColor = selectedColor;
        });

        document.getElementById('titleInput').addEventListener('input', function() {
            var newTitle = this.value;
            document.querySelector('.title-text h4').textContent = newTitle; // Supondo que o título é um <h4>
        });

        document.getElementById('descriptionInput').addEventListener('input', function() {
            var newTitle = this.value;
            document.querySelector('.description-text h6').textContent = newTitle; // Supondo que o título é um <h4>
        });

        document.getElementById('subtitleInput').addEventListener('input', function() {
            var newSubtitle = this.value;
            document.querySelector('.title-text h6').textContent = newSubtitle; // Supondo que o subtítulo é um <h6>
        });

        document.querySelectorAll('.image-options input[type="radio"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                var imageUrl = this.nextElementSibling.getAttribute('data-image-url');
                document.querySelector('.display-mobile').style.backgroundImage = 'url(' + imageUrl + ')';

            });
        });

        function updateLineShadow() {
            var shadowX = document.getElementById('shadowX').value;
            var shadowY = document.getElementById('shadowY').value;
            var shadowBlur = document.getElementById('shadowBlur').value;
            var shadowColor = document.getElementById('shadowColor').value;

            var line = document.querySelector('.title-line');
            line.style.boxShadow = `${shadowX}px ${shadowY}px ${shadowBlur}px ${shadowColor}`;
        }

        document.getElementById('shadowX').addEventListener('input', updateLineShadow);
        document.getElementById('shadowY').addEventListener('input', updateLineShadow);
        document.getElementById('shadowBlur').addEventListener('input', updateLineShadow);
        document.getElementById('shadowColor').addEventListener('input', updateLineShadow);


        function updateLineShadowDescription() {
            var shadowX = document.getElementById('shadowXDescription').value;
            var shadowY = document.getElementById('shadowYDescription').value;
            var shadowBlur = document.getElementById('shadowBlurDescription').value;
            var shadowColor = document.getElementById('shadowColorDescription').value;

            var line = document.querySelector('.description-line');
            line.style.boxShadow = `${shadowX}px ${shadowY}px ${shadowBlur}px ${shadowColor}`;
        }

        document.getElementById('shadowXDescription').addEventListener('input', updateLineShadowDescription);
        document.getElementById('shadowYDescription').addEventListener('input', updateLineShadowDescription);
        document.getElementById('shadowBlurDescription').addEventListener('input', updateLineShadowDescription);
        document.getElementById('shadowColorDescription').addEventListener('input', updateLineShadowDescription);


        document.getElementById('titleInput').addEventListener('input', function() {
            var newTitle = this.value;
            document.querySelector('.title-text h4').textContent = newTitle;
        });

        document.getElementById('subtitleInput').addEventListener('input', function() {
            var newSubtitle = this.value;
            document.querySelector('.title-text h6').textContent = newSubtitle;
        });

        document.getElementById('titleColor').addEventListener('input', function() {
            var newTitleColor = this.value;
            document.querySelector('.title-text h4').style.color = newTitleColor;
        });

        document.getElementById('descriptionColor').addEventListener('input', function() {
            var newTitleColor = this.value;
            document.querySelector('.description-text h6').style.color = newTitleColor;
        });

        document.getElementById('subtitleColor').addEventListener('input', function() {
            var newSubtitleColor = this.value;
            document.querySelector('.title-text h6').style.color = newSubtitleColor;
        });

        document.getElementById('imageUpload').addEventListener('change', function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.querySelector('.section-img-grande img');
                output.src = reader.result;

                // Atualizar a imagem de preview na seção de configurações
                var outputInPreview = document.getElementById('imagePreviewLarge');
                outputInPreview.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
            updateImagePreview(event, 'imagePreviewLarge');
        });

        function updateImageShadow() {
            var shadowX = document.getElementById('imgShadowX').value;
            var shadowY = document.getElementById('imgShadowY').value;
            var shadowBlur = document.getElementById('imgShadowBlur').value;
            var shadowColor = document.getElementById('imgShadowColor').value;

            var image = document.querySelector('.section-img-grande img');
            var images = document.querySelectorAll('.section-two-img-and-price img');
            images.forEach(function(image) {
                image.style.boxShadow = `${shadowX}px ${shadowY}px ${shadowBlur}px ${shadowColor}`;
            });
            image.style.boxShadow = `${shadowX}px ${shadowY}px ${shadowBlur}px ${shadowColor}`;
        }

        document.getElementById('imgShadowX').addEventListener('input', updateImageShadow);
        document.getElementById('imgShadowY').addEventListener('input', updateImageShadow);
        document.getElementById('imgShadowBlur').addEventListener('input', updateImageShadow);
        document.getElementById('imgShadowColor').addEventListener('input', updateImageShadow);
        document.getElementById('overlayTopColor').addEventListener('input', updateOverlay);


        document.getElementById('overlayBottomColor').addEventListener('input', updateOverlay);
        document.getElementById('overlayOpacity').addEventListener('input', updateOverlay);

        function updateOverlay() {
            var topColor = document.getElementById('overlayTopColor').value;
            var bottomColor = document.getElementById('overlayBottomColor').value;
            var opacity = document.getElementById('overlayOpacity').value / 100;
            var overlay = document.querySelector('.display-mobile .background-overlay');

            overlay.style.background =
                `linear-gradient(to bottom, rgba(${hexToRgb(topColor)}, ${opacity}), rgba(${hexToRgb(bottomColor)}, ${opacity}))`;
        }

        function hexToRgb(hex) {
            var r = parseInt(hex.slice(1, 3), 16);
            var g = parseInt(hex.slice(3, 5), 16);
            var b = parseInt(hex.slice(5, 7), 16);
            return `${r}, ${g}, ${b}`;
        }

        document.getElementById('backgroundImageUpload').addEventListener('change', function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var displayMobile = document.querySelector('.display-mobile');
                displayMobile.style.backgroundImage = 'url(' + reader.result + ')';
            };
            reader.readAsDataURL(event.target.files[0]);
        });

        document.getElementById('image1Upload').addEventListener('change', function(event) {
            updateImagePreview(event, '.section-two-img-and-price .img1', 'imagePrevi1');
        });

        document.getElementById('image2Upload').addEventListener('change', function(event) {
            updateImagePreview(event, '.section-two-img-and-price .img2', 'imagePrevi2');
        });

        function updateImagePreview(event, selector, element) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.querySelector(selector);
                output.src = reader.result;

                var output = document.getElementById(element);
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
