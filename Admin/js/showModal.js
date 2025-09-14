document.addEventListener("DOMContentLoaded", () => {
    const manageModal = document.getElementById("manageModal");
    const modalBody = document.getElementById("modalBody");

    document.body.addEventListener("click", function(e) {
        if (e.target.classList.contains("btn-action")) {
            const id = e.target.getAttribute("data-id");
            const type = e.target.getAttribute("data-type");

            let url = "";
            if (type === "patient") {
                url = `${BASE_URL}/Admin/processes/patients/get_patient_details.php?id=${id}`;
            } else if (type === "booking") {
                url = `${BASE_URL}/Admin/processes/patients/get_booking_details.php?id=${id}`;
            } else if (type === "inactive") {
                url = `${BASE_URL}/Admin/processes/patients/get_inactive_patient_details.php?id=${id}`;
            }

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        modalBody.innerHTML = `<p style="color:red;">${data.error}</p>`;
                        manageModal.style.display = "block";
                        return;
                    }

                    // PATIENT DETAILS
                    if (type === "patient" || type === "inactive") {
                        modalBody.innerHTML = `
                            <h2>Patient Details</h2>
                            <p><strong>Name:</strong><span>${data.last_name}, ${data.first_name} ${data.middle_name ?? ''}</span></p>
                            <p><strong>Email:</strong><span>${data.email}</span></p>
                            <p><strong>Contact:</strong><span>${data.contact_number ?? '-'}</span></p>
                            <p><strong>Gender:</strong><span>${data.gender ?? '-'}</span></p>
                            <p><strong>Date of Birth:</strong><span>${data.date_of_birth ?? '-'}</span></p>
                            <p><strong>Address:</strong><span>${data.address ?? '-'}</span></p>
                            <p><strong>Status:</strong><span>${type === "inactive" ? "Inactive" : "Active"}</span></p>
                        `;
                        manageModal.style.display = "block";
                    }

                    // BOOKING DETAILS
                    else if (type === "booking") {
                        modalBody.innerHTML = `
                            <h2>Booking Details</h2>
                            <p><strong>Patient:</strong><span>${data.patient_name}</span></p>
                            <p><strong>Dentist:</strong><span>${data.dentist ?? 'Available Dentist'}</span></p>
                            <p><strong>Branch:</strong><span>${data.branch}</span></p>
                            <p><strong>Service:</strong><span>${data.service}</span></p>
                            <p><strong>Date:</strong><span>${data.appointment_date}</span></p>
                            <p><strong>Time:</strong><span>${data.appointment_time}</span></p>
                            <p><strong>Notes:</strong><span>${data.notes ?? '-'}</span></p>
                            <p><strong>Status:</strong><span>${data.status}</span></p>
                        `;
                        manageModal.style.display = "block";
                    }
                })
                .catch(err => {
                    modalBody.innerHTML = `<p style="color:red;">Error loading details</p>`;
                    manageModal.style.display = "block";
                });
        }
    });

    // Close modal when clicking outside
    window.onclick = (e) => {
        if (e.target == manageModal) {
            manageModal.style.display = "none";
        }
    };
});
