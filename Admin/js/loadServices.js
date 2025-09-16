document.addEventListener("DOMContentLoaded", function () {
    const branchInput = document.querySelector("input[name='appointmentBranch']");
    const serviceSelect = document.getElementById("appointmentService");

    if (branchInput && serviceSelect) {
        const branchId = branchInput.value;

        if (branchId) {
            $.ajax({
                type: "POST",
                url: `${BASE_URL}/Admin/processes/load_services.php`,
                data: { appointmentBranch: branchId },
                success: function (response) {
                    serviceSelect.innerHTML = response;
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching services:", error);
                    serviceSelect.innerHTML = '<option disabled>Error loading services</option>';
                }
            });
        }
    }
});
