document.addEventListener("DOMContentLoaded", () => {
    const appointmentModal = document.getElementById("manageModal");
    const appointmentBody = document.getElementById("modalBody");

    const transactionModal = document.getElementById("transactionModal");
    const transactionBody = document.getElementById("transactionModalBody");

    document.body.addEventListener("click", function(e) {
        if (e.target.classList.contains("btn-action")) {
            const id = e.target.getAttribute("data-id");
            const type = e.target.getAttribute("data-type");

            let url = "";
            if (type === "appointment") {
                url = `${BASE_URL}/Patient/processes/get_appointment_details.php?id=${id}`;
            } else if (type === "transaction") {
                url = `${BASE_URL}/Patient/processes/get_dental_transaction_details.php?id=${id}`;
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
                            <p><strong>Branch:</strong>${data.branch}</p>
                            <p><strong>Service:</strong>${data.service}</p>
                            <p><strong>Date:</strong>${data.appointment_date}</p>
                            <p><strong>Time:</strong>${data.appointment_time}</p>
                            <p><strong>Notes:</strong><span>${data.notes ?? '-'}</span></p>
                            <p><strong>Status:</strong>${data.status}</p>
                            <p><strong>Date Booked:</strong>${data.date_created}</p>
                        `;
                        appointmentModal.style.display = "block";
                    } 

                    else if (type === "transaction") {
                        transactionBody.innerHTML = `
                            <div class="transaction-columns">
                                <div class="transaction-section">
                                    <h3>Dental Transaction</h3>
                                    <p><strong>Dentist:</strong> <span>${data.dentist ?? 'Available Dentist'}</span></p>
                                    <p><strong>Branch:</strong> <span>${data.branch}</span></p>
                                    <p><strong>Service:</strong> <span>${data.service}</span></p>
                                    <p><strong>Date:</strong> <span>${data.appointment_date}</span></p>
                                    <p><strong>Time:</strong> <span>${data.appointment_time}</span></p>
                                    <p><strong>Amount Paid:</strong> <span>${data.amount_paid}</span></p>
                                    <p><strong>Notes:</strong> <span>${data.notes ?? '-'}</span></p>
                                    <p><strong>Date Recorded:</strong> <span>${data.date_created}</span></p>
                                </div>

                                <div class="transaction-section">
                                    <h3>Vitals</h3>
                                    <p><strong>Swelling:</strong> <span>${data.is_swelling}</span></p>
                                    <p><strong>Sensitivity:</strong> <span>${data.is_sensitive}</span></p>
                                    <p><strong>Bleeding:</strong> <span>${data.is_bleeding}</span></p>
                                    <p><strong>Body Temp:</strong> <span>${data.body_temp ?? '-'}</span></p>
                                    <p><strong>Pulse Rate:</strong> <span>${data.pulse_rate ?? '-'}</span></p>
                                    <p><strong>Respiratory Rate:</strong> <span>${data.respiratory_rate ?? '-'}</span></p>
                                    <p><strong>Blood Pressure:</strong> <span>${data.blood_pressure ?? '-'}</span></p>
                                    <p><strong>Height:</strong> <span>${data.height ?? '-'}</span></p>
                                    <p><strong>Weight:</strong> <span>${data.weight ?? '-'}</span></p>
                                </div>

                                <div class="transaction-section">
                                    <h3>Prescription</h3>
                                    <div id="prescriptionList"></div>

                                    <div class="button-group button-group-profile">
                                        ${
                                            data.prescription_downloaded == 0
                                            ? `<button class="confirm-btn" id="downloadPrescription">Download Prescription</button>`
                                            : `<button class="confirm-btn" disabled>Already Downloaded</button>`
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
                                        <p><strong>Drug:</strong> <span>${p.drug}</span></p>
                                        <p><strong>Route:</strong> <span>${p.route ?? '-'}</span></p>
                                        <p><strong>Frequency:</strong> <span>${p.frequency ?? '-'}</span></p>
                                        <p><strong>Dosage:</strong> <span>${p.dosage ?? '-'}</span></p>
                                        <p><strong>Duration:</strong> <span>${p.duration ?? '-'}</span></p>
                                        <p><strong>Instructions:</strong> <span>${p.instructions ?? '-'}</span></p>
                                        <hr>
                                    </div>
                                `;
                            });
                        } else {
                            prescriptionHtml = `<p>No prescriptions recorded.</p>`;
                        }

                        document.getElementById("prescriptionList").innerHTML = prescriptionHtml;
                        transactionModal.style.display = "block";

                        // ========= DOWNLOAD PRESCRIPTION =========
                        const btn = document.getElementById("downloadPrescription");
                        if (btn) {
                            btn.addEventListener("click", async () => {
                                const { jsPDF } = window.jspdf;
                                const doc = new jsPDF();

                                async function getBase64ImageFromUrl(url) {
                                    const res = await fetch(url);
                                    const blob = await res.blob();
                                    return new Promise((resolve, reject) => {
                                        const reader = new FileReader();
                                        reader.onloadend = () => resolve(reader.result);
                                        reader.onerror = reject;
                                        reader.readAsDataURL(blob);
                                    });
                                }

                                // ===== HEADER =====
                                const logoUrl = `${BASE_URL}/images/logo/logo_default.png`;
                                const logoBase64 = await getBase64ImageFromUrl(logoUrl);
                                doc.addImage(logoBase64, "PNG", 10, 10, 50, 30);

                                doc.setFontSize(14);
                                doc.setFont("helvetica", "bold");
                                doc.text("SMILE-IFY DENTAL CLINIC", 105, 15, { align: "center" });

                                doc.setFontSize(11);
                                doc.setFont("helvetica", "normal");
                                doc.text("Mandaue • Pusok • Babag", 105, 22, { align: "center" });
                                doc.text("Contact Us: 09955446451", 105, 28, { align: "center" });
                                doc.text("Smile-ify@gmail.com", 105, 34, { align: "center" });
                                doc.text("Clinic Hours: 9AM - 3PM | Mon–Sun (All Branches)", 105, 40, { align: "center" });

                                doc.line(10, 45, 200, 45);

                                // ===== PATIENT INFO =====
                                const patientFullName = `${data.patient_last_name}, ${data.patient_first_name} ${data.patient_middle_name ? data.patient_middle_name[0] + '.' : ''}`;
                                let patientAge = "-";
                                if (data.patient_dob) {
                                    const dob = new Date(data.patient_dob);
                                    const diff = Date.now() - dob.getTime();
                                    patientAge = Math.floor(diff / (1000 * 60 * 60 * 24 * 365.25)) + " yrs";
                                }

                                doc.setFontSize(12);
                                doc.setFont("helvetica", "bold");

                                // Row 1
                                doc.text("Patient Name:", 10, 55);
                                doc.line(45, 55, 100, 55);

                                doc.text("Age:", 110, 55);
                                doc.line(122, 55, 145, 55);

                                doc.text("Gender:", 155, 55);
                                doc.line(178, 55, 200, 55);

                                doc.setFont("helvetica", "normal");
                                doc.text(patientFullName || "-", 47, 54);
                                doc.text(patientAge || "-", 124, 54);
                                doc.text(data.gender ?? "-", 180, 54);

                                // Row 2
                                doc.setFont("helvetica", "bold");
                                doc.text("Service:", 10, 70);
                                doc.line(35, 70, 100, 70);

                                doc.text("Branch:", 110, 70);
                                doc.line(140, 70, 190, 70);

                                doc.setFont("helvetica", "normal");
                                doc.text(data.service || "-", 37, 69);
                                doc.text(data.branch || "-", 142, 69);

                                doc.setFont("helvetica", "bold");
                                doc.text("Date:", 10, 85);
                                doc.line(30, 85, 80, 85);

                                doc.text("Time:", 110, 85);
                                doc.line(135, 85, 190, 85);

                                doc.setFont("helvetica", "normal");
                                doc.text(data.appointment_date || "-", 32, 84);
                                doc.text(data.appointment_time || "-", 137, 84);

                                // ===== PRESCRIPTIONS =====
                                doc.setFont("helvetica", "bold");
                                doc.text("Prescription:", 10, 110);

                                doc.setFont("helvetica", "normal");
                                let y = 120;
                                if (data.prescriptions && data.prescriptions.length > 0) {
                                    data.prescriptions.forEach((p, index) => {
                                        if (index > 0) y += 3;
                                        doc.text(`• ${p.drug} | ${p.dosage} | ${p.frequency} | ${p.duration}`, 10, y);
                                        y += 7;
                                        if (p.instructions) {
                                            doc.text(`  Notes: ${p.instructions}`, 15, y);
                                            y += 7;
                                        }
                                    });
                                } else {
                                    doc.text("No prescriptions recorded.", 10, y);
                                }

                                // ===== SIGNATURE =====
                                if (data.signature_image) {
                                    const sigUrl = `${BASE_URL}/images/signatures/${data.signature_image}`;
                                    try {
                                        const sigBase64 = await getBase64ImageFromUrl(sigUrl);
                                        doc.addImage(sigBase64, "PNG", 130, 220, 60, 40);
                                    } catch (err) {
                                        console.warn("Could not load signature", err);
                                    }
                                }

                                doc.line(120, 250, 200, 250);
                                const dentistFullName = `${data.dentist_last_name}, ${data.dentist_first_name} ${data.dentist_middle_name ? data.dentist_middle_name[0] + '.' : ''}`;
                                doc.text("Dr. " + dentistFullName, 160, 260, { align: "center" });
                                doc.text("License No: " + (data.license_number ?? "-"), 160, 270, { align: "center" });

                                // Save PD
                                const fileName = `${data.patient_last_name}_${data.date_created.split(" ")[0]}.pdf`;
                                doc.save(fileName);

                                try {
                                    const res = await fetch(
                                        `${BASE_URL}/Patient/processes/mark_prescription_downloaded.php`,
                                        {
                                            method: "POST",
                                            headers: { "Content-Type": "application/json" },
                                            body: JSON.stringify({
                                                transaction_id: data.dental_transaction_id
                                            })
                                        }
                                    );

                                    const json = await res.json();

                                    if (json.success) {
                                        btn.textContent = "Already Downloaded";
                                        btn.disabled = true;
                                    } else {
                                        console.error("Update failed:", json.error);
                                        window.location.href = `${BASE_URL}/Patient/processes/mark_prescription_downloaded.php?error=1`;
                                    }
                                } catch (err) {
                                    console.error("Update fetch error:", err);
                                    window.location.href = `${BASE_URL}/Patient/processes/mark_prescription_downloaded.php?error=1`;
                                }
                            });
                        }
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
