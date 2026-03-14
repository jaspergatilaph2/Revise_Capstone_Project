document.addEventListener('DOMContentLoaded', function () {

    const calendarEl = document.getElementById('calendar');
    const eventModalEl = document.getElementById('eventModal');
    const alertModalEl = document.getElementById('alertModal');

    const eventModal = new bootstrap.Modal(eventModalEl);
    const alertModal = new bootstrap.Modal(alertModalEl);

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,

        eventContent: function (arg) {
            return {
                html: `
                <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;text-align:center;">
                    <div style="font-weight:600">${arg.event.title}</div>
                    <div style="font-size:12px;color:#555">${arg.timeText}</div>
                </div>
                `
            };
        },

        dateClick: function (info) {
            document.getElementById('event_date').value = info.dateStr;
            eventModal.show();
        }
    });

    calendar.render();

    document.getElementById('saveEvent').addEventListener('click', function () {

        const title = document.getElementById('event_title').value.trim();
        const date = document.getElementById('event_date').value;
        const time = document.getElementById('event_time').value;
        const color = document.getElementById('event_color').value;

        if (title && time) {

            const datetime = date + "T" + time;

            calendar.addEvent({
                title: title,
                start: datetime,
                backgroundColor: color,
                borderColor: color
            });

            // clear inputs
            document.getElementById('event_title').value = "";
            document.getElementById('event_time').value = "";

            eventModal.hide();

        } else {

            document.getElementById('alertMessage').innerText = "Please enter event title and time";
            alertModal.show();

        }

    });

});