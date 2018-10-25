<div id="viewModal" class="modal fade bs-example-modal-lg {{$modalClass}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">View School</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Code</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $school->code }}
                        </div>
                    </div>

                    @foreach(request()->session()->get('languages') as $lang => $language)
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                            <div class="control-div col-md-6 col-sm-6 col-xs-12">
                                {{ $school->getTranslation($lang)->name }}
                            </div>
                            <div class='control-label col-md-3 col-sm-3 col-xs-3'>
                                <img src="{{ $language['flag'] }}" class="pull-left img-responsive" alt="{{$language['name']}} Flag" width="25" height="20">
                            </div>
                        </div>
                    @endforeach

                    @foreach(request()->session()->get('languages') as $lang => $language)
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Locality</label>
                            <div class="control-div col-md-6 col-sm-6 col-xs-12">
                                {{ $school->getTranslation($lang)->locality }}
                            </div>
                            <div class='control-label col-md-3 col-sm-3 col-xs-3'>
                                <img src="{{ $language['flag'] }}" class="pull-left img-responsive" alt="{{$language['name']}} Flag" width="25" height="20">
                            </div>
                        </div>
                    @endforeach

                    @foreach(request()->session()->get('languages') as $lang => $language)
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                            <div class="control-div col-md-6 col-sm-6 col-xs-12">
                                {{ $school->getTranslation($lang)->address }}
                            </div>
                            <div class='control-label col-md-3 col-sm-3 col-xs-3'>
                                <img src="{{ $language['flag'] }}" class="pull-left img-responsive" alt="{{$language['name']}} Flag" width="25" height="20">
                            </div>
                        </div>
                    @endforeach

                    @foreach(request()->session()->get('languages') as $lang => $language)
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                            <div class="control-div col-md-6 col-sm-6 col-xs-12">
                                {{ $school->getTranslation($lang)->near_by }}
                            </div>
                            <div class='control-label col-md-3 col-sm-3 col-xs-3'>
                                <img src="{{ $language['flag'] }}" class="pull-left img-responsive" alt="{{$language['name']}} Flag" width="25" height="20">
                            </div>
                        </div>
                    @endforeach

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Image</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            <img src="{{url(\App\School::THUMB_DIR . $school->image)}}" alt="Team" width="150" height="150">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">City</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $school->city->name }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">State</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $school->state->name }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $school->email }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Mobile</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $school->mobile }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fax</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $school->fax }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $school->status ? 'Active' : 'Inactive' }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Created</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $school->created_at }}
                        </div>
                    </div>

                    <!--Roles Form Input-->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Last Updated</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $school->updated_at }}
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