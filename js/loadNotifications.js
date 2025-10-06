document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('notifDropdownToggle');
    const dropdown = document.getElementById('notifDropdown');

    if (toggle && dropdown) {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', function (e) {
            if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    }

    const notifItems = document.querySelectorAll('.notif-item');
    if (notifItems.length > 0) {
        notifItems.forEach(function (item) {
            item.addEventListener('click', function () {
                if (!this.classList.contains('unread')) {
                    return;
                }

                const id = this.getAttribute('data-id');

                fetch(`${BASE_URL}/processes/read_notification.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'notification_id=' + encodeURIComponent(id)
                })
                    .then(response => response.text())
                    .then(data => {
                        if (data.trim() === "success") {
                            this.classList.remove('unread');

                            const notifBadge = document.querySelector('#notifDropdownToggle .notif-badge');
                            if (notifBadge) {
                                const count = parseInt(notifBadge.textContent || '0', 10) || 0;
                                if (count > 1) {
                                    notifBadge.textContent = count - 1;
                                } else {
                                    notifBadge.remove();
                                }
                            }
                        }
                    })
                    .catch(err => console.error('Error:', err));
            });
        });
    }

    const markAllReadBtn = document.getElementById('markAllRead');
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function (e) {
            e.preventDefault();

            fetch(`${BASE_URL}/processes/read_all_notifications.php`, {
                method: 'POST'
            })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === "success") {
                        document.querySelectorAll('.notif-item.unread').forEach(item => {
                            item.classList.remove('unread');
                        });

                        const notifBadge = document.querySelector('#notifDropdownToggle .notif-badge');
                        if (notifBadge) notifBadge.remove();
                    }
                })
                .catch(err => console.error('Failed to mark all as read:', err));
        });
    }

    function updatePatientsBadge() {
        fetch(`${BASE_URL}/Admin/processes/index/get_booking_notification.php`)
            .then(res => res.json())
            .then(data => {
                const badge = document.getElementById('patientsBadge');
                if (!badge) return;

                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = "inline-block";
                } else {
                    badge.style.display = "none";
                }
            })
            .catch(err => console.error("Error updating patients badge:", err));
    }

    updatePatientsBadge();
    setInterval(updatePatientsBadge, 30000);
});
