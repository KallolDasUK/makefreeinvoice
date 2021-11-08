@extends('acc::layouts.app')

@section('content')
    @include('partials.ajax-reason-create-form')

    <div class="card">

        <div class="card-header">

            <h5 class="my-1 float-left">Create New Inventory Adjustment</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('inventory_adjustments.inventory_adjustment.index') }}" class="btn btn-primary {{  ability(\App\Utils\Ability::INVENTORY_ADJUSTMENT_READ) }}"
                   title="Show All Inventory Adjustment">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Inventory Adjustment
                </a>
            </div>

        </div>

        <div class="card-body">


            <form method="POST" action="{{ route('inventory_adjustments.inventory_adjustment.store') }}"
                  accept-charset="UTF-8" id="create_inventory_adjustment_form" name="create_inventory_adjustment_form"
                  class="form-horizontal">
                {{ csrf_field() }}
                @include ('inventory_adjustments.form', ['inventoryAdjustment' => null])

                <div class="form-group">
                    <div class="float-right">

                        <button class="btn btn-primary btn-lg btn-fw" type="submit">

                            <i class="far fa-save"></i> Save Adjustment
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

        var inventory_adjustment_items = [copiedObject];

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
        })
    </script>


    <script src="{{ asset('js/inventory-adjustment/adjustment.js') }}"></script>
@endsection
