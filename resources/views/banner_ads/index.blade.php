@extends('master.master-layout')

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

            <h5  class="my-1 float-left">Banner Ads</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('banner_ads.banner_ad.create') }}" class="btn btn-success" title="Create New Banner Ad">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Banner Ad
                </a>
            </div>

        </div>

        @if(count($bannerAds) == 0)
            <div class="card-body text-center">
                <h4>No Banner Ads Available.</h4>
            </div>
        @else
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Link</th>
                            <th>Banner Type</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($bannerAds as $bannerAd)
                        <tr>
                            <td>{{ $bannerAd->title }}</td>
                            <td>{{ $bannerAd->link }}</td>
                            <td>{{ $bannerAd->banner_type }}</td>

                            <td>

                                <form method="POST" action="{!! route('banner_ads.banner_ad.destroy', $bannerAd->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm float-right " role="group">
                                        <a href="{{ route('banner_ads.banner_ad.show', $bannerAd->id ) }}"title="Show Banner Ad">
                                            <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('banner_ads.banner_ad.edit', $bannerAd->id ) }}" class="mx-4" title="Edit Banner Ad">
                                            <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                        </a>

                                        <button type="submit" style="border: none;background: transparent"  title="Delete Banner Ad" onclick="return confirm(&quot;Click Ok to delete Banner Ad.&quot;)">
                                            <i class=" fas  fa-trash text-danger" aria-hidden="true"></i>
                                        </button>
                                    </div>

                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="card-footer">
            {!! $bannerAds->render() !!}
        </div>

        @endif

    </div>
@endsection

@section('scripts')

     <script>
         $(document).ready(function () {
             $('table').DataTable({
                 responsive: true,
                 "order": [],
                 dom: 'lBfrtip',
                 buttons: [
                     'copy', 'excel', 'pdf', 'print'
                 ]

             });
         });
     </script>

     <style>
         .dataTables_filter {
             float: right;
         }
        i:hover { color: #0248fa !important; }

     </style>


@endsection


