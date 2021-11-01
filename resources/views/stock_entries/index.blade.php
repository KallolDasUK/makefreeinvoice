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

            <h5  class="my-1 float-left">Stock Entries</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('stock_entries.stock_entry.create') }}" class="btn btn-success" title="Create New Stock Entry">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Stock Entry
                </a>
            </div>

        </div>

        @if(count($stockEntries) == 0)
            <div class="card-body text-center">
                <h4>No Stock Entries Available.</h4>
            </div>
        @else
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                                <th>Ref</th>
                            <th>Date</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Product</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($stockEntries as $stockEntry)
                        <tr>
                                <td>{{ $stockEntry->ref }}</td>
                            <td>{{ $stockEntry->date }}</td>
                            <td>{{ optional($stockEntry->brand)->name }}</td>
                            <td>{{ optional($stockEntry->category)->name }}</td>
                            <td>{{ optional($stockEntry->product)->name }}</td>

                            <td>

                                <form method="POST" action="{!! route('stock_entries.stock_entry.destroy', $stockEntry->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm float-right " role="group">
                                        <a href="{{ route('stock_entries.stock_entry.show', $stockEntry->id ) }}"title="Show Stock Entry">
                                            <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('stock_entries.stock_entry.edit', $stockEntry->id ) }}" class="mx-4" title="Edit Stock Entry">
                                            <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                        </a>

                                        <button type="submit" style="border: none;background: transparent"  title="Delete Stock Entry" onclick="return confirm(&quot;Click Ok to delete Stock Entry.&quot;)">
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

        <div class="card-footer">
            {!! $stockEntries->render() !!}
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


