@extends('admin.layouts.layout')

@section('adminHeadCSS')
@endsection

@section('adminContent')

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Edit Language</h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group" style='float:right;'>
                        <a href="{{ route('languages.index') }}" class="btn btn-primary">List Language</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <br />

                        {!! Form::model($language, ['method' => 'PUT', 'route' => ['languages.update',  $language->id ], 'class' => 'form-horizontal form-label-left', 'enctype'=>'multipart/form-data']) !!}
                            @include('admin.language._form')
                            <!-- Submit Form Button -->
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    {!! Form::submit('Update', ['class' => 'btn btn-success']) !!}
                                    {!! Form::reset('Reset', ['class' => 'btn btn-primary']) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                        
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection