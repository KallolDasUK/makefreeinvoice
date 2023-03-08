@extends('master.master-layout')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <table class="table" id="myTable">
{{--                        let table = new DataTable('#myTable');--}}
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
                                <td>
                                    <a href="{{ route('edit-blog-category', ['id' => $blogCategory->id]) }}" class="btn btn-warning btn-sm"><i class="anticon anticon-edit"></i></a>
                                    <a href="{{ route('delete-blog-category', ['id' => $blogCategory->id]) }}" onclick="return confirm('Are you sure to delete this?')" class="btn btn-danger btn-sm"><i class="anticon anticon-delete"></i></a>

                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('js')
    <script>

        $('.ads_checkbox').on('change', function () {
            let is_checked = this.checked;
            $.ajax({
                url: route('ajax.toggleAdSettings'),
                method: 'post',
                data: {_token: "{{ csrf_token() }}", show_ads: is_checked, user_id: $(this).attr('user_id')}
            })
        });
        $('#save').on('click', function () {
            $('#user_settings_form_btn').submit();
            $('#user_settings_form_btn').click();
            $('#settingsModal').modal('hide')
        })


        $(document).ready(function () {
            $('.linkContainer').on('click', function () {
                setTimeout(() => {
                    $(this).find('input').toggle()
                    $(this).find('input').select()
                    document.execCommand("copy");
                }, 10)
                setTimeout(() => {

                    $(this).find('input').toggle()
                }, 15)


                // $(this).text('Copied')
            })

            $('#settingsModal').on('shown.bs.modal', function (e) {
                // alert('test')
                //get data-id attribute of the clicked element
                $('#content').html("<img width='200' style='text-align: center' src='https://c.tenor.com/tEBoZu1ISJ8AAAAC/spinning-loading.gif'/>")
                var user_id = $(e.relatedTarget).data('user-id');
                $.ajax({
                    url: route('master.user_settings'),
                    method: 'get',

                    data: {_token: "{{ csrf_token() }}", user_id: user_id},
                    success: function (data) {
                        $('#content').html(data)
                        // alert('test')
                    }
                })
            })

        })
    </script>
@endsection



