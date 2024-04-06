@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                Add Categoria
            </h6>
            <div class="ml-auto">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Retornar Para Categorias</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="subcategory_id" id="subcategory_id" value="">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="parent_id">Categoria Pai</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">---</option>
                                @forelse ($categorias as $categoria)
                                    <option value="{{ $categoria['name'] }}" id="{{ $categoria['id'] }}"
                                        {{ old('category_id') == $categoria['id'] ? 'selected' : null }}>
                                        {{ $categoria['name'] }}
                                    </option>
                                @empty
                                    <option value="" disabled>No categories found</option>
                                @endforelse
                            </select>
                            @error('parent_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- Novo select para as subcategorias (será preenchido via Ajax) -->
                    <div class="col-12">
                        <div class="form-group" id="subcategories-container" required>
                            <!-- Subcategorias serão adicionadas aqui via Ajax -->
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">---</option>
                                <option value="1" {{ old('status') == '1' ? 'selected' : null }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : null }}>Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-12">
                        <label for="cover">Imagem</label>
                        <br>
                        <div class="file-loading">
                            <input type="file" name="cover" id="category-img" class="file-input-overview">
                            <span class="form-text text-muted">Image width should be 500px x 500px</span>
                        </div>
                        @error('cover')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button class="btn btn-primary" type="submit" name="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        // Adiciona um ouvinte de evento quando uma opção é selecionada
        document.getElementById('parent_id').addEventListener('change', function() {
            var categoryId = this.options[this.selectedIndex]; // Obtém o ID da categoria selecionada
            // alert(categoryId.getAttribute('id'))

            // Chama a função Ajax para obter subcategorias
            fetchSubcategories(categoryId.getAttribute('id'));
        });

        function fetchSubcategories(categoryId) {
            // Implemente a lógica Ajax aqui usando o ID da categoria selecionada
            // Exemplo de solicitação Ajax usando fetch:
            fetch('https://api.mercadolibre.com/categories/' + categoryId)
                .then(response => response.json())
                .then(data => {
                    // Chama uma função para processar os dados e gerar o novo select
                    console.log(data);
                    processSubcategories(data);
                })
                .catch(error => console.error('Erro na solicitação Ajax:', error));
        }

        function processSubcategories(data) {
            var subcategories = data.children_categories;

            // Limpa os selects subsequentes
            var subcategoriesContainer = document.getElementById('subcategories-container');
            subcategoriesContainer.innerHTML = '';

            // Obtém a última subcategoria selecionada (se houver)
            var lastSelectedSubcategory = document.getElementById('last-selected-subcategory');
            var lastSelectedSubcategoryId = lastSelectedSubcategory ? lastSelectedSubcategory.value : null;

            if (subcategories && subcategories.length > 0) {
                // Se houver subcategorias, cria um novo select
                var selectHtml = '<label for="subcategory">Subcategoria</label>';
                selectHtml += '<select name="subcategory" class="form-control">';
                selectHtml += '<option value="">Selecione a SubCategoria</option>';

                // Adiciona a opção "Voltar" apenas se houver uma última subcategoria selecionada
                if (lastSelectedSubcategoryId) {
                    selectHtml += '<option value="back">Voltar</option>';
                }

                subcategories.forEach(subcategory => {
                    selectHtml += '<option value="' + subcategory.id + '">' + subcategory.name + '</option>';
                });

                selectHtml += '</select>';

                // Cria um novo elemento div para conter o select
                var newSelectContainer = document.createElement('div');
                newSelectContainer.classList.add('form-group');
                newSelectContainer.innerHTML = selectHtml;

                // Adiciona o novo select ao contêiner de subcategorias
                subcategoriesContainer.appendChild(newSelectContainer);

                // Adiciona um ouvinte de evento para o novo select
                var newSelect = newSelectContainer.querySelector('select');
                newSelect.addEventListener('change', function() {
                    // Obtém o ID da subcategoria selecionada
                    var selectedSubcategoryId = this.value;

                    if (selectedSubcategoryId === 'back') {
                        // Se a opção "Voltar" for selecionada, recarrega a última subcategoria
                        fetchSubcategories(lastSelectedSubcategoryId);
                    } else {
                        // Atualiza o valor do campo hidden com o ID da subcategoria selecionada
                        document.getElementById('subcategory_id').value = selectedSubcategoryId;

                        // Chama a função Ajax para obter subcategorias da próxima camada
                        fetchSubcategories(selectedSubcategoryId);

                        // Atualiza o valor da última subcategoria selecionada
                        lastSelectedSubcategory.value = selectedSubcategoryId;
                    }
                });
            } else {
                // Se não houver subcategorias, exibe a categoria atual
                var categoryHtml = '<label for="category">Categoria</label>';
                categoryHtml += '<input type="text" class="form-control" name="name" value="' + data.name + '" >';

                var categoryContainer = document.createElement('div');
                categoryContainer.classList.add('form-group');
                categoryContainer.innerHTML = categoryHtml;

                // Adiciona a categoria atual ao contêiner de subcategorias
                subcategoriesContainer.appendChild(categoryContainer);
            }
        }





        $(function() {
            $("#category-img").fileinput({
                theme: "fas",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false
            })
        })
    </script>
@endsection
