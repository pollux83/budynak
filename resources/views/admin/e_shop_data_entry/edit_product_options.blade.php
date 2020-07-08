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
                            <br/>
                            <form method="post" id="demo-form2" novalidate
                                  class="form-horizontal form-label-left"
                                  @if(Session::has('message') && Session::get('message') == 'Product create'))
                                  action="{{ secure_url('admin/products/create-product-options') }}">
                                <input type="hidden" name="_method" value="PUT"/>
                                <input type="hidden" name="product_id" value="{{ $product->id }}"/>
                                  @else
                                    action="{{ action('EShopDataEntry\ProductsController@updateProductOptions',['product' => $product->id]) }}">
                                  @endif
                                {{--<input type="hidden" name="_method" value="PUT"/>--}}
                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                <!-- Add block of options for a product -->
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Options</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="form-inline" role="form">
                                        <div class="form-group">
                                            <div id="append-html">
                                                @foreach($productOptionValues as $key => $prodOptVal)
                                                    <div class="get">
                                                        <div class="input-group">
                                         <span class="input-group-btn">
                                            <button class="btn btn-default option_button" type="button"><i
                                                        class="glyphicon glyphicon-plus"></i></button>
                                         </span><span class="input-group-btn">
                                            <button class="btn btn-default remove_button" type="button"><i
                                                        class="glyphicon glyphicon-minus"></i></button>
                                            </span>
                                                            <select class="form-control select-option" name="option">
                                                                @foreach($options as $option)
                                                                    @if($option->id == $prodOptVal->option->id)
                                                                        <option value={{ $option->id }} selected>{{ $option->name }}</option>
                                                                    @else
                                                                        <option value={{ $option->id }}>{{ $option->name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <select class="form-control select-value">
                                                                @foreach($productOptionValues as $val)
                                                                    @if($val->value['id'] == $prodOptVal->value['id'])
                                                                        <option value={{ $val->value['id'] }} selected>{{ $val->value['name'] }}</option>
                                                                    @elseif($val->option->id == $prodOptVal->option->id)
                                                                        <option value={{ $val->value['id'] }}>{{ $val->value['name'] }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <input type="number" class="form-control price_option"
                                                                   name="price_option_{{$key}}" step="any"
                                                                   placeholder="price for the value of the option"
                                                                   value="{{$prodOptVal->price}}">
                                                            @if($prodOptVal->product_option->required == 1)
                                                                <input type="checkbox" class="require_option"
                                                                       name="require_option" checked>
                                                            @else
                                                                <input type="checkbox" class="require_option"
                                                                       name="require_option">
                                                            @endif
                                                            <label for="require_option">Require</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end block-->
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <button type="submit" class="btn btn-success">Update</button>
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