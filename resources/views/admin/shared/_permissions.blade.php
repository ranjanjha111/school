<div class="table-responsive">
    <table class="table table-striped bulk_action">
        <thead>
        <tr>
            <th class="col-md-1">#</th>
            <th class="col-md-3">Name</th>
            <th class="col-md-2"><label style="color:#337ab7">View</label></th>
            <th class="col-md-2"><label style="color:#337ab7">Add</label></th>
            <th class="col-md-2"><label style="color:#337ab7">Edit</label></th>
            <th class="col-md-2"><label style="color:#337ab7">Delete</label></th>
        </tr>
        </thead>
        <tbody>

        <?php
        $index = 0;
        ?>
        @foreach($permissions as $key => $permission)
            <?php
            $per_found = null;
            if (isset($role)) {
                $per_found = $role->hasPermissionTo($permission->name);
            }
            if (isset($user)) {
                $per_found = $user->hasDirectPermission($permission->name);
            }

            ?>

            @if($key % 4 === 0 || $index === 0)
                <tr>
                    <td class="col-md-1">{{ ++$index }}</td>
                    <td class="col-md-3">{{ $permission->name }}</td>
                    @endif
                    <td class="col-md-2">
                        @if(isset($id))
                            @if($per_found)
                                <i class="fa fa-check" style="font-size: 18px; color:#3CB371"></i>
                            @else
                                <i class="fa fa-close" style="font-size: 18px; color:#cc0000"></i>
                            @endif
                        @else
                            <div class="checkbox">
                                {!! Form::checkbox("permissions[]", $permission->name, $per_found, ['class'=>'flat']) !!}
                            </div>
                        @endif
                    </td>

                    @if(($key + 1) % 4 === 0)
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>