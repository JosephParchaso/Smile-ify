document.addEventListener("DOMContentLoaded", () => {
    const employeeModal = document.getElementById("manageModal");
    const employeeBody = document.getElementById("modalBody");

    const today = new Date().toISOString().split("T")[0];

    document.body.addEventListener("focusin", function (e) {
        if (e.target && e.target.id === "dateofBirth") {
            e.target.setAttribute("min", "1900-01-01");
            e.target.setAttribute("max", today);
        }
        if (e.target && e.target.id === "dateStarted") {
            e.target.setAttribute("min", today);
        }
    });

    document.body.addEventListener("click", function (e) {
        if (e.target.classList.contains("btn-action")) {
            const id = e.target.getAttribute("data-id");
            const type = e.target.getAttribute("data-type");

            let url = "";
            if (type === "admin") {
                url = `${BASE_URL}/Owner/processes/employees/get_admin_details.php?id=${id}`;
            } else if (type === "dentist") {
                url = `${BASE_URL}/Owner/processes/employees/get_dentist_details.php?id=${id}`;
            }

            fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    employeeBody.innerHTML = `<p style="color:red;">${data.error}</p>`;
                    employeeModal.style.display = "block";
                    return;
                }

                if (type === "admin") {
                    renderAdminForm(data);
                } else if (type === "dentist") {
                    renderDentistForm(data);
                }

                employeeModal.style.display = "block";
            })
            .catch(() => {
                employeeBody.innerHTML = `<p style="color:red;">Error loading details</p>`;
                employeeModal.style.display = "block";
            });
        }
    });

    document.body.addEventListener("click", function (e) {
        if (e.target.id === "addAdminBtn") {
            renderAdminForm(null);
            employeeModal.style.display = "block";
        }
        if (e.target.id === "addDentistBtn") {
            renderDentistForm(null);
            employeeModal.style.display = "block";
        }
    });

    document.body.addEventListener("change", function (e) {
        if (e.target && e.target.id === "dateofBirth") {
            const dobInput = e.target;
            const errorEl = document.getElementById("dobError");
            const todayDate = new Date();

            if (dobInput.value) {
                const selectedDate = new Date(dobInput.value);

                if (selectedDate.getFullYear() === 1) {
                    errorEl.textContent = "Please enter a valid date of birth.";
                    errorEl.style.display = "block";
                    dobInput.value = "";
                } else if (selectedDate > todayDate || selectedDate.getFullYear() < 1900) {
                    errorEl.textContent = "Please enter a valid date of birth.";
                    errorEl.style.display = "block";
                    dobInput.value = "";
                } else {
                    errorEl.style.display = "none";
                }
            }
        }
    });

    document.body.addEventListener("change", function (e) {
        if (e.target && e.target.id === "dateStarted") {
            const dateInput = e.target;
            const errorEl = document.getElementById("dateError");

            if (dateInput.value) {
                const selectedDate = new Date(dateInput.value);
                const day = selectedDate.getUTCDay();

                if (day === 0) { // Sunday
                    errorEl.style.display = "block";
                    dateInput.value = "";
                } else {
                    errorEl.style.display = "none";
                }
            }
        }
    });

    function renderAdminForm(data) {
        const isEdit = !!data;
        employeeBody.innerHTML = `
            <h2>${isEdit ? "Manage Admin" : "Add Admin"}</h2>
            <form id="adminForm" action="${BASE_URL}/Owner/processes/employees/${isEdit ? "update_admin.php" : "insert_admin.php"}" method="POST" autocomplete="off">
                ${isEdit ? `<input type="hidden" name="user_id" value="${data.user_id}">` : ""}

                ${isEdit ? `
                <div class="form-group">
                    <input type="text" id="userName" class="form-control" value="${data.username}" disabled  autocomplete="off">
                    <label for="userName" class="form-label">Username</label>
                </div>` : ""}

                <div class="form-group">
                    <input type="text" id="lastName" name="lastName" class="form-control"
                        value="${isEdit ? data.last_name : ""}" required placeholder=" " autocomplete="off">
                    <label for="lastName" class="form-label">Last Name <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="firstName" name="firstName" class="form-control"
                        value="${isEdit ? data.first_name : ""}" required placeholder=" " autocomplete="off">
                    <label for="firstName" class="form-label">First Name <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="middleName" name="middleName" class="form-control"
                        value="${isEdit ? (data.middle_name || "") : ""}" placeholder=" " autocomplete="off">
                    <label for="middleName" class="form-label">Middle Name</label>
                </div>

                <div class="form-group">
                    <select id="gender" name="gender"  class="form-control" required>
                        <option value="" disabled selected hidden></option>
                        <option value="Male" ${isEdit && data.gender === "Male" ? "selected" : ""}>Male</option>
                        <option value="Female" ${isEdit && data.gender === "Female" ? "selected" : ""}>Female</option>
                    </select>
                    <label for="gender" class="form-label">Gender <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="date" id="dateofBirth" name="dateofBirth" class="form-control"
                        value="${isEdit ? data.date_of_birth : ""}" required autocomplete="off">
                    <label for="dateofBirth" class="form-label">Date of Birth <span class="required">*</span></label>
                    <span id="dobError" class="error-msg-calendar error" style="display: none;"></span>
                </div>

                <div class="form-group">
                    <input type="email" id="email" name="email" class="form-control"
                        value="${isEdit ? data.email : ""}" required placeholder=" " autocomplete="off">
                    <label for="email" class="form-label">Email <span class="required">*</span></label>
                </div>

                <div class="form-group phone-group">
                    <input type="tel" id="contactNumber" name="contactNumber"  class="form-control"
                        value="${isEdit ? data.contact_number : ""}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" pattern="[0-9]{10}" title="Mobile number must be 10 digits" required maxlength="10" autocomplete="off">
                    <label for="contactNumber" class="form-label">Mobile Number <span class="required">*</span></label>
                    <span class="phone-prefix">+63</span>
                </div>

                <div class="form-group">
                    <input type="text" id="address" name="address" class="form-control"
                        value="${isEdit ? data.address : ""}" required placeholder=" " autocomplete="off">
                    <label for="address" class="form-label">Address <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <select id="branchAssignment" name="branchAssignment" class="form-control" required>
                        <option value="" disabled selected hidden></option>
                    </select>
                    <label for="branchAssignment" class="form-label">Branch <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <select id="status" name="status" class="form-control" required>
                        <option value="" disabled selected hidden></option>
                        <option value="Active" ${isEdit && data.status === "Active" ? "selected" : ""}>Active</option>
                        <option value="Inactive" ${isEdit && data.status === "Inactive" ? "selected" : ""}>Inactive</option>
                    </select>
                    <label for="status" class="form-label">Status <span class="required">*</span></label>
                </div>
                            
                <div class="form-group">
                    <input type="date" id="dateStarted" name="dateStarted" class="form-control"
                        value="${isEdit ? data.date_started : ''}" required autocomplete="off">
                    <label for="dateStarted" class="form-label">Start Date <span class="required">*</span></label>
                    <span id="dateError" class="error-msg-calendar error" style="display: none;">
                        Sundays are not available for appointments. Please select another date.
                    </span>
                </div>

                ${isEdit ? `
                <div class="form-group">
                    <input type="text" id="dateCreated" class="form-control" value="${data.date_created}" disabled>
                    <label for="dateCreated" class="form-label">Date Created</label>
                </div>` : ""}

                <div class="button-group button-group-profile">
                    <button type="submit" class="form-button confirm-btn">${isEdit ? "Save Changes" : "Add Admin"}</button>
                    <button type="button" class="form-button cancel-btn" onclick="closeEmployeeModal()">Cancel</button>
                </div>
            </form>
        `;

        fetch(`${BASE_URL}/Owner/processes/employees/get_branches.php`)
        .then(res => res.json())
        .then(branches => {
            const branchSelect = document.getElementById("branchAssignment");
            branches.forEach(branch => {
                const option = document.createElement("option");
                option.value = branch.branch_id;
                option.textContent = branch.name;
                if (isEdit && branch.branch_id == data.branch_id) option.selected = true;
                branchSelect.appendChild(option);
            });
        });
    }
    
    function renderDentistForm(data) {
        const isEdit = !!data;
        const selectedBranches = isEdit && data.branches ? data.branches.map(b => parseInt(b)) : [];
        const selectedServices = isEdit && data.services ? data.services.map(s => parseInt(s)) : [];
        
        employeeBody.innerHTML = `
            <h2>${isEdit ? "Manage Dentist" : "Add Dentist"}</h2>
            <form id="dentistForm" action="${BASE_URL}/Owner/processes/employees/${isEdit ? "update_dentist.php" : "insert_dentist.php"}" method="POST" enctype="multipart/form-data" autocomplete="off">
                ${isEdit ? `<input type="hidden" name="dentist_id" value="${data.dentist_id}">` : ""}

                <div class="form-group">
                    <input type="text" id="lastName" name="lastName" class="form-control"
                        value="${isEdit ? data.last_name : ""}" required placeholder=" " autocomplete="off">
                    <label for="lastName" class="form-label">Last Name <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="firstName" name="firstName" class="form-control"
                        value="${isEdit ? data.first_name : ""}" required placeholder=" " autocomplete="off">
                    <label for="firstName" class="form-label">First Name <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="middleName" name="middleName" class="form-control"
                        value="${isEdit ? (data.middle_name || "") : ""}" placeholder=" " autocomplete="off">
                    <label for="middleName" class="form-label">Middle Name</label>
                </div>

                <div class="form-group">
                    <select id="gender" name="gender" class="form-control" required>
                        <option value="" disabled selected hidden></option>
                        <option value="Male" ${isEdit && data.gender === "Male" ? "selected" : ""}>Male</option>
                        <option value="Female" ${isEdit && data.gender === "Female" ? "selected" : ""}>Female</option>
                    </select>
                    <label for="gender" class="form-label">Gender <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="date" id="dateofBirth" name="dateofBirth" class="form-control"
                        value="${isEdit ? data.date_of_birth : ""}" required autocomplete="off">
                    <label for="dateofBirth" class="form-label">Date of Birth <span class="required">*</span></label>
                    <span id="dobError" class="error-msg-calendar error" style="display: none;">
                        Date of birth cannot be in the future.
                    </span>
                </div>

                <div class="form-group">
                    <input type="email" id="email" name="email" class="form-control"
                        value="${isEdit ? data.email : ""}" required placeholder=" " autocomplete="off">
                    <label for="email" class="form-label">Email <span class="required">*</span></label>
                </div>

                <div class="form-group phone-group">
                    <input type="tel" id="contactNumber" name="contactNumber" class="form-control" 
                        value="${isEdit ? data.contact_number : ""}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" pattern="[0-9]{10}" title="Mobile number must be 10 digits" required maxlength="10" autocomplete="off">
                    <label for="contactNumber" class="form-label">Mobile Number <span class="required">*</span></label>
                    <span class="phone-prefix">+63</span>
                </div>

                <div class="form-group">
                    <input type="text" id="licenseNumber" name="licenseNumber" class="form-control"
                        value="${isEdit ? data.license_number : ""}" required placeholder=" " autocomplete="off">
                    <label for="licenseNumber" class="form-label">License Number <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <div id="branchAssignment" class="checkbox-group"></div>
                </div>

                <div class="form-group">
                    <div id="servicesCheckboxes" class="checkbox-group"></div>
                </div>

                <div class="form-group">
                    <select id="status" name="status" class="form-control" required>
                        <option value="" disabled selected hidden></option>
                        <option value="Active" ${isEdit && data.status === "Active" ? "selected" : ""}>Active</option>
                        <option value="Inactive" ${isEdit && data.status === "Inactive" ? "selected" : ""}>Inactive</option>
                    </select>
                    <label for="status" class="form-label">Status <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="file" id="signatureImage" name="signatureImage" class="form-control" accept="image/*" ${isEdit ? "" : "required"}>
                    <label for="signatureImage" class="form-label">Signature Image <span class="required">*</span></label>

                    ${isEdit && data.signature_image 
                        ? `<div class="mt-2">
                                <p>Current Signature:</p>
                                <img src="${BASE_URL}/images/signatures/${data.signature_image}" alt="Signature" style="max-width:150px; border:1px solid #ccc; padding:4px; border-radius:6px;">
                        </div>` 
                        : ""
                    }
                </div>
                
                <div class="form-group">
                    <input type="date" id="dateStarted" name="dateStarted" class="form-control"
                        value="${isEdit ? data.date_started : ''}" required autocomplete="off">
                    <label for="dateStarted" class="form-label">Start Date <span class="required">*</span></label>
                    <span id="dateError" class="error-msg-calendar error" style="display: none;">
                        Sundays are not available for appointments. Please select another date.
                    </span>
                </div>

                ${isEdit ? `
                <div class="form-group">
                    <input type="text" id="dateCreated" class="form-control" value="${data.date_created}" disabled>
                    <label for="dateCreated" class="form-label">Date Created</label>
                </div>` : ""}

                <div class="button-group button-group-profile">
                    <button type="submit" class="form-button confirm-btn">${isEdit ? "Save Changes" : "Add Dentist"}</button>
                    <button type="button" class="form-button cancel-btn" onclick="closeEmployeeModal()">Cancel</button>
                </div>
            </form>
        `;

        fetch(`${BASE_URL}/Owner/processes/employees/get_branches.php`)
        .then(res => res.json())
        .then(branches => {
            const container = document.getElementById("branchAssignment");
            container.innerHTML = "";

            branches.forEach(branch => {
            const wrapper = document.createElement("div");
            wrapper.innerHTML = `
                <div class="checkbox-item">
                    <input type="checkbox" id="branch_${branch.branch_id}" name="branches[]" value="${branch.branch_id}"
                        ${isEdit && selectedBranches.includes(parseInt(branch.branch_id)) ? "checked" : ""}>
                    <label for="branch_${branch.branch_id}">${branch.name}</label>  
                </div>
            `;
            container.appendChild(wrapper);
            });
        });

        fetch(`${BASE_URL}/Owner/processes/employees/get_services.php`)
        .then(res => res.json())
        .then(services => {
            const container = document.getElementById("servicesCheckboxes");
            container.innerHTML = "";

            services.forEach(service => {
                const wrapper = document.createElement("div");
                wrapper.innerHTML = `
                    <div class="checkbox-item">
                        <input type="checkbox" id="service_${service.service_id}" name="services[]" value="${service.service_id}"
                            ${isEdit ? (selectedServices.includes(parseInt(service.service_id)) ? "checked" : "") : "checked"}>
                        <label for="service_${service.service_id}">${service.name}</label>
                    </div>
                `;
                container.appendChild(wrapper);
            });
        });
    }
});

function closeEmployeeModal() {
    document.getElementById("manageModal").style.display = "none";
}
