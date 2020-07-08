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
                            page management
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
                            <form method="post" novalidate
                                  class="form-horizontal form-label-left"
                                  action="{{ action('FrontendDataEntry\PagesController@update',['page' => $page->id]) }}">
                                <input type="hidden" name="_method" value="PUT"/>
                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                <input type="hidden" id="user_id" name="user_id" value="{{$page->user_id}}"/><label for="user_id">ID User: {{$page->user_id}}</label>
                                <div class="form-group">
                                    @if(mb_strlen($page->name) === 0)
                                        <p>
                                            <span id="flash-message">The Category Name isn't exist. Update category name - <b>{{ $categories[$page->id]->name }}</b>!</span>
                                        </p>
                                    @endif
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                    	@foreach($categories as $cat)
                                            @if($cat->id == $page->id && mb_strlen($cat->name) > 0)
                                            <input class="form-control" name="name" id="name" type="text" value="{{ $cat->name }}">
                                            @endif
                                        @endforeach
                                        {{--<select class="form-control" name="name" id="name">
                                                                                                                            @foreach($categories as $cat)
                                                                                                                                @if($cat->id == $page->id && mb_strlen($cat->name) > 0)
                                                                                                                            <option value="{{ $cat->name }}" selected>{{ $cat->name }}</option>
                                                                                                                                @else
                                                                                                                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                                                                                                                                @endif
                                                                                                                            @endforeach
                                                                                                                        </select>--}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Title
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="title" name="title" required="required"
                                               class="form-control col-md-7 col-xs-12" value="{{ $page->title }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alias">Alias
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="alias" name="alias" required="required"
                                               class="form-control col-md-7 col-xs-12" value="{{ $alias->alias }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Meta description <span class="required">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <textarea name="meta_description" class="form-control" rows="3" required="required">{{ $page->meta_description }}</textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Keywords
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input name="keywords" id="tags_1" type="text" class="tags form-control" value="{{ $page->keywords }}" />
                                        <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Content
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <textarea name="content" class="mytextarea" required="required">{{ $page->content }}</textarea>
                                    </div>
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