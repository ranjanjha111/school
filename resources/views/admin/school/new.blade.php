@extends('admin.layouts.layout')

@section('adminHeadCSS')
@endsection

@section('adminContent')

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Add School</h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group" style='float:right;'>
                        <a href="{{ route('schools.index') }}" class="btn btn-primary"> List School</a>
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
                    {{--<div class="x_content">--}}
                        {{--<br/>--}}

                        {{--{!! Form::open(['route' => ['schools.store'], 'class' => 'form-horizontal form-label-left', 'enctype'=>'multipart/form-data']) !!}--}}
                        {{--@include('admin.school._form')--}}

                        {{--<!-- Submit Form Button -->--}}
                        {{--<div class="ln_solid"></div>--}}
                        {{--<div class="form-group">--}}
                            {{--<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">--}}
                                {{--{!! Form::submit('Create', ['class' => 'btn btn-success']) !!}--}}
                                {{--{!! Form::reset('Reset', ['class' => 'btn btn-primary']) !!}--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--{!! Form::close() !!}--}}

                    {{--</div>--}}

                    <div class="col-md-3">
                        <div class="thumbnail" style="height: auto">
                                <img src="{{ url(\App\School::THUMB_DIR . '1539414880.png') }}" class="img-responsive" alt="Team Image" width="150" height="150">
                            <div class="text-center">
                                <h5>
                                    Wells International School
                                    <small>demoschool@gmail.com</small>
                                </h5>
                            </div>
                        </div>


                    </div>
                    <div class="col-md-9">

                    </div>


                </div>
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