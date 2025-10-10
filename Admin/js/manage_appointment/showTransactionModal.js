document.addEventListener("DOMContentLoaded", () => {
    const manageModal = document.getElementById("manageRecordModal");
    const modalBody = document.getElementById("modalRecordBody");

    if (!manageModal || !modalBody) return;
    
    document.body.addEventListener("click", function (e) {
        if (e.target.classList.contains("btn-action")) {
            const id = e.target.getAttribute("data-id");
            const type = e.target.getAttribute("data-type");

            let url = "";
            if (type === "dental_transaction") {
                url = `${BASE_URL}/Admin/processes/manage_appointment/get_transaction_details.php?id=${id}`;
            } else if (type === "vital") {
                url = `${BASE_URL}/Admin/processes/manage_appointment/get_vital_details.php?id=${id}`;
            } else if (type === "prescription") {
                url = `${BASE_URL}/Admin/processes/manage_appointment/get_prescription_details.php?id=${id}`;
            }

            if (!url) return;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    modalBody.innerHTML = `<p style="color:red;">${data.error}</p>`;
                    manageModal.style.display = "block";
                    return;
                }

                if (type === "dental_transaction") {
                    renderTransactionForm(data);
                } else if (type === "vital") {
                    renderVitalForm(data);
                } else if (type === "prescription") {
                    renderPrescriptionForm(data);
                }

                manageModal.style.display = "block";
            })
            .catch(() => {
                modalBody.innerHTML = `<p style="color:red;">Error loading ${type} details</p>`;
                manageModal.style.display = "block";
            });
        }
    });

    document.body.addEventListener("click", function (e) {
        if (e.target.id === "insertVitalBtn") {
            renderVitalForm(null);
            manageModal.style.display = "block";
        }
        if (e.target.id === "insertPrescriptionBtn") {
            renderPrescriptionForm(null);
            manageModal.style.display = "block";
        }
        if (e.target.id === "insertTransactionBtn") {
            renderTransactionForm(null);
            manageModal.style.display = "block";
        }
    });

    let cachedServices = [];

    function renderTransactionForm(data) {
        const isEdit = !!data;

        modalBody.innerHTML = `
            <h2>${isEdit ? "Manage Transaction" : "Add Transaction"}</h2>
            <form id="transactionForm" 
                action="${BASE_URL}/Admin/processes/manage_appointment/${isEdit ? 'update_transaction.php' : 'insert_transaction.php'}" 
                method="POST" autocomplete="off">

                ${isEdit ? `<input type="hidden" name="dental_transaction_id" value="${data.dental_transaction_id}">` : ""}
                <input type="hidden" name="appointment_transaction_id" value="${appointmentId}">

                <div class="form-group">
                    <select id="transactionDentist" class="form-control" name="dentist_id" required>
                        <option value="" disabled ${isEdit ? "" : "selected"} hidden></option>
                    </select>
                    <label for="transactionDentist" class="form-label">Dentist <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <div id="serviceContainer">
                        <div class="service-row">
                            <select id="transactionService" class="form-control transactionServiceSelect" name="service_ids[]" required>
                            </select>
                            <label for="transactionService" class="form-label">Services</label>
                            <button type="button" class="add-service-btn" title="Add another service">+</button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <select id="transactionPromo" class="form-control" name="promo_id">
                        <option value="" selected hidden>None</option>
                    </select>
                    <label for="transactionPromo" class="form-label">Promo </label>
                </div>

                <div class="form-group">
                    <textarea id="notes" class="form-control" name="notes" rows="3">${isEdit ? data.notes || "" : ""}</textarea>
                    <label for="notes" class="form-label">Notes</label>
                </div>

                <div class="checkout-summary">
                    <h3>Transaction Summary</h3>
                    <div id="servicesList"></div> 
                    <div class="summary-item">
                        <span>Subtotal:</span>
                        <span id="subtotalDisplay">₱0.00</span>
                    </div>
                    <div class="summary-item">
                        <span>Discount:</span>
                        <span id="discountDisplay">₱0.00</span>
                    </div>
                    <hr>
                    <div class="summary-item total">
                        <span>Total Payment:</span>
                        <span id="totalDisplay">₱0.00</span>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="form-button confirm-btn">${isEdit ? "Update Transaction" : "Save Transaction"}</button>
                    <button type="button" class="form-button cancel-btn" onclick="closeManageModal()">Cancel</button>
                </div>
            </form>
        `;

        const dentistSelect = modalBody.querySelector("#transactionDentist");
        if (dentistSelect) loadDentistsByAppointment(appointmentId, dentistSelect, isEdit ? data.dentist_id : null);

        const promoSelect = modalBody.querySelector("#transactionPromo");
        if (promoSelect) loadPromos(promoSelect, isEdit ? data.promo_id : null, appointmentId);

        const serviceContainer = modalBody.querySelector("#serviceContainer");

        loadAllServicesOnce(branchId, serviceContainer.querySelector(".transactionServiceSelect"));

        serviceContainer.addEventListener("click", (e) => {
            if (e.target.classList.contains("add-service-btn")) {
                const newRow = document.createElement("div");
                newRow.classList.add("service-row");
                newRow.innerHTML = `
                    <select class="form-control transactionServiceSelect" name="service_ids[]" required>
                    </select>
                    <button type="button" class="remove-service-btn">–</button>
                `;
                serviceContainer.appendChild(newRow);

                populateServicesDropdown(newRow.querySelector(".transactionServiceSelect"));
            }

            if (e.target.classList.contains("remove-service-btn")) {
                e.target.closest(".service-row").remove();
                updateServicesSummary();
            }
        });

        serviceContainer.addEventListener("change", (e) => {
            if (e.target.classList.contains("transactionServiceSelect")) {
                updateServicesSummary();
            }
        });
    }

    function updateCheckoutSummary(data) {
        data = data || {};

        const services = data.services || [];

        const servicesList = document.getElementById("servicesList");
        const subtotalEl = document.getElementById("subtotalDisplay");
        const discountEl = document.getElementById("discountDisplay");
        const totalEl = document.getElementById("totalDisplay");

        if (servicesList) servicesList.innerHTML = "";

        let subtotal = 0;
        services.forEach(service => {
            const price = parseFloat(service.price) || 0;
            subtotal += price;

            const item = document.createElement("div");
            item.classList.add("summary-item");
            item.innerHTML = `
                <span>${service.name}</span>
                <span>₱${price.toFixed(2)}</span>
            `;
            servicesList.appendChild(item);
        });

        const promoDiscount = data.promo_discount ? parseFloat(data.promo_discount) : 0;
        const discount = promoDiscount > 0 ? (subtotal * (promoDiscount / 100)) : 0;
        const total = subtotal - discount;

        if (subtotalEl) subtotalEl.textContent = `₱${subtotal.toFixed(2)}`;
        if (discountEl) discountEl.textContent = `₱${discount.toFixed(2)}`;
        if (totalEl) totalEl.textContent = `₱${total.toFixed(2)}`;
    }

    function updateServicesSummary() {
        const serviceSelects = document.querySelectorAll(".transactionServiceSelect");
        const services = [];

        serviceSelects.forEach(sel => {
            const opt = sel.selectedOptions[0];
            if (opt && opt.value) {
                services.push({
                    name: opt.dataset.name,
                    price: parseFloat(opt.dataset.price)
                });
            }
        });

        const promoSelect = document.getElementById("transactionPromo");
        const discount = promoSelect?.selectedOptions[0]?.dataset?.discount 
            ? parseFloat(promoSelect.selectedOptions[0].dataset.discount)
            : 0;

        updateCheckoutSummary({
            services: services,
            promo_discount: discount
        });
    }

    function loadAllServicesOnce(branchId, firstSelectEl) {
        if (cachedServices.length > 0) {
            populateServicesDropdown(firstSelectEl);
            return;
        }

        fetch(`${BASE_URL}/Admin/processes/manage_appointment/get_services_by_branch.php?branch_id=${branchId}`)
            .then(res => res.json())
            .then(services => {
                cachedServices = services;
                populateServicesDropdown(firstSelectEl);
            })
            .catch(err => console.error("Failed to load services:", err));
    }

    function populateServicesDropdown(selectEl) {
        if (!selectEl) return;

        selectEl.innerHTML = `
            ${cachedServices.map(s => `
                <option value="${s.service_id}" data-name="${s.name}" data-price="${s.price}">
                    ${s.name} — ₱${parseFloat(s.price).toFixed(2)}
                </option>
            `).join("")}
        `;
    }

    function renderVitalForm(data) {
        const isEdit = !!data;

        modalBody.innerHTML = `
            <h2>${isEdit ? "Manage Vitals" : "Add Vitals"}</h2>
            <form id="vitalForm" 
                action="${BASE_URL}/Admin/processes/manage_appointment/${isEdit ? 'update_vital.php' : 'insert_vital.php'}" 
                method="POST" autocomplete="off" />
                
                ${isEdit ? `<input type="hidden" name="vitals_id" value="${data.vitals_id}">` : ""}
                <input type="hidden" name="appointment_transaction_id" value="${appointmentId}">

                <div class="form-group">
                    <input type="number" step="0.1" id="bodyTemp" class="form-control" name="body_temp"
                        value="${isEdit ? data.body_temp : ""}" required />
                    <label for="bodyTemp" class="form-label">Body Temperature (°C) <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="number" id="pulseRate" class="form-control" name="pulse_rate"
                        value="${isEdit ? data.pulse_rate : ""}" required />
                    <label for="pulseRate" class="form-label">Pulse Rate (bpm) <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="number" id="respiratoryRate" class="form-control" name="respiratory_rate"
                        value="${isEdit ? data.respiratory_rate : ""}" required />
                    <label for="respiratoryRate" class="form-label">Respiratory Rate <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="bloodPressure" class="form-control" name="blood_pressure"
                        value="${isEdit ? data.blood_pressure : ""}" required autocomplete="off" />
                    <label for="bloodPressure" class="form-label">Blood Pressure <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="number" step="0.1" id="height" class="form-control" name="height"
                        value="${isEdit ? data.height : ""}" required />
                    <label for="height" class="form-label">Height (cm) <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="number" step="0.1" id="weight" class="form-control" name="weight"
                        value="${isEdit ? data.weight : ""}" required />
                    <label for="weight" class="form-label">Weight (kg) <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <select id="isSwelling" class="form-control" name="is_swelling" required>
                        <option value="No" ${isEdit && data.is_swelling === "No" ? "selected" : ""}>No</option>
                        <option value="Yes" ${isEdit && data.is_swelling === "Yes" ? "selected" : ""}>Yes</option>
                    </select>
                    <label for="isSwelling" class="form-label">Swelling <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <select id="isSensitive" class="form-control" name="is_sensitive" required>
                        <option value="No" ${isEdit && data.is_sensitive === "No" ? "selected" : ""}>No</option>
                        <option value="Yes" ${isEdit && data.is_sensitive === "Yes" ? "selected" : ""}>Yes</option>
                    </select>
                    <label for="isSensitive" class="form-label">Sensitive <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <select id="isBleeding" class="form-control" name="is_bleeding" required>
                        <option value="No" ${isEdit && data.is_bleeding === "No" ? "selected" : ""}>No</option>
                        <option value="Yes" ${isEdit && data.is_bleeding === "Yes" ? "selected" : ""}>Yes</option>
                    </select>
                    <label for="isBleeding" class="form-label">Bleeding <span class="required">*</span></label>
                </div>

                <div class="button-group">
                    <button type="submit" class="form-button confirm-btn">${isEdit ? "Update Vitals" : "Save Vitals"}</button>
                    <button type="button" class="form-button cancel-btn" onclick="closeManageModal()">Cancel</button>
                </div>
            </form>
        `;
    }

    function renderPrescriptionForm(data) {
        const isEdit = !!data;

        modalBody.innerHTML = `
            <h2>${isEdit ? "Manage Prescription" : "Add Prescription"}</h2>
            <form id="prescriptionForm" 
                action="${BASE_URL}/Admin/processes/manage_appointment/${isEdit ? 'update_prescription.php' : 'insert_prescription.php'}" 
                method="POST" autocomplete="off" />
                
                ${isEdit ? `<input type="hidden" name="prescription_id" value="${data.prescription_id}">` : ""}
                <input type="hidden" name="appointment_transaction_id" value="${appointmentId}">

                <div class="form-group">
                    <input type="text" id="drug" class="form-control" name="drug"
                        value="${isEdit ? data.drug : ""}" required />
                    <label for="drug" class="form-label">Drug <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="frequency" class="form-control" name="frequency"
                        value="${isEdit ? data.frequency : ""}" required />
                    <label for="frequency" class="form-label">Frequency <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="dosage" class="form-control" name="dosage"
                        value="${isEdit ? data.dosage : ""}" required />
                    <label for="dosage" class="form-label">Dosage <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="duration" class="form-control" name="duration"
                        value="${isEdit ? data.duration : ""}" required />
                    <label for="duration" class="form-label">Duration <span class="required">*</span></label>
                </div>

                
                <div class="form-group">
                    <input type="text" id="quantity" class="form-control" name="quantity"
                        value="${isEdit ? data.quantity : ""}" required />
                    <label for="quantity" class="form-label">Quantity <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <textarea id="instructions" class="form-control" name="instructions" rows="3" required>${isEdit ? data.instructions : ""}</textarea>
                    <label for="instructions" class="form-label">Instructions <span class="required">*</span></label>
                </div>

                <div class="button-group">
                    <button type="submit" class="form-button confirm-btn">${isEdit ? "Update Prescription" : "Save Prescription"}</button>
                    <button type="button" class="form-button cancel-btn" onclick="closeManageModal()">Cancel</button>
                </div>
            </form>
        `;
    }

    function loadDentistsByAppointment(appointmentId, dentistSelect, selectedId = null) {
        $.ajax({
            type: "GET",
            url: `${BASE_URL}/Admin/processes/manage_appointment/get_dentists.php`,
            data: { appointment_id: appointmentId },
            dataType: "json", 
            success: function (dentists) {
                dentistSelect.innerHTML = '<option value="" disabled selected hidden></option>';
                
                dentists.forEach(d => {
                    const opt = document.createElement("option");
                    opt.value = d.id;
                    opt.textContent = d.name;
                    if (selectedId && selectedId == d.id) {
                        opt.selected = true;
                    }
                    dentistSelect.appendChild(opt);
                });
            },
            error: function (xhr, status, error) {
                console.error("Dentist load failed:", status, error, xhr.responseText);
                dentistSelect.innerHTML = '<option disabled>Error loading dentists</option>';
            }
        });
    }

    function loadPromos(promoSelect, selectedId = null, appointmentId) {
        $.ajax({
            type: "GET",
            url: `${BASE_URL}/Admin/processes/manage_appointment/get_promos.php`,
            data: { appointment_id: appointmentId },
            dataType: "json", 
            success: function (promos) {
                promoSelect.innerHTML = '<option value="" disabled selected hidden></option>';
                
                if (promos.length === 0) {
                    const opt = document.createElement("option");
                    opt.value = "";
                    opt.textContent = "No promos available";
                    opt.disabled = true;
                    promoSelect.appendChild(opt);
                    return;
                }

                promos.forEach(p => {
                    const opt = document.createElement("option");
                    opt.value = p.id;
                    opt.textContent = p.name;
                    if (selectedId && selectedId == p.id) {
                        opt.selected = true;
                    }
                    promoSelect.appendChild(opt);
                });
            },
            error: function (xhr, status, error) {
                console.error("Promo load failed:", status, error, xhr.responseText);
                promoSelect.innerHTML = '<option disabled>Error loading promos</option>';
            }
        });
    }

    function checkVitalStatus() {
        fetch(`${BASE_URL}/Admin/processes/manage_appointment/check_vital_exists.php?appointment_id=${appointmentId}`)
            .then(res => res.json())
            .then(data => {
                const insertVitalBtn = document.getElementById("insertVitalBtn");
                if (!insertVitalBtn) return;

                if (data.exists) {
                    insertVitalBtn.style.display = "none";
                } else {
                    insertVitalBtn.style.display = "inline-block";
                }
            })
            .catch(err => console.error("Error checking vital status:", err));
    }
    
    checkVitalStatus();
});


function closeManageModal() {
    document.getElementById("manageRecordModal").style.display = "none";
}


