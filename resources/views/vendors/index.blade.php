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

            <h5 class="my-1 float-left">Vendors</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('vendors.vendor.create') }}" class="btn btn-success" title="Create New Vendor">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Vendor
                </a>
            </div>

        </div>


        <div class="card-body">

            <div class="">
                <form action="{{ route('vendors.vendor.index') }}">
                    <div class="row align-items-center mb-4">

                        <div class="col-4">
                            <input name="q" type="text" class="form-control" placeholder="Name, Phone, Email"
                                   value="{{ $q }}">
                        </div>
                        <div class="col-4">

                            <button role="button" type="submit" class="btn btn-primary ">
                                <i class="fas fa-sliders-h"></i>
                                Filter
                            </button>

                            @if( $q != null)
                                <a href="{{ route('vendors.vendor.index') }}" title="Clear Filter"
                                   class="btn btn-icon btn-light-danger"> X</a>
                            @endif


                        </div>

                    </div>
                </form>
                <table class="table mb-0  table-head-custom table-vertical-center ">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Payables</th>
                        <th>Advance</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="font-weight-bolder" style="font-size: 14px">
                    @foreach($vendors as $vendor)
                        <tr>
                            <td>{{ (($vendors->currentPage() - 1) * 10) + $loop->iteration }}</td>
                            <td><a
                                    data-toggle="tooltip" data-placement="top" title="Vendor Statement"
                                    href="{{ route('reports.report.vendor_statement',['vendor_id'=>$vendor->id]) }}">{{ $vendor->name }}</a>
                                <br>
                                <p style="font-size: 14px">{{ $vendor->email }}</p>
                            </td>
                            <td>{{ $vendor->phone }}</td>

                            <td class="text-center">{{ decent_format_dash_if_zero($vendor->payables) }}</td>
                            <td class="text-center">{{ decent_format_dash_if_zero($vendor->advance) }}</td>


                            <td>

                                <form method="POST" action="{!! route('vendors.vendor.destroy', $vendor->id) !!}"
                                      accept-charset="UTF-8">
                                    <input name="_method" value="DELETE" type="hidden">
                                    {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm float-right " role="group">

                                        <a style="text-decoration: underline"
                                           class="{{ $vendor->payables > 0?'':'d-none' }} font-weight-bolder text-success  font-size-lg underline  text-hover-danger cursor-pointer mx-4 recordPaymentBtn"
                                           href="{{ route('bill_payments.bill_payment.create',['vendor_id'=>$vendor->id]) }}">
                                            Pay Vendor
                                        </a>
                                        <a href="{{ route('vendors.vendor.show', $vendor->id ) }}"
                                           class="btn btn-outline-secondary"
                                           title="Show Vendor">
                                            <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('vendors.vendor.edit', $vendor->id ) }}"
                                           class="btn btn-outline-secondary mx-4"
                                           title="Edit Vendor">
                                            <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                        </a>

                                        <button type="submit" class="btn btn-outline-secondary"
                                                title="Delete Vendor"
                                                onclick="return confirm(&quot;Click Ok to delete Vendor.&quot;)">
                                            <i class=" fas  fa-trash text-danger" aria-hidden="true"></i>
                                        </button>
                                    </div>

                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if(count($vendors) == 0)
                    <div class="card-body text-center">
                        <div class="text-center">
                            <img style="text-align: center;margin: 0 auto;"
                                 src="https://1.bp.blogspot.com/-oFZuUJWkeVI/YU2wRxUt26I/AAAAAAAAFKw/tA92-qZCPksDCerRYqgANfzaeF8xtGTFQCLcBGAsYHQ/s320/norecord.png"
                                 alt="">
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-footer">
            {!! $vendors->render() !!}
        </div>


    </div>
@endsection

@section('scripts')

    <script>

    </script>

    <style>
        .dataTables_filter {
            float: right;
        }

        i:hover {
            color: #0248fa !important;
        }

    </style>


@endsection


