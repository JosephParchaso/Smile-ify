$(document).ready(function() {
    $('#appointmentTable').DataTable({
        "ajax": `${BASE_URL}/Patient/processes/profile/load_appointments.php`,
        "pageLength": 20,
        "lengthChange": false,
        "ordering": true,
        "searching": true,
        "order": [[7, "desc"]],
        "columns": [
            { "title": "Dentist" },
            { "title": "Branch" },
            { "title": "Service" },
            { "title": "Date" },
            { "title": "Time" },
            { "title": "Status" },
            { "title": "Action", "orderable": false },
            { "title": "Created", "visible": false, "searchable": false }
        ],
        "language": {
            search: "",
            searchPlaceholder: "Search"
        },
        "initComplete": function() {
            const $searchInput = $('#appointmentTable_filter input[type=search]');
            $searchInput
                .attr('id', 'appointmentSearch')
                .attr('name', 'appointmentSearch');
            $('#appointmentTable_filter label').attr('for', 'appointmentSearch');
        }
    });
});
