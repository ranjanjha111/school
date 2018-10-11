<div class="form-group @if ($errors->has('name')) has-error @endif">
    {!! Form::label('name', 'Name *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('name', null, ['class' => 'form-control', 'required'=>'required']) !!}
        @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
    </div>
</div>

<div class="form-group @if ($errors->has('menu_id')) has-error @endif">
    {!! Form::label('menu_id', 'Parent Menu *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{Form::select('menu_id', $menu_id, null, ['class'=>'form-control'])}}
        @if ($errors->has('menu_id')) <p class="help-block">{{ $errors->first('menu_id') }}</p> @endif
    </div>
</div>

<div class="form-group @if ($errors->has('permission_id')) has-error @endif">
    {!! Form::label('permission_id', 'Permission *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{Form::select('permission_id', $permission_id, null, ['class'=>'form-control'])}}
        @if ($errors->has('permission_id')) <p class="help-block">{{ $errors->first('permission_id') }}</p> @endif
    </div>
</div>

<div class="form-group @if ($errors->has('menu_order')) has-error @endif">
    {!! Form::label('menu_order', 'Order', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-2 col-sm-2 col-xs-12">
        {!! Form::text('menu_order', null, ['class' => 'form-control']) !!}
        @if ($errors->has('menu_order')) <p class="help-block">{{ $errors->first('menu_order') }}</p> @endif
    </div>
</div>

<div class="form-group @if ($errors->has('status')) has-error @endif">
    {!! Form::label('status', 'Status *', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{Form::select('status', $status, null, ['class'=>'form-control'])}}
        @if ($errors->has('status')) <p class="help-block">{{ $errors->first('status') }}</p> @endif
    </div>
</div>