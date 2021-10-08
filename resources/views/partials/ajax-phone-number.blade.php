<div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-labelledby="phoneModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top:30px!important;!important;">
        <div class="modal-content">

            <div class="modal-body">
                <form id="phoneForm" method="post" action="{{ route('ajax.storePhoneNumber') }}">
                    @csrf
                    <div class="content px-2 py-0">
                        <div class="form-group">
                            <b class="text-primary">Hey {{ auth()->user()->name }},</b>
                            <h2 class="font-weight-bolder text-black">What's Your Phone Number?</h2>
                            <input class="form-control" name="phone" type="text" placeholder="ex. 01680852026"
                                   required
                                   style="font-size: 30px">
                            <button class="btn btn-primary mt-4 text-right float-right" style="font-size: 25px">Save &
                                Hide
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


