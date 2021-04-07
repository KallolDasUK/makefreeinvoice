<div class="container">

    <div>
        <form wire:submit.prevent="submit" >

            <div class="row justify-content-center align-items-center">
                <div class="col form-group ">
                    <label class=""> <b> Select Head</b>
                    </label>
                    <select class="form-control @error('selectedHead') is-invalid @enderror" name="option" wire:model="selectedHead" required>
                        <option value="Choose your option" disabled selected>Choose your option</option>
                        @foreach($heads as $head)
                            <option value="{{ $head->head }}">{{ $head->head }}</option>
                        @endforeach
                    </select>

                </div>


                <div class="col form-group">
                    <label class=""><b>Start Date</b></label>
                    <input class="form-control @error('startDate') is-invalid @enderror" wire:model="startDate" type="date" >
                </div>

                <div class="col form-group">
                    <label class="w3-text-teal"><b>End Date</b></label>
                    <input class="form-control @error('endDate') is-invalid @enderror" wire:model="endDate" type="date" >

                </div>

                <div class="col">
                    <input type="submit" class="btn btn-info btn-lg " value="Show Data"/>
                </div>
            </div>
        </form>
    </div>

    <div class="card mt-4">

        <table class="table">
            <tr>
                <th class="border border-gray-500" scope="col">Previous Balance</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th class="border border-gray-500" scope="col">{{ $previousBalance }}</th>
            </tr>

            <tr>
                <th class="border border-gray-500" scope="col">Date</th>
                <th class="border border-gray-500" scope="col">Voucher No#</th>
                <th class="border border-gray-500" scope="col">Description</th>
                <th class="border border-gray-500" scope="col">Debit Taka</th>
                <th class="border border-gray-500" scope="col">Credit Taka</th>
                <th class="border border-gray-500 text-center" scope="col">Balance</th>


            </tr>
            @foreach($reports as $index=>$trail)
                <tr class="h-6">
                    <th class="border border-gray-500 text-center"
                        scope="row">{{ $trail['date']  }}</th>
                    <td class="border border-gray-500" scope="row">{{ $trail['vno']  }}</td>
                    <td class="border border-gray-500" scope="row">{{ $trail['description']  }}</td>
                    <td class="border border-gray-500" scope="row">{{ $trail['debit']  }}</td>
                    <td class="border border-gray-500" scope="row">{{ $trail['credit']  }}</td>
                    <th class="border border-gray-500" scope="row">{{ $trail['debit'] - $trail['credit']  }}</th>
                </tr>
            @endforeach

        </table>

    </div>
</div>


