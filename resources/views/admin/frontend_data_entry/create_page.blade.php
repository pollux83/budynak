@extends('admin.layouts.layout')

@section('title', 'Page Title')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>
                        CREATE
                        <small>
                            page management
                        </small>
                    </h3>
                </div>

                
            <div class="clearfix"></div>

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">

                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            @if(Session::has('message'))
                                <p><b><span id="flash-message">{{  Session::get('message') }}!</span></b></p>
                            @endif
                            <br/>
                            <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="{{ action('FrontendDataEntry\PagesController@store') }}">
                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                <input type="hidden" name="user_id" value="1"/>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        @if(count($categories) === 0)
                                            <p><b><span id="flash-message">New Category hasn't. Please add new category!</span></b></p>
                                        @else
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">ID
                                                <span class="required">*</span>
                                            </label>
                                            <select name="id" id="id">
                                                @foreach($categories as $id => $category)
                                                    @if($id === 0)
                                                        <option value="{{ $category->id }}" selected="">{{ $category->id }}: {{ $category->name }}</option>
                                                    @else
                                                        <option value="{{ $category->id }}">{{ $category->id }}: {{ $category->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name
                                            <span class="required">*</span>
                                        </label>
                                        <select name="name" id="name">
                                            @foreach($categories as $id => $category)
                                                @if($id === 0)
                                                    <option value="{{ $category->name }}" selected="">{{ $category->name }}</option>
                                                @else
                                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Title
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="title" name="title" required="required"
                                               class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Meta description <span class="required">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <textarea name="meta_description" class="form-control" rows="3" required="required"></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Keywords
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input name="keywords" id="tags_1" type="text" class="tags form-control" />
                                        <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Content
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <textarea name="content" class="mytextarea" required="required">Content</textarea>
                                    </div>
                                </div>
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <button type="submit" class="btn btn-success">Create</button>
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

                <br/>
                <br/>
                <br/>

            </div>
        </div>
        <!-- footer content -->
    @include('admin.layouts.footer')
    <!-- /footer content -->

    </div>
    <!-- /page content -->

@endsection