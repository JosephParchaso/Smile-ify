document.addEventListener("DOMContentLoaded", () => {
    const promoModal = document.getElementById("managePromoModal");
    const promoBody = document.getElementById("promoModalBody");

    const today = new Date().toISOString().split("T")[0];

    document.body.addEventListener("click", function (e) {
        if (e.target.classList.contains("btn-promo")) {
            const id = e.target.getAttribute("data-id");

            fetch(`${BASE_URL}/Admin/processes/promos/get_promo_details.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        promoBody.innerHTML = `<p style="color:red;">${data.error}</p>`;
                        promoModal.style.display = "block";
                        return;
                    }
                    renderPromoForm(data);
                    promoModal.style.display = "block";
                })
                .catch(() => {
                    promoBody.innerHTML = `<p style="color:red;">Error loading details</p>`;
                    promoModal.style.display = "block";
                });
        }

        if (e.target.id === "insertPromoBtn") {
            renderPromoForm(null);
            promoModal.style.display = "block";
        }
    });

    document.body.addEventListener("focusin", function (e) {
        if (e.target && e.target.id === "startDate") {
            e.target.setAttribute("min", today);
        }
        if (e.target && e.target.id === "endDate") {
            e.target.setAttribute("min", today);
        }
    });

    document.body.addEventListener("change", function (e) {
        if (e.target && e.target.id === "startDate") {
            const startInput = e.target;
            const errorEl = document.getElementById("startDateError");

            if (startInput.value) {
                const selectedDate = new Date(startInput.value);

                if (selectedDate < new Date(today)) {
                    errorEl.textContent = "Please enter a valid date.";
                    errorEl.style.display = "block";
                    startInput.value = "";
                } else {
                    errorEl.style.display = "none";
                }
            }
        }

        if (e.target && e.target.id === "endDate") {
            const startInput = document.getElementById("startDate");
            const endInput = e.target;
            const errorEl = document.getElementById("endDateError");

            if (endInput.value) {
                const startDate = startInput.value ? new Date(startInput.value) : null;
                const endDate = new Date(endInput.value);

                if (endDate < new Date(today)) {
                    errorEl.textContent = "Please enter a valid date.";
                    errorEl.style.display = "block";
                    endInput.value = "";
                } else if (startDate && endDate < startDate) {
                    errorEl.textContent = "Please enter a valid date.";
                    errorEl.style.display = "block";
                    endInput.value = "";
                } else {
                    errorEl.style.display = "none";
                }
            }
        }
    });

    function renderPromoForm(data) {
        const isEdit = !!data;
            
        const startDate = isEdit && data.start_date ? data.start_date : "";
        const endDate   = isEdit && data.end_date   ? data.end_date   : "";

        promoBody.innerHTML = `
            <h2>${isEdit ? "Manage Promo" : "Add Promo"}</h2>
            <form id="promoForm" action="${BASE_URL}/Admin/processes/promos/${isEdit ? "update_promo.php" : "insert_promo.php"}" method="POST" enctype="multipart/form-data" autocomplete="off">
                ${isEdit ? `<input type="hidden" name="promo_id" value="${data.promo_id}">` : ""}

                <div class="form-group">
                    <input type="text" id="promoName" name="promoName" class="form-control"
                        value="${isEdit ? data.name : ""}" required placeholder=" ">
                    <label for="promoName" class="form-label">Promo Name <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <textarea id="description" name="description" class="form-control" rows="3" placeholder=" ">${isEdit ? (data.description || "") : ""}</textarea>
                    <label for="description" class="form-label">Description</label>
                </div>

                <div class="form-group">
                    <input type="file" id="promoImage" name="promoImage" class="form-control" accept="image/*">
                    <label for="promoImage" class="form-label">Promo Image</label>
                    ${isEdit && data.image_path 
                    ? `<div style="margin-top:10px;">
                        <img src="${BASE_URL}${data.image_path}" 
                            alt="Promo Image" 
                            style="max-width:300px; max-height:300px; border-radius:4px; object-fit:cover; display:block;">
                    </div>` 
                    : ""}
                </div>

                <div class="form-group">
                    <select id="discountType" name="discountType" class="form-control" required>
                        <option value="" disabled ${!isEdit ? "selected" : ""}></option>
                        <option value="percentage" ${isEdit && data.discount_type === "percentage" ? "selected" : ""}>Percentage (%)</option>
                        <option value="fixed" ${isEdit && data.discount_type === "fixed" ? "selected" : ""}>Fixed Amount</option>
                    </select>
                    <label for="discountType" class="form-label">Discount Type <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="number" id="discountValue" name="discountValue" class="form-control"
                        value="${isEdit ? data.discount_value : ""}" required placeholder=" " min="0">
                    <label for="discountValue" class="form-label">Discount Value <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="date" id="startDate" name="startDate" class="form-control"
                        value="${startDate}">
                    <label for="startDate" class="form-label">Start Date </label>
                    <span id="startDateError" class="error-msg-calendar error" style="display: none;"></span>
                </div>

                <div class="form-group">
                    <input type="date" id="endDate" name="endDate" class="form-control"
                        value="${endDate}">
                    <label for="endDate" class="form-label">End Date </label>
                    <span id="endDateError" class="error-msg-calendar error" style="display: none;"></span>
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
                    <label for="dateUpdated" class="form-label">Date Updated</label>
                </div>` : ""}

                <div class="button-group button-group-profile">
                    <button type="submit" class="form-button confirm-btn">${isEdit ? "Save Changes" : "Add Promo"}</button>
                    <button type="button" class="form-button cancel-btn" onclick="closePromoModal()">Cancel</button>
                </div>
            </form>
        `;
    }
});

function closePromoModal() {
    document.getElementById("managePromoModal").style.display = "none";
}
