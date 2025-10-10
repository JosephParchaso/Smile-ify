document.addEventListener("DOMContentLoaded", function () {
    const patientCard = document.getElementById("patientCard");
    if (!patientCard) return;

    fetch(`${BASE_URL}/Admin/processes/manage_patient/get_patient_details.php?id=${userId}`)
        .then(response => {
            if (!response.ok) throw new Error("Forbidden or failed to load.");
            return response.json();
        })
        .then(data => {
            if (data.error) {
                patientCard.innerHTML = `<p>${data.error}</p>`;
                return;
            }

            let buttonsHtml = "";
            if (data.status.toLowerCase() === "active") {
                buttonsHtml = `<button type="button" class="confirm-btn" id="setInactiveBtn">Set Inactive</button>`;
            } else if (data.status.toLowerCase() === "inactive") {
                buttonsHtml = `<button type="button" class="confirm-btn" id="setActiveBtn">Set Active</button>`;
            }

            patientCard.innerHTML = `
                <h3>${data.full_name}</h3>
                <p><strong>Gender:</strong><span>${data.gender}</p></span> 
                <p><strong>Date of Birth:</strong><span>${data.date_of_birth}</p></span> 
                <p><strong>Email:</strong><span>${data.email}</p></span> 
                <p><strong>Contact Number:</strong><span>${data.contact_number}</p></span> 
                <p><strong>Address:</strong><span>${data.address}</p></span> 
                <p><strong>Registered:</strong><span>${data.joined}</p></span>
                <p><strong>Last Update:</strong><span>${data.date_updated}</span></p>
                <p><strong>Status:</strong><span>${data.status}</span></p>
                <div class="button-group button-group-profile">
                    ${buttonsHtml}
                </div>
            `;

            const openStatusModal = (status) => {
                document.getElementById("statusUserId").value = userId;
                document.getElementById("statusValue").value = status;
                document.getElementById("statusMessage").textContent =
                    `Are you sure you want to set this patient as ${status}?`;
                document.getElementById("setStatusModal").style.display = "block";
            };

            const setActiveBtn = document.getElementById("setActiveBtn");
            const setInactiveBtn = document.getElementById("setInactiveBtn");

            if (setActiveBtn) {
                setActiveBtn.addEventListener("click", () => openStatusModal("active"));
            }
            if (setInactiveBtn) {
                setInactiveBtn.addEventListener("click", () => openStatusModal("inactive"));
            }
        })
        .catch(error => {
            patientCard.innerHTML = "<p>Error loading profile.</p>";
            console.error("Fetch error:", error);
        });
});

function closeStatusModal() {
    document.getElementById("setStatusModal").style.display = "none";
}
