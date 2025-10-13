document.addEventListener("DOMContentLoaded", function () {
    function loadUpcomingAppointments() {
        fetch(`${BASE_URL}/Admin/processes/index/get_upcoming_appointments.php`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    return;
                }

                const todayCount = document.getElementById("todayCount");
                const tomorrowCount = document.getElementById("tomorrowCount");

                if (todayCount && tomorrowCount) {
                    todayCount.textContent = data.today || 0;
                    tomorrowCount.textContent = data.tomorrow || 0;
                }
            })
            .catch(error => console.error("Error loading appointments:", error));
    }

    function loadPatientCounts() {
        fetch(`${BASE_URL}/Admin/processes/index/get_patient_counts.php`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    return;
                }

                const newPatients = document.getElementById("newPatientsCount");
                const totalPatients = document.getElementById("totalPatientsCount");

                if (newPatients && totalPatients) {
                    newPatients.textContent = data.newPatients || 0;
                    totalPatients.textContent = data.totalPatients || 0;
                }
            })
            .catch(error => console.error("Error loading patient counts:", error));
    }

    function loadLowSupplies() {
        fetch(`${BASE_URL}/Admin/processes/index/get_low_supplies.php`)
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById("lowSuppliesContainer");
                if (!container) return;

                if (data.error) {
                    container.innerHTML = `<div class="announcement">${data.error}</div>`;
                    return;
                }

                const supplies = data.lowSupplies || [];

                if (supplies.length === 0) {
                    container.innerHTML = `<div class="announcement">All supplies stocked</div>`;
                } else {
                    container.innerHTML = supplies
                        .map(s => `<div class="announcement">${s.name} - ${s.quantity} left</div>`)
                        .join("");
                }
            })
            .catch(error => console.error("Error loading low supplies:", error));
    }

    loadUpcomingAppointments();
    loadPatientCounts();
    loadLowSupplies();

    if (!window.dashboardUpdater) {
        window.dashboardUpdater = setInterval(() => {
            loadUpcomingAppointments();
            loadPatientCounts();
            loadLowSupplies();
        }, 60000);
    }
});
