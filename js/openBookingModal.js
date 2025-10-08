document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        document.querySelectorAll(".flash-msg").forEach((el) => {
            el.style.transition = "opacity 1s ease";
            el.style.opacity = "0";
            setTimeout(() => el.remove(), 1000);
        });
    }, 10000);

    const branchSelect = document.getElementById("appointmentBranch");
    const servicesContainer = document.getElementById("servicesContainer");
    const dentistSelect = document.getElementById("appointmentDentist");
    const dateSelect = document.getElementById("appointmentDate");
    const timeSelect = document.getElementById("appointmentTime");

    window.openBookingModal = function () {
        const modal = document.getElementById("bookingModal");
        if (modal) {
            modal.style.display = "block";
            document.body.classList.add("modal-open");
        }
    };

    window.closeBookingModal = function () {
        const modal = document.getElementById("bookingModal");
        if (modal) {
            modal.style.display = "none";
            document.body.classList.remove("modal-open");
        }
    };

    function resetTime() {
        if (!timeSelect) return;
        timeSelect.value = "";
        timeSelect.innerHTML = '<option value="" disabled selected hidden></option>';
        [...timeSelect.options].forEach(opt => {
            opt.disabled = false;
            opt.style.color = "#000";
        });
    }

    function resetDateAndTime() {
        if (dateSelect) dateSelect.value = "";
        resetTime();
    }

    function loadServices() {
        const branchId = branchSelect?.value;
        if (!branchId) {
            servicesContainer.innerHTML = `<p class="loading-text">Select a branch to load available services...</p>`;
            return;
        }

        servicesContainer.innerHTML = `<p class="loading-text">Loading services...</p>`;

        fetch(`${BASE_URL}/processes/load_services.php`, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `appointmentBranch=${branchId}`,
        })
            .then(res => res.text())
            .then(html => {
                servicesContainer.innerHTML = html;
                dentistSelect.innerHTML = `<option value="" disabled selected hidden></option>`;
                resetDateAndTime();
            })
            .catch(err => {
                console.error("Error loading services:", err);
                servicesContainer.innerHTML = `<p class="error-msg">Failed to load services.</p>`;
            });
    }

    function loadDentists() {
        const branchId = branchSelect?.value;
        const checkedServices = [
            ...document.querySelectorAll("#servicesContainer input[type='checkbox']:checked"),
        ].map(cb => cb.value);

        if (!branchId || checkedServices.length === 0) {
            dentistSelect.innerHTML = '<option value="" disabled selected hidden></option>';
            resetDateAndTime();
            return;
        }

        const fd = new FormData();
        fd.append('appointmentBranch', branchId);
        checkedServices.forEach(s => fd.append('appointmentServices[]', s));

        dentistSelect.innerHTML = `<option disabled>Loading available dentists...</option>`;

        fetch(`${BASE_URL}/processes/load_dentists.php`, {
            method: "POST",
            body: fd,
        })
            .then(res => res.text())
            .then(html => {
                dentistSelect.innerHTML = html;
                resetDateAndTime();
            })
            .catch(err => {
                console.error("Error loading dentists:", err);
                dentistSelect.innerHTML = '<option disabled>Error loading dentists</option>';
            });
    }

    function loadAvailableTimes() {
        const branchId = branchSelect?.value;
        const date = dateSelect?.value;
        const services = [
            ...document.querySelectorAll("#servicesContainer input[type='checkbox']:checked")
        ].map(cb => cb.value);

        if (!branchId || !date || services.length === 0) {
            resetTime();
            return;
        }

        const fd = new FormData();
        fd.append("branch_id", branchId);
        fd.append("appointment_date", date);
        services.forEach(s => fd.append("services[]", s));

        timeSelect.innerHTML = '<option disabled>Loading available times...</option>';

        fetch(`${BASE_URL}/processes/load_available_times.php`, {
            method: "POST",
            body: fd,
        })
            .then(res => res.json())
            .then(data => {
                timeSelect.innerHTML = "";

                if (data.error) {
                    timeSelect.innerHTML = `<option disabled>${data.error}</option>`;
                    return;
                }

                if (Array.isArray(data) && data.length > 0) {
                    let options = '<option value="" disabled selected hidden></option>';
                    data.forEach(time => {
                        const [h, m] = time.split(":");
                        const formatted = new Date(0, 0, 0, h, m).toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        options += `<option value="${time}">${formatted}</option>`;
                    });
                    timeSelect.innerHTML = options;
                } else {
                    timeSelect.innerHTML = '<option disabled>No available times</option>';
                }
            })
            .catch(err => {
                console.error("Error loading available times:", err);
                timeSelect.innerHTML = '<option disabled>Error loading times</option>';
            });
    }

    if (branchSelect && servicesContainer && dentistSelect && dateSelect && timeSelect) {
        branchSelect.addEventListener("change", () => {
            loadServices();
            resetDateAndTime();
        });

        servicesContainer.addEventListener("change", (e) => {
            if (e.target.matches("input[type='checkbox']")) {
                loadDentists();
                resetDateAndTime();
            }
        });

        dentistSelect.addEventListener("change", resetDateAndTime);

        dateSelect.addEventListener("change", () => {
            resetTime();
            loadAvailableTimes();
        });
    }
});
