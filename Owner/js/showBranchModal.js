document.addEventListener("DOMContentLoaded", () => {
    const branchModal = document.getElementById("manageBranchModal");
    const branchBody = document.getElementById("branchModalBody");

    document.body.addEventListener("click", function (e) {
        if (e.target.classList.contains("btn-branch")) {
            const id = e.target.getAttribute("data-id");

            fetch(`${BASE_URL}/Owner/processes/profile/branches/get_branch_details.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        branchBody.innerHTML = `<p style="color:red;">${data.error}</p>`;
                        branchModal.style.display = "block";
                        return;
                    }

                    renderBranchForm(data);
                    branchModal.style.display = "block";
                })
                .catch(() => {
                    branchBody.innerHTML = `<p style="color:red;">Error loading details</p>`;
                    branchModal.style.display = "block";
                });
        }
    });

    document.body.addEventListener("click", function (e) {
        if (e.target.id === "insertBranchBtn") {
            renderBranchForm(null);
            branchModal.style.display = "block";
        }
    });

    function renderBranchForm(data) {
        const isEdit = !!data;
        branchBody.innerHTML = `
            <h2>${isEdit ? "Manage Branch" : "Add Branch"}</h2>
            <form id="branchForm" action="${BASE_URL}/Owner/processes/profile/branches/${isEdit ? "update_branch.php" : "insert_branch.php"}" method="POST" autocomplete="off">
                ${isEdit ? `<input type="hidden" name="branch_id" value="${data.branch_id}">` : ""}

                <div class="form-group">
                    <input type="text" id="branchName" name="branchName" class="form-control"
                        value="${isEdit ? data.name : ""}" required placeholder=" ">
                    <label for="branchName" class="form-label">Branch Name <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="address" name="address" class="form-control"
                        value="${isEdit ? (data.address || "") : ""}" required placeholder=" " autocomplete="off">
                    <label for="address" class="form-label">Address <span class="required">*</span></label>
                </div>

                <div class="form-group phone-group">
                    <input type="tel" 
                        id="contactNumber" 
                        name="contactNumber" 
                        class="form-control" 
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                        pattern="[0-9]{10}" 
                        title="Mobile number must be 10 digits" 
                        required 
                        maxlength="10"
                        value="${isEdit ? (data.phone_number ? data.phone_number.replace('+63','') : '') : ''}" />
                    <label for="contactNumber" class="form-label">Mobile Number <span class="required">*</span></label>
                    <span class="phone-prefix">+63</span>
                </div>

                <div class="form-group time-group">
                    <input type="time" id="opening_time" name="opening_time" class="form-control"
                        value="${isEdit ? (data.opening_time || '') : ''}">
                    <label for="opening_time" class="form-label">Opening Time</label>
                </div>

                <div class="form-group time-group">
                    <input type="time" id="closing_time" name="closing_time" class="form-control"
                        value="${isEdit ? (data.closing_time || '') : ''}">
                    <label for="closing_time" class="form-label">Closing Time</label>
                </div>

                <div class="form-group">
                    <input type="url" id="map_url" name="map_url" class="form-control"
                        value="${isEdit ? (data.map_url || '') : ''}" placeholder=" ">
                    <label for="map_url" class="form-label">Google Maps URL <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <select id="status" name="status" class="form-control" required>
                        <option value="" disabled ${!isEdit ? "selected" : ""}></option>
                        <option value="active" ${isEdit && data.status === "active" ? "selected" : ""}>Active</option>
                        <option value="inactive" ${isEdit && data.status === "inactive" ? "selected" : ""}>Inactive</option>
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
                    <button type="submit" class="form-button confirm-btn">${isEdit ? "Save Changes" : "Add Branch"}</button>
                    <button type="button" class="form-button cancel-btn" onclick="closeBranchModal()">Cancel</button>
                </div>
            </form>
        `;
    }
});

function closeBranchModal() {
    document.getElementById("manageBranchModal").style.display = "none";
}
