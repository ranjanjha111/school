{{--'danger', 'warning', 'success', 'info'--}}
@foreach (['danger', 'success'] as $key)
    @if(session()->has($key))
        <div class="alert alert-{{$key}} alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            {{session()->get($key)}}
        </div>
    @endif
@endforeach