@extends('acc::layouts.app')

@push('css')
    <style>
        .table > tbody > tr > td {
            vertical-align: middle;
            padding: 15px;


        }

        .table > thead > tr > th {
            vertical-align: middle;
            padding: 15px;
            font-weight: bolder;
            color: black;

        }

        .table > tbody > tr > td .form-group {
            vertical-align: middle;
            margin-bottom: 0px;

        }

        input.picker[type="date"] {
            position: relative;
        }

        input.picker[type="date"]::-webkit-calendar-picker-indicator {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            padding: 0;
            color: transparent;
            background: transparent;
        }
    </style>
@endpush
@section('content')

    <div class="card card-default">

        <div class="card-heading clearfix">


            <div class="btn-group btn-group-sm float-right" role="group">
                <a target="_blank" href="{{ route('journals.journal.pdf',$transaction->id) }}"
                   class="btn btn-inverse-primary mr-2" title="Print Transaction">
                    <span class="mdi mdi-printer" aria-hidden="true"></span>
                    Print Payment
                </a>
                <a href="{{ route('journals.journal.index') }}" class="btn btn-primary mr-2"
                   title="Show All Transaction">
                    <span class="mdi mdi-format-list-bulleted" aria-hidden="true"></span>
                    Show All Payment

                </a>

                <a href="{{ route('journals.journal.create') }}" class="btn btn-success"
                   title="Create New Transaction">
                    <span class="mdi mdi-plus" aria-hidden="true"></span>
                    Create New Payment
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

            <form method="POST" action="{{ route('journals.journal.update', $transaction->id) }}"
                  id="edit_transaction_form" name="edit_transaction_form" accept-charset="UTF-8"
                  class="form-horizontal">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('acc::journals.form', [
                                            'transaction' => $transaction,
                                          ])


                <div id="errCon" class="alert alert-danger" style="display: none">
                    <strong id="err" class="font-weight-bolder"></strong>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Update">
                    </div>
                </div>
            </form>

        </div>
    </div>

    @verbatim
        <script id="template" type="text/ractive">

        <table class="table text-black table-bordered" style="background-color: lightgrey;border-color: white">
    <thead>
    <tr class="form-group" style=" border-bottom: solid lightgrey 10px;">
        <th scope="col">DrCr <span class="text-danger font-weight-bold">*</span></th>
        <th>Particulars <span class="text-danger font-weight-bold">*</span></th>
        <th>Single Narration</th>
        <th>Debit <span class="text-danger font-weight-bold">*</span></th>
        <th>Credit <span class="text-danger font-weight-bold">*</span></th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>


    {{#each txns:i}}
            <tr style=" border-bottom: solid lightgrey 10px;">
                <td>
                    <select value="{{ entry_type }}" class="selectize-input" style="min-width: 100px;cursor:pointer;">
                <option value="Cr">Cr</option>
                <option value="Dr">Dr</option>
            </select>
        </td>
        <td style="min-width: 250px">
            <select id="ledger{{i}}" index="{{i}}
            " autocomplete="off" class="ledgerSelect form-control ledger form-control-sm" value="{{ ledger_id }}"
                    required>
                <option></option>
                {{#each ledgers}}
            <option value="{{ id }}">{{ ledger_name }}</option>
                {{/each}}
            </select>
        </td>
        <td>
            <div class="form-group">
                <input class="selectize-input" value="{{ note }}">
            </div>
        </td>
        <td>
            <div class="form-group">
                {{# entry_type =='Dr' }}
            <input class="selectize-input" type="number"
                   value="{{ amount }}" required>
                {{/entry_type}}


            </div>
        </td>
        <td>
            <div class="form-group">
                {{# entry_type =='Cr' }}
            <input class="selectize-input" type="number"
                   value="{{ amount }}" required>
                {{/entry_type}}
            </div>
        </td>
        <td>
            <div class="form-group">
                <button tabindex="-1" on-click="@this.addNewTransaction()" type="button" class="btn btn-sm btn-primary">
                    <i
                        class="mdi mdi-plus"></i></button>
            </div>
        </td>
        <td>
            <div class="form-group">
                <button tabindex="-1" on-click="@this.delete(i)" type="button" class="btn btn-sm btn-danger"><i
                    class="mdi mdi-delete"></i></button>
            </div>
        </td>

    </tr>

    {{ # amount>0 }}
            {{ #is_bank }}
            <tr>

                <td colspan="7" style="padding: 0px">
                    <table id="tblChequeDetails_3" style="margin: 5px auto;">
                        <thead>
                        <tr>
                            <td colspan="3"> Cheque Details</td>
                        </tr>
                        <tr style="background-color: #0062ff;color: white;font-weight: bolder">
                            <th class="head">Cheque No.</th>
                            <th class="head">Cheque Date</th>
                            <th class="head">Bank Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr id="row_0">
                            <td><input type="text" value="{{ cheque_number }}"
                               class="form-control txtChequeNoCd focusColor col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    </td>
                    <td><input type="date" value="{{ cheque_date }}"
                               class="form-control txtChequeDateCd focusColor col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                    </td>
                    <td><input type="text" value="{{ bank_name }}"
                               class="form-control txtBankNameCd focusColor col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    </td>
                </tr>
                </tbody>
            </table>
        </td>


    </tr>
    {{ /is_bank }}
            {{ /amount }}
            {{/each}}
            <tr>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-secondary font-weight-bolder">Total Debit <br> <b class="text-black">{{ tdr }}</b></td>
            <td class="text-secondary font-weight-bolder">Total Credit <br> <b class="text-black">{{ tcr }}</b></td>
            </tr>
            </tbody>
        </table>



        </script>
    @endverbatim

@endsection

@push('js')
    <script type="text/javascript">
        // alert('sdlfkj')
        var ledgers = {!! json_encode($ledgers)!!}
        var transactions = {!! json_encode($txns)!!};
        var bankLedgerId = {!! json_encode($bank_ledger)!!}


        $(document).ready(function () {
            function openPicker(inputDateElem) {
                var ev = document.createEvent('KeyboardEvent');
                ev.initKeyboardEvent('keydown', true, true, document.defaultView, 'F4', 0);
                inputDateElem.dispatchEvent(ev);
            }

            $('#date').on('focus', function () {
                $(this).click()
                // alert('boom')
            })

            $("form").submit(function (e) {
                console.log('form prevented submitted')
                let txns = ractive.get('txns')
                let cr = 0;
                let dr = 0;
                for (let txn of txns) {
                    if (txn.entry_type === 'Cr') {
                        cr += parseInt(txn.amount)
                    } else {
                        dr += parseInt(txn.amount)
                    }
                    console.log(cr, dr, txn.amount)
                }
                // for (let x = 0; x < txns.length; i++) {
                //     const txn = txns[i];
                //     if (txn.entry_type === 'Cr') {
                //         cr += parseInt(txn.amount)
                //     } else {
                //         dr += parseInt(txn.amount)
                //     }
                //     console.log(cr, dr, txn.amount)
                // }
                console.log(cr, dr, txns)
                // e.preventDefault()
                // return false;
                if (cr != dr) {
                    flash('Debit and Credit amount needs to be same')
                    return false
                }
                if ((cr + dr) == 0) {
                    flash('Debit and Credit amount cannot be zero')
                    return false
                }


                $("<input />").attr("type", "hidden")
                    .attr("name", "txns")
                    .attr("value", JSON.stringify(txns))
                    .appendTo(this);
                return true;
            });

            function flash(msg) {
                $('#errCon').show()

                $('#err').text(msg)
                setTimeout(function () {

                    $('#errCon').hide(500)
                    $('#err').text('')

                }, 3000)
            }
        })

    </script>
    <script src="{{ asset('acc/transactions.js') }}"></script>


@endpush
