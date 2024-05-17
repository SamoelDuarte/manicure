@extends('layouts.app')
@section('title', 'Agenda')

<style>
    #calendar {
        width: 800px;
        height: 600px;
    }
</style>
@section('content')
    <div id='calendar'></div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        selectable: true,
        locale: 'pt-br',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
        },
        // Textos dos botões
        buttonText: {
            today: 'Hoje',
        },
        events: [],
        dayCellDidMount: function(info) {
            var availability = {!! $availability !!};
            var dayOfWeek = info.date.getDay(); // 0 (Domingo) - 6 (Sábado)
            var isAvailable = availability.some(item => isAvailableString(item.day_of_week) ===
                dayOfWeek);

            var today = new Date();
            
            if (isSameDay(info.date, today)) {
                // Criar um elemento span para mostrar 'Hoje' com uma bolinha azul
                var todayMarker = document.createElement('span');
                todayMarker.innerHTML = `<span style="height: 10px; width: 10px; background-color: #0000ff; border-radius: 50%; display: inline-block;"></span> Hoje`;
                info.el.appendChild(todayMarker);
                info.el.style.backgroundColor = '#ffffff'; // Fundo branco para o dia atual
            } else if (isAvailable) {
                info.el.style.backgroundColor = '#00800047'; // Dia disponível (verde)
                info.el.addEventListener('click', function() {
                    alert('Dia disponível: ' + info.date.toLocaleDateString());
                });
            } else {
                info.el.style.backgroundColor = '#ff00002b'; // Dia indisponível (vermelho)
            }
        }
    });

    calendar.render();
});

function isAvailableString(string) {
    switch (string.toLowerCase()) {
        case 'segunda':
            return 1;
        case 'terça':
            return 2;
        case 'quarta':
            return 3;
        case 'quinta':
            return 4;
        case 'sexta':
            return 5;
        case 'sábado':
            return 6;
        case 'domingo':
            return 0;
        default:
            return -1; // Retorna -1 se o nome do dia da semana for inválido
    }
}

function isSameDay(d1, d2) {
    return d1.getFullYear() === d2.getFullYear() &&
           d1.getMonth() === d2.getMonth() &&
           d1.getDate() === d2.getDate();
}

</script>
