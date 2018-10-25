<div class="form-group @if ($errors->has('code')) has-error @endif">
    {!! Form::label('code', 'School Code', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-2 col-sm-2 col-xs-12">
        {!! Form::text('code', null, ['class' => 'form-control']) !!}
        @if ($errors->has('code')) <p class="help-block">{{ $errors->first('code') }}</p> @endif
    </div>
</div>

@foreach(request()->session()->get('languages') as $key => $lang)
    <div class="form-group @if ($errors->has($key . '_name')) has-error @endif">
        {!! Form::label('name', 'Name *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
        <div class="col-md-6 col-sm-6 col-xs-12">
            {!! Form::text($key . '_name', isset($school->id) ? old($key . '_name', $school->translate($key)->name) : null, ['class' => 'form-control', 'placeholder'=>'Enter school name']) !!}
            @if ($errors->has($key . '_name')) <p class="help-block">{{ $errors->first($key . '_name') }}</p> @endif
        </div>
        <div class='control-label col-md-3 col-sm-3 col-xs-3'>
            <img src="{{ $lang['flag'] }}" class="pull-left img-responsive" alt="{{$lang['name']}} Flag" width="25" height="20">
        </div>
    </div>
@endforeach

<div class="form-group @if ($errors->has('state_id')) has-error @endif">
    {!! Form::label('state_id', 'State *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{Form::select('state_id', $stateList, null, ['class'=>'form-control', 'id' => 'state'])}}
        @if ($errors->has('state_id')) <p class="help-block">{{ $errors->first('state_id') }}</p> @endif
    </div>
</div>

<div class="form-group @if ($errors->has('city_id')) has-error @endif">
    {!! Form::label('city_id', 'City *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{Form::select('city_id',  $city_id, null, ['class'=>'form-control', 'id' => 'city'])}}
        @if ($errors->has('city_id')) <p class="help-block">{{ $errors->first('city_id') }}</p> @endif
    </div>
</div>

@foreach(request()->session()->get('languages') as $key => $lang)
    <div class="form-group @if ($errors->has($key . '_locality')) has-error @endif">
        {!! Form::label('locality', 'Locality *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
        <div class="col-md-6 col-sm-6 col-xs-12">
            {!! Form::textarea($key . '_locality', isset($school->id) ? old($key . '_locality', $school->translate($key)->locality) : null, ['class' => 'form-control', 'placeholder'=>'Enter locality', 'rows'=> '4']) !!}
            @if ($errors->has($key . '_locality')) <p class="help-block">{{ $errors->first($key . '_locality') }}</p> @endif
        </div>
        <div class='control-label col-md-3 col-sm-3 col-xs-3'>
            <img src="{{ $lang['flag'] }}" class="pull-left img-responsive" alt="{{$lang['name']}} Flag" width="25" height="20">
        </div>
    </div>
@endforeach

@foreach(request()->session()->get('languages') as $key => $lang)
    <div class="form-group @if ($errors->has($key . '_address')) has-error @endif">
        {!! Form::label('address', 'Address *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
        <div class="col-md-6 col-sm-6 col-xs-12">
            {!! Form::textarea($key . '_address', isset($school->id) ? old($key . '_address', $school->translate($key)->address) : null, ['class' => 'form-control', 'placeholder'=>'Enter address', 'rows'=> '4']) !!}
            @if ($errors->has($key . '_address')) <p class="help-block">{{ $errors->first($key . '_address') }}</p> @endif
        </div>
        <div class='control-label col-md-3 col-sm-3 col-xs-3'>
            <img src="{{ $lang['flag'] }}" class="pull-left img-responsive" alt="{{$lang['name']}} Flag" width="25" height="20">
        </div>
    </div>
@endforeach

@foreach(request()->session()->get('languages') as $key => $lang)
    <div class="form-group @if ($errors->has($key . '_near_by')) has-error @endif">
        {!! Form::label('near_by', 'Near By', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
        <div class="col-md-6 col-sm-6 col-xs-12">
            {!! Form::textarea($key . '_near_by', isset($school->id) ? old($key . '_near_by', $school->translate($key)->near_by) : null, ['class' => 'form-control', 'placeholder'=>'Enter near by location', 'rows'=> '4']) !!}
            @if ($errors->has($key . '_near_by')) <p class="help-block">{{ $errors->first($key . '_near_by') }}</p> @endif
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
    @if(isset($school->image) && $school->image != '')
        @if(file_exists( public_path(\App\School::THUMB_DIR  . $school->image)) && $school->image != '')
            <div class="col-md-3 col-sm-3 col-xs-12">
                <img src="{{ url(\App\School::THUMB_DIR  . $school->image) }}" class="pull-right img-responsive" alt="School Image" width="150" height="150">
            </div>
        @endif
    @endif
</div>

<div class="form-group @if ($errors->has('email')) has-error @endif">
    {!! Form::label('email', 'Email *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
        @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
    </div>
</div>

<div class="form-group @if ($errors->has('mobile')) has-error @endif">
    {!! Form::label('mobile', 'Mobile *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
        @if ($errors->has('mobile')) <p class="help-block">{{ $errors->first('mobile') }}</p> @endif
    </div>
</div>

<div class="form-group @if ($errors->has('fax')) has-error @endif">
    {!! Form::label('fax', 'Fax', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('fax', null, ['class' => 'form-control']) !!}
        @if ($errors->has('fax')) <p class="help-block">{{ $errors->first('fax') }}</p> @endif
    </div>
</div>

<div class="form-group @if ($errors->has('status')) has-error @endif">
    {!! Form::label('status', 'Status *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{Form::select('status', $status, null, ['class'=>'form-control'])}}
        @if ($errors->has('status')) <p class="help-block">{{ $errors->first('status') }}</p> @endif
    </div>
</div>