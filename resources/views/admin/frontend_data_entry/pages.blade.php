@extends('admin.layouts.layout')

@section('title', 'Page Title')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>
                        Front end Pages
                        <small>
                            front end pages management
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
                                    <th>Post Title</th>
                                    {{--<th>Description</th>--}}
                                    <th>Meta description</th>
                                    <th>Keywords</th>
                                    <th>Author </th>
                                    <th class=" no-link last"><span class="nobr">Action</span>
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($pages as $page)
                                    @if($page->id %2 == 0)
                                        <tr class="even pointer">
                                    @else
                                        <tr class="odd pointer">
                                            @endif
                                            <td class=" ">{{ $page->id }}</td>
                                            <td class=" ">{{ $page->name }}</td>
                                            {{--<td class=" "><i>{!! str_limit($page->content, 100) !!}</i></td>--}}
                                            <td class=" "><i>{!! str_limit($page->meta_description, 20) !!}</i></td>
                                            <td class=" "><i>{!! str_limit($page->keywords, 20) !!}</i></td>
                                            <td class=" ">{{ $page->user->name }} </td>
                                            <td class=" last"><a
                                                        href="{{ secure_asset('admin/pages/'.$page->id.'/edit') }}">Edit</a>
                                                | <span class="del">Delete</span></td>
                                        </tr>
                                        @endforeach
                                </tbody>

                            </table>

                            {{ $pages->links() }}

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