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
                            products value management
                        </small>
                    </h3>
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

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">

                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Settings 1</a>
                                        </li>
                                        <li><a href="#">Settings 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            @if(Session::has('message'))
                                <p><b><span id="flash-message">{{  Session::get('message') }}!</span></b></p>
                            @endif
                            <br/>
                            <form method="post" id="demo-form2" data-parsley-validate
                                  class="form-horizontal form-label-left"
                                  action="{{ action('EShopDataEntry\ValuesController@store') }}">
                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="name" id="name" required="required"
                                               class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Option
                                        <span class="required">*</span></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <select class="form-control" name="option_id" required="required">
                                            @foreach($options as $option)
                                                <option value={{ $option->id }}>{{ $option->name }} (id:{{ $option->id }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sort_order">Sort
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="number" min="0" name="sort_order" id="sort_order" required="required"
                                               class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <!--block upload image -->
                                <div class="x_panel">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="input-group block-image">
                                          <span class="input-group-btn">
                                            <a href="javascript:open_popup('{{secure_url('filemanager/dialog.php?type=1&popup=1&field_id=fieldID')}}')" class="btn btn-primary pathimage">
                                              <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                          </span>
                                            <input id="fieldID" type="text" class="form-control pathimage" onchange="getPreviewImg(this);"
                                                   name="image"  value="">
                                        </div>
                                        <img class='img-preview' src= "{{asset('image/unavailable-sm.jpg')}}" style="margin-top:15px;max-height:100px;">
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <a class="btn btn-primary" href="{{ secure_url('admin/values') }}">Back</a>
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