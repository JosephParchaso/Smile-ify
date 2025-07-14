document.addEventListener("DOMContentLoaded", function () {
    const dateInput = document.getElementById("appointmentDate");
    const errorMsg = document.getElementById("dateError");

    if (!dateInput) return; 

    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const minDate = `${yyyy}-${mm}-${dd}`;
    dateInput.setAttribute("min", minDate);

    dateInput.addEventListener("input", function () {
        const selectedDate = new Date(this.value);
        if (selectedDate.getDay() === 0) {
            errorMsg.style.display = "block";
            this.value = "";
        } else {
            errorMsg.style.display = "none";
        }
    });
});
