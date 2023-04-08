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

            <h5 class="my-1 float-left">Blog Category</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('blog.category.create') }}" class="btn btn-success"
                   title="Create New Blog Category">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New Blog Category
                </a>
            </div>

        </div>


    @if(count($blogCategories) == 0)
        <div class="card-body text-center">
            <h4>No Blog Categories Available.</h4>
        </div>
    @else
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered ">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($blogCategories as $blogCategory)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $blogCategory->category_name }}</td>
                            <td>{{ $blogCategory->status == 1? 'Published' : 'Unpublished' }}</td>
{{--                                                    <td>--}}
{{--                                                        <a href="{{ route('blog.category.edit', [$blogCategory->id]) }}" class="btn btn-warning btn-sm"><i class="anticon anticon-edit"></i></a>--}}
{{--                                                        <a href="{{ route('blog.category.destroy', [$blogCategory->id]) }}" onclick="return confirm('Are you sure to delete this?')" class="btn btn-danger btn-sm"><i class="anticon anticon-delete"></i></a>--}}
{{--                                                   </td>--}}
                            <td>

                                                        <form method="POST"
                                                              action="{!! route('blog.category.destroy', $blogCategory->id) !!}"
                                                              accept-charset="UTF-8">
                                                            <input name="_method" value="DELETE" type="hidden">
                                                            {{ csrf_field() }}

                                                            <div class="btn-group btn-group-sm float-right " role="group">
                                                                <a href="{{ route('blog.category.show', $blogCategory->id ) }}"title="Show Payment Request">
                                                                    <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                                                </a>
                                                                <a href="{{ route('blog.category.edit', $blogCategory->id ) }}"
                                                                   class="mx-4" title="Edit Collect Payment">
                                                                    <i class="fas fa-edit text-primary" aria-hidden="true"></i>
                                                                </a>

                                                                <button type="submit" style="border: none;background: transparent"
                                                                        title="Delete Blog Category"
                                                                        onclick="return confirm(&quot;Click Ok to delete Blog Category.&quot;)"
                                                                >
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

{{--        <div class="card-footer">--}}
{{--            {!! $blogCategories->render() !!}--}}
{{--        </div>--}}

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

        i:hover {
            color: #0248fa !important;
        }

    </style>


@endsection

{{--@section('js')--}}
{{--<script>--}}

{{--    $('.ads_checkbox').on('change', function () {--}}
{{--        let is_checked = this.checked;--}}
{{--        $.ajax({--}}
{{--            url: route('ajax.toggleAdSettings'),--}}
{{--            method: 'post',--}}
{{--            data: {_token: "{{ csrf_token() }}", show_ads: is_checked, user_id: $(this).attr('user_id')}--}}
{{--        })--}}
{{--    });--}}
{{--    $('#save').on('click', function () {--}}
{{--        $('#user_settings_form_btn').submit();--}}
{{--        $('#user_settings_form_btn').click();--}}
{{--        $('#settingsModal').modal('hide')--}}
{{--    })--}}


{{--    $(document).ready(function () {--}}
{{--        $('.linkContainer').on('click', function () {--}}
{{--            setTimeout(() => {--}}
{{--                $(this).find('input').toggle()--}}
{{--                $(this).find('input').select()--}}
{{--                document.execCommand("copy");--}}
{{--            }, 10)--}}
{{--            setTimeout(() => {--}}

{{--                $(this).find('input').toggle()--}}
{{--            }, 15)--}}


{{--            // $(this).text('Copied')--}}
{{--        })--}}

{{--        $('#settingsModal').on('shown.bs.modal', function (e) {--}}
{{--            // alert('test')--}}
{{--            //get data-id attribute of the clicked element--}}
{{--            $('#content').html("<img width='200' style='text-align: center' src='https://c.tenor.com/tEBoZu1ISJ8AAAAC/spinning-loading.gif'/>")--}}
{{--            var user_id = $(e.relatedTarget).data('user-id');--}}
{{--            $.ajax({--}}
{{--                url: route('master.user_settings'),--}}
{{--                method: 'get',--}}

{{--                data: {_token: "{{ csrf_token() }}", user_id: user_id},--}}
{{--                success: function (data) {--}}
{{--                    $('#content').html(data)--}}
{{--                    // alert('test')--}}
{{--                }--}}
{{--            })--}}
{{--        })--}}

{{--    })--}}
{{--</script>--}}
{{--@endsection--}}



