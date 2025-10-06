document.addEventListener("DOMContentLoaded", function() {
    function loadPatientAppointments() {
        fetch(`${BASE_URL}/Patient/processes/get_upcoming_appointments.php`)
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById("patientUpcomingAppointments");
                if (!container) return;

                if (data.error) {
                    container.innerHTML = `<div class="appointment">${data.error}</div>`;
                    return;
                }

                const appts = data.appointments || [];
                if (appts.length === 0) {
                    container.innerHTML = `<div class="appointment">No upcoming appointments</div>`;
                    return;
                }

                container.innerHTML = appts.map(a => `
                    <div class="appointment">
                        <strong>${a.date}</strong> at ${a.time}<br>
                        ${a.service ? `${a.service}` : ""}
                        with ${a.dentist} (${a.branch})
                    </div>
                `).join("");
            })
            .catch(err => console.error("Error loading patient appointments:", err));
    }

    loadPatientAppointments();
});
