$(document).ready(function() {
    if (typeof userId !== "undefined" && userId !== "") {
        $('#appointmentTable').DataTable({
            "ajax": `${BASE_URL}/Admin/processes/manage_patient/load_appointments.php?id=${userId}`,
            "pageLength": 20,
            "lengthChange": false,
            "ordering": true,
            "searching": true,
            "order": [[7, "desc"]],
            "columns": [
                { "title": "ID" },
                { "title": "Dentist" },
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
    }
});
