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

    <div>
        <div>

            <h5 class="my-1 float-left">{{ isset($title) ? $title : 'Expense' }}</h5>

            <div class="float-right">

                <form method="POST" action="{!! route('expenses.expense.destroy', $expense->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('expenses.expense.index') }}" class="btn btn-primary mr-2 {{  ability(\App\Utils\Ability::EXPENSE_READ) }}"
                           title="Show All Expense">
                            <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                            Show All Expense
                        </a>

                        <a href="{{ route('expenses.expense.create') }}" class="btn btn-success mr-2 {{  ability(\App\Utils\Ability::EXPENSE_CREATE) }}"
                           title="Create New Expense">
                            <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                            Create New Expense
                        </a>

                        <a href="{{ route('expenses.expense.edit', $expense->id ) }}" class="btn btn-primary mr-2 {{  ability(\App\Utils\Ability::EXPENSE_EDIT) }}"
                           title="Edit Expense">
                            <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                            Edit Expense
                        </a>

                        <button type="submit" class="btn btn-danger" title="Delete Expense"
                                {{  ability(\App\Utils\Ability::EXPENSE_DELETE) }}
                                onclick="return confirm(&quot;Click Ok to delete Expense.?&quot;)">
                            <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                            Delete Expense
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
        </div>
        <div id="receipt-container" class="receipt-container mx-auto" style="width: 400px">
            <div class="card ">
                <div class="card-body text-center">
                    <h2> Expense Receipt</h2>
                    @if($settings->business_logo??false)
                        <img
                            class="rounded text-center mx-auto my-2"
                            src="{{ asset('storage/'.$settings->business_logo) }}"
                            width="100"
                            alt="">
                    @endif
                    <address class="">
                        <h5 class="m-0 p-0">{{ $settings->business_name??'n/a' }}</h5>
                        @if($settings->street_1??'')
                            {{ $settings->street_1??'' }}
                        @endif
                        @if($settings->street_2??'')
                            <br> {{ $settings->street_2??'' }}
                        @endif
                        @if(($settings->state??'') || ($settings->zip_post??'') )
                            <br> {{ $settings->state??'' }} {{ $settings->zip_post??'' }}
                        @endif
                        @if($settings->email??'')
                            <br> {{ $settings->email??'' }}
                        @endif
                        @if($settings->phone??'')
                            <br> {{ $settings->phone??'' }}
                        @endif
                    </address>
                    <table class="table " style="width: 100%">
                        <tr>

                            <th>Name</th>
                            <th class="text-right">Amount</th>
                        </tr>
                        @foreach($expense->expense_items as $expense_item)
                            <tr>
                                <td>{{ $expense_item->ledger->ledger_name??'' }} <br>
                                    <small>{{ $expense_item->notes }}</small>
                                </td>
                                <td class="text-right">{{ $expense_item->amount }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>Taxable Amount</td>
                            <td class="text-right">{{ decent_format($expense->taxable_amount) }}</td>
                        </tr>
                    </table>
                    <br>
                    <div class="row">
                        <div class="col"><h2>Total Amount</h2></div>
                        <div class="col text-right"><h2>{{ decent_format($expense->amount) }}</h2></div>
                    </div>

                    <dl class="dl-horizontal d-none">
                        <dt>Date</dt>
                        <dd>{{ $expense->date }}</dd>
                        <dt>Paid Through</dt>
                        <dd>{{ optional($expense->ledger)->id }}</dd>
                        <dt>Vendor</dt>
                        <dd>{{ optional($expense->vendor)->name }}</dd>
                        <dt>Customer</dt>
                        <dd>{{ optional($expense->customer)->name }}</dd>
                        <dt>Ref#</dt>
                        <dd>{{ $expense->ref }}</dd>
                        <dt>Is Billable</dt>
                        <dd>{{ ($expense->is_billable) ? 'Yes' : 'No' }}</dd>
                        <dt>File</dt>
                        <dd>{{ asset('storage/' . $expense->file) }}</dd>

                    </dl>

                </div>
            </div>
        </div>
        @if($expense->file)
            <div class="mx-auto">
                <h2 class="text-center mx-auto">
                    <img  src="{{ asset('storage/'.$expense->file) }} " style="width: 50%" class="card mx-auto"/></h2>
            </div>
        @endif


    </div>

@endsection

@push('js')
    <script>

        $('#printBtn').on('click', function () {
            window.print()
        })
        $('#downloadBtn').on('click', function () {
            var element = document.getElementById('receipt-container');
            let invoice_number = "{{ $expense->ref??'expense'.$expense->id }}"
            var opt = {
                filename: invoice_number + '.pdf',
                image: {type: 'jpeg', quality: 0.98},
                html2canvas: {scale: 2},
                jsPDF: {unit: 'in', format: 'letter', orientation: 'portrait'}
            };
            html2pdf(element, opt);
        })
        $(document).ready(() => {
            let is_print = {{ $is_print }};
            let is_download = {{ $is_download }};
            if (is_print) {
                $('#printBtn').click()
                setTimeout(() => {
                    window.location.href = "{{ route('expenses.expense.index') }}";
                }, 100)
            }
            if (is_download) {
                $('#downloadBtn').click()
                setTimeout(() => {
                    window.location.href = "{{ route('expenses.expense.index') }}";
                }, 1000)
            }
        });

    </script>
@endpush
