<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
            <tr class="headings">
                <th class="column-title col-md-1">Id</th>
                <th class="column-title col-md-2">Name</th>
                <th class="column-title col-md-1">Profile</th>
                <th class="column-title col-md-3">Description</th>
                <th class="column-title col-md-1">Image</th>
                <th class="column-title col-md-1">Status</th>
                @can('view_teams', 'edit_teams', 'delete_teams')
                    <th class="column-title text-center col-md-3">Actions</th>
                @endcan
            </tr>
            </thead>
            <tbody>
            @foreach($result as $key => $item)
                <tr>
                    <td class="col-md-1">{{ $key + 1 }}</td>
                    <td class="col-md-2">{{ $item->name }}</td>
                    <td class="col-md-1">{{ $item->profile_heading }}</td>
                    <td class="col-md-3">{{ str_limit($item->description, $limit = 30, $end = '...') }}</td>
                    <td class="col-md-1">
                        <img src="{{url(\App\Team::TEAM_THUMB_DIR . $item->image)}}" alt="Team" width="45" height="45">
                    </td>
                    <td class="col-md-1">{{ ($item->status == 1) ? 'Active' : 'Inactive' }}</td>
                    @can('view_teams', 'edit_teams', 'delete_teams')
                        @include('admin.shared._actions', ['entity' => 'teams', 'id' => $item->id])
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