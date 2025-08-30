document.addEventListener("DOMContentLoaded", function () {
    const profileCard = document.getElementById("profileCard");
    if (!profileCard) return;

    fetch(`${BASE_URL}/Patient/processes/load_details.php`)
        .then(response => {
            if (!response.ok) {
                throw new Error("Forbidden or failed to load.");
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                profileCard.innerHTML = `<p>${data.error}</p>`;
                return;
            }

            profileCard.innerHTML = `
                <h3>${data.full_name}</h3>
                <p><strong>Gender:</strong><span>${data.gender}</p></span> 
                <p><strong>Date of Birth:</strong><span>${data.date_of_birth}</p></span> 
                <p><strong>Email:</strong><span>${data.email}</p></span> 
                <p><strong>Contact Number:</strong><span>${data.contact_number}</p></span> 
                <p><strong>Address:</strong><span>${data.address}</p></span> 
                <p><strong>Joined:</strong><span>${data.joined}</p> </span>
                <div class="button-group button-group-profile">
                    <button class="confirm-btn" id="editDetails">Edit Profile</button>
                    <button class="confirm-btn" id="changePasswordBtn">Change Password</button>
                </div>
            `;
            const editBtn = document.getElementById("editDetails");
            if (editBtn) {
                editBtn.addEventListener("click", () => {
                    document.getElementById("contactNumber").value = data.contact_number || "";
                    document.getElementById("address").value = data.address || "";
                    document.getElementById("editProfileModal").style.display = "block";
                });
            }

            const changePasswordBtn = document.getElementById("changePasswordBtn");
            if (changePasswordBtn) {
                changePasswordBtn.addEventListener("click", () => {
                    document.getElementById("changePasswordModal").style.display = "block";
                });
            }
        })
        .catch(error => {
            profileCard.innerHTML = "<p>Error loading profile.</p>";
            console.error("Fetch error:", error);
        });
});

function closeEditProfileModal() {
    document.getElementById("editProfileModal").style.display = "none";
}
function closeChangePasswordModal() {
    document.getElementById("changePasswordModal").style.display = "none";
}
