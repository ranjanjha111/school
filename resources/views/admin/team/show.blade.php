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
                    @foreach(request()->session()->get('languages') as $lang => $language)
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                            <div class="control-div col-md-6 col-sm-6 col-xs-12">
                                {{ $team->getTranslation($lang)->name }}
                            </div>
                            <div class='control-label col-md-3 col-sm-3 col-xs-3'>
                                <img src="{{ $language['flag'] }}" class="pull-left img-responsive" alt="{{$language['name']}} Flag" width="25" height="20">
                            </div>
                        </div>
                    @endforeach

                    @foreach(request()->session()->get('languages') as $lang => $language)
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Profile Heading</label>
                            <div class="control-div col-md-6 col-sm-6 col-xs-12">
                                {{ $team->getTranslation($lang)->profile_heading }}
                            </div>
                            <div class='control-label col-md-3 col-sm-3 col-xs-3'>
                                <img src="{{ $language['flag'] }}" class="pull-left img-responsive" alt="{{$language['name']}} Flag" width="25" height="20">
                            </div>
                        </div>
                    @endforeach

                    @foreach(request()->session()->get('languages') as $lang => $language)
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                            <div class="control-div col-md-6 col-sm-6 col-xs-12">
                                {{ $team->getTranslation($lang)->description }}
                            </div>
                            <div class='control-label col-md-3 col-sm-3 col-xs-3'>
                                <img src="{{ $language['flag'] }}" class="pull-left img-responsive" alt="{{$language['name']}} Flag" width="25" height="20">
                            </div>
                        </div>
                    @endforeach

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Image</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            <img src="{{url(\App\Team::TEAM_THUMB_DIR . $team->image)}}" alt="Team" width="150" height="150">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $team->status ? 'Active' : 'Inactive' }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Created</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $team->created_at }}
                        </div>
                    </div>

                    <!--Roles Form Input-->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Last Updated</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $team->updated_at }}
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