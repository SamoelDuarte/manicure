{{-- resources/views/services/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Serviços</h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#serviceModal">
        Adicionar Serviço
    </button>
    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Valor</th>
                <th>Duração (minutos)</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($services as $service)
            <tr>
                <td>{{ $service->name }}</td>
                <td>{{ $service->value }}</td>
                <td>{{ $service->duration_minutes }}</td>
                <td>
                    <button class="btn btn-info" onclick="editService({{ json_encode($service) }})">Editar</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Modal for Add/Edit --}}
<div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="serviceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModalLabel">Serviço</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="serviceForm" action="{{ route('admin.services.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nome do Serviço</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="value">Valor</label>
                        <input type="text" class="form-control money" id="value" name="value" required>
                    </div>
                    <div class="form-group">
                        <label for="hours">Horas</label>
                        <input type="number" class="form-control" id="hours" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="minutes">Minutos</label>
                        <input type="number" class="form-control" id="minutes" min="0" max="59" required>
                    </div>
                    <input type="hidden" id="duration_minutes" name="duration_minutes">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editService(service) {
    var hours = Math.floor(service.duration_minutes / 60);
    var minutes = service.duration_minutes % 60;
    
    document.getElementById('name').value = service.name;
    document.getElementById('value').value = service.value;
    document.getElementById('hours').value = hours;
    document.getElementById('minutes').value = minutes;
    
    var form = document.getElementById('serviceForm');
    form.action = '{{ url("admin/services") }}/' + service.id;
    form.innerHTML += '<input type="hidden" name="_method" value="PUT">';
    $('#serviceModal').modal('show');
}

document.getElementById('serviceForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var hours = parseInt(document.getElementById('hours').value);
    var minutes = parseInt(document.getElementById('minutes').value);
    document.getElementById('duration_minutes').value = hours * 60 + minutes;
    this.submit();
});
</script>
@endsection
