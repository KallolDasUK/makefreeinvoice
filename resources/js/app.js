require('./bootstrap');
import 'datatables.net-dt/js/dataTables.dataTables';
import 'datatables.net-dt/css/jquery.dataTables.css';

$(document).ready(function () {
    $('#myTable').DataTable();
});
