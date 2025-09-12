$(document).ready(function() {
    if (!$.fn.DataTable.isDataTable('#inactiveTable')) {
        $('#inactiveTable').DataTable({
            "ajax": `${BASE_URL}/Admin/processes/load_inactive_patients.php`,
            "pageLength": 20,
            "lengthChange": false,
            "ordering": true,
            "searching": true,
            "columns": [
                { "title": "ID" },
                { "title": "Name" },
                { "title": "Action", "orderable": false, "searchable": false }
            ],
            "language": {
                search: "",
                searchPlaceholder: "Search"
            },
            "initComplete": function() {
                const $searchInput = $('#inactiveTable_filter input[type=search]');
                $searchInput.attr('id', 'inactiveSearch').attr('name', 'inactiveSearch');
                $('#inactiveTable_filter label').attr('for', 'inactiveSearch');
            }
        });
    }
});
