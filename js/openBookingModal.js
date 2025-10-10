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
    const estimatedEndDisplay = document.getElementById("estimatedEnd");

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
        if (estimatedEndDisplay) estimatedEndDisplay.textContent = "";
    }

    function resetDateAndTime() {
        if (dateSelect) dateSelect.value = "";
        resetTime();
    }

    function loadServices() {
        const branchId = branchSelect?.value;
        if (!branchId) {
            servicesContainer.innerHTML = `<p class="loading-text">Select a branch to load available services</p>`;
            return;
        }

        servicesContainer.innerHTML = `<p class="loading-text">Loading services</p>`;

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

        dentistSelect.innerHTML = `<option disabled>Loading available dentists</option>`;

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

        timeSelect.innerHTML = '<option disabled>Loading available times</option>';

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

                if (Array.isArray(data.times)) {
                    let options = '<option value="" disabled selected hidden></option>';

                    const allSlots = [];
                    const start = new Date("2000-01-01T09:00:00");
                    const end = new Date("2000-01-01T16:30:00");

                    while (start < end) {
                        const hh = String(start.getHours()).padStart(2, "0");
                        const mm = String(start.getMinutes()).padStart(2, "0");
                        allSlots.push(`${hh}:${mm}`);
                        start.setMinutes(start.getMinutes() + 30);
                    }

                    allSlots.forEach(time => {
                        const [h, m] = time.split(":");
                        let hour = parseInt(h);
                        const ampm = hour >= 12 ? "PM" : "AM";
                        hour = hour % 12 || 12;
                        const formatted = `${hour}:${m} ${ampm}`;

                        const isAvailable = data.times.includes(time);
                        const isBlocked = data.blocked.includes(time);

                        if (!isAvailable || isBlocked) {
                            options += `<option value="${time}" disabled style="color: gray;">${formatted}</option>`;
                        } else {
                            options += `<option value="${time}">${formatted}</option>`;
                        }
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

    if (timeSelect) {
        timeSelect.addEventListener("change", function () {
            const selected = this.value;
            if (!selected) return;

            const selectedServices = Array.from(
                document.querySelectorAll("#servicesContainer input[type='checkbox']:checked")
            );

            let totalDuration = 0;
            selectedServices.forEach(cb => {
                totalDuration += parseInt(cb.dataset.duration || 0);
            });

            const start = new Date(`2024-01-01T${selected}:00`);
            start.setMinutes(start.getMinutes() + totalDuration);
            
            let endHours = start.getHours();
            const endMinutes = String(start.getMinutes()).padStart(2, "0");
            const ampm = endHours >= 12 ? "PM" : "AM";
            endHours = endHours % 12 || 12;
            const formattedEnd = `${endHours}:${endMinutes} ${ampm}`;

            const hours = Math.floor(totalDuration / 60);
            const minutes = totalDuration % 60;
            let durationText = "";
            if (hours > 0) {
                durationText += `${hours} hour${hours > 1 ? "s" : ""}`;
                if (minutes > 0) durationText += ` and ${minutes} min${minutes > 1 ? "s" : ""}`;
            } else {
                durationText = `${minutes} min${minutes > 1 ? "s" : ""}`;
            }

            if (estimatedEndDisplay)
                estimatedEndDisplay.textContent = `Estimated End Time: ${formattedEnd} (${durationText} total)`;
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
