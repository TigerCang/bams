{/* <script> */}
$('#tableInit').DataTable({
    "ordering": true,
    "searching": true,
    "autoWidth": false,
    "lengthMenu": [[10, 25, 50,100],[10, 25, 50, 100]],
    "iDisplayLength": 10,
    "language": { //hidden word show entries
        "lengthMenu": "_MENU_"
    },
    "buttons": [
    {
        extend: 'collection',
        text: '<i class="ri-upload-2-line"></i> Export',      
        className: 'btn btn-outline-primary', // className: 'btn btn-label-primary',
        buttons: [
            {
                extend: 'print',
                text: '<i class="ri-printer-line"></i> Print'
            },
            {
                extend: 'excel',
                text: '<i class="fa-regular fa-file-excel"></i> Excel'
            },
            {
                extend: 'pdf',
                text: '<i class="fa-regular fa-file-pdf"></i> PDF'
            },
            {
                extend: 'copy',
                text: '<i class="fa-regular fa-copy"></i> Copy'
            },
        ]
    }, 
],
    "initComplete": function() {
        $('#tableMain_length .select2').addClass('custom-select2');
    },
    dom: '<"row"<"col-12 col-md-2 col-lg-2"f><"col-1 col-md-6 col-lg-7"><"col-5 col-md-2 col-lg-1"l><"col-5 col-md-2 col-lg-2"B>>rt<"row"<"col-12 col-md-5 col-lg-6"i><"col-12 col-md-7 col-lg-6"p>>',
 
});


// $('#tableData').DataTable({
//     "ordering": true,
//     "searching": true,
//     "lengthChange": false,
//     "paging": false, 
//     "info": false
// });

// $('#tabelModal').DataTable({
//     "ordering": true,
//     "searching": false,
//     "autoWidth": false,
//     "lengthChange": false,
//     "pageLength": 5,
//     "paging": true, 
//     // "dom": 'lrtip'
// });

