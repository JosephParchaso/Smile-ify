document.addEventListener("DOMContentLoaded", () => {
    const manageModal = document.getElementById("manageModal");
    const modalBody = document.getElementById("modalBody");

    document.body.addEventListener("click", function(e) {
        if (e.target.classList.contains("btn-action")) {
            const id = e.target.getAttribute("data-id");
            const type = e.target.getAttribute("data-type");

            let url = "";
            if (type === "patient") {
                url = `${BASE_URL}/Admin/processes/get_patient_details.php?id=${id}`;
            } else if (type === "booking") {
                url = `${BASE_URL}/Admin/processes/get_booking_details.php?id=${id}`;
            } else if (type === "inactive") {
                url = `${BASE_URL}/Admin/processes/get_inactive_patient_details.php?id=${id}`;
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
                            <p><strong>Name:</strong> ${data.last_name}, ${data.first_name} ${data.middle_name ?? ''}</p>
                            <p><strong>Email:</strong> ${data.email}</p>
                            <p><strong>Contact:</strong> ${data.contact_number ?? '-'}</p>
                            <p><strong>Gender:</strong> ${data.gender ?? '-'}</p>
                            <p><strong>Date of Birth:</strong> ${data.date_of_birth ?? '-'}</p>
                            <p><strong>Status:</strong> ${type === "inactive" ? "Inactive" : "Active"}</p>
                        `;
                        manageModal.style.display = "block";
                    }

                    // BOOKING DETAILS
                    else if (type === "booking") {
                        modalBody.innerHTML = `
                            <h2>Booking Details</h2>
                            <p><strong>Patient:</strong> ${data.patient_name}</p>
                            <p><strong>Dentist:</strong> ${data.dentist ?? 'Available Dentist'}</p>
                            <p><strong>Branch:</strong> ${data.branch}</p>
                            <p><strong>Service:</strong> ${data.service}</p>
                            <p><strong>Date:</strong> ${data.appointment_date}</p>
                            <p><strong>Time:</strong> ${data.appointment_time}</p>
                            <p><strong>Notes:</strong> ${data.notes ?? '-'}</p>
                            <p><strong>Status:</strong> ${data.status}</p>
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
