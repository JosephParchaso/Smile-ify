document.addEventListener("DOMContentLoaded", function () {
    const bookingModal = document.getElementById("manageAppointmentModal");
    const bookingBody = document.getElementById("appointmentModalBody");

    document.body.addEventListener("click", function (e) {
        if (e.target.id === "insertAppointmentBtn") {
            renderAppointmentForm();
            bookingModal.style.display = "block";

            const branchSelect = bookingBody.querySelector("#appointmentBranch");
            const dentistSelect = bookingBody.querySelector("#appointmentDentist");
            const dateSelect = bookingBody.querySelector("#appointmentDate");
            const timeSelect = bookingBody.querySelector("#appointmentTime");
            const servicesContainer = bookingBody.querySelector("#servicesContainer");
            const estimatedEndDiv = bookingBody.querySelector("#estimatedEnd");

            if (branchSelect) {
                loadBranches(branchSelect);

                branchSelect.addEventListener("change", () => {
                    loadServices(branchSelect.value, servicesContainer);
                    resetDentistDateTime(dentistSelect, dateSelect, timeSelect, estimatedEndDiv);
                });

                dentistSelect.addEventListener("change", () => {
                    resetDateAndTime(dateSelect, timeSelect, estimatedEndDiv);
                });

                dateSelect.addEventListener("change", () => {
                    resetTime(timeSelect, estimatedEndDiv);
                    loadAvailableTimes(branchSelect, dateSelect, servicesContainer, timeSelect);
                });

                timeSelect.addEventListener("change", () => {
                    calculateEstimatedEnd(timeSelect.value, servicesContainer, estimatedEndDiv);
                });
            }
        }
    });

    function renderAppointmentForm() {
        bookingBody.innerHTML = `
            <h2>Book Appointment</h2>
            <form id="manageAppointmentForm" action="${BASE_URL}/Admin/processes/manage_patient/insert_appointment.php" method="POST" autocomplete="off">
                <input type="hidden" name="user_id" value="${userId}">

                <div class="form-group">
                    <select id="appointmentBranch" name="appointmentBranch" class="form-control" required>
                        <option value="" disabled selected hidden></option>
                    </select>
                    <label for="appointmentBranch" class="form-label">Branch <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <div id="servicesContainer" class="checkbox-group">
                        <p class="loading-text">Select a branch to load available services</p>
                    </div>
                </div>

                <div class="form-group">
                    <select id="appointmentDentist" class="form-control" name="appointmentDentist" required>
                        <option value="" disabled selected hidden></option>
                    </select>
                    <label for="appointmentDentist" class="form-label">Dentist <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="date" id="appointmentDate" class="form-control" name="appointmentDate" required />
                    <label for="appointmentDate" class="form-label">Date <span class="required">*</span></label>
                    <span id="dateError" class="error-msg-calendar error">
                        Sundays are not available for appointments. Please select another date.
                    </span>
                </div>

                <div class="form-group">
                    <select id="appointmentTime" name="appointmentTime" class="form-control" required></select>
                    <label for="appointmentTime" class="form-label">Time <span class="required">*</span></label>
                    <div id="estimatedEnd"></div>
                </div>

                <div class="form-group">
                    <textarea id="notes" class="form-control" name="notes" rows="3" placeholder=" "></textarea>
                    <label for="notes" class="form-label">Add a note</label>
                </div>

                <div class="button-group">
                    <button type="submit" class="form-button confirm-btn">Confirm</button>
                    <button type="button" class="form-button cancel-btn" onclick="closePatientBookingModal()">Cancel</button>
                </div>
            </form>
        `;

        const dateInput = bookingBody.querySelector("#appointmentDate");
        const errorMsg = bookingBody.querySelector("#dateError");

        if (dateInput) {
            const today = new Date();
            today.setDate(today.getDate() + 1);
            dateInput.min = today.toISOString().split("T")[0];

            dateInput.addEventListener("input", function () {
                if (!this.value) return;
                const selectedDate = new Date(this.value);
                if (selectedDate.getDay() === 0) {
                    errorMsg.style.display = "block";
                    this.value = "";
                    this.classList.add("is-invalid");
                } else {
                    errorMsg.style.display = "none";
                    this.classList.remove("is-invalid");
                }
            });
        }
    }

    function loadBranches(branchSelect) {
        $.ajax({
            type: "GET",
            url: `${BASE_URL}/Admin/processes/index/load_branches.php`,
            success: function (response) {
                branchSelect.innerHTML = response;
            },
            error: function () {
                branchSelect.innerHTML = '<option disabled>Error loading branches</option>';
            }
        });
    }

function loadServices(branchId, container) {
    container.innerHTML = '<p class="loading-text">Loading services</p>';
    $.ajax({
        type: "POST",
        url: `${BASE_URL}/processes/load_services.php`,
        data: { appointmentBranch: branchId },
        success: function (response) {
            container.innerHTML = response;

            const dentistSelect = document.getElementById("appointmentDentist");
            const dateSelect = document.getElementById("appointmentDate");
            const timeSelect = document.getElementById("appointmentTime");
            const estimatedEndDiv = document.getElementById("estimatedEnd");

            const serviceCheckboxes = container.querySelectorAll('input[name="appointmentServices[]"]');

            serviceCheckboxes.forEach(cb => {
                cb.addEventListener("change", function () {
                    const selectedServices = [...container.querySelectorAll('input[name="appointmentServices[]"]:checked')]
                        .map(cb => cb.value);

                    resetDentistDateTime(dentistSelect, dateSelect, timeSelect, estimatedEndDiv);

                    loadDentists(branchId, selectedServices, dentistSelect);
                });
            });
        },
        error: function () {
            container.innerHTML = '<p class="error">Error loading services</p>';
        }
    });
}


    function loadDentists(branchId, selectedServices, dentistSelect) {
        if (!selectedServices.length) {
            dentistSelect.innerHTML = '<option value="" disabled selected hidden></option>';
            return;
        }

        $.ajax({
            type: "POST",
            url: `${BASE_URL}/processes/load_dentists.php`,
            data: {
                appointmentBranch: branchId,
                appointmentServices: selectedServices
            },
            success: function (response) {
                dentistSelect.innerHTML = response;
            },
            error: function () {
                dentistSelect.innerHTML = '<option disabled>Error loading dentists</option>';
            }
        });
    }

    function loadAvailableTimes(branchSelect, dateSelect, servicesContainer, timeSelect) {
        const branchId = branchSelect?.value;
        const date = dateSelect?.value;
        const services = [
            ...servicesContainer.querySelectorAll("input[type='checkbox']:checked")
        ].map(cb => cb.value);

        if (!branchId || !date || services.length === 0) {
            resetTime(timeSelect);
            return;
        }

        const fd = new FormData();
        fd.append("branch_id", branchId);
        fd.append("appointment_date", date);
        services.forEach(s => fd.append("services[]", s));

        fetch(`${BASE_URL}/processes/load_available_times.php`, {
            method: "POST",
            body: fd,
        })
            .then(res => res.json())
            .then(data => {
                timeSelect.innerHTML = "";

                if (data.error) {
                    timeSelect.innerHTML = `<option disabled selected>${data.error}</option>`;
                    return;
                }

                if (!Array.isArray(data.times) || data.times.length === 0) {
                    timeSelect.innerHTML = '<option disabled selected>No available times</option>';
                    return;
                }

                const allSlots = [];
                const start = new Date("2000-01-01T09:00:00");
                const end = new Date("2000-01-01T16:30:00");

                while (start < end) {
                    const hh = String(start.getHours()).padStart(2, "0");
                    const mm = String(start.getMinutes()).padStart(2, "0");
                    allSlots.push(`${hh}:${mm}`);
                    start.setMinutes(start.getMinutes() + 30);
                }

                const blocked = Array.isArray(data.blocked) ? data.blocked : [];
                let options = "";

                allSlots.forEach(time => {
                    const [h, m] = time.split(":");
                    const formatted = new Date(0, 0, 0, h, m).toLocaleTimeString([], {
                        hour: "2-digit",
                        minute: "2-digit"
                    });

                    const isAvailable = data.times.includes(time);
                    const isBlocked = blocked.includes(time);

                    if (!isAvailable || isBlocked) {
                        options += `<option value="${time}" disabled style="color:gray;">${formatted}</option>`;
                    } else {
                        options += `<option value="${time}">${formatted}</option>`;
                    }
                });

                timeSelect.innerHTML = `<option value="" disabled selected hidden></option>` + options;
            })
            .catch(err => {
                console.error("Error loading available times:", err);
                timeSelect.innerHTML = '<option disabled selected>Error loading times</option>';
            });
    }

    function calculateEstimatedEnd(startTime, servicesContainer, outputDiv) {
        if (!startTime) {
            outputDiv.textContent = "";
            return;
        }

        const selectedServices = servicesContainer.querySelectorAll('input[name="appointmentServices[]"]:checked');
        if (selectedServices.length === 0) {
            outputDiv.textContent = "";
            return;
        }

        const totalDuration = Array.from(selectedServices).reduce((sum, cb) => {
            return sum + parseInt(cb.dataset.duration || 0);
        }, 0);

        if (totalDuration === 0) {
            outputDiv.textContent = "";
            return;
        }

        const [h, m] = startTime.split(":").map(Number);
        const start = new Date();
        start.setHours(h, m, 0, 0);
        start.setMinutes(start.getMinutes() + totalDuration);

        let endHours = start.getHours();
        const endMinutes = String(start.getMinutes()).padStart(2, "0");
        const ampm = endHours >= 12 ? "PM" : "AM";
        endHours = endHours % 12 || 12;
        const endFormatted = `${endHours}:${endMinutes} ${ampm}`;

        const hours = Math.floor(totalDuration / 60);
        const minutes = totalDuration % 60;
        let durationText = "";
        if (hours > 0) {
            durationText += `${hours} hour${hours > 1 ? "s" : ""}`;
            if (minutes > 0) durationText += ` and ${minutes} min${minutes > 1 ? "s" : ""}`;
        } else {
            durationText = `${minutes} min${minutes > 1 ? "s" : ""}`;
        }

        outputDiv.textContent = `Estimated End Time: ${endFormatted} (${durationText} total)`;
    }

    function resetDentist(dentistSelect) {
        if (dentistSelect) {
            dentistSelect.innerHTML = '<option value="" disabled selected hidden></option>';
        }
    }

    function resetDate(dateSelect) {
        if (dateSelect) dateSelect.value = "";
    }

    function resetTime(timeSelect, estimatedEndDiv) {
        if (timeSelect) {
            timeSelect.value = "";
            timeSelect.innerHTML = "";
        }
        if (estimatedEndDiv) estimatedEndDiv.textContent = "";
    }

    function resetDateAndTime(dateSelect, timeSelect, estimatedEndDiv) {
        resetDate(dateSelect);
        resetTime(timeSelect, estimatedEndDiv);
    }

    function resetDentistDateTime(dentistSelect, dateSelect, timeSelect, estimatedEndDiv) {
        resetDentist(dentistSelect);
        resetDate(dateSelect);
        resetTime(timeSelect, estimatedEndDiv);
    }
});

function closePatientBookingModal() {
    document.getElementById("manageAppointmentModal").style.display = "none";
}
