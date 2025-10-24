document.addEventListener("DOMContentLoaded", () => {
    const announcementModal = document.getElementById("manageAnnouncementModal");
    const announcementBody = document.getElementById("announcementModalBody");

    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const formattedToday = today.toISOString().split("T")[0];

    document.body.addEventListener("click", function (e) {
        if (e.target.classList.contains("btn-announcement")) {
            const id = e.target.getAttribute("data-id");

            fetch(`${BASE_URL}/Admin/processes/profile/announcements/get_announcement_details.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        announcementBody.innerHTML = `<p style="color:red;">${data.error}</p>`;
                        announcementModal.style.display = "block";
                        return;
                    }
                    renderAnnouncementForm(data);
                    announcementModal.style.display = "block";
                })
                .catch(() => {
                    announcementBody.innerHTML = `<p style="color:red;">Error loading details</p>`;
                    announcementModal.style.display = "block";
                });
        }

        if (e.target.id === "insertAnnouncementBtn") {
            renderAnnouncementForm(null);
            announcementModal.style.display = "block";
        }
    });

    document.body.addEventListener("focusin", function (e) {
        if (e.target && (e.target.id === "start_date" || e.target.id === "end_date")) {
            e.target.setAttribute("min", formattedToday);
        }
    });

    document.body.addEventListener("change", function (e) {
        const target = e.target;

        if (target && target.id === "start_date") {
            const startInput = target;
            const errorEl = document.getElementById("startDateError");

            if (startInput.value) {
                const selectedDate = new Date(startInput.value);
                selectedDate.setHours(0, 0, 0, 0);

                if (selectedDate < today) {
                    errorEl.textContent = "Please enter a valid date.";
                    errorEl.style.display = "block";
                    startInput.value = "";
                } else {
                    errorEl.style.display = "none";
                }
            }
        }

        if (target && target.id === "end_date") {
            const startInput = document.getElementById("start_date");
            const endInput = target;
            const errorEl = document.getElementById("endDateError");

            if (endInput.value) {
                const endDate = new Date(endInput.value);
                const startDate = startInput.value ? new Date(startInput.value) : null;
                endDate.setHours(0, 0, 0, 0);

                if (endDate < today) {
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

    function renderAnnouncementForm(data) {
        const isEdit = !!data;

        const startDate = isEdit && data.start_date ? data.start_date : "";
        const endDate = isEdit && data.end_date ? data.end_date : "";

        announcementBody.innerHTML = `
            <h2>${isEdit ? "Manage Announcement" : "Add Announcement"}</h2>
            <form id="announcementForm" 
                action="${BASE_URL}/Admin/processes/profile/announcements/${isEdit ? "update_announcement.php" : "insert_announcement.php"}" 
                method="POST" autocomplete="off">

                ${isEdit ? `<input type="hidden" name="announcement_id" value="${data.announcement_id}">` : ""}
                <input type="hidden" name="branch_id" id="branch_id" value="${ADMIN_BRANCH_ID ?? ''}">

                <div class="form-group">
                    <input type="text" id="title" name="title" class="form-control"
                        value="${isEdit ? (data.title || "") : ""}" required placeholder=" ">
                    <label for="title" class="form-label">Title <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <textarea id="description" name="description" class="form-control" rows="4"
                        placeholder=" ">${isEdit ? (data.description || "") : ""}</textarea>
                    <label for="description" class="form-label">Description</label>
                </div>

                <div class="form-group">
                    <select id="type" name="type" class="form-control" required>
                        <option value="" disabled hidden ${!isEdit ? "selected" : ""}></option>
                        <option value="General" ${isEdit && data.type === "General" ? "selected" : ""}>General</option>
                        <option value="Closed" ${isEdit && data.type === "Closed" ? "selected" : ""}>Closed</option>
                    </select>
                    <label for="type" class="form-label">Type <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="date" id="start_date" name="start_date" class="form-control"
                        value="${startDate}">
                    <label for="start_date" class="form-label">Start Date</label>
                    <span id="startDateError" class="error-msg-calendar error" style="display:none;"></span>
                </div>

                <div class="form-group">
                    <input type="date" id="end_date" name="end_date" class="form-control"
                        value="${endDate}">
                    <label for="end_date" class="form-label">End Date</label>
                    <span id="endDateError" class="error-msg-calendar error" style="display:none;"></span>
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
                    <label for="dateUpdated" class="form-label">Last Updated</label>
                </div>` : ""}

                <div class="button-group button-group-profile">
                    <button type="submit" class="form-button confirm-btn">${isEdit ? "Save Changes" : "Add Announcement"}</button>
                    <button type="button" class="form-button cancel-btn" onclick="closeAnnouncementModal()">Cancel</button>
                </div>
            </form>
        `;
    }
});

function closeAnnouncementModal() {
    document.getElementById("manageAnnouncementModal").style.display = "none";
}
