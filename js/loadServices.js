document.addEventListener("DOMContentLoaded", function () {
    const branchSelect = document.getElementById("appointmentBranch");
    const serviceSelect = document.getElementById("appointmentService");
    
    if (branchSelect && serviceSelect) {
        branchSelect.addEventListener("change", function () {
            const branchId = this.value;

            if (branchId) {
                $.ajax({
                    type: "POST",
                    url: `/Smile-ify/processes/get_services.php`,
                    data: { appointmentBranch: branchId },
                    success: function (response) {
                        serviceSelect.innerHTML = response;
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching services:", error);
                        serviceSelect.innerHTML = '<option disabled>Error loading services</option>';
                    }
                });
            } else {
                serviceSelect.innerHTML = '<option value="" disabled selected hidden></option> ';
            }
        });
    }
});
