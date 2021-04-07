<div class="container">
    <div class="card  p-4 mb-4">
        <div class="row align-items-end justify-content-center">
            <div class="col form-group">
                <label for="" class="text-black font-weight-bold">Start Date</label>

                <input class="form-control" wire:model="start" type="date">

            </div>
            <div class="col form-group">
                <label for="" class="text-black font-weight-bold" >End Date</label>
                <input class="form-control" wire:model="end" type="date">

            </div>
            <div class="col form-group">

                <button class="btn btn-lg btn-info btn-lg" wire:click="filter">Submit</button>
            </div>
        </div>
    </div>


    <div class="card">
        <table class="table table-fixed w-full ">

            <tr class="text-center">
                <th class="border border-gray-500" colspan="3" scope="colgroup">Income</th>
                <th class="border border-gray-500" colspan="3" scope="colgroup">Expense</th>
            </tr>
            <tr class="text-center">
                <th class="border border-gray-500" scope="col">No#</th>
                <th class="border border-gray-500" scope="col">Income Account</th>
                <th class="border border-gray-500" scope="col">Amount</th>

                <th class="border border-gray-500 text-center" scope="col">No#</th>
                <th class="border border-gray-500" scope="col">Expense Account</th>
                <th class="border border-gray-500" scope="col">Amount</th>
            </tr>

            @foreach($i as $incomeHead => $income )
                @php($index = $loop->index)
                <tr class="text-center">
                    <th class="border border-gray-500 text-center"
                        scope="row">{{ $loop->index+1 }}</th>
                    <td class="border border-gray-500 text-center" scope="row"> {{ $incomeHead }} </td>
                    <td class="border border-gray-500 text-center">{{ $income===0?'-':$income }} </td>
                    <th class="border border-gray-500 text-center"
                        scope="row">{{ $loop->index+1 }}</th>
                    @foreach($e as $expenseHead=> $expense)
                        @if ($index === $loop->index)
                            <td class="border border-gray-500 text-center" scope="row">{{ $expenseHead }}</td>
                            <td class="border border-gray-500 text-center"
                                scope="row">{{ $expense===0?'-':$expense }}</td>
                        @endif
                    @endforeach

                </tr>
            @endforeach

            <tr class="text-center">
                <th scope="row"></th>
                <td class="border border-gray-500 text-center"><b>Total</b></td>
                <td class="border border-gray-500 text-center">{{ number_format($t_income, 0)}}</td>
                <td></td>
                <td class="border border-gray-500 text-center"><b>Total</b></td>
                <td class="border border-gray-500 text-center">{{ number_format($t_expense, 0) }}</td>
            </tr>
        </table>
    </div>

</div>
