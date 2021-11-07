@extends('acc::layouts.app')
@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">{{ !empty($brand->name) ? $brand->name : 'Brand' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('brands.brand.index') }}" class="btn btn-primary mr-2  {{ ability(\App\Utils\Ability::BRAND_READ) }}" title="Show All Brand">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Brand
                </a>

                <a href="{{ route('brands.brand.create') }}" class="btn btn-success  {{ ability(\App\Utils\Ability::BRAND_CREATE) }}" title="Create New Brand">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Brand
                </a>

            </div>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('brands.brand.update', $brand->id) }}" id="edit_brand_form" name="edit_brand_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('brands.form', [
                                        'brand' => $brand,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Update">
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection
