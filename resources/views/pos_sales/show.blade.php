@extends('layouts.pos_layout')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($title) ? $title : 'Pos Sale' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('pos_sales.pos_sale.destroy', $posSale->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('pos_sales.pos_sale.index') }}" class="btn btn-primary mr-2" title="Show All Pos Sale">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Pos Sale
                    </a>

                    <a href="{{ route('pos_sales.pos_sale.create') }}" class="btn btn-success mr-2" title="Create New Pos Sale">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Pos Sale
                    </a>

                    <a href="{{ route('pos_sales.pos_sale.edit', $posSale->id ) }}" class="btn btn-primary mr-2" title="Edit Pos Sale">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Pos Sale
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Pos Sale" onclick="return confirm(&quot;Click Ok to delete Pos Sale.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Pos Sale
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Pos Number</dt>
            <dd>{{ $posSale->pos_number }}</dd>
            <dt>Date</dt>
            <dd>{{ $posSale->date }}</dd>
            <dt>Customer</dt>
            <dd>{{ optional($posSale->customer)->name }}</dd>
            <dt>Branch</dt>
            <dd>{{ optional($posSale->branch)->id }}</dd>
            <dt>Ledger</dt>
            <dd>{{ optional($posSale->ledger)->id }}</dd>
            <dt>Discount Type</dt>
            <dd>{{ $posSale->discount_type }}</dd>
            <dt>Discount</dt>
            <dd>{{ $posSale->discount }}</dd>
            <dt>Vat</dt>
            <dd>{{ $posSale->vat }}</dd>
            <dt>Service Charge Type</dt>
            <dd>{{ $posSale->service_charge_type }}</dd>
            <dt>Service Charge</dt>
            <dd>{{ $posSale->service_charge }}</dd>
            <dt>Note</dt>
            <dd>{{ $posSale->note }}</dd>
            <dt>Payment Method</dt>
            <dd>{{ optional($posSale->ledger)->id }}</dd>
            <dt>Sub Total</dt>
            <dd>{{ $posSale->sub_total }}</dd>
            <dt>Total</dt>
            <dd>{{ $posSale->total }}</dd>
            <dt>Payment Amount</dt>
            <dd>{{ $posSale->payment_amount }}</dd>
            <dt>Due</dt>
            <dd>{{ $posSale->due }}</dd>
            <dt>Pos Status</dt>
            <dd>{{ $posSale->pos_status }}</dd>

        </dl>

    </div>
</div>

@endsection
