$(document).ready(function() {
    $('#appointmentTable').DataTable({
        "ajax": `${BASE_URL}/Patient/processes/load_appointments.php`,
        "pageLength": 20,
        "lengthChange": false,
        "ordering": true,
        "searching": true,
        "order": [[6, "desc"]],
        "columns": [
            { "title": "Dentist" },
            { "title": "Branch" },
            { "title": "Service" },
            { "title": "Date" },
            { "title": "Time" },
            { "title": "Status" },
            { "title": "Created", "visible": false, "searchable": false }
        ],
        "language": {
            search: "",
            searchPlaceholder: "Search..."
        },
        "initComplete": function() {
            const $searchInput = $('div.dataTables_filter input[type=search]');
            $searchInput
                .attr('id', 'appointmentSearch')
                .attr('name', 'appointmentSearch');
            $('div.dataTables_filter label').attr('for', 'appointmentSearch');
        }
    });
});
