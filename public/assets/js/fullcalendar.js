import { Calendar } from '@fullcalendar/core';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ interactionPlugin ],
        locale: 'fr',
        firstDay: 1,
        initialView: 'dayGridMonth',
        buttonText: {
            today: 'Aujourd\'hui',
            month: 'mois',
            week: 'semaine',
            list: 'Liste'
        },
        dayClick: function(date, jsEvent, view) {
            //$('#schedule-add').modal('show');
            console.log('ok');
        }
    });
    calendar.render();
});