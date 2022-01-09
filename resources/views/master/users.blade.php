@extends('master.master-layout')

@section('css')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endsection
@section('content')

    <!-- Modal -->
    <div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="settingsModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <div id="content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hide</button>
                    <button type="button" id="save" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-8"><h2>Client List</h2></div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</button>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5>Total Clients</h5>
                        {{ $totalClients }}
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5>Total Invoices</h5>
                        {{ $totalInvoices }}
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5>Total POS</h5>
                        {{ $totalPosSale }}
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5>Total Bills</h5>
                        {{ $totalBills }}
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('master.users') }}">
                    <div class="row align-items-end justify-content-center">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Filter Type</label>
                                <select name="filter_type" id="filter_type" class="form-control" required>
                                    <option value="active_within" @if($filter_type == "active_within") selected @endif>
                                        Active Within
                                    </option>
                                    <option value="joined_within" @if($filter_type == "joined_within") selected @endif>
                                        Joined Within
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Email</label>
                                <select name="email" id="email" class="form-control searchable">

                                    <option value="" disabled selected>-- Choose --</option>
                                    @foreach(\App\Models\User::query()->get() as $user)
                                        <option value="{{ $user->email }}"
                                                @if($email == $user->email) selected @endif> {{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Sort Type</label>
                                <select name="sort_type" id="sort_type" class="form-control" required>
                                    <option value="asc" @if($sort_type == "asc") selected @endif>Ascending</option>
                                    <option value="desc" @if($sort_type == "desc") selected @endif>Descending</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Start Date</label>
                                <input type="date" name="start_date" class="form-control" required
                                       value="{{ $start_date??today()->toDateString() }}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">End Date</label>
                                <input type="date" name="end_date" class="form-control" required
                                       value="{{ $end_date??today()->toDateString() }}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">&nbsp</label>
                                <input type="submit" value="Filter" class="btn btn-primary">
                                <a href="{{ route('master.users') }}" class="btn btn-danger">Clear Filter</a>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <table class="table table-bordered table-sm">
            <thead>
            <tr>
                <th>Name</th>
                <th>Settings</th>
                <th>On Plan</th>
                <th>Joined</th>
                <th>Last Active</th>
                <th>Invoices</th>
                <th>POS</th>
                <th>Bills</th>
                <th>Estimate</th>
                <th>Expense</th>
                <th>Customers</th>
                <th>Vendors</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>
                        <div class="row">
                            <div class="col-3">
                                <img class=" rounded"
                                     src="{{ asset('storage/'.(optional($user->settings)->business_logo??'logo.png' )) }}"
                                     alt=""
                                     height="50"
                                     width="50">
                            </div>
                            <div class="col">
                                {{ $user->name }} <br><small>{{ $user->email }}</small><br><small><a
                                        href="tel:{{ optional($user->settings)->phone }}">{{ optional($user->settings)->phone }}</a></small>
                            </div>
                        </div>


                    </td>
                    <td>
                        <label>
                            <button class="btn btn-sm btn-link" data-user-id="{{ $user->id }}"
                                    data-toggle="modal" data-target="#settingsModal"> View Settings
                            </button>
                        </label>
                    </td>
                    <td>{{ Str::title($user->plan) }}</td>
                    <td> {{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</td>
                    @if($user->last_active_at)
                        <td> {{ \Carbon\Carbon::parse($user->last_active_at)->diffForHumans() }}</td>
                    @else
                        <td>-</td>
                    @endif
                    <td>{{ count($user->invoices)==0?'-':count($user->invoices) }}</td>
                    <td>{{ $user->pos_sales_count==0?'-': $user->pos_sales_count }}</td>
                    <td>{{ count($user->bills)==0?'-':count($user->bills) }}</td>
                    <td>{{ count($user->estimates)==0?'-':count($user->estimates) }}</td>
                    <td>{{ count($user->expenses)==0?'-':count($user->expenses) }}</td>
                    <td>{{ count($user->customers)==0?'-':count($user->customers) }}</td>
                    <td>{{ count($user->vendors)==0?'-':count($user->vendors) }}</td>
                    <td>
                        {{--                        <a onclick="window.open('{{ $user->login_url }}', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');" target="_blank" class="add" title="" data-toggle="tooltip"--}}

                        <a class="btn btn-sm btn-danger mr-4 d-none" onclick="return confirm('are you sure?')"
                           href="{{ route('master.users.delete',$user->id) }}">Delete</a>
                        <button class="linkContainer btn btn-sm btn-info">

                            <input type="text" value="{{ $user->login_url }}" style="width: 20px;display: none"
                                   readonly>
                            Copy Login URL
                        </button>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $users->withQueryString()->links() !!}
    </div>
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
