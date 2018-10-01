<div class="form-group @if ($errors->has('name')) has-error @endif">
    {!! Form::label('name', 'Name *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
    {!! Form::text('name', null, ['class' => 'form-control', 'required'=>'required']) !!}
    @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
    </div>
</div>

<div class="form-group @if ($errors->has('code')) has-error @endif">
    {!! Form::label('name', 'Code *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('code', null, ['class' => 'form-control', 'required'=>'required']) !!}
        @if ($errors->has('code')) <p class="help-block">{{ $errors->first('code') }}</p> @endif
    </div>
</div>

<div class="form-group @if ($errors->has('flag')) has-error @endif">
    {!! Form::label('name', 'Language Flag *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-3 col-sm-3 col-xs-12">
        {!! Form::file('flag', null, ['class' => 'form-control', 'placeholder'=>'Upload language flag']) !!}
        @if ($errors->has('flag')) <p class="help-block">{{ $errors->first('flag') }}</p> @endif
    </div>
    @if(isset($language->flag) && $language->flag != '')
        @if(file_exists( public_path(\App\Language::LANGUAGE_THUMB_DIR  . $language->flag)) && $language->flag != '')
            <div class="col-md-3 col-sm-3 col-xs-12">
                <img src="{{ url(\App\Language::LANGUAGE_THUMB_DIR . $language->flag) }}" class="pull-right img-responsive" alt="Language Flag" width="25" height="20">
            </div>
        @else
            <img src="{{ url('images/default.png') }}" alt="Language Flag" width="25" height="20">
        @endif
    @endif
</div>

<div class="form-group @if ($errors->has('is_default')) has-error @endif">
    {!! Form::label('name', 'Is Default', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::checkbox('is_default', '1', null) !!}
        @if ($errors->has('is_default')) <p class="help-block">{{ $errors->first('is_default') }}</p> @endif
    </div>
</div>

<div class="form-group @if ($errors->has('status')) has-error @endif">
    {!! Form::label('status', 'Status', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        <select name="status" class="form-control">
            <option value="1" {{ @$galllery->status == "1" ? 'selected="selected"' : '' }} >Active</option>
            <option value="0" {{ @$galllery->status == "0" ? 'selected="selected"' : '' }} >Inactive</option>
        </select>
        @if ($errors->has('status')) <p class="help-block">{{ $errors->first('status') }}</p> @endif
    </div>
</div>