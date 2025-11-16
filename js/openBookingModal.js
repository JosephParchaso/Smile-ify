document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        document.querySelectorAll(".flash-msg").forEach((el) => {
            el.style.transition = "opacity 1s ease";
            el.style.opacity = "0";
            setTimeout(() => el.remove(), 1000);
        });
    }, 10000);

    const branchSelect = document.getElementById("appointmentBranch");
    const dateSelect = document.getElementById("appointmentDate");
    const timeSelect = document.getElementById("appointmentTime");
    const servicesContainer = document.getElementById("servicesContainer");
    const dentistSelect = document.getElementById("appointmentDentist");
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

    if (!branchSelect || !dateSelect || !timeSelect || !servicesContainer || !dentistSelect) {
        return;
    }

    dateSelect.disabled = true;
    dentistSelect.disabled = true;
    timeSelect.disabled = true;

    function resetServices() {
        servicesContainer.innerHTML = `<p class="loading-text">Select a branch to load services</p>`;
    }

    function resetDentist() {
        dentistSelect.disabled = true;
        dentistSelect.innerHTML = '<option value="" disabled selected hidden></option>';
    }

    function resetTime() {
        timeSelect.disabled = true;
        timeSelect.innerHTML = '<option value="" disabled selected hidden></option>';
        estimatedEndDisplay.textContent = "";
    }

    function resetDate() {
        dateSelect.value = "";
    }

    function loadAvailableTimes() {
        const branchId = branchSelect.value;
        const date = dateSelect.value;

        if (!branchId || !date) {
            resetTime();
            return;
        }

        timeSelect.disabled = false;
        timeSelect.innerHTML = '<option value="" disabled selected hidden></option>';

        const allSlots = [];
        const step = 30;
        const start = new Date("2000-01-01T09:00:00");
        const end = new Date("2000-01-01T16:30:00");

        while (start < end) {
            const hh = String(start.getHours()).padStart(2, "0");
            const mm = String(start.getMinutes()).padStart(2, "0");
            allSlots.push(`${hh}:${mm}`);
            start.setMinutes(start.getMinutes() + step);
        }

        allSlots.forEach(time => {
            const [h, m] = time.split(":");
            let hour = parseInt(h);
            const ampm = hour >= 12 ? "PM" : "AM";
            hour = hour % 12 || 12;
            const formatted = `${hour}:${m} ${ampm}`;

            timeSelect.innerHTML += `
                <option value="${time}">${formatted}</option>
            `;
        });
    }

    function loadServices() {
        const branchId = branchSelect.value;
        if (!branchId) {
            resetServices();
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
        })
        .catch(err => {
            console.error("Service load error:", err);
            servicesContainer.innerHTML = `<p class="error-msg">Failed to load services.</p>`;
        });
    }

    function loadDentists() {
        const branchId = branchSelect.value;
        const date = dateSelect.value;
        const time = timeSelect.value;

        const checkedServices = [
            ...document.querySelectorAll("#servicesContainer input[type='checkbox']:checked"),
        ].map(cb => cb.value);

        if (!branchId || !date || !time || checkedServices.length === 0) {
            resetDentist();
            return;
        }

        const fd = new FormData();
        fd.append("appointmentBranch", branchId);
        fd.append("appointmentDate", date);
        fd.append("appointmentTime", time);
        checkedServices.forEach(s => fd.append("appointmentServices[]", s));

        dentistSelect.disabled = true;
        dentistSelect.innerHTML = `<option disabled>Loading dentists...</option>`;

        fetch(`${BASE_URL}/processes/load_dentists.php`, {
            method: "POST",
            body: fd
        })
        .then(res => res.text())
        .then(html => {
            dentistSelect.innerHTML = html;
            dentistSelect.disabled = false;
        })
        .catch(err => {
            console.error("Dentist load error:", err);
            dentistSelect.innerHTML = `<option disabled>Error loading dentists</option>`;
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

            let durationText = hours > 0
                ? `${hours} hour${hours > 1 ? "s" : ""}${minutes > 0 ? " and " + minutes + " min" : ""}`
                : `${minutes} min`;

            estimatedEndDisplay.textContent = `Estimated End Time: ${formattedEnd} (${durationText})`;
        });
    }

    function updateEstimatedEndTime() {
        const selectedTime = timeSelect.value;
        if (!selectedTime) {
            estimatedEndDisplay.textContent = "";
            return;
        }

        const selectedServices = Array.from(
            document.querySelectorAll("#servicesContainer input[type='checkbox']:checked")
        );

        let totalDuration = 0;
        selectedServices.forEach(cb => {
            totalDuration += parseInt(cb.dataset.duration || 0);
        });

        if (totalDuration === 0) {
            estimatedEndDisplay.textContent = `Estimated End Time: ${selectedTime} (0 min)`;
            return;
        }

        const start = new Date(`2024-01-01T${selectedTime}:00`);
        start.setMinutes(start.getMinutes() + totalDuration);

        let endHours = start.getHours();
        const endMinutes = String(start.getMinutes()).padStart(2, "0");
        const ampm = endHours >= 12 ? "PM" : "AM";
        endHours = endHours % 12 || 12;

        const formattedEnd = `${endHours}:${endMinutes} ${ampm}`;

        const hours = Math.floor(totalDuration / 60);
        const minutes = totalDuration % 60;

        let durationText = hours > 0
            ? `${hours} hour${hours > 1 ? "s" : ""}${minutes > 0 ? " and " + minutes + " min" : ""}`
            : `${minutes} min`;

        estimatedEndDisplay.textContent =
            `Estimated End Time: ${formattedEnd} (${durationText})`;
    }

    branchSelect.addEventListener("change", () => {
        dateSelect.disabled = false;

        resetDate();
        resetTime();
        resetDentist();
        loadServices();
    });

    dateSelect.addEventListener("change", () => {
        resetTime();
        resetDentist();
        timeSelect.disabled = false;
        loadAvailableTimes();
    });

    timeSelect.addEventListener("change", () => {
        resetDentist();
        updateEstimatedEndTime();
    });

    servicesContainer.addEventListener("change", (e) => {
        if (e.target.matches("input[type='checkbox']")) {
            loadDentists();
            updateEstimatedEndTime();
        }
    });
});