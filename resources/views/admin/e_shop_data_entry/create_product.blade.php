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
                            products brands management
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
                            <form method="post" id="demo-form2"
                                  class="form-horizontal form-label-left"
                                  action="{{ secure_url('admin/products/create') }}">
                                <input type="hidden" name="_method" value="PUT"/>
                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                <input type="hidden" name="product_id" value="{{ $idProduct }}"/>
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Title
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="title" id="title" required="required"
                                               class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alias">Alias
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="alias" id="alias" pattern="[a-z0-9\-]+" required="required"
                                               class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">Price
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="number" id="price" name="price" step="any" required="required"
                                               class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Brand
                                        <span class="required">*</span></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <select class="form-control" name="brand_id" required="required">
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}(id:{{ $brand->id }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Category
                                        <span class="required">*</span></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <select class="select2_multiple form-control" multiple="multiple" name="category_id[]" required="required">
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}
                                                (id:{{ $category->id }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status
                                        <span class="required">*</span></label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <select class="form-control" name="status" required="required">
                                            <option value="1">On</option>
                                            <option value="0">Off</option>
                                        </select>
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Meta description <span class="required">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <textarea name="meta_description" class="form-control" rows="3" required="required"></textarea>
                                    </div>
                                </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="discount">Discount </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="discount" name="discount"
                                           class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Date End </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="date_end" name="date_end" class="date-picker form-control col-md-7 col-xs-12" type="date">
                                </div>
                            </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Start </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="date_start" name="date_start" class="date-picker form-control col-md-7 col-xs-12" type="date" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea name="description" class="mytextarea" required="required"></textarea>
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
                                                   name="filepath[]"  value="">
                                        </div>
                                        <img class='img-preview' src= "{{secure_asset('image/unavailable-sm.jpg')}}" style="margin-top:15px;max-height:100px;">
                                    </div>
                                </div>

                                <div class="form-inline">
                                    <div class="ln_solid"></div>
                                    <h4>Additional image</h4>
                                </div>
                                <button class="btn btn-primary add_images" type="button"><i
                                            class="glyphicon glyphicon-plus"></i></button>
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
    </div>

    </div>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->                  
    <!-- footer content -->
    @include('admin.layouts.footer')
    <!-- /footer content -->
    <!-- /page content -->
<div class="modal fade" class="myModal" style="margin-left: -350px;">
<div class="modal-dialog">
  <div class="modal-content" style="width: 780px">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">Modal title</h4>
    </div>
    <div class="modal-body" style="padding:0px; margin:0px; width: 700px;">
      <iframe  width="765" height="550" frameborder="0"
                                                    src="" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; ">
                                                </iframe>
@endsection