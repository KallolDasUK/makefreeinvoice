<!-- Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="notificationModalLabel" > <i class="fa fa-bullhorn mr-4" aria-hidden="true"></i>Notice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach($user->user_unseen_notifications as $notification)
                    <h3>{{ $notification->title  }}</h3>
                    <p><b>{{ $notification->body }}</b></p>
                @endforeach
            </div>
            <div class="modal-footer">
                <button id="closeNoticeBtn" type="button" class="btn btn-primary">I Understand</button>
            </div>
        </div>
    </div>
</div>
