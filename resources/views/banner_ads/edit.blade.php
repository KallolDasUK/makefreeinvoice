@extends('master.master-layout')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">{{ !empty($bannerAd->title) ? $bannerAd->title : 'Banner Ad' }}</h5>

            <div class="btn-group btn-group-sm float-right" role="group">

                <a href="{{ route('banner_ads.banner_ad.index') }}" class="btn btn-primary mr-2" title="Show All Banner Ad">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Banner Ad
                </a>

                <a href="{{ route('banner_ads.banner_ad.create') }}" class="btn btn-success" title="Create New Banner Ad">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Banner Ad
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

            <form method="POST" action="{{ route('banner_ads.banner_ad.update', $bannerAd->id) }}" id="edit_banner_ad_form" name="edit_banner_ad_form" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('banner_ads.form', [
                                        'bannerAd' => $bannerAd,
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
