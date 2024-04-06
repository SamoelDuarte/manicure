@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('backend/vendor/select2/css/select2.min.css') }}">
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                Criar Banner
            </h6>
            <div class="ml-auto">
                <a href="{{ route('admin.banner.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Retornar</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.banner.update', $banner) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="title" class="text-small text-uppercase">Titulo</label>
                            <input id="title" type="text" class="form-control form-control-lg title-case"
                                name="title" value="{{ old('title', $banner->title) }}">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="subtitle" class="text-small text-uppercase">SubTitulo</label>
                            <input id="subtitle" type="text" class="form-control form-control-lg " name="subtitle"
                                value="{{ old('subtitle', $banner->subtitle) }}">
                            @error('subtitle')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" {{ old('status', $banner->status) == 'Ativo' ? 'selected' : null }}>
                                    Ativo
                                </option>
                                <option value="0"
                                    {{ old('status', $banner->status) == 'Inactive' ? 'selected' : null }}>
                                    Inactive
                                </option>
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
                            <textarea name="description" rows="3" class="form-control summernote">{!! old('description', $banner->description) !!}</textarea>
                            @error('description')
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
                            <input type="file" name="images" id="banner-images" class="file-input-overview">
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
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
            // summernote
            $('.summernote').summernote({
                tabSize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style',
                        'color'
                    ]], // Adicione 'color' aqui para incluir o botão de seleção de cor
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]

            })

            // upload images
            $("#banner-images").fileinput({
                theme: "fas",
                maxFileCount: 5,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if ($banner->image)
                        "{{ asset('storage/images/banners/' . $banner->image) }}",
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($banner->image)

                        {

                            caption: "{{ $banner->image }}",
                            size: "{{ $banner->image }}",
                            width: "120px",
                            url: "{{ route('admin.banner.remove_image', [
                                'id' => $banner->id,
                                'image' => $banner->image,
                                '_token' => csrf_token(),
                            ]) }}",
                            key: {{ $banner->id }}
                        },
                    @endif
                ]
            }).on('filesorted', function(event, params) {
                console.log(params.previewId, params.oldIndex, params.newIndex, params.stack)
            });



        })
    </script>
@endsection
