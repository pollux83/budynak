@extends('admin.layouts.layout')

@section('title', 'Page Title')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>
                    Informations
                    <small>
                        management
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
                                    <th>Name</th>
                                    <th>Title</th>
                                    <th>Meta Description</th>
                                    <th>Keywords</th>
                                    {{--<th>Content</th>--}}
                                    <th>Status </th>
                                    <th class=" no-link last"><span class="nobr">Action</span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($informations as $info)
                                @if($info->id %2 == 0)
                                    <tr class="even pointer">
                                @else
                                    <tr class="odd pointer">
                                        @endif
                                        <td class=" ">{{ $info->id }}</td>
                                        <td class=" ">{{ $info->name }}</td>
                                        <td class=" ">{{ $info->title }}</td>
                                        <td class=" "><i>{!! str_limit($info->meta_description, 20) !!}</i></td>
                                        <td class=" "><i>{!! str_limit($info->keywords, 20) !!}</i></td>
                                        {{--<td class=" "><i>{!! str_limit($info->content, 30) !!}</i></td>--}}
                                        @if($info->status == 1)
                                        <td class=" ">On</td>
                                        @else
                                        <td class=" ">Off</td>
                                        @endif
                                        <td class=" last"><a
                                                    href="{{ secure_asset('admin/informations/'.$info->id.'/edit') }}">Edit</a>
                                            | <span class="del">Delete</span></td>
                                    </tr>
                            @endforeach
                            </tbody>

                        </table>

                        {{ $informations->links() }}

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