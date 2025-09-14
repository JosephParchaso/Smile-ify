$(document).ready(function() {
    if (!$.fn.DataTable.isDataTable('#recentTable')) {
        $('#recentTable').DataTable({
            "ajax": `${BASE_URL}/Admin/processes/patients/load_recent_bookings.php`,
            "pageLength": 20,
            "lengthChange": false,
            "ordering": true,
            "searching": true,
            "order": [[4, "desc"], [5, "desc"]],
            "columns": [
                { "title": "ID" },
                { "title": "Patient" },
                { "title": "Service" },
                { "title": "Dentist" },
                { "title": "Date" },
                { "title": "Time" },
                { "title": "Status" },
                { "title": "Action", "orderable": false, "searchable": false }
            ],
            "language": {
                search: "",
                searchPlaceholder: "Search"
            },
            "initComplete": function() {
                const $searchInput = $('#recentTable_filter input[type=search]');
                $searchInput.attr('id', 'recentSearch').attr('name', 'recentSearch');
                $('#recentTable_filter label').attr('for', 'recentSearch');
            }
        });
    }
});
