$(document).ready(function() {
    $('#transactionTable').DataTable({
        "ajax": `${BASE_URL}/Patient/processes/load_dental_transactions.php`,
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
            { "title": "Amount" },
            { "title": "Action", "orderable": false },
            { "title": "Created", "visible": false, "searchable": false }
        ],
        "language": {
            search: "",
            searchPlaceholder: "Search"
        },
        "initComplete": function() {
            const $searchInput = $('#transactionTable_filter input[type=search]');
            $searchInput
                .attr('id', 'dentalTransactionSearch')
                .attr('name', 'dentalTransactionSearch');
            $('#transactionTable_filter label').attr('for', 'dentalTransactionSearch');
        }
    });
});
