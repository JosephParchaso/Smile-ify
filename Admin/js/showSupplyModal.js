document.addEventListener("DOMContentLoaded", () => {
    const supplyModal = document.getElementById("manageSupplyModal");
    const supplyBody = document.getElementById("supplyModalBody");

    const today = new Date().toISOString().split("T")[0];

    document.body.addEventListener("click", function (e) {
        if (e.target.classList.contains("btn-supply")) {
            const id = e.target.getAttribute("data-id");

            fetch(`${BASE_URL}/Admin/processes/supplies/get_supply_details.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        supplyBody.innerHTML = `<p style="color:red;">${data.error}</p>`;
                        supplyModal.style.display = "block";
                        return;
                    }

                    renderSupplyForm(data);
                    supplyModal.style.display = "block";

                    const expInput = document.getElementById("expiration_date");
                    if (expInput) expInput.setAttribute("min", today);
                })
                .catch(() => {
                    supplyBody.innerHTML = `<p style="color:red;">Error loading details</p>`;
                    supplyModal.style.display = "block";
                });
        }
    });

    document.body.addEventListener("click", function (e) {
        if (e.target.id === "insertSupplyBtn") {
            renderSupplyForm(null);
            supplyModal.style.display = "block";

            const expInput = document.getElementById("expiration_date");
            if (expInput) expInput.setAttribute("min", today);
        }
    });

    document.body.addEventListener("change", function (e) {
        if (e.target && e.target.id === "expiration_date") {
            const expInput = e.target;
            if (expInput.value) {
                const selected = new Date(expInput.value);
                const now = new Date(today);

                if (selected < now) {
                    alert("Expiration date cannot be in the past.");
                    expInput.value = "";
                }
            }
        }
    });

    function renderSupplyForm(data) {
        const isEdit = !!data;
        supplyBody.innerHTML = `
            <h2>${isEdit ? "Manage Supply" : "Add Supply"}</h2>
            <form id="supplyForm" action="${BASE_URL}/Admin/processes/supplies/${isEdit ? "update_supply.php" : "insert_supply.php"}" method="POST" autocomplete="off">
                ${isEdit ? `<input type="hidden" name="supply_id" value="${data.supply_id}">` : ""}

                <div class="form-group">
                    <input type="text" id="supplyName" name="supplyName" class="form-control"
                        value="${isEdit ? data.name : ""}" required placeholder=" ">
                    <label for="supplyName" class="form-label">Supply Name <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="description" name="description" class="form-control"
                        value="${isEdit ? (data.description || "") : ""}" placeholder=" ">
                    <label for="description" class="form-label">Description</label>
                </div>

                <div class="form-group">
                    <input type="text" id="category" name="category" class="form-control"
                        value="${isEdit ? (data.category || "") : ""}" placeholder=" ">
                    <label for="category" class="form-label">Category</label>
                </div>

                <div class="form-group">
                    <input type="text" id="unit" name="unit" class="form-control"
                        value="${isEdit ? (data.unit || "") : ""}" placeholder=" ">
                    <label for="unit" class="form-label">Unit</label>
                </div>

                <div class="form-group">
                    <input type="number" id="quantity" name="quantity" class="form-control"
                        value="${isEdit ? data.quantity : ""}" required placeholder=" " min="0">
                    <label for="quantity" class="form-label">Quantity <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="number" id="reorderLevel" name="reorderLevel" class="form-control"
                        value="${isEdit ? data.reorder_level : ""}" required placeholder=" " min="0">
                    <label for="reorderLevel" class="form-label">Reorder Level <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="date" id="expiration_date" name="expiration_date" class="form-control"
                        value="${isEdit ? (data.expiration_date || "") : ""}" placeholder=" ">
                    <label for="expiration_date" class="form-label">Expiration Date</label>
                </div>

                <div class="form-group">
                    <select id="status" name="status" class="form-control" required>
                        <option value="" disabled ${!isEdit ? "selected" : ""}></option>
                        <option value="Available" ${isEdit && data.status === "Available" ? "selected" : ""}>Available</option>
                        <option value="Out of Stock" ${isEdit && data.status === "Out of Stock" ? "selected" : ""}>Out of Stock</option>
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
                    <label for="dateUpdated" class="form-label">Date Updated</label>
                </div>` : ""}

                <div class="button-group button-group-profile">
                    <button type="submit" class="form-button confirm-btn">${isEdit ? "Save Changes" : "Add Supply"}</button>
                    <button type="button" class="form-button cancel-btn" onclick="closeSupplyModal()">Cancel</button>
                </div>
            </form>
        `;
    }
});

function closeSupplyModal() {
    document.getElementById("manageSupplyModal").style.display = "none";
}
