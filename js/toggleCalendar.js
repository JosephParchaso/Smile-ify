document.addEventListener("DOMContentLoaded", function () {
    const appointmentInput = document.getElementById("appointmentDate");
    const appointmentError = document.getElementById("dateError");
    const branchSelect = document.getElementById("appointmentBranch");

    let closedDates = [];

    if (appointmentInput) {
        const today = new Date();
        today.setDate(today.getDate() + 1);
        appointmentInput.min = today.toISOString().split("T")[0];
    }

    if (branchSelect) {
        branchSelect.addEventListener("change", async function () {
            const branchId = this.value;
            if (!branchId) return;

            try {
                const res = await fetch(`${BASE_URL}/processes/get_closed_dates.php?branch_id=${branchId}`);
                const data = await res.json();

                if (data.error) {
                    console.error("Closed dates fetch error:", data.error);
                    closedDates = [];
                } else {
                    closedDates = data.closedDates || [];
                }
            } catch (err) {
                console.error("Network error fetching closed dates:", err);
                closedDates = [];
            }
        });
    }

    if (appointmentInput && appointmentError) {
        appointmentInput.addEventListener("input", function () {
            if (!this.value) return;

            const selectedDate = this.value;
            const day = new Date(selectedDate).getDay();

            if (day === 0) {
                appointmentError.textContent = "Sundays are not available for appointments.";
                appointmentError.style.display = "block";
                this.classList.add("is-invalid");
                this.value = "";
                return;
            }

            if (closedDates.includes(selectedDate)) {
                appointmentError.textContent = "This date is unavailable due to a branch closure.";
                appointmentError.style.display = "block";
                this.classList.add("is-invalid");
                this.value = "";
                return;
            }

            appointmentError.style.display = "none";
            this.classList.remove("is-invalid");
        });
    }

    const dobInput = document.getElementById("dateofBirth");
    const dobError = document.getElementById("dobError");

    if (dobInput && dobError) {
        const today = new Date();
        dobInput.max = today.toISOString().split("T")[0];

        dobInput.addEventListener("input", function () {
            if (!this.value) return;
            const selectedDate = new Date(this.value);

            if (isNaN(selectedDate.getTime()) || selectedDate > today || selectedDate.getFullYear() < 1900) {
                dobError.textContent = "Please enter a valid date of birth.";
                dobError.style.display = "block";
                this.classList.add("is-invalid");
            } else {
                dobError.style.display = "none";
                this.classList.remove("is-invalid");
            }
        });
    }
});
