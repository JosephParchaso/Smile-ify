document.addEventListener("DOMContentLoaded", function () {
    const bookingModal = document.getElementById("manageAppointmentModal");
    const bookingBody = document.getElementById("appointmentModalBody");

    document.body.addEventListener("click", function (e) {
        if (e.target.id === "insertAppointmentBtn") {
            renderAppointmentForm();
            bookingModal.style.display = "block";

            const branchSelect  = bookingBody.querySelector("#appointmentBranch");
            const serviceSelect = bookingBody.querySelector("#appointmentService");
            const dentistSelect = bookingBody.querySelector("#appointmentDentist");
            const dateSelect    = bookingBody.querySelector("#appointmentDate");
            const timeSelect    = bookingBody.querySelector("#appointmentTime");

            if (branchSelect) {
                loadBranches(branchSelect);

                branchSelect.addEventListener("change", () => {
                    loadServices(branchSelect.value, serviceSelect);
                    resetDentist(dentistSelect);
                    resetDateAndTime(dateSelect, timeSelect);
                });

                serviceSelect.addEventListener("change", () => {
                    loadDentists(branchSelect.value, serviceSelect.value, dentistSelect);
                    resetDateAndTime(dateSelect, timeSelect);
                });

                dentistSelect.addEventListener("change", () => {
                    resetDateAndTime(dateSelect, timeSelect);
                });

                dateSelect.addEventListener("change", () => {
                    loadAvailableTimes(branchSelect.value, dateSelect.value, timeSelect);
                });
            }
        }
    });

    function renderAppointmentForm() {
        bookingBody.innerHTML = `
            <h2>Book Appointment</h2>
            <form action="${BASE_URL}/Admin/processes/manage_patient/insert_appointment.php" method="POST" autocomplete="off">
                <input type="hidden" name="user_id" value="${userId}">

                <div class="form-group">
                    <select id="appointmentBranch" name="appointmentBranch" class="form-control" required>
                        <option value="" disabled selected hidden></option>
                    </select>
                    <label for="appointmentBranch" class="form-label">Branch <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <select id="appointmentService" class="form-control" name="appointmentService" required>
                        <option value="" disabled selected hidden></option>
                    </select>
                    <label for="appointmentService" class="form-label">Service <span class="required">*</span></label>
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
                    <select id="appointmentTime" class="form-control" name="appointmentTime" required>
                        <option value="" disabled selected hidden></option>
                        <option value="09:00">9:00 AM</option>
                        <option value="09:45">9:45 AM</option>
                        <option value="10:30">10:30 AM</option>
                        <option value="11:15">11:15 AM</option>
                        <option value="12:00">12:00 PM</option>
                        <option value="12:45">12:45 PM</option>
                        <option value="13:30">1:30 PM</option>
                        <option value="14:15">2:15 PM</option>
                        <option value="15:00">3:00 PM</option>
                    </select>
                    <label for="appointmentTime" class="form-label">Time <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <textarea id="notes" class="form-control" name="notes" rows="3" placeholder=" " autocomplete="off"></textarea>
                    <label for="notes" class="form-label">Add a note...</label>
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

    function loadServices(branchId, serviceSelect) {
        $.ajax({
            type: "POST",
            url: `${BASE_URL}/processes/load_services.php`,
            data: { appointmentBranch: branchId },
            success: function (response) {
                serviceSelect.innerHTML = response;
            },
            error: function () {
                serviceSelect.innerHTML = '<option disabled>Error loading services</option>';
            }
        });
    }

    function loadDentists(branchId, serviceId, dentistSelect) {
        if (!serviceId) {
            dentistSelect.innerHTML = '<option value="" disabled selected hidden></option>';
            return;
        }

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
    }

    function loadAvailableTimes(branchId, date, timeSelect) {
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

    function resetDentist(dentistSelect) {
        dentistSelect.innerHTML = '<option value="" disabled selected hidden></option>';
    }

    function resetDateAndTime(dateSelect, timeSelect) {
        if (dateSelect) dateSelect.value = "";
        if (timeSelect) {
            timeSelect.value = "";
            [...timeSelect.options].forEach(opt => {
                opt.disabled = false;
                opt.style.color = "#000";
            });
        }
    }
});

function closeBookingModal() {
    document.getElementById("bookingModal").style.display = "none";
}
function closePatientBookingModal() {
    document.getElementById("manageAppointmentModal").style.display = "none";
}
