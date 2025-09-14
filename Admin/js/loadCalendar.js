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
                <p><strong>Patient:</strong> ${appointment.patient}</p>
                <p><strong>Dentist:</strong> ${appointment.dentist ? "Dr. " + appointment.dentist : "Available Dentist"}</p>
                <p><strong>Service:</strong> ${appointment.service}</p>
                <p><strong>Date:</strong> ${info.event.start.toLocaleDateString()}</p>
                <p><strong>Time:</strong> ${info.event.start.toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}</p>
                <p><strong>Notes:</strong> ${appointment.notes ?? '-'}</p>
                <p><strong>Status:</strong> ${appointment.status}</p>
                <p><strong>Date Booked:</strong> ${appointment.date_created}</p>
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