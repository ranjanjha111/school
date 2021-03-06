<div id="viewModal" class="modal fade bs-example-modal-lg {{$modalClass}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">View User</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $user->name }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $user->email }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Role</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ implode($user->roles->pluck('name')->toArray()) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Created</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $user->created_at }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Last Updated</label>
                        <div class="control-div col-md-6 col-sm-6 col-xs-12">
                            {{ $user->updated_at }}
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_content">
                            <h2>{{ $role->name . ' Permission' }}</h2>

                            @include('admin.shared._permissions')
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