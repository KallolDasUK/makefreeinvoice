@extends('acc::layouts.app')

@section('content')
    @include('partials.ajax-reason-create-form')

    <div class="card">

        <div class="card-header">

            <h5 class="my-1 float-left">{{ !empty($title) ? $title : 'Inventory Adjustment' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('inventory_adjustments.inventory_adjustment.index') }}" class="btn btn-primary mr-2  {{  ability(\App\Utils\Ability::INVENTORY_ADJUSTMENT_READ) }}"
                   title="Show All Inventory Adjustment">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Inventory Adjustment
                </a>

                <a href="{{ route('inventory_adjustments.inventory_adjustment.create') }}" class="btn btn-success  {{  ability(\App\Utils\Ability::INVENTORY_ADJUSTMENT_CREATE) }}"
                   title="Create New Inventory Adjustment">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Inventory Adjustment
                </a>

            </div>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST"
                  action="{{ route('inventory_adjustments.inventory_adjustment.update', $inventoryAdjustment->id) }}"
                  id="edit_inventory_adjustment_form" name="edit_inventory_adjustment_form" accept-charset="UTF-8"
                  class="form-horizontal">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('inventory_adjustments.form', [
                                            'inventoryAdjustment' => $inventoryAdjustment,
                                          ])

                <div class="form-group">
                    <div class="float-right">

                        <button class="btn btn-primary btn-lg btn-fw" type="submit">

                            <i class="far fa-save"></i> Update Adjustment
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection

@section('js')
    <script>

        var sample_item = {
            product_id: '', reason_id: '', type: 'add', add_qnt: '', sub_qnt: '', stock: ''
        };
        var products = @json($products);
        var reasons = @json($reasons);
        var copiedObject = jQuery.extend(true, {}, sample_item)

        var inventory_adjustment_items = @json($inventoryAdjustment->inventory_adjustment_items);

        $(document).ready(function () {
            $('#ledger_id').select2({allowClear: true, placeholder: 'Select Account'})
            $('#reason_id').select2({allowClear: true, placeholder: 'Select Reason'})
            $('#date').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
                immediateUpdates: true,
                todayBtn: true,
                todayHighlight: true
            })
            ractive.set('inventory_adjustment_items.0.add_sub',1)
            ractive.set('inventory_adjustment_items.0.add_sub','')
        })
    </script>


    <script src="{{ asset('js/inventory-adjustment/adjustment.js') }}"></script>
@endsection
