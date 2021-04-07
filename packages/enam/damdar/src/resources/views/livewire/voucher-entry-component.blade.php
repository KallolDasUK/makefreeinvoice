<div>


    <div id="id01" class="modal">
        <div class="modal-content w3-animate-top">
            <div class="w3-container">
                <span wire:click="refreshHeads" onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <hr>
                <livewire:acc::acc-head-component/>
                <div class="w3-container w3-light-grey w3-padding">
                    <button class="w3-button w3-right w3-white w3-border"
                            onclick="document.getElementById('id01').style.display='none'" wire:click="refreshHeads">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="h-screen">

        @if($toast)
            <p class="text-white font-bold text-xl bg-green-500 p-4 text-center mb-4">{{ $toast }}</p>
        @endif
        <div class="flex justify-center">
            <form class="w-full ml-16 mr-16" wire:submit.prevent="submit">


                {{-- New Line 2 Items--}}
                <div class="line flex justify-between container ">
                    <div class='flex-1 mr-4'>
                        <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'
                               for='grid-text-1'></label>
                        <input
                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                            id='grid-text-1' type='text' placeholder='Voucher ID' hidden>


                    </div>
                    <div class='flex-1'>
                        <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'
                               for='grid-text-1'>Voucher
                            Type</label>
                        <div class="flex-shrink w-full inline-block relative">
                            <select wire:model="voucherType" required
                                    class="block appearance-none text-gray-600 w-full bg-white border border-gray-400 shadow-inner px-4 py-2 pr-8 rounded">
                                <option value="" selected>-- Select Voucher Type --</option>
                                <option value="Debit">Debit</option>
                                <option value="Credit">Credit</option>
                                <option value="Journal">Journal</option>
                            </select>

                            <div
                                class="pointer-events-none absolute top-0 mt-3  right-0 flex items-center px-2 text-gray-600">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                {{-- New Line 2 Items--}}
                <div class="line flex justify-between container ">
                    <div class='flex-1 mr-4'>
                        <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'
                               for='grid-text-1'>Voucher
                            No</label>
                        <input wire:model="vno"
                               class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                               id='grid-text-1' type='text' placeholder='Voucher ID' disabled>
                        @error('vid') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>
                    <div class='flex-1'>
                        <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'
                               for='grid-text-1'>Voucher
                            Date</label>
                        <input wire:model="date"
                               class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                               id='grid-text-1' type='date' placeholder='Voucher Date' required>
                    </div>
                </div>


                {{-- New Line 2 Items--}}
                <br>
                <div class="line flex justify-between container ">
                    <div class='flex-1 mr-4'>
                        <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>
                            Pick Head <a class="text-blue-500 underline cursor-pointer font-bold"
                                         onclick="document.getElementById('id01').style.display='block'">+Add New Head</a>
                        </label>
                        <div class="flex-shrink w-full inline-block relative">
                            <select wire:model="head"
                                    class="block appearance-none text-gray-600 w-full bg-white border border-gray-400 shadow-inner px-4 py-2 pr-8 rounded"
                                    required>
                                <option value="" selected>Select Head</option>
                                @foreach($heads as $head)
                                    <option value="{{$head->head}}">{{$head->head}}</option>
                                @endforeach
                            </select>

                            <div
                                class="pointer-events-none absolute top-0 mt-3  right-0 flex items-center px-2 text-gray-600">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>

                    </div>
                    <div class='flex-1'>
                        <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'
                               for='grid-text-1'>Voucher
                            Description</label>
                        <input wire:model="description"
                               class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                               id='grid-text-1' type='text' placeholder='Description' required>
                        @error('vid') <span class="text-red-500 p-4">{{ $message }}</span> @enderror

                    </div>
                </div>
                {{-- New Line 2 Items--}}
                <br>
                <div class="line flex justify-between container ">
                    <div class='flex-1 mr-4'>
                        <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>
                            Transaction Type
                        </label>
                        <div class="flex-shrink w-full inline-block relative">
                            <select wire:model="transaction"
                                    class=" block appearance-none text-gray-600 w-full bg-white border border-gray-400 shadow-inner px-4 py-2 pr-8 rounded {{ $voucherType !== 'Journal'?'bg-gray-300':'' }}" {{ $voucherType !== 'Journal'?'disabled':'' }}>

                                <option selected>Select Transaction Type</option>
                                <option>Debit</option>
                                <option>Credit</option>

                            </select>
                            <div
                                class="pointer-events-none absolute top-0 mt-3  right-0 flex items-center px-2 text-gray-600">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class='flex-1'>
                        <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'
                               for='grid-text-1'>
                            Amount
                        </label>
                        <input wire:model="amount" wire:keydown.enter="addItem"
                               class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500 {{ $transaction === ''|| $transaction === 'Select Transaction Type'?'bg-gray-300':'' }}'
                               id='grid-text-1' type='text' placeholder='Please Enter Amount'
                               required {{ $transaction === ''|| $transaction === 'Select Transaction Type'?'disabled':'' }}>
                    </div>

                </div>

                {{-- New Line 2 Items--}}
                <br>
                <div class="card">
                <table class=" table " style="width: 100%">
                    <tr>
                        <th class="border border-gray-500" scope="col">Bill No</th>
                        <th class="border border-gray-500" scope="col">Head</th>
                        <th class="border border-gray-500" scope="col">Debit</th>
                        <th class="border border-gray-500" scope="col">Credit</th>
                        <th class="border border-gray-500" scope="col">Description</th>
                        <th class="border border-gray-500" scope="col">Delete</th>
                    </tr>
                    @foreach($transaction_items as $index => $t)
                        <tr class="w-full">
                            <th class="border border-gray-500 font-normal p-4">{{ $t['vno'] }}</th>
                            <th class="border border-gray-500 font-normal p-4">{{ $t['head'] }}</th>
                            @if($t['voucherType'] === \Enam\Acc\Utils\MyApp::JOURNAL)
                                <th class="border border-gray-500 font-normal p-4">{{ $t['debit'] }}</th>
                                <th class="border border-gray-500 font-normal p-4">{{ $t['credit'] }}</th>
                            @else
                                <th class="border border-gray-500 font-normal p-4">{{ $t['credit'] }}</th>
                                <th class="border border-gray-500 font-normal p-4">{{ $t['debit'] }}</th>
                            @endif


                            <th class="border border-gray-500 font-normal p-4">{{ $t['description'] }}</th>
                            <th class="border border-gray-500 font-normal p-4"><b class="btn btn-danger btn-sm"
                                    wire:click="deleteTransactionItem({{ $index }})">Delete</b></th>
                        </tr>
                    @endforeach
                </table>
                </div>
                <br>

                <div class="line flex justify-between container ">
                    <div class='flex-1 mr-4'>
                        <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>
                            Attachments
                        </label>
                        <input wire:model="image"
                               class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                               id='grid-text-1' type='file' placeholder='Description'>
                    </div>
                    <div class='flex-1'>
                        <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'
                               for='grid-text-1'>Voucher
                            Notes</label>
                        <input wire:model="note"
                               class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                               id='grid-text-1' type='text' placeholder='Notes' >
                    </div>
                </div> {{-- New Line 2 Items--}}
                <br>
                <div class="line flex justify-between container hidden ">
                    <div class='flex-1 mr-4'>

                    </div>
                    <div class='flex-1'>

                        <button
                            class='w3-btn w3-purple appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                            id='grid-text-1' type='submit'>Confirm
                        </button>
                    </div>
                </div>

            </form>
        </div>
        <div class="line flex justify-between container ">
            <div class='flex-1 mr-4'>

            </div>
            <div class='flex-1'>

                <button wire:click="processToDatabase"
                        class='w3-btn w3-purple appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                        id='grid-text-1' type='submit' {{ count($transaction_items)==0?'disabled':'' }}>Confirm
                </button>
            </div>
        </div>

    </div>
</div>

