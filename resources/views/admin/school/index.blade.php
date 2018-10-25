@extends('admin.layouts.layout')

@section('adminHeadCSS')
<!-- iCheck -->
<link href="{{ asset('admin/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
@endsection

@section('adminContent')

    <div class="right_col" role="main">
        <div class="page-title">
            <div class="title_left">
                <h3>List School<small></small></h3>
            </div>

            <div class="title_right">
                <div class="col-md-8 col-sm-8 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        {!! Form::text('search', null, ['class' => 'form-control', 'id' => 'search', 'placeholder' => 'Search by name']) !!}

                        <span class="input-group-btn">
                            <button class="btn btn-default" id="searchButton" type="button">Go!</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        {{--Notification Message--}}
        @include('admin.layouts.message')

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    @include('admin.school.load')

                </div>
            </div>
        </div>
    </div>
@endsection

@section('adminFooterScript')
    <!-- iCheck -->
    <script src="{{ asset('admin/vendors/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection