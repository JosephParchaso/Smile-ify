$(document).ready(function() {
        if (typeof userId !== "undefined" && userId !== "") {
        $('#transactionTable').DataTable({
            "ajax": `${BASE_URL}/Admin/processes/manage_patient/load_dental_transactions.php?id=${userId}`,
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
                { "title": "Amount" },
                { "title": "Action", "orderable": false },
                { "title": "Created", "visible": false, "searchable": false }
            ],
            "order": [[3, "desc"], [4, "asc"]],
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
    }
});
