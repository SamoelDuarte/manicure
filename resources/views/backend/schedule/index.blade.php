@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        @php
        $days = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
        @endphp

        @foreach ($days as $day)
        <div class="col">
            <div class="card">
                <div class="card-header" id="{{ 'header-' . $loop->index }}" style="background-color: #ffe5e2;">{{ $day }}</div>
                <div class="card-body">
                    <!-- Switch para ativar/desativar -->
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="{{ 'switch-' . $loop->index }}" onchange="toggleStatus(this, '{{ 'header-' . $loop->index }}')">
                        <label class="custom-control-label" for="{{ 'switch-' . $loop->index }}">Inativo</label>
                    </div>
                    <!-- Inputs para horas e minutos -->
                    <div class="form-group">
                        <label>Hora de início:</label>
                        <input type="time" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Hora de término:</label>
                        <input type="time" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<script>
function toggleStatus(element, headerId) {
    var header = document.getElementById(headerId);
    if (element.checked) {
        element.nextElementSibling.textContent = 'Ativo';
        header.style.backgroundColor = '#e2ffee'; // Verde transparente
    } else {
        element.nextElementSibling.textContent = 'Inativo';
        header.style.backgroundColor = '#ffe5e2'; // Vermelho transparente
    }
}
</script>
@endsection
