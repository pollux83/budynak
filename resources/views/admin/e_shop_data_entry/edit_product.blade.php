@extends('admin.layouts.layout')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>
                        @if($newId)
                        CREATE
                        @else
                        EDIT
                        @endif
                        <small>
                            products management
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
                            <form method="post"
                                  class="form-horizontal form-label-left"
                                @if($newId)
                                  action="{{ secure_url('admin/products/create') }}">
                                    <input type="hidden" name="product_id" value="{{ $newId }}"/>
                                <input type="hidden" name="oldId" value="{{$product->id}}"/>
                                @else
                                    action="{{ action('EShopDataEntry\ProductsController@update',['product' => $product->id]) }}">
                                @endif
                                <input type="hidden" name="_method" value="PUT"/>
                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                    @if($newId)
                                <a href="{{ secure_url('admin/products/edit-product-options/'.$product->id.'new'.$newId) }}" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-original-title="" title="">
                                    Create options product
                                    @else
                                <a href="{{ secure_url('admin/products/edit-product-options/'.$product->id) }}" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-original-title="" title="">
                                    Edit options product
                                    @endif
                                </a>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="name" name="name" required="required"
                                               class="form-control col-md-7 col-xs-12" value="{{ $product->name }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Title
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="title" id="title" required="required"
                                               class="form-control col-md-7 col-xs-12" value="{{ $product->title }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alias">Alias
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="alias" id="alias" pattern="[a-z0-9\-]+" required="required"
                                               class="form-control col-md-7 col-xs-12" value="{{(count($alias) > 0) ? $alias[0]->alias : null }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">Price
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="price" name="price" required="required"
                                               class="form-control col-md-7 col-xs-12" value="{{ $product->price }}">
                                    </div>
                                </div>
                                <!--div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Brand
                                        <span class="required">*</span></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <select class="form-control" name="brand_id" required="required">
                                            @foreach($brands as $brand)
                                                @if($brand->id == $product->brand_id)
                                                    <option value="{{ $brand->id }}" selected>{{ $brand->name }}
                                                        (id:{{ $brand->id }})
                                                    </option>
                                                @else
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}
                                                        (id:{{ $brand->id }})
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div-->

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Category
                                        <span class="required">*</span></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <select class="select2_multiple form-control" multiple="multiple" name="category_id[]" required="required">
                                            @foreach($prodCat as $pc)
                                                <option value="{{ $pc->id }}" selected>{{ $pc->name }}
                                                    (id:{{ $pc->id }})
                                                </option>
                                            @endforeach
                                            @foreach($categories as $category)
                                                 <option value="{{ $category->id }}">{{ $category->name }}
                                                    id:{{ $category->id }})
                                                 </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Meta description <span class="required">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <textarea name="meta_description" class="form-control" rows="3" required="required">{{ $product->meta_description }}</textarea>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Keywords
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input name="keywords" id="tags_1" type="text" class="tags form-control" value="{{ $product->keywords }}" />
                                        <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status
                                        <span class="required">*</span></label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <select class="form-control" name="status" required="required">
                                            @if($list_product->status == 1)
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="discount">Discount </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="discount" name="discount"
                                               class="form-control col-md-7 col-xs-12" value="@if(count($productDiscount) > 0 && mb_strlen($productDiscount[0]->discount) > 0){{$productDiscount[0]->discount}}
                                    @endif">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Date End </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="date_end" name="date_end" class="date-picker form-control col-md-7 col-xs-12" type="date" value=
                                        "@if(count($productDiscount) > 0){{$productDiscount[0]->date_end}}@endif"
                                        >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date_start">Date Start </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="date_start" name="date_start" class="date-picker form-control col-md-7 col-xs-12" type="date" value=
                                        "@if(count($productDiscount) > 0){{$productDiscount[0]->date_start}}@endif"
                                        >
                                    </div>
                                </div>

                                <div class="form-group">
                          <textarea  class="form-control mytextarea" name="description" required="required"
                                    data-parsley-trigger="keyup" data-parsley-minlength="20"
                                    data-parsley-maxlength="100"
                                    data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.."
                                    data-parsley-validation-threshold="10">{{ $product->description }}</textarea>
                                </div>
                                <!--block upload image -->
                                <div class="x_panel">
                                @if(count($images) > 0)
                                    @foreach($images as $key => $img)
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="input-group block-image">
                                          <span class="input-group-btn">
                                            <a href="javascript:open_popup('{{secure_url('filemanager/dialog.php?type=1&popup=1&field_id=fieldID'.$key)}}')" class="btn btn-primary pathimage">
                                              <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                          </span>
                                            <input id="fieldID{{$key}}" type="text" class="form-control pathimage" onchange="getPreviewImg(this);"
                                                   name="filepath[]" value="{{ $img->image }}">
                                        </div>
                                        <img class='img-preview' style="margin-top:15px;max-height:100px;" src="/image/{{ $img->image }}">
                                    </div>
                                    @endforeach
                                @else 
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
                                @endif
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
                                            <button type="submit" class="btn btn-success">@if($newId)CREATE @else Update @endif</button>
                                        </div>
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