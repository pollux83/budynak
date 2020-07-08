@extends('admin.layouts.layout')

@section('title', 'Page Title')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>
                        Categories
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
                        <div class="x_title">
                            <h2>Records Listing</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(Session::has('message'))
                                <p><b><span id="flash-message">{{  Session::get('message') }}!</span></b></p>
                            @endif
                            <br/>
                            <table class="table table-striped responsive-utilities jambo_table">
                                <thead>
                                <tr class="headings">
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>On/Off</th>
                                    <th>Parent</th>
                                    <th>Path to an image</th>
                                    <th>Brand</th>
                                    <th>Sort</th>
                                    <th class=" no-link last"><span class="nobr">Action</span>
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($categories as $category)
                                    @if($category->id %2 == 0)
                                        <tr class="even pointer">
                                    @else
                                        <tr class="odd pointer">
                                            @endif
                                            <td class=" ">{{ $category->id }}</td>
                                            <td class=" ">{{ $category->name }}</td>
                                            @if($category->status == 1)
                                                <td class=" ">On</td>
                                            @else
                                                <td class=" ">Off</td>
                                            @endif
                                            @foreach($units as $unit)
                                                @if($unit->id == $category->category)
                                                <td class=" ">{{ $unit->name }}</td>
                                                @elseif($unit->name == null)
                                                    <td class=" ">none</td>
                                                @endif
                                            @endforeach
                                            <td class=" ">{{ $category->image }}</td>
                                            @if($category->brand == 1)
                                            <td class=" ">yes</td>
                                            @else
                                            <td class=" ">no</td>
                                            @endif
                                            <td class=" ">{{ $category->sort }}</td>
                                            <td class=" last"><a
                                                        href="{{ secure_url('admin/categories/'.$category->id.'/edit') }}">Edit</a>
                                                | <span class="del">Delete</span></td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>


                            {{$categories->render()}}

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