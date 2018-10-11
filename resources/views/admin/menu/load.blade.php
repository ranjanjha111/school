<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title col-md-1">#</th>
                    <th class="column-title col-md-3">Name</th>
                    <th class="column-title col-md-2">Parent Menu</th>
                    <th class="column-title col-md-2">Permission</th>
                    <th class="column-title col-md-1">Status</th>
                    @can('view_menus', 'edit_menus', 'delete_menus')
                        <th class="column-title text-center col-md-3">Actions</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach($result as $key => $item)
                <tr>
                    <td class="col-md-1">{{ $key + 1 }}</td>
                    <td class="col-md-3">{{ $item->name }}</td>
                    <td class="col-md-2">{{ $item->rootMenu()->first()->name ?? '-' }}</td>
                    <td class="col-md-2">{{ $item->menuRoutes()->first()->name ?? '-' }}</td>
                    <td class="col-md-1">{{ ($item->status == 1) ? 'Active' : 'Inactive' }}</td>
                    @can('view_menus', 'edit_menus', 'delete_menus')
                        @include('admin.shared._actions', ['entity' => 'menus', 'id' => $item->id])
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
    {{ $result->links() }}
</div>