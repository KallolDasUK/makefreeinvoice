@extends('master.master-layout')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5 class="my-1 float-left">Create New Banner Ad</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('banner_ads.banner_ad.index') }}" class="btn btn-primary" title="Show All Banner Ad">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Banner Ad
                </a>
            </div>

        </div>

        <div class="card-body">


            <form method="POST" action="{{ route('banner_ads.banner_ad.store') }}" accept-charset="UTF-8"
                  id="create_banner_ad_form" name="create_banner_ad_form" class="form-horizontal"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                @include ('banner_ads.form', ['bannerAd' => null ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection


