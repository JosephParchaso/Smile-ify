document.addEventListener("DOMContentLoaded", function () {
    const branchSelect = document.getElementById("appointmentBranch");

    function loadBranches() {
        $.ajax({
            type: "GET",
            url: `${BASE_URL}/Admin/processes/load_branches.php`,
            success: function (response) {
                branchSelect.innerHTML = `
                    <option value="" disabled selected hidden></option>
                    ${response}
                `;
            },
            error: function (xhr, status, error) {
                console.error("Error fetching branches:", error);
                branchSelect.innerHTML = '<option disabled>Error loading branches</option>';
            }
        });
    }

    if (branchSelect) {
        loadBranches();
    }
});
