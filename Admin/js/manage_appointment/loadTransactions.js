$(document).ready(function () {
    if (typeof appointmentId !== "undefined" && appointmentId !== "") {

        $('#vitalTable').DataTable({
            "ajax": `${BASE_URL}/Admin/processes/manage_appointment/load_vitals.php?appointment_id=${appointmentId}`,
            "pageLength": 20,
            "lengthChange": false,
            "ordering": true,
            "searching": false,
            "columns": [
                { "title": "ID" },
                { "title": "Body Temp" },
                { "title": "Pulse Rate" },
                { "title": "Blood Pressure" },
                { "title": "Action", "orderable": false },
            ],
            "initComplete": function () {
                $('#vitalTable_filter').remove();
                $('#vitalTable_wrapper .dataTables_length').remove();
                $('#vitalTable_wrapper').prepend(
                    '<div class="table-action"><button id="insertVitalBtn">+ Add</button></div>'
                );
            }
        });

        $('#prescriptionTable').DataTable({
            "ajax": `${BASE_URL}/Admin/processes/manage_appointment/load_prescriptions.php?appointment_id=${appointmentId}`,
            "pageLength": 20,
            "lengthChange": false,
            "ordering": true,
            "searching": false,
            "columns": [
                { "title": "ID" },
                { "title": "Drug" },
                { "title": "Dosage" },
                { "title": "Frequency" },
                { "title": "Duration" },
                { "title": "Action", "orderable": false },
            ],
            "initComplete": function () {
                $('#prescriptionTable_filter').remove();
                $('#prescriptionTable_wrapper .dataTables_length').remove();
                $('#prescriptionTable_wrapper').prepend(
                    '<div class="table-action"><button id="insertPrescriptionBtn">+ Add</button></div>'
                );
            }
        });

        $('#dentaltransactionTable').DataTable({
            "ajax": `${BASE_URL}/Admin/processes/manage_appointment/load_transactions.php?appointment_id=${appointmentId}`,
            "pageLength": 20,
            "lengthChange": false,
            "ordering": true,
            "searching": false,
            "columns": [
                { "title": "ID" },
                { "title": "Dentist" },
                { "title": "Amount" },
                { "title": "Action", "orderable": false },
            ],
            "initComplete": function () {
                $('#dentaltransactionTable_filter').remove();
                $('#dentaltransactionTable_wrapper .dataTables_length').remove();
                $('#dentaltransactionTable_wrapper').prepend(
                    '<div class="table-action"><button id="insertTransactionBtn">+ Add</button></div>'
                );
            }
        });
    }
});
