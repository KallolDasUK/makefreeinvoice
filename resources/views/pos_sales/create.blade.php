@extends('layouts.pos_layout')

@section('content')




    <form method="POST" action="{{ route('pos_sales.pos_sale.store') }}" accept-charset="UTF-8"
          id="create_pos_sale_form" name="create_pos_sale_form" class="form-horizontal">
        {{ csrf_field() }}
        @include ('pos_sales.form', ['posSale' => null])


    </form>


@endsection

@section('js')

    <script>
        $(document).ready(function () {

        });
    </script>
    <script src="{{ asset('js/pos/pos_sales.js') }}"></script>
@endsection

