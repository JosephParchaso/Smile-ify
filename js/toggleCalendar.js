document.addEventListener("DOMContentLoaded", function () {
    const dateInput = document.getElementById("appointmentDate");
    const errorMsg = document.getElementById("dateError");

    if (!dateInput) return;

    const today = new Date();
    today.setDate(today.getDate() + 1);
    dateInput.min = today.toISOString().split("T")[0];

    dateInput.addEventListener("input", function () {
        if (!this.value) return;

        const selectedDate = new Date(this.value);
        const isSunday = selectedDate.getDay() === 0;

        if (isSunday) {
            errorMsg.style.display = "block";
            this.classList.add("is-invalid");
        } else {
            errorMsg.style.display = "none";
            this.classList.remove("is-invalid");
        }
    });
});
