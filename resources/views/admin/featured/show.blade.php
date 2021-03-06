<div id="viewModal" class="modal fade bs-example-modal-lg {{$modalClass}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">View Featured</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">School</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ 1 }}
                        </div>
                    </div>

                    @foreach(request()->session()->get('languages') as $lang => $language)
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                            <div class="control-div col-md-6 col-sm-6 col-xs-12">
                                {{ $featured->getTranslation($lang)->title }}
                            </div>
                            <div class='control-label col-md-3 col-sm-3 col-xs-3'>
                                <img src="{{ $language['flag'] }}" class="pull-left img-responsive" alt="{{$language['name']}} Flag" width="25" height="20">
                            </div>
                        </div>
                    @endforeach

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Image</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12"  style="background-color: #ff6403">
                            <img src="{{url(\App\Featured::THUMB_DIR . $featured->image)}}" alt="Team" width="150" height="150">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $featured->status ? 'Active' : 'Inactive' }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Created</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $featured->created_at }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Last Updated</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $featured->updated_at }}
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