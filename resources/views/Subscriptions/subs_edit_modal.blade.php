<div class="modal" tabindex="-1" role="dialog" id="subs_edit_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Subscription</h5>
                <button type="button" class="btn-close" id="btn_close_edit_modal" data-dismiss="modal" aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p id="p_sub_details">Customer Package</p>
                    </div>
                    <div class="col-md-6">
                        <p id="p_sub_dates">Subscription dates</p>
                    </div>
                </div>

                <input type="hidden" name="hide_subscription_id" id="hide_subscription_id" value="0">
                <form action="{{ route('customer.updateExpireDate') }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="hide_customer_id" id="hide_customer_id" value="0">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="expire_date" class="form-label">Expire Date</label>
                                <input type="date" class="form-control" id="expire_date" name="expire_date" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="expire_time" class="form-label">Expire Time</label>
                                <input type="time" class="form-control" id="expire_time" name="expire_time" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary mt-4">Update Expire Date</button>
                        </div>
                    </div>
                </form>

            </div>

            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div> --}}
        </div>
    </div>
</div>
