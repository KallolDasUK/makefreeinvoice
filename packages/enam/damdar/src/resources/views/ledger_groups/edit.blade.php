@extends('acc::layouts.app')


@section('content')

    <div class="panel panel-default">

        <div class="panel-heading clearfix">


            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('ledger_groups.ledger_group.index') }}" class="btn btn-primary mr-2"
                   title="Show All Ledger Group">
                    <span class="mdi mdi-format-list-bulleted" aria-hidden="true"></span>
                    Show All Ledger Group
                </a>

                <a href="{{ route('ledger_groups.ledger_group.create') }}" class="btn btn-success"
                   title="Create New Ledger Group">
                    <span class="mdi mdi-plus" aria-hidden="true"></span>
                    Create New Ledger Group
                </a>

            </div>
        </div>

        <div class="panel-body">

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('ledger_groups.ledger_group.update', $ledgerGroup->id) }}"
                  id="edit_ledger_group_form" name="edit_ledger_group_form" accept-charset="UTF-8"
                  class="form-horizontal">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('acc::ledger_groups.form', [
                                            'ledgerGroup' => $ledgerGroup,
                                          ])

                <div class="form-group">
                    <button class="btn btn-primary btn-fw" type="submit"><i class="mdi mdi-sync"></i>Update</button>

                </div>
            </form>

        </div>
    </div>

@endsection

@section('css')
    @endsection


@section('js')
    <script>
        $(document).ready(function () {
            $('#group_name').focus()

            let isDefault = {{ $ledgerGroup->is_default }}

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
