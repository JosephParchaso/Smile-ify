document.addEventListener("DOMContentLoaded", function () {
    const profileCard = document.getElementById("profileCard");
    if (!profileCard) return;

    fetch(`${BASE_URL}/processes/Owner/load_details.php`)
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
                <p><strong>Gender:</strong> ${data.gender}</p>
                <p><strong>Email:</strong> ${data.email}</p>
                <p><strong>Contact Number:</strong> ${data.contact_number}</p>
                <p><strong>Address:</strong> ${data.address}</p>
                <p><strong>Joined:</strong> ${data.joined}</p>
                <div class="button-group">
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
        })
        .catch(error => {
            profileCard.innerHTML = "<p>Error loading profile.</p>";
            console.error("Fetch error:", error);
        });
});
