@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('backend/vendor/select2/css/select2.min.css') }}">
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                Criar Produto
            </h6>
            <div class="ml-auto">
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Retornar</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label for="name" class="text-small text-uppercase">Nome</label>
                            <input id="name" type="text" class="form-control form-control-lg title-case"
                                name="name" value="{{ old('name') }}" maxlength="60">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="price" class="text-small text-uppercase">Valor</label>
                            <input id="price" type="text" class="form-control form-control-lg money" name="price"
                                value="{{ old('price') }}">
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="quantity" class="text-small text-uppercase">Quantidade</label>
                            <input id="quantity" type="number" max="10000" class="form-control form-control-lg"
                                name="quantity" value="{{ old('quantity') }}">
                            @error('quantity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="condition" class="text-small text-uppercase">{{ __('Condição') }}</label>
                            <select id="condition" class="form-control form-control-lg" name="condition">
                                <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>Novo</option>
                                <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Usado</option>
                            </select>
                            @error('condition')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="brand">Marca</label>
                            <input type="text" class="form-control" name="brand" value="{{ old('brand') }}">
                            @error('brand')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="model">Modelo</label>
                            <input type="text" class="form-control" name="model" value="{{ old('model') }}">
                            @error('model')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="category_id">Categorias</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">---</option>
                                @forelse($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : null }}>
                                        {{ $category->name }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <select name="tags[]" id="tags" class="form-control select2" multiple="multiple">
                                @forelse($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('tags')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="height" class="text-small text-uppercase">Altura (cm)</label>
                            <input id="height" type="number" class="form-control form-control-lg" name="height"
                                value="{{ old('height') }}">
                            @error('height')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="width" class="text-small text-uppercase">Largura (cm)</label>
                            <input id="width" type="number" class="form-control form-control-lg" name="width"
                                value="{{ old('width') }}">
                            @error('width')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="length" class="text-small text-uppercase">Comprimento (cm)</label>
                            <input id="length" type="number" class="form-control form-control-lg" name="length"
                                value="{{ old('length') }}">
                            @error('length')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="weight" class="text-small text-uppercase">Peso (g)</label>
                            <input id="weight" type="text" class="form-control form-control-lg" name="weight"
                                value="{{ old('weight') }}"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 3, 'radixPoint': '.', 'placeholder': '0'">
                            @error('weight')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="featured">Destacar</label>
                            <select name="featured" id="featured" class="form-control">
                                <option value="">---</option>
                                <option value="1" {{ old('featured') == '1' ? 'selected' : null }}>Sim</option>
                                <option value="0" {{ old('featured') == '0' ? 'selected' : null }}>Não</option>
                            </select>
                            @error('featured')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">---</option>
                                <option value="1" {{ old('status') == '1' ? 'selected' : null }}>Ativo</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : null }}>Inativo</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="description" class="text-small text-uppercase">{{ __('Descrição') }}</label>
                            <textarea name="description" rows="3" class="form-control summernote">{!! old('description') !!}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="details" class="text-small text-uppercase">{{ __('Detalhes') }}</label>
                            <textarea name="details" rows="3" class="form-control summernote">{!! old('details') !!}</textarea>
                            @error('details')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="images">Imagens</label>
                        <br>
                        <div class="file-loading">
                            <input type="file" name="images[]" id="product-images" class="file-input-overview"
                                multiple="multiple">
                        </div>
                        @error('images')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Salvar') }}
                    </button>
                </div>
            </form>
            {{-- <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label for="name" class="text-small text-uppercase">Nome</label>
                            <input id="name" type="text" class="form-control form-control-lg title-case" name="name"
                                   value="dwqdwqdqwd dwqdwqdwq qwdwqdqwd qwdqwdqw{{ old('name') }}">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="price" class="text-small text-uppercase">Valor</label>
                            <input id="price" type="text" class="form-control form-control-lg money" name="price"
                                   value="2323{{ old('price') }}" >
                            @error('price')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="quantity" class="text-small text-uppercase">{{ __('Quantidade') }}</label>
                            <input id="quantity" type="number" max="10000" class="form-control form-control-lg" name="quantity"
                                   value="23{{ old('quantity') }}" >
                            @error('quantity')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="condition" class="text-small text-uppercase">{{ __('Condição') }}</label>
                            <select id="condition" class="form-control form-control-lg" name="condition">
                                <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>Novo</option>
                                <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Usado</option>
                            </select>
                            @error('condition')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="brand">Marca</label>
                        <input type="text" class="form-control" name="brand" value="232323{{ old('brand') }}">
                        @error('brand')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="model">Modelo</label>
                            <input type="text" class="form-control" name="model" value="23232323{{ old('model') }}">
                            @error('model')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                  
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="category_id">Categorias</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">---</option>
                                @forelse($categories as $category)
                                    <option value="{{ $category->id }}"  selected old('category_id') == $category->id ? 'selected' : null }}>
                                        {{ $category->name }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                            @error('category_id')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <select name="tags[]" id="tags" class="form-control select2" multiple="multiple">
                                @forelse($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('tags')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="height" class="text-small text-uppercase">Altura (cm)</label>
                            <input id="height" type="number" class="form-control form-control-lg" name="height" value="23{{ old('height') }}" >
                            @error('height')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="width" class="text-small text-uppercase">Largura (cm)</label>
                            <input id="width" type="number" class="form-control form-control-lg" name="width" value="23{{ old('width') }}" >
                            @error('width')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="length" class="text-small text-uppercase">Comprimento (cm)</label>
                            <input id="length" type="number" class="form-control form-control-lg" name="length" value="23{{ old('length') }}" >
                            @error('length')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="featured">Destacar</label>
                            <select name="featured" id="featured" class="form-control">
                                <option value="">---</option>
                                <option value="1" selected {{ old('featured') == "1" ? 'selected' : null }}>Sim</option>
                                <option value="0" {{ old('featured') == "0" ? 'selected' : null }}>Não</option>
                            </select>
                            @error('featured')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">---</option>
                                <option value="1" selected {{ old('status') == "1" ? 'selected' : null }}>Ativo</option>
                                <option value="0" {{ old('status') == "0" ? 'selected' : null }}>Inativo</option>
                            </select>
                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="description" class="text-small text-uppercase">{{ __('Descrição') }}</label>
                            <textarea name="description" rows="3" class="form-control summernote">{!! old('description') !!}wfwrfdvgefvfbrgfevf</textarea>
                            @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="details" class="text-small text-uppercase">{{ __('Detalhes') }}</label>
                            <textarea name="details" rows="3" class="form-control summernote">{!! old('details') !!}wfwrfdvgefvfbrgfevf</textarea>
                            @error('details')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="images">Imagens</label>
                        <br>
                        <div class="file-loading">
                            <input type="file" name="images[]" id="product-images" class="file-input-overview" multiple="multiple">
                        </div>
                        @error('images')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Salvar') }}
                    </button>
                </div>
            </form> --}}
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('backend/vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Aplica a máscara ao campo de peso
            $('#weight').inputmask('numeric', {
                radixPoint: '.',
                groupSeparator: '',
                autoGroup: true,
                digits: 3,
                placeholder: '0.000'
            });

        });
        $(function() {
            // summernote
            $('.summernote').summernote({
                tabSize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            })
            // upload images
            $("#product-images").fileinput({
                theme: "fas",
                maxFileCount: 5,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false
            });
            // select2
            function matchStart(params, data) {
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Skip if there is no 'children' property
                if (typeof data.children === 'undefined') {
                    return null;
                }

                // `data.children` contains the actual options that we are matching against
                var filteredChildren = [];
                $.each(data.children, function(idx, child) {
                    if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
                        filteredChildren.push(child);
                    }
                });

                // If we matched any of the timezone group's children, then set the matched children on the group
                // and return the group object
                if (filteredChildren.length) {
                    var modifiedData = $.extend({}, data, true);
                    modifiedData.children = filteredChildren;

                    // You can return modified objects from here
                    // This includes matching the `children` how you want in nested data sets
                    return modifiedData;
                }

                // Return `null` if the term should not be displayed
                return null;
            }
            $(".select2").select2({
                tags: true,
                closeOnSelect: false,
                minimumResultsForSearch: Infinity,
                matcher: matchStart
            });
        })
    </script>
@endsection
