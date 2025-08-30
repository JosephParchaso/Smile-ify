document.addEventListener("DOMContentLoaded", function () {
    const profileCard = document.getElementById("profileCard");
    if (!profileCard) return;

    fetch(`${BASE_URL}/Admin/processes/load_details.php`)
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
                <p><strong>Date of Birth:</strong><span>${data.date_of_birth}</p></span> 
                <p><strong>Email:</strong> ${data.email}</p>
                <p><strong>Contact Number:</strong> ${data.contact_number}</p>
                <p><strong>Joined:</strong> ${data.joined}</p>
            `;
        })
        .catch(error => {
            profileCard.innerHTML = "<p>Error loading profile.</p>";
            console.error("Fetch error:", error);
        });
});
