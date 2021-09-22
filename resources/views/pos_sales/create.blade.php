@extends('layouts.pos_layout')

@section('content')




            <form method="POST" action="{{ route('pos_sales.pos_sale.store') }}" accept-charset="UTF-8" id="create_pos_sale_form" name="create_pos_sale_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('pos_sales.form', ['posSale' => null])


            </form>


@endsection


