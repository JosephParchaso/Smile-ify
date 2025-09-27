document.addEventListener("DOMContentLoaded", () => {
    const manageModal = document.getElementById("manageRecordModal");
    const modalBody = document.getElementById("modalRecordBody");

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

    function renderTransactionForm(data) {
        const isEdit = !!data;

        modalBody.innerHTML = `
            <h2>${isEdit ? "Manage Transaction" : "Add Transaction"}</h2>
            <form id="transactionForm" 
                action="${BASE_URL}/Admin/processes/manage_appointment/${isEdit ? 'update_transaction.php' : 'insert_transaction.php'}" 
                method="POST" autocomplete="off" />
                
                ${isEdit ? `<input type="hidden" name="dental_transaction_id" value="${data.dental_transaction_id}">` : ""}
                <input type="hidden" name="appointment_transaction_id" value="${appointmentId}">

                <div class="form-group">
                    <select id="transactionDentist" class="form-control" name="dentist_id" required>
                        <option value="" disabled ${isEdit ? "" : "selected"} hidden></option>
                    </select>
                    <label for="transactionDentist" class="form-label">Dentist <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <select id="transactionPromo" class="form-control" name="promo_id" required>
                        <option value="" disabled ${isEdit ? "" : "selected"} hidden></option>
                    </select>
                    <label for="transactionPromo" class="form-label">Promo <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="number" step="0.01" id="amountPaid" class="form-control" name="amount_paid"
                        value="${isEdit ? data.amount_paid : ""}" required />
                    <label for="amountPaid" class="form-label">Amount Paid <span class="required">*</span></label>
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

                <div class="form-group">
                    <textarea id="notes" class="form-control" name="notes" rows="3">${isEdit ? data.notes : ""}</textarea>
                    <label for="notes" class="form-label">Notes</label>
                </div>

                <div class="button-group">
                    <button type="submit" class="form-button confirm-btn">${isEdit ? "Update Transaction" : "Save Transaction"}</button>
                    <button type="button" class="form-button cancel-btn" onclick="closeManageModal()">Cancel</button>
                </div>
            </form>
        `;
        const dentistSelect = modalBody.querySelector("#transactionDentist");
        if (dentistSelect) {
            loadDentistsByAppointment(appointmentId, dentistSelect, isEdit ? data.dentist_id : null);
        }
        
        const promoSelect = modalBody.querySelector("#transactionPromo");
            if (promoSelect) {
                loadPromos(promoSelect, isEdit ? data.promo_id : null, appointmentId);
        }
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
                        value="${isEdit ? data.blood_pressure : ""}" placeholder="e.g. 120/80" required autocomplete="off" />
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
});

function closeManageModal() {
    document.getElementById("manageRecordModal").style.display = "none";
}
