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

            <h5  class="my-1 float-left">Taxes</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('taxes.tax.create') }}" class="btn btn-success" title="Create New Tax">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Tax
                </a>
            </div>

        </div>

        @if(count($taxes) == 0)
            <div class="card-body text-center">
                <h4>No Taxes Available.</h4>
            </div>
        @else
        <div class="card-body">

            <div class="">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Value (%)</th>
                            <th>Tax Type</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($taxes as $tax)
                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                                <td>{{ $tax->name }}</td>
                            <td>{{ $tax->value }}</td>
                            <td>{{ $tax->tax_type }}</td>

                            <td>

                                <form method="POST" action="{!! route('taxes.tax.destroy', $tax->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm float-right " role="group">
                                        <a href="{{ route('taxes.tax.show', $tax->id ) }}"title="Show Tax">
                                            <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('taxes.tax.edit', $tax->id ) }}" class="mx-4" title="Edit Tax">
                                            <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                        </a>

                                        <button type="submit" style="border: none;background: transparent"  title="Delete Tax" onclick="return confirm(&quot;Click Ok to delete Tax.&quot;)">
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
        </div>


        @endif

    </div>
@endsection

@section('js')

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


