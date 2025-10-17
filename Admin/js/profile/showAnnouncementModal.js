document.addEventListener("DOMContentLoaded", () => {
    const announcementModal = document.getElementById("manageAnnouncementModal");
    const announcementBody = document.getElementById("announcementModalBody");

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
    });

    document.body.addEventListener("click", function (e) {
        if (e.target.id === "insertAnnouncementBtn") {
            renderAnnouncementForm(null);
            announcementModal.style.display = "block";
        }
    });

    function renderAnnouncementForm(data) {
        const isEdit = !!data;

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
                        value="${isEdit ? (data.start_date || "") : ""}">
                    <label for="start_date" class="form-label">Start Date</label>
                </div>

                <div class="form-group">
                    <input type="date" id="end_date" name="end_date" class="form-control"
                        value="${isEdit ? (data.end_date || "") : ""}">
                    <label for="end_date" class="form-label">End Date</label>
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
                    <button type="submit" class="form-button confirm-btn">
                        ${isEdit ? "Save Changes" : "Add Announcement"}
                    </button>
                    <button type="button" class="form-button cancel-btn" onclick="closeAnnouncementModal()">Cancel</button>
                </div>
            </form>
        `;
    }
});

function closeAnnouncementModal() {
    document.getElementById("manageAnnouncementModal").style.display = "none";
}
