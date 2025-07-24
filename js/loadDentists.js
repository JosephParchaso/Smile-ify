document.addEventListener("DOMContentLoaded", function () {
    const branchSelect = document.getElementById("appointmentBranch");
    const serviceSelect = document.getElementById("appointmentService");
    const dentistSelect = document.getElementById("appointmentDentist");

    function loadDentists() {
        const branchId = branchSelect.value;
        const serviceId = serviceSelect.value;

        if (branchId && serviceId) {
            $.ajax({
                type: "POST",
                url: `${BASE_URL}/processes/get_dentists.php`,
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
            dentistSelect.innerHTML = `
                <option value="" disabled selected hidden></option>
            `;
        }
    }

    if (branchSelect && serviceSelect && dentistSelect) {
        branchSelect.addEventListener("change", loadDentists);
        serviceSelect.addEventListener("change", loadDentists);
    }
});
