@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                Banners
            </h6>
            <div class="ml-auto">
                @can('create_category')
                    <a href="{{ route('admin.banner.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                        <span class="text">Novo Banner</span>
                    </a>
                @endcan
            </div>
        </div>

        @include('partials.backend.filter', ['model' => route('admin.banner.index')])

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>IMG</th>
                    <th>Titulo</th>
                    <th>SubTitulo</th>
                    <th class="text-center" style="width: 30px;">Ações</th>
                </tr>
                </thead>
                <tbody>
                @forelse($banners as $banner)
                    <tr>
                    
                        <td>
                            @if($banner->image)
                            <img src="{{ asset('storage/images/banners/' . $banner->image) }}"
                                 width="60" height="60" alt="{{ $banner->title }}">
                            @else
                                <img src="{{ asset('img/no-img.png') }}" width="60" height="60" alt="{{ $banner->title }}">
                            @endif
                        </td>
                        <td><a href="{{ route('admin.banner.show', $banner->id) }}">{{ $banner->title }}</a></td>
                        <td>{{ $banner->subtitle }}</td>
                       
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.banner.edit', $banner) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="javascript:void(0);"
                                   onclick="if (confirm('Deseja realmente Deletar o Banner ?'))
                                       {document.getElementById('delete-banner-{{ $banner->id }}').submit();} else {return false;}"
                                   class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                            <form action="{{ route('admin.banner.destroy', $banner) }}"
                                  method="POST"
                                  id="delete-banner-{{ $banner->id }}" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="10">Nenhum Banner Encontrado.</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="10">
                        <div class="float-right">
                            {!! $banners->appends(request()->all())->links() !!}
                        </div>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
