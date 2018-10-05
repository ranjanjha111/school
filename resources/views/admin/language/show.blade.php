<div id="viewModal" class="modal fade bs-example-modal-lg {{$modalClass}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">View Activity</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $language->name }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Code</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $language->code }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Flag</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            <img src="{{url(\App\Language::LANGUAGE_THUMB_DIR . $language->flag)}}" alt="Language Flag" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Is Default</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $language->is_default }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $language->status ? 'Active' : 'Inactive' }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Created</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $language->created_at }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Last Updated</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $language->updated_at }}
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>