@extends('acc::layouts.app')


@section('content')

    <div class="panel panel-default">

        <div class="panel-heading clearfix">


            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('ledger_groups.ledger_group.index') }}" class="btn btn-primary"
                   title="Show All Ledger Group">
                    <span class="mdi mdi-format-list-bulleted" aria-hidden="true"></span>
                    Show All Ledger Group
                </a>
            </div>

        </div>

        <div class="panel-body">


            <form method="POST" action="{{ route('ledger_groups.ledger_group.store') }}" accept-charset="UTF-8"
                  id="create_ledger_group_form" name="create_ledger_group_form" class="form-horizontal">
                {{ csrf_field() }}
                @include ('acc::ledger_groups.form', [
                                            'ledgerGroup' => null,
                                          ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection


@section('js')
    <script>

        $(document).ready(function () {

            $('#group_name').focus()
            $('#parent').select2({
                placeholder: "Choose a Group",
            });

            $('#nature').select2({
                placeholder: "Select Nature",
            });

            $('#cashflow_type').select2({
                placeholder: "Select Cashflow Type",
            });

            $('#parent').on('select2:select', function (e) {

                let isPrimary = parseInt(e.target.value) === -1;
                if (isPrimary) {
                    $('#nature').prop('disabled', false)
                    $('#nature').css('cursor', 'pointer')
                    $('#cashflow_type').prop('disabled', false)
                    $('#cashflow_type').css('cursor', 'pointer')

                } else {
                    $('#nature').val('').trigger('change')
                    $('#nature').prop('disabled', true)
                    $('#nature').css('cursor', 'no-drop')

                    $('#cashflow_type').val('').trigger('change')
                    $('#cashflow_type').prop('disabled', true)
                    $('#cashflow_type').css('cursor', 'no-drop')
                }
            });

        })

    </script>
@endsection
