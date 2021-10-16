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


            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('s_rs.s_r.create') }}" class="btn btn-success" title="Create New S R">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New S R
                </a>
            </div>

        </div>

        @if(count($sRs) == 0)
            <div class="card-body text-center">
                <h4>No S Rs Available.</h4>
            </div>
        @else
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                                <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($sRs as $sR)
                        <tr>
                                <td>{{ $sR->name }}</td>
                            <td>{{ $sR->phone }}</td>
                            <td>{{ $sR->email }}</td>
                            <td>{{ $sR->address }}</td>

                            <td>

                                <form method="POST" action="{!! route('s_rs.s_r.destroy', $sR->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm float-right " role="group">
                                        <a href="{{ route('s_rs.s_r.show', $sR->id ) }}"title="Show S R">
                                            <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('s_rs.s_r.edit', $sR->id ) }}" class="mx-4" title="Edit S R">
                                            <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                        </a>

                                        <button type="submit" style="border: none;background: transparent"  title="Delete S R" onclick="return confirm(&quot;Click Ok to delete S R.&quot;)">
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
            {!! $sRs->render() !!}
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


