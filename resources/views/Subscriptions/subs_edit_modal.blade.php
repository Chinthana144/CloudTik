<div class="modal" tabindex="-1" role="dialog" id="subs_edit_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Subscription</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
            </div>

            <div class="modal-body">
                <p id="p_sub_details">Customer Package</p>

                <form id="frm_update_stat" method="post">
                    @csrf
                    {{-- @method('PUT') --}}
                    <input type="hidden" name="hide_subscription_id" id="hide_subscription_id" value="0">
                    <div class="row">
                        <div class="col-md-8">
                            <Select class="form-select" name="cmb_status" id="cmb_status">
                                <option value="0">Expired</option>
                                <option value="1">Active</option>
                                <option value="2">Pending</option>
                                <option value="3">Cancled</option>
                            </Select>
                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Update</button>
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
