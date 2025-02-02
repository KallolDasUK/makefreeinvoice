@extends('acc::layouts.app')

@section('content')

    <div class="card">

        <div class="card-header">


            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('customers.customer.index') }}" class="btn btn-primary  {{ ability(\App\Utils\Ability::CUSTOMER_READ) }}" title="Show All Customer">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Customer
                </a>
            </div>

        </div>

        <div class="card-body">


            <form method="POST" action="{{ route('customers.customer.store') }}" accept-charset="UTF-8"
                  id="create_customer_form" name="create_customer_form" class="form-horizontal"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                @include ('customers.form', ['customer' => null])

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
            $('select').select2()
            $('table').DataTable()
        })
    </script>
@endsection
