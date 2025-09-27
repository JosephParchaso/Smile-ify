document.addEventListener("DOMContentLoaded", function () {
    const appointmentInput = document.getElementById("appointmentDate");
    const appointmentError = document.getElementById("dateError");

    if (appointmentInput && appointmentError) {
        const today = new Date();
        today.setDate(today.getDate() + 1);
        appointmentInput.min = today.toISOString().split("T")[0];

        appointmentInput.addEventListener("input", function () {
            if (!this.value) return;

            const selectedDate = new Date(this.value);
            const isSunday = selectedDate.getDay() === 0;

            if (isSunday) {
                appointmentError.style.display = "block";
                this.classList.add("is-invalid");
            } else {
                appointmentError.style.display = "none";
                this.classList.remove("is-invalid");
            }
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

            if (
                isNaN(selectedDate.getTime()) || selectedDate > today || selectedDate.getFullYear() < 1900) {
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
