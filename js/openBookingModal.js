document.addEventListener("DOMContentLoaded", function () {
    const branchSelect = document.getElementById("appointmentBranch");
    const serviceSelect = document.getElementById("appointmentService");
    const dentistSelect = document.getElementById("appointmentDentist");
    const dateSelect = document.getElementById("appointmentDate");
    const timeSelect = document.getElementById("appointmentTime");
    const errorMsg = document.getElementById("dateError");

    window.openBookingModal = function () {
        document.getElementById("bookingModal").style.display = "block";
        document.body.classList.add("modal-open");
    };

    window.closeBookingModal = function () {
        document.getElementById("bookingModal").style.display = "none";
        document.body.classList.remove("modal-open");
    };

    function loadServices() {
        const branchId = branchSelect.value;

        if (branchId) {
            $.ajax({
                type: "POST",
                url: `${BASE_URL}/processes/load_services.php`,
                data: { appointmentBranch: branchId },
                success: function (response) {
                    serviceSelect.innerHTML = response;
                    dentistSelect.innerHTML = `<option value="" disabled selected hidden></option>`;
                },
                error: function () {
                    serviceSelect.innerHTML = '<option disabled>Error loading services</option>';
                }
            });
        } else {
            serviceSelect.innerHTML = '<option value="" disabled selected hidden></option>';
        }
    }

    function loadDentists() {
        const branchId = branchSelect.value;
        const serviceId = serviceSelect.value;

        if (branchId && serviceId) {
            $.ajax({
                type: "POST",
                url: `${BASE_URL}/processes/load_dentists.php`,
                data: {
                    appointmentBranch: branchId,
                    appointmentService: serviceId
                },
                success: function (response) {
                    dentistSelect.innerHTML = response;
                },
                error: function () {
                    dentistSelect.innerHTML = '<option disabled>Error loading dentists</option>';
                }
            });
        } else {
            dentistSelect.innerHTML = '<option value="" disabled selected hidden></option>';
        }
    }

    function loadAvailableTimes() {
        const branchId = branchSelect.value;
        const date = dateSelect.value;

        if (!date) return;

        const selectedDate = new Date(date);
        if (selectedDate.getDay() === 0) {
            errorMsg.style.display = "block";
            dateSelect.value = "";
            resetTime();
            return;
        } else {
            errorMsg.style.display = "none";
        }

        if (branchId && date) {
            fetch(`${BASE_URL}/processes/load_booked_times.php`, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `branch_id=${branchId}&appointment_date=${date}`
            })
            .then(res => res.json())
            .then(bookedTimes => {
                [...timeSelect.options].forEach(opt => {
                    if (opt.value && bookedTimes.includes(opt.value)) {
                        opt.disabled = true;
                        opt.style.color = "#999";
                    } else {
                        opt.disabled = false;
                        opt.style.color = "#000";
                    }
                });

                if (timeSelect.value && bookedTimes.includes(timeSelect.value)) {
                    timeSelect.value = "";
                }
            })
            .catch(err => console.error("Error fetching times:", err));
        }
    }

    function resetDateAndTime() {
        if (dateSelect) dateSelect.value = "";
        resetTime();
    }

    function resetTime() {
        if (timeSelect) {
            timeSelect.value = "";
            [...timeSelect.options].forEach(opt => {
                opt.disabled = false;
                opt.style.color = "#000";
            });
        }
    }

    if (branchSelect && serviceSelect && dentistSelect && dateSelect && timeSelect) {
        branchSelect.addEventListener("change", () => {
            loadServices();
            resetDateAndTime();
        });

        serviceSelect.addEventListener("change", () => {
            loadDentists();
            resetDateAndTime();
        });

        dentistSelect.addEventListener("change", resetDateAndTime);

        dateSelect.addEventListener("change", loadAvailableTimes);
    }
});
