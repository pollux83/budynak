@extends('admin.layouts.layout')

@section('title', 'Page Title')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>
                        EDIT
                        <small>
                            products categories management
                        </small>
                    </h3>
                </div>

                
            </div>
            <div class="clearfix"></div>

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">

                        <div class="x_content">
                            @if(Session::has('message'))
                                <p><b><span id="flash-message">{{  Session::get('message') }}!</span></b></p>
                            @endif
                            <br/>
                            <form method="post" id="demo-form2" data-parsley-validate
                                  class="form-horizontal form-label-left"
                                  action="{{ action('EShopDataEntry\CategoriesController@update',['category' => $category->id]) }}">
                                <input type="hidden" name="_method" value="PUT"/>
                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                <input type="hidden" name="id" value="{{$category->id}}"/>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="name" name="name" required="required"
                                               class="form-control col-md-7 col-xs-12" value="{{ $category->name }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alias">Alias
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="alias" name="alias" pattern="[a-z0-9\-]+" required="required"
                                               class="form-control col-md-7 col-xs-12" value="{{ $uri[0]->alias }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="category" class="control-label col-md-3 col-sm-3 col-xs-12">Parent category
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="category" name="category" required="required">
                                            @foreach($allCategories as $allCategory)
                                                @if($allCategory->id == $category->category)
                                                    <option value="{{ $allCategory->id }}" selected>{{ $allCategory->name }}
                                                        (id:{{ $allCategory->id }})
                                                    </option>
                                                @else
                                                    <option value="{{ $allCategory->id }}">{{ $allCategory->name }}
                                                        (id:{{ $allCategory->id }})
                                                    </option>
                                                @endif
                                            @endforeach
                                                @if($category->category == null)
                                                    <option value="" selected>none</option>
                                                @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="menu" class="control-label col-md-3 col-sm-3 col-xs-12">Menu
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select id="menu" class="form-control" name="menu" required="required">
                                            @foreach($menus as $menu)
                                                @if($category->menu == $menu->id)
                                                    <option value="{{ $menu->id }}" selected>{{ $menu->name }}
                                                        (id:{{ $menu->id }})
                                                    </option>
                                                @else
                                                    <option value="{{ $menu->id }}">{{ $menu->name }}
                                                        (id:{{ $menu->id }})
                                                    </option>
                                                @endif
                                            @endforeach
                                            @if($category->menu == null)
                                                    <option value="null" selected>none</option>
                                                @else
                                                    <option value="null">none</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sort">Sort
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="number" id="sort" name="sort" required="required"
                                               class="form-control col-md-7 col-xs-12" value="{{ $category->sort }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="brand" class="control-label col-md-3 col-sm-3 col-xs-12">Brand
                                        <span class="required">*</span></label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <select class="form-control" id="brand" name="brand" required="required">
                                            @if($category->brand == 1)
                                                <option value="1" selected>Yes</option>
                                                <option value="0">No</option>
                                            @else
                                                <option value="1">Yes</option>
                                                <option value="0" selected>No</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="control-label col-md-3 col-sm-3 col-xs-12">Status
                                        <span class="required">*</span></label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <select class="form-control" id="status" name="status" required="required">
                                            @if($category->status == 1)
                                            <option value="1" selected>On</option>
                                            <option value="0">Off</option>
                                                @else
                                                <option value="1">On</option>
                                                <option value="0" selected>Off</option>
                                            @endif
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
                                                   name="image" value="{{ $category->image }}">
                                        </div>
                                        <img class='img-preview' style="margin-top:15px;max-height:100px;" src="{{secure_asset('image/'.$category->image)}}" style="margin-top:15px;max-height:100px;">
                                    </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="submit" class="btn btn-success">Update</button>
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