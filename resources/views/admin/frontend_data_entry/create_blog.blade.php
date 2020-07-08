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
                            blog management
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
                            <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="{{ action('FrontendDataEntry\BlogPostsController@store') }}">
                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                <input type="hidden" id="user_id" name="user_id" value="1"/><label for="user_id">User_id: 1</label>
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="name" name="name" required="required"
                                               class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alias">Alias
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="alias" name="alias" required="required"
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
                                        <input name="keywords" id="tags_1" type="text" class="tags form-control" value="" />
                                        <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="control-label col-md-3 col-sm-3 col-xs-12">Status
                                        <span class="required">*</span></label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <select class="form-control" id="status" name="status" required="required">
                                            <option value="1" selected>On</option>
                                            <option value="0">Off</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Content
                                        <span class="required">*</span>
                                    </label>
                                    <div>
                                        <textarea name="content" class="mytextarea" required="required">Content</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">                                        
                                        <div class="block-image">
                                          <div class="input-append">
                                                <input id="fieldID" type="text" class="form-control pathimage" onchange="getPreviewImg(this);" name="image" value="">
                                                <a href="javascript:open_popup('{{secure_url('filemanager/dialog.php?type=1&popup=1&field_id=fieldID')}}')" class="btn btn-primary iframe-btn" type="button">Select</a>
                                                <img class='img-preview' src= "{{secure_asset('image/unavailable-sm.jpg')}}" style="margin-top:15px;max-height:100px;">
                                          </div>                                           
                                        </div>
                                    </div>
                                </div>

                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <button type="submit" class="btn btn-success">Create</button>
                                        </div>
                                    </div>
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