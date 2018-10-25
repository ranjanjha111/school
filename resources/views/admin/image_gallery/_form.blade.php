<div class="form-group @if ($errors->has('school_id')) has-error @endif">
    {!! Form::label('school_id', 'School *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{Form::select('school_id', $schoolList, null, ['class'=>'form-control'])}}
        @if ($errors->has('school_id')) <p class="help-block">{{ $errors->first('school_id') }}</p> @endif
    </div>
</div>


@foreach(request()->session()->get('languages') as $key => $lang)
    <div class="form-group @if ($errors->has($key . '_title')) has-error @endif">
        {!! Form::label('title', 'Title *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
        <div class="col-md-6 col-sm-6 col-xs-12">
            {!! Form::text($key . '_title', isset($gallery->id) ? old($key . '_title', $gallery->translate($key)->title) : null, ['class' => 'form-control', 'placeholder'=>'Enter title']) !!}
            @if ($errors->has($key . '_title')) <p class="help-block">{{ $errors->first($key . '_title') }}</p> @endif
        </div>
        <div class='control-label col-md-3 col-sm-3 col-xs-3'>
            <img src="{{ $lang['flag'] }}" class="pull-left img-responsive" alt="{{$lang['name']}} Flag" width="25" height="20">
        </div>
    </div>
@endforeach

<div class="form-group @if ($errors->has('image')) has-error @endif">
    {!! Form::label('image', 'Image', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-3 col-sm-3 col-xs-12">
        {!! Form::file('image', null, ['class' => 'form-control', 'placeholder'=>'Select image']) !!}
        @if ($errors->has('image')) <p class="help-block">{{ $errors->first('image') }}</p> @endif
    </div>
    @if(isset($gallery->image) && $gallery->image != '')
        @if(file_exists( public_path(\App\ImageGallery::THUMB_DIR  . $gallery->image)) && $gallery->image != '')
            <div class="col-md-3 col-sm-3 col-xs-12">
                <img src="{{ url(\App\ImageGallery::THUMB_DIR  . $gallery->image) }}" class="pull-right img-responsive" alt="Featured Image" width="150" height="150">
            </div>
        @endif
    @endif
</div>

<div class="form-group @if ($errors->has('status')) has-error @endif">
    {!! Form::label('status', 'Status *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{Form::select('status', $status, null, ['class'=>'form-control'])}}
        @if ($errors->has('status')) <p class="help-block">{{ $errors->first('status') }}</p> @endif
    </div>
</div>