@extends('master.master-layout')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($bannerAd->title) ? $bannerAd->title : 'Banner Ad' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('banner_ads.banner_ad.destroy', $bannerAd->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('banner_ads.banner_ad.index') }}" class="btn btn-primary mr-2" title="Show All Banner Ad">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Banner Ad
                    </a>

                    <a href="{{ route('banner_ads.banner_ad.create') }}" class="btn btn-success mr-2" title="Create New Banner Ad">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Banner Ad
                    </a>

                    <a href="{{ route('banner_ads.banner_ad.edit', $bannerAd->id ) }}" class="btn btn-primary mr-2" title="Edit Banner Ad">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Banner Ad
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Banner Ad" onclick="return confirm(&quot;Click Ok to delete Banner Ad.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Banner Ad
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Title</dt>
            <dd>{{ $bannerAd->title }}</dd>
            <dt>Banner Image</dt>
            <dd>{{ asset('storage/' . $bannerAd->photo) }}</dd>
            <dt>Link</dt>
            <dd>{{ $bannerAd->link }}</dd>
            <dt>Banner Type</dt>
            <dd>{{ $bannerAd->banner_type }}</dd>

        </dl>

    </div>
</div>

@endsection
