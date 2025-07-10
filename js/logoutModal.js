function openLogoutModal() {
    document.getElementById("logoutModal").style.display = "flex";
    document.body.classList.add("modal-open");
}

function closeLogoutModal() {
    document.getElementById("logoutModal").style.display = "none";
    document.body.classList.remove("modal-open");
}

function confirmLogout() {
    window.location.href = '/Smile-ify/includes/logout.php';
}

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("logoutLink").addEventListener("click", function (e) {
        e.preventDefault();
        openLogoutModal();
    });

    document.getElementById("confirmLogout").addEventListener("click", confirmLogout);
    document.getElementById("cancelLogout").addEventListener("click", closeLogoutModal);
});
