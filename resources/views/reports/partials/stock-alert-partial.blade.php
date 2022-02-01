
<main>


    <div class="card">
        <div class="card-body p-0">
            <div class="">
                <table class="table mb-0 table-bordered">
                    <thead class="card-header">
                    <tr>
                        <td class=" border-0"><strong>SL</strong></td>
                        <td class=" border-0"><strong>Product Name</strong></td>
                        <td class=" border-0"><strong>Minimum Stock</strong></td>
                        <td class=" border-0"><strong>Stock</strong></td>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($records as $record)
                        <tr>
                            <td class=" border-0">{{ $loop->iteration }}</td>
                            <td class="text-start border-0" style="max-width: 300px">
                                {{ optional($record->product)->name }}</td>
                            <td class="text-start border-0" style="max-width: 300px"> {{ decent_format_dash($record->minimum_stock) }}</td>
                            <td class="text-start border-0" style="max-width: 300px"> {{ decent_format_dash($record->stock) }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
