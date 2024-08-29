{/* <script> */}
$(document).ready(function() {
    $('#tabelload').DataTable({
        "ordering": true,
        "searching": true,
        "autoWidth": false,
        "lengthMenu": [
            [10, 25, 50,100, -1],
            [10, 25, 50, 100,'All'],
        ],
        "iDisplayLength": 25,
        "buttons": ['excel', 'pdf', 'print'],
        dom: 'lBfrtpi', //length Button filter process table info paging
    });

    $('#tabelload2').DataTable({
        "ordering": true,
        "searching": true,
        "autoWidth": false,
        "lengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All'],
        ],
        "iDisplayLength": 25,
    });

    $('#tabelload3').DataTable({
        "ordering": true,
        "searching": true,
        "autoWidth": false,   
        "paging": false, 
    });
});