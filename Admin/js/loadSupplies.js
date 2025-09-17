$(document).ready(function() { 
    if (!$.fn.DataTable.isDataTable('#suppliesTable')) {
        $('#suppliesTable').DataTable({
            "ajax": `${BASE_URL}/Admin/processes/supplies/load_supplies.php`,
            "pageLength": 20,
            "lengthChange": false,
            "ordering": true,
            "searching": true,
            "order": [[5, "desc"]],
            "columns": [
                { "title": "ID" },
                { "title": "Supply Name" },
                { "title": "Quantity" },
                { "title": "Reorder Level" },
                { "title": "Status" },
                { "title": "Created", "visible": false, "searchable": false },
                { "title": "Action", "orderable": false }
            ],
            "order": [[2, "desc"]],
            "language": {
                search: "",
                searchPlaceholder: "Search"
            },
            "initComplete": function() {
                const $searchInput = $('#suppliesTable_filter input[type=search]');
                $searchInput.attr('id', 'suppliesSearch').attr('name', 'suppliesSearch');
                $('#suppliesTable_filter label').attr('for', 'suppliesSearch');

                $('#suppliesTable_filter').append(
                    '<button id="insertSupplyBtn">+ Add</button>'
                );
            }
        });
    }
});
