{{--@can('edit_'.$entity)--}}
    {{--<a href="{{ route($entity.'.edit', [str_singular($entity) => $id])  }}" class="btn btn-xs btn-info">--}}
        {{--<i class="fa fa-edit"></i> Edit</a>--}}
{{--@endcan--}}

{{--@can('delete_'.$entity)--}}
    {{--{!! Form::open( ['method' => 'delete', 'url' => route($entity.'.destroy', ['user' => $id]), 'style' => 'display: inline', 'onSubmit' => 'return confirm("Are yous sure wanted to delete it?")']) !!}--}}
        {{--<button type="submit" class="btn-delete btn btn-xs btn-danger">--}}
            {{--<i class="glyphicon glyphicon-trash"></i>--}}
        {{--</button>--}}
    {{--{!! Form::close() !!}--}}
{{--@endcan--}}



<td class="text-center col-md-3">
    {{--<a href="{{ route('activities.show', [str_singular('activies') => $item->id])  }}" class="btn btn-xs btn-default">--}}
    {{--<i class="fa fa-eye"></i>View--}}
    {{--</a>--}}
    @can('view_' . $entity)
        <button type="button" class="btn btn-xs btn-default viewBtn" view-modal-class="view-modal-{{$id}}" view-id="{{$id}}">
            <i class="fa fa-eye"> View</i>
        </button>
    @endcan

    @can('edit_' . $entity)
        <a href="{{route($entity . '.edit', ['id' => $id ])}}" class="btn btn-xs btn-info">
            <i class="fa fa-edit"></i> Edit</a>
    @endcan

    @can('delete_' . $entity)
        {!! Form::open( ['method' => 'delete', 'url' => route($entity . '.destroy', ['id' => $id]), 'style' => 'display: inline']) !!}
        <button type="button" class="btn btn-xs btn-danger deleteBtn" delete-modal-class="delete-modal-{{$id}}">
            <i class="fa fa-trash-o"> Delete</i>
        </button>

        <div class="modal fade delete-modal-{{$id}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Delete</h4>
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
