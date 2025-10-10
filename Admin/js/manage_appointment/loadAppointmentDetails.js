document.addEventListener("DOMContentLoaded", function () {
    const appointmentCard = document.getElementById("appointmentCard");
    if (!appointmentCard) return;

    fetch(`${BASE_URL}/Admin/processes/manage_appointment/get_appointment_details.php?id=${appointmentId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error("Forbidden or failed to load.");
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                appointmentCard.innerHTML = `<p>${data.error}</p>`;
                return;
            }

            appointmentCard.innerHTML = `
                <h3>${data.full_name}</h3>
                <p><strong>Gender:</strong><span>${data.gender}</span></p>
                <p><strong>Date of Birth:</strong><span>${data.date_of_birth}</span></p>
                <p><strong>Email:</strong><span>${data.email}</span></p>
                <p><strong>Contact Number:</strong><span>${data.contact_number}</span></p>
                <p><strong>Address:</strong><span>${data.address}</span></p>
                <p><strong>Registered:</strong><span>${data.joined}</span></p>
                <p><strong>Last Update:</strong><span>${data.date_updated}</span></p>
                <hr>
                <h3>Appointment Details</h3>
                <p><strong>Branch:</strong><span>${data.branch}</span></p>
                <p><strong>Service:</strong><span>${data.services}</span></p>
                <p><strong>Dentist:</strong><span>${data.dentist}</span></p>
                <p><strong>Date:</strong><span>${data.appointment_date}</span></p>
                <p><strong>Time:</strong><span>${data.appointment_time}</span></p>
                <p><strong>Status:</strong><span>${data.status}</span></p>
                <p><strong>Notes:</strong><span>${data.notes || '-'}</span></p>
                <p><strong>Date Booked:</strong><span>${data.date_created}</span></p>
                <div class="button-group button-group-profile">
                    <button class="confirm-btn" id="downloadReceipt">Download Receipt</button>
                    <button class="confirm-btn" id="markDone">Complete Appointment</button>
                    <button class="cancel-btn-appointment" id="markCancel">Cancel Appointment</button>
                </div>
            `;

            const recordVitalsBtn = document.getElementById("recordVitals");
            if (recordVitalsBtn) {
                recordVitalsBtn.addEventListener("click", () => {
                    document.getElementById("recordVitalsModal").style.display = "block";
                });
            }

            const recordPrescriptionBtn = document.getElementById("recordPrescription");
            if (recordPrescriptionBtn) {
                recordPrescriptionBtn.addEventListener("click", () => {
                    document.getElementById("recordPrescriptionModal").style.display = "block";
                });
            }
        })
        .catch(error => {
            appointmentCard.innerHTML = "<p>Error loading profile.</p>";
            console.error("Fetch error:", error);
        });
});

function closeRecordVitalsModal() {
    document.getElementById("recordVitalsModal").style.display = "none";
}
function closeRecordPrescriptionModal() {
    document.getElementById("recordPrescriptionModal").style.display = "none";
}
