@foreach(request()->session()->get('languages') as $key => $lang)
    <div class="form-group @if ($errors->has($key . '_name')) has-error @endif">
        {!! Form::label('name', 'Name *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
        <div class="col-md-6 col-sm-6 col-xs-12">
            {!! Form::text($key . '_name', isset($standard->id) ? old($key . '_name', $standard->translate($key)->name) : null, ['class' => 'form-control', 'placeholder'=>'Enter Name']) !!}
            @if ($errors->has($key . '_name')) <p class="help-block">{{ $errors->first($key . '_name') }}</p> @endif
        </div>
        <div class='control-label col-md-3 col-sm-3 col-xs-3'>
            <img src="{{ $lang['flag'] }}" class="pull-left img-responsive" alt="{{$lang['name']}} Flag" width="25" height="20">
        </div>
    </div>
@endforeach

@foreach(request()->session()->get('languages') as $key => $lang)
    <div class="form-group @if ($errors->has($key . '_description')) has-error @endif">
        {!! Form::label('name', 'Description *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
        <div class="col-md-6 col-sm-6 col-xs-12">
            {!! Form::textarea($key . '_description', isset($standard->id) ? old($key . '_description', $standard->translate($key)->description) : null, ['class' => 'form-control', 'placeholder'=>'Enter Description', 'rows'=> '4']) !!}
            @if ($errors->has($key . '_description')) <p class="help-block">{{ $errors->first($key . '_description') }}</p> @endif
        </div>
        <div class='control-label col-md-3 col-sm-3 col-xs-3'>
            <img src="{{ $lang['flag'] }}" class="pull-left img-responsive" alt="{{$lang['name']}} Flag" width="25" height="20">
        </div>
    </div>
@endforeach

<div class="form-group @if ($errors->has('banner')) has-error @endif">
    {!! Form::label('banner', 'Banner *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-3 col-sm-3 col-xs-12">
        {!! Form::file('banner', null, ['class' => 'form-control', 'placeholder'=>'Select banner']) !!}
        @if ($errors->has('banner')) <p class="help-block">{{ $errors->first('banner') }}</p> @endif
    </div>
    @if(isset($standard->banner) && $standard->banner != '')
        @if(file_exists( public_path(\App\Standard::THUMB_DIR  . $standard->banner)) && $standard->banner != '')
            <div class="col-md-3 col-sm-3 col-xs-12">
                <img src="{{ url(\App\Standard::THUMB_DIR  . $standard->banner) }}" class="pull-right img-responsive" alt="Featured banner" width="150" height="150">
            </div>
        @endif
    @endif
</div>

<div class="form-group @if ($errors->has('age_from')) has-error @endif">
    {!! Form::label('age_from', 'Age from *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('age_from', null, ['class' => 'form-control', 'required'=>'required']) !!}
        @if ($errors->has('age_from')) <p class="help-block">{{ $errors->first('age_from') }}</p> @endif
    </div>
</div>

<div class="form-group @if ($errors->has('age_to')) has-error @endif">
    {!! Form::label('age_to', 'Age to *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('age_to', null, ['class' => 'form-control', 'required'=>'required']) !!}
        @if ($errors->has('age_to')) <p class="help-block">{{ $errors->first('age_to') }}</p> @endif
    </div>
</div>

<div class="form-group @if ($errors->has('time_from')) has-error @endif">
    {!! Form::label('time_from', 'Time from', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('time_from', null, ['class' => 'form-control']) !!}
        @if ($errors->has('time_from')) <p class="help-block">{{ $errors->first('time_from') }}</p> @endif
    </div>
</div>

<div class="form-group @if ($errors->has('time_to')) has-error @endif">
    {!! Form::label('time_to', 'Time to', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('time_to', null, ['class' => 'form-control']) !!}
        @if ($errors->has('time_to')) <p class="help-block">{{ $errors->first('time_to') }}</p> @endif
    </div>
</div>

<div class="form-group @if ($errors->has('size')) has-error @endif">
    {!! Form::label('size', 'Size *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('size', null, ['class' => 'form-control']) !!}
        @if ($errors->has('size')) <p class="help-block">{{ $errors->first('size') }}</p> @endif
    </div>
</div>

<div class="form-group @if ($errors->has('status')) has-error @endif">
    {!! Form::label('status', 'Status *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{Form::select('status', $status, null, ['class'=>'form-control'])}}
        @if ($errors->has('status')) <p class="help-block">{{ $errors->first('status') }}</p> @endif
    </div>
</div>