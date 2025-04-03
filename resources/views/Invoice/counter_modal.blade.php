<div class="modal" tabindex="-1" role="dialog" id="counter_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Counter</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
            </div>

            <div class="modal-body">
                <p>Do you want to close the counter? </p>
                <p id="p_counter_close_data"></p>
                <form action="" method="post">
                    <input type="hidden" name="hide_counter_close_id" id="hide_counter_close_id"
                        value="{{ $counter->id }}">

                    <button class="btn btn-danger">Close Counter</button>
                </form>
            </div>

            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div> --}}

        </div>
    </div>
</div>
