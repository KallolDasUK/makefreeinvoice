<div class="mb-16">

    <div class="container">
        <form wire:submit.prevent="submit">


            <div class="row align-items-center justify-center">
                <div class="col form-group">
                    <label class="w3-text-teal"><b>Start Date</b></label>
                    <input class="form-control" wire:model="startDate" type="date" required>
                </div>
                <div class="col form-group">
                    <label class="w3-text-teal"><b>End Date</b></label>
                    <input class="form-control" wire:model="endDate" type="date" required>

                </div>
                <div class="col">
                    <button type="button" wire:click="submit" class="btn btn-lg btn-info">Filter
                    </button>
                </div>
        </form>
    </div>

    <div class="card mt-4 ">
        <table class="table table-fixed w-full ">


            <tr>
                <th class="border border-gray-500" scope="col">Ledger Name</th>
                <th class="border border-gray-500" scope="col">Debit Taka</th>
                <th class="border border-gray-500" scope="col">Credit Taka</th>
                <th class="border border-gray-500 text-center" scope="col">Closing Balance</th>


            </tr>
            @foreach($trails as $index=>$trail)
                <tr class="h-6">
                    <th class="border border-gray-500"
                        scope="row">{{ $trail['head']  }}</th>
                    <td class="border border-gray-500" scope="row">{{ $trail['debit']  }}</td>
                    <td class="border border-gray-500" scope="row">{{ $trail['credit']  }}</td>
                    <th class="border border-gray-500 text-center"
                        scope="row">{{ $trail['bal']  }}</th>
                </tr>
            @endforeach

        </table>

    </div>
</div>

</div>
