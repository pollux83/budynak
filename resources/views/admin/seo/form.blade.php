@extends('admin.layouts.layout')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>SEO report</h3>
                </div>

                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>SEO table</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="table table-striped responsive-utilities jambo_table">
                                <thead>
                                <tr class="headings">
                                    @foreach($ths as $th)
                                    <th>{{ $th }}</th>
                                    @endforeach
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($pages as $page)
                                    @if($page->id %2 == 0)
                                        <tr class="even pointer">
                                    @else
                                        <tr class="odd pointer">
                                            @endif
                                            @foreach($ths as $th)
                                                @php($th = strtolower($th))
                                            <td class=" ">{{ $page->$th }}</td>
                                            @endforeach
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

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Doubles</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="control-group">
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <p>{{ $keysDouble }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
        </div>

        <!-- footer content -->
    @include('admin.layouts.footer')
    <!-- /footer content -->

    </div>
    <!-- /page content -->
@endsection