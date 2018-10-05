@foreach(request()->session()->get('languages') as $key => $lang)
    <div class="form-group @if ($errors->has($key . '_name')) has-error @endif">
        {!! Form::label('name', 'Name *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
        <div class="col-md-6 col-sm-6 col-xs-12">
            {!! Form::text($key . '_name', isset($team->id) ? old($key . '_name', $team->translate($key)->name) : null, ['class' => 'form-control', 'placeholder'=>'Enter Name']) !!}
            @if ($errors->has($key . '_name')) <p class="help-block">{{ $errors->first($key . '_name') }}</p> @endif
        </div>
        <div class='control-label col-md-3 col-sm-3 col-xs-3'>
            <img src="{{ $lang['flag'] }}" class="pull-left img-responsive" alt="{{$lang['name']}} Flag" width="25" height="20">
        </div>
    </div>
@endforeach

@foreach(request()->session()->get('languages') as $key => $lang)
    <div class="form-group @if ($errors->has($key . '_profile_heading')) has-error @endif">
        {!! Form::label('name', 'Profile Heading *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
        <div class="col-md-6 col-sm-6 col-xs-12">
            {!! Form::text($key . '_profile_heading', isset($team->id) ? old($key . '_profile_heading', $team->translate($key)->profile_heading) : null, ['class' => 'form-control', 'placeholder'=>'Enter Profile Heading']) !!}
            @if ($errors->has($key . '_profile_heading')) <p class="help-block">{{ $errors->first($key . '_profile_heading') }}</p> @endif
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
            {!! Form::textarea($key . '_description', isset($team->id) ? old($key . '_description', $team->translate($key)->description) : null, ['class' => 'form-control', 'placeholder'=>'Enter Description', 'rows'=> '4']) !!}
            @if ($errors->has($key . '_description')) <p class="help-block">{{ $errors->first($key . '_description') }}</p> @endif
        </div>
        <div class='control-label col-md-3 col-sm-3 col-xs-3'>
            <img src="{{ $lang['flag'] }}" class="pull-left img-responsive" alt="{{$lang['name']}} Flag" width="25" height="20">
        </div>
    </div>
@endforeach

<div class="form-group @if ($errors->has('image')) has-error @endif">
    {!! Form::label('image', 'Image', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-3 col-sm-3 col-xs-12">
        {!! Form::file('image', null, ['class' => 'form-control', 'placeholder'=>'Enter Profile Image']) !!}
        @if ($errors->has('image')) <p class="help-block">{{ $errors->first('image') }}</p> @endif
    </div>
    @if(isset($team->image) && $team->image != '')
        @if(file_exists( public_path(\App\Team::TEAM_THUMB_DIR  . $team->image)) && $team->image != '')
            <div class="col-md-3 col-sm-3 col-xs-12">
                <img src="{{ url(\App\Team::TEAM_THUMB_DIR  . $team->image) }}" class="pull-right img-responsive" alt="Team Image" width="150" height="150">
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
