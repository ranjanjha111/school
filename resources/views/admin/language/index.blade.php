@extends('admin.layouts.layout')

@section('adminHeadCSS')
<!-- iCheck -->
<link href="{{ asset('admin/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
@endsection

@section('adminContent')

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>List Language <small></small></h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
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
                    <div class="x_content">
                        <div class="table-responsive">
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">Id</th>
                                        <th class="column-title">Name</th>
                                        <th class="column-title">Code</th>
                                        <th class="column-title">Flag</th>
                                        <th class="column-title">Default</th>
                                        @can('view_users', 'edit_users', 'delete_users')
                                        <th class="column-title text-center">Actions</th>
                                        @endcan
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($result as $key => $language)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $language->name }}</td>
                                        <td>{{ $language->code }}</td>
                                        <td><img src="{{url(\App\Language::LANGUAGE_THUMB_DIR . $language->flag)}}" alt="Language Flag"></td>
                                        <td>{{ $language->is_default }}</td>
                                        @can('view_users', 'edit_users', 'delete_users')
                                        <td class="text-center">
                                            @can('view_users')
                                            <a href="{{ route('languages.show', [str_singular('users') => $language->id])  }}" class="btn btn-xs btn-primary">
                                                <i class="fa fa-folder"></i> View</a>
                                            @endcan
                                            @can('edit_users')
                                            <a href="{{ route('languages.edit', [str_singular('users') => $language->id])  }}" class="btn btn-xs btn-info">
                                                <i class="fa fa-edit"></i> Edit</a>
                                            @endcan
                                            @can('delete_users')
                                            {!! Form::open( ['method' => 'delete', 'url' => route('languages.destroy', ['user' => $language->id]), 'style' => 'display: inline', 'onSubmit' => 'return confirm("Are yous sure wanted to delete it?")']) !!}
                                            <button type="submit" class="btn btn-xs btn-danger">
                                                <i class="fa fa-trash-o"> Delete</i>
                                            </button>
                                            {!! Form::close() !!}
                                            @endcan
                                        </td>
                                        @endcan
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="text-right">
                                {{ $result->render() }}
                            </div>
                        </div>
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
@endsection