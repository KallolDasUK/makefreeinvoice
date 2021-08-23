@extends('acc::layouts.app')
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.1/html2pdf.bundle.min.js"
            integrity="sha512-vDKWohFHe2vkVWXHp3tKvIxxXg0pJxeid5eo+UjdjME3DBFBn2F8yWOE0XmiFcFbXxrEOR1JriWEno5Ckpn15A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>@endsection
@section('css')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #receipt-container, #receipt-container * {
                visibility: visible;
            }

            #receipt-container {
                position: absolute;
                left: 0;
                top: 0;
                right: 0;
            }
        }
    </style>
@endsection
@section('content')

    <div class="">
        <div>

            <h5 class="my-1 float-left">{{ isset($title) ? $title : 'Inventory Adjustment' }}</h5>

            <div class="float-right">

                <form method="POST"
                      action="{!! route('inventory_adjustments.inventory_adjustment.destroy', $inventoryAdjustment->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('inventory_adjustments.inventory_adjustment.index') }}"
                           class="btn btn-primary mr-2" title="Show All Inventory Adjustment">
                            <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                            Show All Inventory Adjustment
                        </a>

                        <a href="{{ route('inventory_adjustments.inventory_adjustment.create') }}"
                           class="btn btn-success mr-2" title="Create New Inventory Adjustment">
                            <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                            Create New Inventory Adjustment
                        </a>

                        <a href="{{ route('inventory_adjustments.inventory_adjustment.edit', $inventoryAdjustment->id ) }}"
                           class="btn btn-primary mr-2" title="Edit Inventory Adjustment">
                            <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                            Edit Inventory Adjustment
                        </a>

                        <button type="submit" class="btn btn-danger" title="Delete Inventory Adjustment"
                                onclick="return confirm(&quot;Click Ok to delete Inventory Adjustment.?&quot;)">
                            <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                            Delete Inventory Adjustment
                        </button>
                    </div>
                </form>

            </div>

        </div>

        <p class="clearfix"></p>
        <div class="btn-group btn-group-lg float-right bg-white" role="group" aria-label="Large button group">
            <button id="printBtn" type="button" class="btn btn-outline-secondary">
                <i class="fa fa-print text-danger"></i>
                <b>Print Receipt</b>
            </button>
            <button id="downloadBtn" type="button" class="btn btn-outline-secondary">
                <i class="fa fa-download text-primary"></i>

                <b>Download</b>
            </button>
        </div>        <div id="receipt-container" class="card mx-auto my-4" style="width: 50%">


            <div class="card-body">
                <dl class="dl-horizontal">
                    <dt>Date</dt>
                    <dd>{{ $inventoryAdjustment->date }}</dd>
                    <dt>Ref</dt>
                    <dd>{{ $inventoryAdjustment->ref }}</dd>
                    <dt>Accounts</dt>
                    <dd>{{ optional($inventoryAdjustment->ledger)->ledger_name }}</dd>
                    <dt>Note</dt>
                    <dd>{{ $inventoryAdjustment->description }}</dd>

                </dl>
                <table class="table ">
                    <tr>
                        <th>SL</th>
                        <th>Item</th>
                        <th>Reason</th>
                        <th>Type</th>
                        <th>Added Quantity</th>
                        <th>Removed Quantity</th>
                    </tr>

                    @foreach($inventoryAdjustment->inventory_adjustment_items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->reason->name }}</td>
                            <td>{{ $item->type=='add'?'Added':'Removed' }}</td>
                            <td>{{ $item->add_qnt == '0.00'?'-':$item->add_qnt }}</td>
                            <td>{{ $item->sub_qnt == '0.00'?'-':$item->sub_qnt }}</td>

                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>

        $('#printBtn').on('click', function () {
            window.print()
        })
        $('#downloadBtn').on('click', function () {
            var element = document.getElementById('receipt-container');
            let invoice_number = "{{ $inventoryAdjustment->ref??'adjustment'.$inventoryAdjustment->id }}"
            var opt = {
                filename: invoice_number + '.pdf',
                image: {type: 'jpeg', quality: 0.98},
                html2canvas: {scale: 2},
                jsPDF: {unit: 'in', format: 'letter', orientation: 'portrait'}
            };
            html2pdf(element, opt);
        })
        $(document).ready(() => {
            {{--let is_print = {{ $is_print }};--}}
            {{--let is_download = {{ $is_download }};--}}
            {{--if (is_print) {--}}
            {{--    $('#printBtn').click()--}}
            {{--    setTimeout(() => {--}}
            {{--        window.location.href = "{{ route('expenses.expense.index') }}";--}}
            {{--    }, 100)--}}
            {{--}--}}
            {{--if (is_download) {--}}
            {{--    $('#downloadBtn').click()--}}
            {{--    setTimeout(() => {--}}
            {{--        window.location.href = "{{ route('expenses.expense.index') }}";--}}
            {{--    }, 1000)--}}
            {{--}--}}
        });

    </script>
@endpush
