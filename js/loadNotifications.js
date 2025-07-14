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
                const id = this.getAttribute('data-id');

                fetch('/Smile-ify/processes/read_notification.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'notification_id=' + encodeURIComponent(id)
                })
                    .then(response => response.text())
                    .then(data => {
                        console.log('Marked as read:', data);
                        if (data.trim() === "success") {
                            this.classList.remove('unread');

                            const badge = document.querySelector('.notif-badge');
                            if (badge) {
                                let count = parseInt(badge.textContent);
                                if (count > 1) {
                                    badge.textContent = count - 1;
                                } else {
                                    badge.remove();
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

            fetch('/Smile-ify/processes/read_all_notifications.php', {
                method: 'POST'
            })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === "success") {
                        document.querySelectorAll('.notif-item.unread').forEach(item => {
                            item.classList.remove('unread');
                        });

                        const badge = document.querySelector('.notif-badge');
                        if (badge) badge.remove();
                    }
                })
                .catch(err => console.error('Failed to mark all as read:', err));
        });
    }
});
