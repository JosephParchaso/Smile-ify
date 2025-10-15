document.addEventListener("DOMContentLoaded", () => {
    const appointmentModal = document.getElementById("manageModal");
    const appointmentBody = document.getElementById("modalBody");

    const transactionModal = document.getElementById("transactionModal");
    const transactionBody = document.getElementById("transactionModalBody");

    if (!appointmentModal && !transactionModal) return;

    document.body.addEventListener("click", function (e) {
        if (e.target.classList.contains("btn-action")) {
            const id = e.target.getAttribute("data-id");
            const type = e.target.getAttribute("data-type");

            let url = "";
            if (type === "appointment") {
                url = `${BASE_URL}/Admin/processes/manage_patient/get_appointment_details.php?id=${id}`;
            } else if (type === "transaction") {
                url = `${BASE_URL}/Admin/processes/manage_patient/get_dental_transaction_details.php?id=${id}`;
            }

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        if (type === "appointment") {
                            appointmentBody.innerHTML = `<p style="color:red;">${data.error}</p>`;
                            appointmentModal.style.display = "block";
                        } else {
                            transactionBody.innerHTML = `<p style="color:red;">${data.error}</p>`;
                            transactionModal.style.display = "block";
                        }
                        return;
                    }

                    if (type === "appointment") {
                        appointmentBody.innerHTML = `
                            <h2>Appointment Details</h2>
                            <p><strong>Dentist:</strong><span>${data.dentist ?? 'Available Dentist'}</span></p>
                            <p><strong>Branch:</strong><span>${data.branch}<span></p>
                            <p><strong>Service:</strong><span>${data.services || '-'}</p>
                            <p><strong>Date:</strong><span>${
                                data.appointment_date
                                    ? new Date(data.appointment_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })
                                    : ''
                            }</span></p>
                            <p><strong>Time:</strong><span>${
                                data.appointment_time
                                    ? new Date(`1970-01-01T${data.appointment_time}`).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })
                                    : ''
                            }</span></p>
                            <p><strong>Notes:</strong><span>${data.notes || '-'}</span></p>
                            <p><strong>Status:</strong><span>${data.status}<span></p>
                            <p><strong>Date Booked:</strong><span>${
                                data.date_created
                                    ? new Date(data.date_created).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })
                                    : '-'
                            }</span></p>
                        `;
                        appointmentModal.style.display = "block";
                    }

                    else if (type === "transaction") {
                        transactionBody.innerHTML = `
                            <div class="transaction-columns">
                                <div class="transaction-section">
                                    <h3>Dental Transaction</h3>
                                    <p><strong>Dentist:</strong><span>${data.dentist ?? 'Available Dentist'}</span></p>
                                    <p><strong>Branch:</strong><span>${data.branch}</span></p>
                                    <p><strong>Service:</strong><span>${data.services || '-'}</span></p>
                                    <p><strong>Date:</strong><span>${
                                        data.appointment_date
                                            ? new Date(data.appointment_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })
                                            : ''
                                    }</span></p>
                                    <p><strong>Time:</strong><span>${
                                        data.appointment_time
                                            ? new Date(`1970-01-01T${data.appointment_time}`).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })
                                            : ''
                                    }</span></p>
                                    <p><strong>Amount Paid:</strong><span>${data.total}</span></p>
                                    <p><strong>Notes:</strong><span>${data.notes || '-'}</span></p>
                                    <p><strong>Prepared by:</strong><span>${data.admin_name || '-'}</span></p>
                                    <p><strong>Date Recorded:</strong><span>${
                                        data.date_created
                                            ? new Date(data.date_created).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })
                                            : '-'
                                    }</span></p>
                                </div>

                                <div class="transaction-section">
                                    <h3>Vitals</h3>
                                    <p><strong>Body Temp:</strong><span>${data.body_temp}</span></p>
                                    <p><strong>Pulse Rate:</strong><span>${data.pulse_rate}</span></p>
                                    <p><strong>Respiratory Rate:</strong><span>${data.respiratory_rate}</span></p>
                                    <p><strong>Blood Pressure:</strong><span>${data.blood_pressure}</span></p>
                                    <p><strong>Height:</strong><span>${data.height}</span></p>
                                    <p><strong>Weight:</strong><span>${data.weight}</span></p>
                                    <p><strong>Swelling:</strong><span>${data.is_swelling}</span></p>
                                    <p><strong>Sensitivity:</strong><span>${data.is_sensitive}</span></p>
                                    <p><strong>Bleeding:</strong><span>${data.is_bleeding}</span></p>
                                </div>

                                <div class="transaction-section">
                                    <h3>Prescription</h3>
                                    <div id="prescriptionList"></div>

                                    <div class="button-group button-group-profile">
                                    <button class="confirm-btn" id="downloadPrescription">Download Prescription</button>
                                        ${
                                            data.prescription_downloaded == 0
                                            ? `<button class="confirm-btn" id="downloadPrescription">Release Prescription</button>`
                                            : `<button class="confirm-btn" disabled>Released</button>`
                                        }
                                    </div>
                                </div>
                            </div>
                        `;

                        // ===== PRESCRIPTIONS LIST =====
                        let prescriptionHtml = '';
                        if (data.prescriptions && data.prescriptions.length > 0) {
                            data.prescriptions.forEach(p => {
                                prescriptionHtml += `
                                    <div class="prescription-item">
                                        <p><strong>Drug:</strong><span>${p.drug}</span></p>
                                        <p><strong>Frequency:</strong><span>${p.frequency}</span></p>
                                        <p><strong>Dosage:</strong><span>${p.dosage}</span></p>
                                        <p><strong>Duration:</strong><span>${p.duration}</span></p>
                                        <p><strong>Quantity:</strong><span>${p.quantity}</span></p>
                                        <p><strong>Instructions:</strong><span>${p.instructions}</span></p>
                                        <hr>
                                    </div>
                                `;
                            });
                        } else {
                            prescriptionHtml = `<p>No prescriptions recorded.</p>`;
                        }

                        document.getElementById("prescriptionList").innerHTML = prescriptionHtml;
                        transactionModal.style.display = "block";
                    }
                })
                .catch(err => {
                    if (type === "appointment") {
                        appointmentBody.innerHTML = `<p style="color:red;">Error loading details</p>`;
                        appointmentModal.style.display = "block";
                    } else {
                        transactionBody.innerHTML = `<p style="color:red;">Error loading details</p>`;
                        transactionModal.style.display = "block";
                    }
                });
        }
    });

    window.onclick = (e) => {
        if (e.target == appointmentModal) {
            appointmentModal.style.display = "none";
        }
        if (e.target == transactionModal) {
            transactionModal.style.display = "none";
        }
    };
});
