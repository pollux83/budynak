@extends('admin.layouts.layout')

@section('title', 'Page Title')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>
                        Front end Brands
                        <small>
                            front end brands management
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
                            <table class="table table-striped responsive-utilities jambo_table">
                                <thead>
                                <tr class="headings">
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Meta description</th>
                                    <th>Keywords</th>
                                    <th>Author </th>
                                    <th class=" no-link last"><span class="nobr">Action</span>
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($brands as $brand)
                                    @if($brand->id %2 == 0)
                                        <tr class="even pointer">
                                    @else
                                        <tr class="odd pointer">
                                            @endif
                                            <td class=" ">{{ $brand->id }}</td>
                                            <td class=" ">{{ $brand->title }}</td>
                                            <td class=" ">{{ $brand->name }}</td>
                                            <td class=" "><i>{!! str_limit($brand->content, 20) !!}</i></td>
                                            <td class=" "><i>{!! str_limit($brand->meta_description, 20) !!}</i></td>
                                            <td class=" "><i>{!! str_limit($brand->keywords, 20) !!}</i></td>
                                            <td class=" ">{{ $brand->user->name }} </td>
                                            <td class=" last"><a
                                                        href="{{ secure_asset('admin/brand-descriptions/'.$brand->id.'/edit') }}">Edit</a>
                                                | <span class="del">Delete</span></td>
                                        </tr>
                                        @endforeach
                                </tbody>

                            </table>

                            {{ $brands->links() }}

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