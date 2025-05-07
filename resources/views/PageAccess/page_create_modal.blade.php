<div class="modal" tabindex="-1" role="dialog" id="page_create_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"
                    id="close_page_create_modal">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
            </div>

            <form action="{{ route('rolepages.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <label for="">select role</label>
                    <select name="cmb_role" id="cmb_role" class="form-select">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>

                    <div class="mt-2">
                        <p>Pages</p>
                        @foreach ($pages as $page)
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="page_{{ $page->id }}" name="page_{{ $page->id }}">
                                <label class="form-check-label"
                                    for="page_{{ $page->id }}">{{ $page->pagename }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create Role Access</button>
                    {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                </div>
            </form>

        </div>
    </div>
</div>
