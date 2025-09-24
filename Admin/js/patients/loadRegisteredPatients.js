$(document).ready(function() {
    if (!$.fn.DataTable.isDataTable('#registeredTable')) {
        $('#registeredTable').DataTable({
            "ajax": `${BASE_URL}/Admin/processes/patients/load_registered_patients.php`,
            "pageLength": 20,
            "lengthChange": false,
            "ordering": true,
            "searching": true,
            "columns": [
                { "title": "ID" },
                { "title": "Name" },
                { "title": "Branch Registered" },
                { "title": "Action", "orderable": false, "searchable": false }
            ],
            "order": [[1, "asc"]],
            "language": {
                search: "",
                searchPlaceholder: "Search"
            },
            "initComplete": function() {
                const $searchInput = $('#registeredTable_filter input[type=search]');
                $searchInput.attr('id', 'patientSearch').attr('name', 'patientSearch');
                $('#registeredTable_filter label').attr('for', 'patientSearch');
            }
        });
    }
});
