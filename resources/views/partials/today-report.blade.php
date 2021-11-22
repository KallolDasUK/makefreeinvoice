<h2 class="font-weight-bolder">Today' s Report [{{ \Carbon\Carbon::parse()->format('m D Y') }}]</h2>
<table class="table table-bordered table-responsive-lg" style="font-size: 20px">
    <tbody>
    <tr>
        <td>Total Sale</td>
        <td>{{ $today_sale }}</td>
    </tr>
    <tr>
        <td>Due Sale</td>
        <td>{{ $due_sale }}</td>
    </tr>
    <tr>
        <td>Due Collection</td>
        <td>{{ $due_collection }}</td>
    </tr>
    <tr>
        <td>Due Payment</td>
        <td>{{ $due_payment }}</td>
    </tr>
    <tr>
        <td>Expense</td>
        <td>{{ $expense }}</td>
    </tr>
    <tr>
        <td>Cash</td>
        <td>{{ $cash }}</td>
    </tr>

    </tbody>
</table>
