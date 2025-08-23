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
            url: `${BASE_URL}/Admin/processes/load_calendar.php`,
            method: 'GET',
            extraParams: {
                branch_id: branchId
            }
        },
        eventClick: function(info) {
            const appointment = info.event.extendedProps;

            document.getElementById('modalPatient').textContent = appointment.patient;
            document.getElementById('modalBranch').textContent = appointment.branch;
            document.getElementById('modalService').textContent = appointment.service;
            document.getElementById('modalDentist').textContent = appointment.dentist 
                ? "Dr. " + appointment.dentist 
                : "Not Assigned";
            document.getElementById('modalDate').textContent = info.event.start.toLocaleDateString();
            document.getElementById('modalTime').textContent = info.event.start.toLocaleTimeString([], {
                hour: '2-digit', minute: '2-digit'
            });

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