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
                url = `${BASE_URL}/Admin/processes/manage_appointment/transactions/get_transaction_details.php?id=${id}`;
            } else if (type === "vital") {
                url = `${BASE_URL}/Admin/processes/manage_appointment/vitals/get_vital_details.php?id=${id}`;
            } else if (type === "prescription") {
                url = `${BASE_URL}/Admin/processes/manage_appointment/prescriptions/get_prescription_details.php?id=${id}`;
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
        if (e.target.id === "insertTransactionBtn") {
            window.appointmentId = e.target.getAttribute("data-appointment-id");
            renderTransactionForm(null);
            manageModal.style.display = "block";
        }
        if (e.target.id === "insertVitalBtn") {
            renderVitalForm(null);
            manageModal.style.display = "block";
        }
        if (e.target.id === "insertPrescriptionBtn") {
            renderPrescriptionForm(null);
            manageModal.style.display = "block";
        }
    });

    function renderTransactionForm(data) {
        const isEdit = !!data;
        const appointmentId = data?.appointment_id || window.appointmentId || null;

        modalBody.innerHTML = `
            <h2>${isEdit ? "Manage Transaction" : "Add Transaction"}</h2>
            <form id="transactionForm" 
                action="${BASE_URL}/Admin/processes/manage_appointment/transactions/${isEdit ? 'update_transaction.php' : 'insert_transaction.php'}" 
                method="POST" autocomplete="off">

                ${isEdit ? `<input type="hidden" name="dental_transaction_id" value="${data.dental_transaction_id}">` : ""}
                <input type="hidden" name="appointment_transaction_id" value="${appointmentId}">
                <input type="hidden" name="admin_user_id" value="${userId}" readonly required>

                <div class="form-group">
                    <select id="transactionDentist" class="form-control" name="dentist_id" required>
                        <option value="" disabled ${isEdit ? "" : "selected"} hidden></option>
                    </select>
                    <label for="transactionDentist" class="form-label">Dentist <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <div id="servicesContainer" class="checkbox-group">
                        <p class="loading-text">Loading Services</p>
                    </div>
                </div>

                <div id="medicalCertFields"></div>

                <div class="form-group">
                    <select id="transactionPromo" class="form-control" name="promo_id">
                        <option value="" selected hidden>None</option>
                    </select>
                    <label for="transactionPromo" class="form-label">Promo </label>
                </div>

                <div class="form-group">
                    <select id="paymentMethod" class="form-control" name="payment_method" required>
                        <option value="" disabled ${isEdit ? "" : "selected"} hidden>Select Payment Method</option>
                        <option value="Cash" ${isEdit && data.payment_method === 'Cash' ? 'selected' : ''}>Cash</option>
                        <option value="Cashless" ${isEdit && data.payment_method === 'Cashless' ? 'selected' : ''}>Cashless</option>
                    </select>
                    <label for="paymentMethod" class="form-label">Payment Method <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <textarea id="notes" class="form-control" name="notes" rows="3" placeholder=" ">${isEdit ? data.notes || "" : ""}</textarea>
                    <label for="notes" class="form-label">Notes</label>
                </div>

                ${isEdit ? `
                <div class="form-group">
                    <input type="text" id="recordedBy" class="form-control" value="${data.recorded_by}" disabled>
                    <label for="recordedBy" class="form-label">Recorded by:</label>
                </div>` : ""}

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
                        <span>Total Amount:</span>
                        <span id="totalDisplay">₱0.00</span>
                    </div>
                </div>

                <input type="hidden" name="total_payment" id="total_payment" value="0">

                <div class="button-group">
                    <button type="submit" class="form-button confirm-btn">${isEdit ? "Update Transaction" : "Save Transaction"}</button>
                    <button type="button" class="form-button cancel-btn" onclick="closeManageModal()">Cancel</button>
                </div>
            </form>
        `;

        const dentistSelect = modalBody.querySelector("#transactionDentist");
        const servicesContainer = modalBody.querySelector("#servicesContainer");
        const appointmentServiceIds = data?.appointment_service_ids || [];
        const appointmentDentistId = data?.dentist_id || window.appointmentDentistId || null;
        const effectiveBranchId = data?.branch_id || branchId;
        const mcFields = modalBody.querySelector("#medicalCertFields");

        if (!isEdit) {
            loadServices(effectiveBranchId, servicesContainer, null, appointmentServiceIds, () => {
                loadDentists(effectiveBranchId, appointmentServiceIds, dentistSelect, appointmentDentistId);
                updateServicesSummary();
                toggleMedicalCertFields();
            });
        } else {
            const selectedServices = data.services?.map(s => s.service_id) || [];
            loadServices(effectiveBranchId, servicesContainer, data.dental_transaction_id, selectedServices, () => {
                loadDentists(effectiveBranchId, [], dentistSelect, data.dentist_id);
                        
                selectedServices.forEach(id => {
                    const checkbox = servicesContainer.querySelector(`input[type="checkbox"][value="${id}"]`);
                    if (checkbox) {
                        checkbox.checked = true;
                        const quantityInput = document.querySelector(`input[name="serviceQuantity[${id}]"]`);
                        if (quantityInput) {
                            const serviceObj = data.services.find(s => s.service_id == id);
                            quantityInput.value = serviceObj?.quantity || 1;
                            quantityInput.style.display = 'inline-block';
                        }
                    }
                });
                updateServicesSummary();
                toggleMedicalCertFields();
            });
        }
        
        const promoSelect = modalBody.querySelector("#transactionPromo");
        if (promoSelect) {
            loadPromos(promoSelect, isEdit ? data.promo_id : null, effectiveBranchId);
        }

        if (isEdit && data.total) {
            const totalDisplay = modalBody.querySelector("#totalDisplay");
            const subtotalDisplay = modalBody.querySelector("#subtotalDisplay");
            const discountDisplay = modalBody.querySelector("#discountDisplay");
            const totalPaymentInput = modalBody.querySelector("#total_payment");

            if (totalDisplay) totalDisplay.textContent = `₱${parseFloat(data.total).toFixed(2)}`;
            if (subtotalDisplay) subtotalDisplay.textContent = `₱${parseFloat(data.total).toFixed(2)}`;
            if (discountDisplay) discountDisplay.textContent = `₱0.00`;
            if (totalPaymentInput) totalPaymentInput.value = parseFloat(data.total).toFixed(2);
            
        }

        function getMedicalCertCheckbox() {
            return [...servicesContainer.querySelectorAll('input[type="checkbox"][name="appointmentServices[]"]')]
                .find(cb => {
                    const lbl = cb.closest("label")?.textContent?.toLowerCase() || "";
                    return lbl.includes("certificate");
                });
        }

        function toggleMedicalCertFields() {
            const mcCheckbox = getMedicalCertCheckbox();

            if (mcCheckbox && mcCheckbox.checked) {
                const fitnessStatus = data?.fitness_status || "";
                const diagnosis = data?.diagnosis || "";
                const remarks = data?.remarks || "";

                mcFields.innerHTML = `
                    <div class="form-group">
                        <input type="text" id="fitnessStatus" class="form-control" 
                            name="fitness_status" placeholder=" " 
                            value="${fitnessStatus}">
                        <label for="fitnessStatus" class="form-label">
                            Fitness Status <span class="required">*</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <input type="text" id="diagnosis" class="form-control" 
                            name="diagnosis" placeholder=" " 
                            value="${diagnosis}">
                        <label for="diagnosis" class="form-label">
                            Diagnosis <span class="required">*</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <textarea id="remarks" class="form-control" 
                                name="remarks" rows="2" placeholder=" ">${remarks}</textarea>
                        <label for="remarks" class="form-label">Remarks <span class="required">*</span></label>
                    </div>
                `;
            } else {
                mcFields.innerHTML = "";
            }
        }

        document.body.addEventListener("input", e => {
            if (
                e.target.matches('input[name^="serviceQuantity"]') ||
                e.target.matches('input[type="checkbox"][name="appointmentServices[]"]')
            ) {
                toggleMedicalCertFields();
                updateServicesSummary();
            }
        });

        if (promoSelect) {
            promoSelect.addEventListener("change", updateServicesSummary);
        }
    }

    function updateServicesSummary() {
        const serviceCheckboxes = document.querySelectorAll('#servicesContainer input[type="checkbox"][name="appointmentServices[]"]');
        const services = [];

        serviceCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const serviceId = checkbox.value;
                const name = checkbox.parentElement.textContent.trim();
                const price = parseFloat(checkbox.closest('.checkbox-item').querySelector('.price').textContent.replace(/[₱,]/g, '')) || 0;
                const quantityInput = document.querySelector(`input[name="serviceQuantity[${serviceId}]"]`);
                const quantity = parseInt(quantityInput?.value || 1);
                services.push({ name, price, quantity });
            }
        });

        const promoSelect = document.getElementById("transactionPromo");
        const selectedPromo = promoSelect ? promoSelect.selectedOptions[0] : null;
        const discountType = selectedPromo?.dataset?.discountType || null;
        const discountValue = parseFloat(selectedPromo?.dataset?.discountValue || 0);

        updateCheckoutSummary({
            services,
            discountType,
            discountValue
        });
    }

    function updateCheckoutSummary({ services = [], discountType = null, discountValue = 0 }) {
        const servicesList = document.getElementById("servicesList");
        const subtotalEl = document.getElementById("subtotalDisplay");
        const discountEl = document.getElementById("discountDisplay");
        const totalEl = document.getElementById("totalDisplay");

        if (servicesList) servicesList.innerHTML = "";

        let subtotal = 0;

        services.forEach(service => {
            const totalPrice = service.price * service.quantity;
            subtotal += totalPrice;

            const item = document.createElement("div");
            item.classList.add("summary-item");
            item.innerHTML = `
                <span>${service.name} × ${service.quantity}</span>
                <span>₱${totalPrice.toFixed(2)}</span>
            `;
            servicesList.appendChild(item);
        });

        let discount = 0;
        if (discountType === "fixed") {
            discount = discountValue;
        } else if (discountType === "percent" || discountType === "percentage") {
            discount = subtotal * (discountValue / 100);
        }

        const total = Math.max(subtotal - discount, 0);

        if (subtotalEl) subtotalEl.textContent = `₱${subtotal.toFixed(2)}`;
        if (discountEl) discountEl.textContent = `₱${discount.toFixed(2)}`;
        if (totalEl) totalEl.textContent = `₱${total.toFixed(2)}`;
        
        const totalPaymentInput = document.getElementById("total_payment");
        if (totalPaymentInput) {
            totalPaymentInput.value = total.toFixed(2);
        }
    }

    function loadPromos(promoSelect, selectedId = null, branchId = null) {
        $.ajax({
            type: "GET",
            url: `${BASE_URL}/processes/load_promos.php`,
            data: { branch_id: branchId || window.branchId || null },
            dataType: "json",
            success: function (promos) {
                promoSelect.innerHTML = '<option value="">None</option>';

                promos.forEach(p => {
                    const opt = document.createElement("option");
                    opt.value = p.id;
                    opt.dataset.discountType = p.discount_type;
                    opt.dataset.discountValue = p.discount_value;

                    let discountLabel = "";
                    if (p.discount_type === "percent" || p.discount_type === "percentage") {
                        discountLabel = ` (${parseFloat(p.discount_value).toFixed(2)}% OFF)`;
                    } else if (p.discount_type === "fixed") {
                        discountLabel = ` (₱${parseFloat(p.discount_value).toFixed(2)} OFF)`;
                    }

                    opt.textContent = `${p.name}${discountLabel}`;
                    if (selectedId && selectedId == p.id) opt.selected = true;
                    promoSelect.appendChild(opt);
                });

                promoSelect.addEventListener("change", updateServicesSummary);
                updateServicesSummary();
            },
            error: function (xhr, status, error) {
                console.error("Promo load failed:", status, error);
                promoSelect.innerHTML = '<option disabled>Error loading promos</option>';
            }
        });
    }

    function loadDentists(branchId, serviceIds = [], dentistSelect, selectedId = null, preserveIfStillValid = false) {
        dentistSelect.innerHTML = '<option disabled>Loading dentists...</option>';

        const finalSelectedId = selectedId || window.appointmentDentistId || null;

        $.ajax({
            type: "POST",
            url: `${BASE_URL}/processes/load_dentists.php`,
            data: {
                appointmentBranch: branchId,
                appointmentServices: serviceIds,
                forTransaction: true,
                selectedDentistId: finalSelectedId
            },
            success: function (response) {
                dentistSelect.innerHTML = response.trim();

                if (finalSelectedId) {
                    const optionToSelect = dentistSelect.querySelector(`option[value="${finalSelectedId}"]`);
                    if (optionToSelect) {
                        dentistSelect.value = finalSelectedId;
                    } else if (!preserveIfStillValid) {
                        dentistSelect.selectedIndex = 0;
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error("Dentist load failed:", status, error, xhr.responseText);
                dentistSelect.innerHTML = '<option disabled>Error loading dentists</option>';
            }
        });
    }

    function loadServices(branchId, container, transactionId = null, appointmentServiceIds = [], callback = null) {
        container.innerHTML = '<p class="loading-text">Loading services</p>';

        $.ajax({
            type: "POST",
            url: `${BASE_URL}/processes/load_services.php`,
            data: {
                appointmentBranch: branchId,
                appointment_transaction_id: transactionId,
                appointment_id: appointmentId,
                hide_duration: true 
            },
            success: function (response) {
                container.innerHTML = response;

                const checkboxes = container.querySelectorAll('input[name="appointmentServices[]"]');
                const dentistSelect = document.getElementById("transactionDentist");

                if (!transactionId && appointmentServiceIds.length > 0) {
                    checkboxes.forEach(cb => {
                        if (appointmentServiceIds.includes(cb.value)) {
                            cb.checked = true;
                        }
                    });
                }

                checkboxes.forEach(cb => {
                    cb.addEventListener("change", function () {
                        const selectedServices = [...container.querySelectorAll('input[name="appointmentServices[]"]:checked')]
                            .map(cb => cb.value);

                        dentistSelect.innerHTML = `<option value="" disabled selected hidden>Select a dentist</option>`;

                        const loadingOption = document.createElement("option");
                        loadingOption.textContent = "Loading available dentists...";
                        loadingOption.disabled = true;
                        dentistSelect.appendChild(loadingOption);

                        if (selectedServices.length === 0) {
                            dentistSelect.innerHTML = `<option value="" disabled selected hidden>No services selected</option>`;
                            return;
                        }
        const qtyInput = container.querySelector(`input[name="serviceQuantity[${cb.value}]"]`);
        qtyInput.style.display = cb.checked ? 'inline-block' : 'none';

        if (!cb.checked) qtyInput.value = 1;

                        const currentDentistId = null;
                        loadDentists(branchId, selectedServices, dentistSelect, currentDentistId, false);
                    });
                });

                if (callback) callback();
            },
            error: function (xhr, status, error) {
                console.error("Service load failed:", status, error, xhr.responseText);
                container.innerHTML = '<p class="error">Error loading services</p>';
            }
        });
    }

    function renderVitalForm(data) {
        const isEdit = !!data;

        modalBody.innerHTML = `
            <h2>${isEdit ? "Manage Vitals" : "Add Vitals"}</h2>
            <form id="vitalForm" 
                action="${BASE_URL}/Admin/processes/manage_appointment/vitals/${isEdit ? 'update_vital.php' : 'insert_vital.php'}" 
                method="POST" autocomplete="off" />
                
                ${isEdit ? `<input type="hidden" name="vitals_id" value="${data.vitals_id}">` : ""}
                <input type="hidden" name="appointment_transaction_id" value="${appointmentId}">
                <input type="hidden" name="admin_user_id" value="${userId}" readonly required>

                <div class="form-group">
                    <input type="number" step="0.1" id="bodyTemp" class="form-control" name="body_temp"
                        value="${isEdit ? data.body_temp : ""}"  placeholder=" "required />
                    <label for="bodyTemp" class="form-label">Body Temperature (°C) <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="number" id="pulseRate" class="form-control" name="pulse_rate"
                        value="${isEdit ? data.pulse_rate : ""}" placeholder=" " required />
                    <label for="pulseRate" class="form-label">Pulse Rate (bpm) <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="number" id="respiratoryRate" class="form-control" name="respiratory_rate"
                        value="${isEdit ? data.respiratory_rate : ""}" placeholder=" " required />
                    <label for="respiratoryRate" class="form-label">Respiratory Rate <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="bloodPressure" class="form-control" name="blood_pressure"
                        value="${isEdit ? data.blood_pressure : ""}" placeholder=" "  required autocomplete="off" />
                    <label for="bloodPressure" class="form-label">Blood Pressure <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="number" step="0.1" id="height" class="form-control" name="height"
                        value="${isEdit ? data.height : ""}" placeholder=" " required />
                    <label for="height" class="form-label">Height (cm) <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="number" step="0.1" id="weight" class="form-control" name="weight"
                        value="${isEdit ? data.weight : ""}" placeholder=" " required />
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

                ${isEdit ? `
                <div class="form-group">
                    <input type="text" id="recordedBy" class="form-control" value="${data.recorded_by}" disabled>
                    <label for="recordedBy" class="form-label">Recorded by:</label>
                </div>` : ""}

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
                action="${BASE_URL}/Admin/processes/manage_appointment/prescriptions/${isEdit ? 'update_prescription.php' : 'insert_prescription.php'}" 
                method="POST" autocomplete="off" />
                
                ${isEdit ? `<input type="hidden" name="prescription_id" value="${data.prescription_id}">` : ""}
                <input type="hidden" name="appointment_transaction_id" value="${appointmentId}">
                <input type="hidden" name="admin_user_id" value="${userId}" readonly required>

                <div class="form-group">
                    <input type="text" id="drug" class="form-control" name="drug"
                        value="${isEdit ? data.drug : ""}" placeholder=" " required />
                    <label for="drug" class="form-label">Drug <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="frequency" class="form-control" name="frequency"
                        value="${isEdit ? data.frequency : ""}" placeholder=" " required />
                    <label for="frequency" class="form-label">Frequency <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="dosage" class="form-control" name="dosage"
                        value="${isEdit ? data.dosage : ""}" placeholder=" " required />
                    <label for="dosage" class="form-label">Dosage <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <input type="text" id="duration" class="form-control" name="duration"
                        value="${isEdit ? data.duration : ""}" placeholder=" " required />
                    <label for="duration" class="form-label">Duration <span class="required">*</span></label>
                </div>

                
                <div class="form-group">
                    <input type="text" id="quantity" class="form-control" name="quantity"
                        value="${isEdit ? data.quantity : ""}" placeholder=" " required />
                    <label for="quantity" class="form-label">Quantity <span class="required">*</span></label>
                </div>

                <div class="form-group">
                    <textarea id="instructions" class="form-control" name="instructions" rows="3" placeholder=" ">${isEdit ? data.instructions : ""}</textarea>
                    <label for="instructions" class="form-label">Instructions</label>
                </div>

                ${isEdit ? `
                <div class="form-group">
                    <input type="text" id="recordedBy" class="form-control" value="${data.recorded_by}" disabled>
                    <label for="recordedBy" class="form-label">Recorded by:</label>
                </div>` : ""}

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

                <div class="button-group">
                    <button type="submit" class="form-button confirm-btn">${isEdit ? "Update Prescription" : "Save Prescription"}</button>
                    <button type="button" class="form-button cancel-btn" onclick="closeManageModal()">Cancel</button>
                </div>
            </form>
        `;
    }
});

function closeManageModal() {
    document.getElementById("manageRecordModal").style.display = "none";
}


