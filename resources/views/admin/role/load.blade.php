<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title col-md-1">Id</th>
                    <th class="column-title col-md-4">Name</th>
                    <th class="column-title col-md-4">Guard</th>
                    @can('view_users', 'edit_users', 'delete_users')
                        <th class="column-title text-center col-md-3">Actions</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $key => $item)
                <tr>
                    <td class="col-md-1">{{ $key + 1 }}</td>
                    <td class="col-md-4">{{ $item->name }}</td>
                    <td class="col-md-4">{{ $item->guard_name }}</td>

                    @can('view_users', 'edit_users', 'delete_users')
                        <td class="text-center col-md-3">
                        @can('view_users')
                            <button type="button" class="btn btn-xs btn-default viewBtn" view-modal-class="view-modal-{{$item->id}}" view-id="{{$item->id}}">
                                <i class="fa fa-eye"> View</i>
                            </button>
                        @endcan

                        @can('edit_users')
                        <a href="{{route('roles.edit', ['id' => $item->id ])}}" class="btn btn-xs btn-info">
                            <i class="fa fa-edit"></i> Edit</a>
                        @endcan

                        @can('delete_users')
                        {!! Form::open( ['method' => 'delete', 'url' => route('roles.destroy', ['id' => $item->id]), 'style' => 'display: inline']) !!}
                            <button type="button" class="btn btn-xs btn-danger deleteBtn" delete-modal-class="delete-modal-{{$item->id}}">
                                <i class="fa fa-trash-o"> Delete</i>
                            </button>

                            <div class="modal fade delete-modal-{{$item->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel2">Delete Role</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this record?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" id="delete_item" class="btn btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {!! Form::close() !!}
                            @endcan
                        </td>
                    @endcan
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<?php
    $recordPerPage  = request()->session()->get('recordPerPage') ?? 1;
?>

<div class="form-group col-sm-6 col-md-6" style="margin: 20px 0">
    {!! Form::label('show', 'Rows', ['class'=>'control-label col-md-1 col-sm-1 col-xs-1', 'style'=> 'margin: 6px 0']) !!}
    <div class="col-md-3 col-sm-3">
        {{Form::select('number_of_records', $showRecords, $recordPerPage, ['class'=>'form-control number_of_records'])}}
    </div>
</div>

<div class="col-sm-6 col-md-6 text-right">
    {{ $roles->links() }}
</div>