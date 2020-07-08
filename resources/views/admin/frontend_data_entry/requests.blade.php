@extends('admin.layouts.layout')

@section('title', 'Page Title')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>
                        Front end Requests
                        <small>
                            front end requests management
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
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th>Email</th>
                                    <th>Content</th>
                                    <th class=" no-link last"><span class="nobr">Action</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($requests as $r)
                                    @if($r->id %2 == 0)
                                        <tr class="even pointer">
                                    @else
                                        <tr class="odd pointer">
                                            @endif
                                            <td class=" ">{{ $r->id }}</td>
                                            <td class=" ">{{ $r->name }}</td>
                                            @if($r->status == 1)
                                                <td class=" ">on </td>
                                            @else
                                                <td class=" ">off </td>
                                            @endif
                                            <td class=" ">{{ $r->email }} </td>
                                            <td class=" "><i>{{ str_limit($r->content, 200) }}</i></td>
                                            <td class=" last"><a
                                                        href="{{ asset('admin/requests/'.$r->id.'/edit') }}">Edit</a>
                                                | <span class="del">Delete</span></td>
                                        </tr>
                                        @endforeach
                                </tbody>

                            </table>

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