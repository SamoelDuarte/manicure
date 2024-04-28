@extends('layouts.app')
@section('title', 'Agenda')

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

                if (isAvailable) {
                    info.el.style.backgroundColor = '#00800047'; // Dia disponível (verde)
                    info.el.addEventListener('click', function() {
                        // Exibir um alerta com informações sobre a célula clicada
                        alert('Dia disponível: ' + info);

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
            case 'sunday':
                return 0;
            case 'monday':
                return 1;
            case 'tuesday':
                return 2;
            case 'wednesday':
                return 3;
            case 'thursday':
                return 4;
            case 'friday':
                return 5;
            case 'saturday':
                return 6;
            default:
                return -1; // Retorna -1 se o nome do dia da semana for inválido
        }
    }
</script>
