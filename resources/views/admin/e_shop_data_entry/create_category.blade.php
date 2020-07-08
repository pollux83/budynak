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
                            products categories management
                        </small>
                    </h3>
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
                            <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="{{ action('EShopDataEntry\CategoriesController@store') }}">
                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                <input type="hidden" name="id" value="{{$idCategory}}"/>
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" pattern="[a-z0-9\-]+" for="alias">Alias
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="alias" name="alias" required="required"
                                               class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Parent category
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="category" name="category" required="required">
                                            @foreach($allCategories as $allCategory)
                                                 <option value="{{ $allCategory->id }}">{{ $allCategory->name }}
                                                    (id:{{ $allCategory->id }})
                                                 </option>
                                            @endforeach
                                                <option value="{{ $idCategory }}" selected>It's a parent</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu">Menu
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="menu" name="menu" required="required">
                                            @foreach($menus as $key => $menu)
                                                    <option value="{{ $menu->id }}">{{ $menu->name }}
                                                        (id:{{ $menu->id }})
                                                    </option>
                                            @endforeach
                                                <option value="null" selected>none</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sort">Sort
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="number" id="sort" name="sort" required="required"
                                               class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="brand" class="control-label col-md-3 col-sm-3 col-xs-12">Brand
                                        <span class="required">*</span></label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <select class="form-control" id="brand" name="brand" required="required">
                                            <option value="1" selected>Yes</option>
                                            <option value="0">No</option>
                                        </select>
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
                                        <img class='img-preview' src= "{{secure_asset('image/unavailable-sm.jpg')}}" style="margin-top:15px;max-height:100px;">
                                    </div>
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <a class="btn btn-primary" href="{{ secure_url('admin/categories') }}">Back</a>
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