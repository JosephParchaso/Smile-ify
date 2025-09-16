document.addEventListener("DOMContentLoaded", function () {
    const branchInput = document.querySelector("input[name='appointmentBranch']");
    const serviceSelect = document.getElementById("appointmentService");
    const dentistSelect = document.getElementById("appointmentDentist");

    function loadDentists() {
        const branchId = branchInput.value;
        const serviceId = serviceSelect.value;

        if (branchId && serviceId) {
            $.ajax({
                type: "POST",
                url: `${BASE_URL}/Admin/processes/load_dentists.php`,
                data: {
                    appointmentBranch: branchId,
                    appointmentService: serviceId
                },
                success: function (response) {
                    dentistSelect.innerHTML = response;
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching dentists:", error);
                    dentistSelect.innerHTML = '<option disabled>Error loading dentists</option>';
                }
            });
        } else {
            dentistSelect.innerHTML = '<option value="" disabled selected hidden></option>';
        }
    }

    if (branchInput && serviceSelect && dentistSelect) {
        serviceSelect.addEventListener("change", loadDentists);
    }
});
