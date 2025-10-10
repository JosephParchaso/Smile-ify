document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    var branchId = document.getElementById('branchIdInput').value;
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'customPrev,customNext today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        customButtons: {
            customPrev: { text: '<', click: () => calendar.prev() },
            customNext: { text: '>', click: () => calendar.next() }
        },
        height: 650,
        events: {
            url: `${BASE_URL}/Admin/processes/calendar/load_calendar.php`,
            method: 'GET',
            extraParams: {
                branch_id: branchId
            }
        },
        eventClick: function(info) {
            const appointment = info.event.extendedProps;

        const modalBody = document.getElementById('modalBody');
        modalBody.innerHTML = `
            <h2>Appointment Details</h2>
            <p><strong>Patient:</strong><span>${appointment.patient || '-'}</span></p>
            <p><strong>Dentist:</strong><span>${appointment.dentist ? 'Dr. ' + appointment.dentist : 'Not Assigned'}</span></p>
            <p><strong>Service:</strong><span>${appointment.services || '-'}</span></p>
            <p><strong>Date:</strong><span>${
                info.event.start
                    ? info.event.start.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })
                    : '-'
            }</span></p>
            <p><strong>Time:</strong><span>${
                info.event.start
                    ? info.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })
                    : '-'
            }</span></p>
            <p><strong>Notes:</strong><span>${appointment.notes || '-'}</span></p>
            <p><strong>Status:</strong><span>${appointment.status || '-'}</span></p>
            <p><strong>Date Booked:</strong><span>${
                appointment.date_created
                    ? new Date(appointment.date_created).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })
                    : '-'
            }</span></p>
        `;

            document.getElementById('appointmentModalDetails').style.display = "block";
        }
    });

    calendar.render();

    window.addEventListener('click', function(event) {
        const modal = document.getElementById('appointmentModalDetails');
        const modalContent = document.querySelector('.booking-modal-content');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});