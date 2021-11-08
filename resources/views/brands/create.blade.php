@extends('acc::layouts.app')
@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">Create New Brand</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('brands.brand.index') }}" class="btn btn-primary  {{ ability(\App\Utils\Ability::BRAND_READ) }}" title="Show All Brand">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Brand
                </a>
            </div>

        </div>

        <div class="card-body">



            <form method="POST" action="{{ route('brands.brand.store') }}" accept-charset="UTF-8" id="create_brand_form" name="create_brand_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('brands.form', [
                                        'brand' => null,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection


