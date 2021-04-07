<div class="h-screen ">

    <dialog {{ $showDialog?'open':'' }} class="bg-white text-black" style="z-index: 999">

        <h4 class="text-black font-weight-bold"> Add New Sub Head</h4>
        <br>
        <input wire:model.lazy="newSubhead" type="text" placeholder="Enter Sub Head Name"
               class="form-control">
        <br>
        <button wire:click="$set('showDialog',false)" class="btn btn-secondary">Cancel</button>
        <button wire:click="addSubHead" class="btn btn-info btn-fw">
            Add Subhead
        </button>


    </dialog>

    <div class="content {{ $showDialog?' hidden':'' }}">
        <div class="card p-4">
            <div class="row align-items-end justify-content-center">
                <div class="col form-group">
                    <label for="" class="text-black font-weight-bold">Paren Head</label>

                    <select wire:model.lazy="c_ph" class="form-control">
                        <option value="Income">Income</option>
                        <option value="Expense">Expense</option>
                        <option value="Expense">Asset</option>
                        <option value="Liabilities">Liabilities</option>

                    </select>

                </div>
                <div class="col form-group">
                    <label for="" class="text-black font-weight-bold">Sub Head</label>
                    <div class="input-group">
                        <select wire:model="c_sh" class="form-control">
                            @foreach($subHeads as $subHead)
                                <option value="{{ $subHead }}"
                                        @if ($loop->first) selected @endif>{{ $subHead }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-prepend">
                            <button wire:click="$set('showDialog',true)" class="btn btn-info">+</button>
                        </div>
                    </div>

                </div>
                <div class="col form-group">
                    <label for="" class="text-black font-weight-bold">Head</label>
                    <input wire:model="c_h" class="form-control" type="text" placeholder="Enter Head Name">
                </div>
                <div class="col form-group">
                    <label for="" class="text-black font-weight-bold"></label>
                    @if($updateMode)
                        <button wire:click="confirmUpdate"
                                class="btn btn-info btn-fw btn-lg">
                            Update
                        </button>
                    @else
                        <button wire:click="add"
                                class="btn btn-info btn-lg">
                            Add New
                        </button>
                    @endif
                </div>
            </div>
        </div>




        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif


        <br>

        @error('newHead') <span class="error">{{ $message }}</span> @enderror

        <div class="card">
            <b class="m-4 h3"> Head List </b>
            <table class="table m-4">
                <thead>
                <tr class="font-weight-bold">
                    <td>Paren Head</td>
                    <td>Sub Head</td>
                    <td>Head</td>
                    <td class="text-center">Actions</td>

                </tr>
                </thead>
            <tbody>


            @foreach($heads as $head)
                <tr>
                    <td>{{ $head->parent_head }}</td>
                    <td>{{ $head->sub_head }}</td>
                    <td>{{ $head->head }}</td>
                    <td class="text-center"><button wire:click="update({{$head->id}})"
                                class="btn btn-inverse-info btn-sm mr-4">
                            Edit
                        </button><button wire:click="delete({{$head->id}})"
                                         class="btn btn-inverse-danger btn-sm">

                            Delete
                        </button></td>
                </tr>

            @endforeach
            </tbody>
            </table>
        </div>
    </div>

</div>
