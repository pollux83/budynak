@extends('admin.layouts.layout')

@section('title', 'Page Title')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>
                    Blog Posts
                    <small>
                        blog posts management
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
                                    <th>Meta Description</th>
                                    <th>Keywords</th>
                                    {{--<th>Content</th>--}}
                                    <th>Date Created </th>
                                    <th>Status </th>
                                    <th class=" no-link last"><span class="nobr">Action</span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($blogs as $blog)
                                @if($blog->id %2 == 0)
                                    <tr class="even pointer">
                                @else
                                    <tr class="odd pointer">
                                        @endif
                                        <td class=" ">{{ $blog->id }}</td>
                                        <td class=" ">{{ $blog->title }}</td>
                                        <td class=" "><i>{!! str_limit($blog->meta_description, 20) !!}</i></td>
                                        <td class=" "><i>{!! str_limit($blog->keywords, 20) !!}</i></td>
                                        {{--<td class=" "><i>{!! str_limit($blog->content, 20) !!}</i></td>--}}
                                        <td class=" ">{{ $blog->created_at }} </td>
                                        @if($blog->list_blog->status == 1)
                                        <td class=" ">On</td>
                                        @else
                                        <td class=" ">Off</td>
                                        @endif
                                        <td class=" last"><a
                                                    href="{{ secure_asset('admin/blog-posts/'.$blog->id.'/edit') }}">Edit</a>
                                            | <span class="del">Delete</span></td>
                                    </tr>
                            @endforeach
                            </tbody>

                        </table>

                        {{ $blogs->links() }}

                    </div>
                </div>
            </div>

            <br />
            <br />
            <br />

        </div>
    </div>
    <!-- footer content -->
    @include('admin.layouts.footer')
    <!-- /footer content -->

</div>
<!-- /page content -->

@endsection