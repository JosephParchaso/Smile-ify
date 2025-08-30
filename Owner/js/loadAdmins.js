    $(document).ready(function() {
        if (!$.fn.DataTable.isDataTable('#adminsTable')) {
            $('#adminsTable').DataTable({
                "ajax": `${BASE_URL}/Owner/processes/load_admins.php`,
                "pageLength": 20,
                "lengthChange": false,
                "ordering": true,
                "searching": true,
                "columns": [
                    { "title": "ID" },
                    { "title": "Name" },
                    { "title": "Branch" },
                    { "title": "Status" },
                    { "title": "Action", "orderable": false, "searchable": false }
                ],
                "language": {
                    search: "",
                    searchPlaceholder: "Search"
                },
                "initComplete": function() {
                    const $searchInput = $('#adminsTable_filter input[type=search]');
                    $searchInput.attr('id', 'adminSearch').attr('name', 'adminSearch');
                    $('#adminsTable_filter label').attr('for', 'adminSearch');

                    $('#adminsTable_filter').append(
                        '<button id="addAdminBtn">+ Add</button>'
                    );
                }
            });
        }
    });
