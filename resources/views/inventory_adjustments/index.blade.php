@extends('acc::layouts.app')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <i class=" fas fa-fw fa-check" aria-hidden="true"></i>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">Inventory Adjustments</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('inventory_adjustments.inventory_adjustment.create') }}" class="btn btn-success  {{  ability(\App\Utils\Ability::INVENTORY_ADJUSTMENT_CREATE) }}" title="Create New Inventory Adjustment">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Inventory Adjustment
                </a>
            </div>

        </div>

        @if(count($inventoryAdjustments) == 0)
            <div class="card-body text-center">
                <h4>No Inventory Adjustments Available.</h4>
            </div>
        @else
        <div class="card-body">

                <table class=" table mb-0  table-head-custom table-vertical-center ">
                    <thead>
                        <tr>
                                <th>Date</th>
                            <th>Ref</th>
                            <th>Accounts</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($inventoryAdjustments as $inventoryAdjustment)
                        <tr>
                                <td>{{ $inventoryAdjustment->date }}</td>
                            <td><a href="{{ route('inventory_adjustments.inventory_adjustment.show',$inventoryAdjustment->id) }}">{{ $inventoryAdjustment->ref }}</a></td>
                            <td>{{ optional($inventoryAdjustment->ledger)->ledger_name }}</td>

                            <td>

                                <form method="POST" action="{!! route('inventory_adjustments.inventory_adjustment.destroy', $inventoryAdjustment->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm float-right " role="group">
                                        <a href="{{ route('inventory_adjustments.inventory_adjustment.show', $inventoryAdjustment->id ) }}" title="Show Inventory Adjustment" class="btn  {{  ability(\App\Utils\Ability::INVENTORY_ADJUSTMENT_READ) }}">
                                            <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('inventory_adjustments.inventory_adjustment.edit', $inventoryAdjustment->id ) }}" class="mx-4 btn  {{  ability(\App\Utils\Ability::INVENTORY_ADJUSTMENT_EDIT) }}" title="Edit Inventory Adjustment">
                                            <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                        </a>

                                        <button type="submit" class="btn btn-default" {{  ability(\App\Utils\Ability::INVENTORY_ADJUSTMENT_DELETE) }} title="Delete Inventory Adjustment" onclick="return confirm(&quot;Click Ok to delete Inventory Adjustment.&quot;)">
                                            <i class=" fas  fa-trash text-danger" aria-hidden="true"></i>
                                        </button>
                                    </div>

                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

        </div>

        <div class="card-footer">
            {!! $inventoryAdjustments->render() !!}
        </div>

        @endif

    </div>
@endsection

@section('scripts')

     <script>
         $(document).ready(function () {
             $('table').DataTable({
                 responsive: true,
                 "order": [],
                 dom: 'lBfrtip',
                 buttons: [
                     'copy', 'excel', 'pdf', 'print'
                 ]

             });
         });
     </script>

     <style>
         .dataTables_filter {
             float: right;
         }
        i:hover { color: #0248fa !important; }

     </style>


@endsection


