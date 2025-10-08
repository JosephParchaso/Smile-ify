document.addEventListener("DOMContentLoaded", () => {
    const serviceModal = document.getElementById("manageServiceModal");
    const serviceBody = document.getElementById("serviceModalBody");

    document.body.addEventListener("click", function (e) {
        if (e.target.classList.contains("btn-service")) {
            const id = e.target.getAttribute("data-id");

            fetch(`${BASE_URL}/Admin/processes/services/get_service_details.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        serviceBody.innerHTML = `<p style="color:red;">${data.error}</p>`;
                        serviceModal.style.display = "block";
                        return;
                    }
                    renderServiceForm(data);
                    serviceModal.style.display = "block";
                })
                .catch(() => {
                    serviceBody.innerHTML = `<p style="color:red;">Error loading details</p>`;
                    serviceModal.style.display = "block";
                });
        }

        if (e.target.id === "insertServiceBtn") {
            renderServiceForm(null);
            serviceModal.style.display = "block";
        }
    });

    function renderServiceForm(data) {
        const isEdit = !!data;
        serviceBody.innerHTML = `
            <h2>${isEdit ? "Manage Service" : "Add Service"}</h2>
            <form id="serviceForm" action="${BASE_URL}/Admin/processes/services/${isEdit ? "update_service.php" : "insert_service.php"}" method="POST" autocomplete="off">
                ${isEdit ? `<input type="hidden" name="service_id" value="${data.service_id}">` : ""}

                <div class="form-group">
                    <input type="text" id="serviceName" name="serviceName" class="form-control"
                        value="${isEdit ? data.name : ""}" required placeholder=" ">
                    <label for="serviceName" class="form-label">Service Name <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="number" id="price" name="price" class="form-control"
                        value="${isEdit ? data.price : ""}" required placeholder=" " min="0">
                    <label for="price" class="form-label">Price <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="number" id="duration_minutes" name="duration_minutes" class="form-control"
                        value="${isEdit ? data.duration_minutes : ""}" required placeholder=" " min="0">
                    <label for="duration_minutes" class="form-label">Duration (minutes)<span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <select id="status" name="status" class="form-control" required>
                        <option value="" disabled ${!isEdit ? "selected" : ""}></option>
                        <option value="Active" ${isEdit && data.status === "Active" ? "selected" : ""}>Active</option>
                        <option value="Inactive" ${isEdit && data.status === "Inactive" ? "selected" : ""}>Inactive</option>
                    </select>
                    <label for="status" class="form-label">Status <span class="required">*</span></label>
                </div>

                ${isEdit ? `
                <div class="form-group">
                    <input type="text" id="dateCreated" class="form-control" value="${data.date_created}" disabled>
                    <label for="dateCreated" class="form-label">Date Created</label>
                </div>` : ""}

                ${isEdit ? `
                <div class="form-group">
                    <input type="text" id="dateUpdated" class="form-control" value="${data.date_updated}" disabled>
                    <label for="dateUpdated" class="form-label">Last Update</label>
                </div>` : ""}

                <div class="button-group button-group-profile">
                    <button type="submit" class="form-button confirm-btn">${isEdit ? "Save Changes" : "Add Service"}</button>
                    <button type="button" class="form-button cancel-btn" onclick="closeServiceModal()">Cancel</button>
                </div>
            </form>
        `;
    }
});

function closeServiceModal() {
    document.getElementById("manageServiceModal").style.display = "none";
}
