document.addEventListener("DOMContentLoaded", function () {
    fetch(`${BASE_URL}/Patient/processes/load_details.php`)
        .then(response => response.json())
        .then(data => {
            const profileCard = document.getElementById("profileCard");

            if (data.error) {
                profileCard.innerHTML = `<p>${data.error}</p>`;
                return;
            }

            profileCard.innerHTML = `
                <h3>${data.full_name}</h3>
                <p><strong>Gender:</strong> ${data.gender}</p>
                <p><strong>Email:</strong> ${data.email}</p>
                <p><strong>Contact:</strong> ${data.contact_number}</p>
                <p><strong>Joined:</strong> ${data.joined}</p>
            `;
        })
        .catch(error => {
            document.getElementById("profileCard").innerHTML = "<p>Error loading profile.</p>";
            console.error("Fetch error:", error);
        });
});
