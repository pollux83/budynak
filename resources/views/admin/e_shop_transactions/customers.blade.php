@extends('admin.layouts.layout')

@section('title', 'Page Title')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>
                    Customers
                    <small>
                        customer records management
                    </small>
                </h3>
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
                        <h2>Records Listing</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="example" class="table table-striped responsive-utilities jambo_table">
                            <thead>
                                <tr class="headings">
                                    <th>ID </th>
                                    <th>Customer Name </th>
                                    <th>Email </th>
                                    <th>Contact Number </th>
                                    <th>Delivery Address </th>
                                    <th>Дата </th>
                                    <th class=" no-link last"><span class="nobr">Action</span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($customer as $c)
                                <tr class="even pointer">
                                    <td class=" ">{{ $c->id }}</td>
                                    <td class=" ">{{ $c->name }}</td>
                                    <td class=" ">{{ $c->email }}</td>
                                    <td class=" ">{{ $c->contact_number }}</td>
                                    <td class=" ">{{ $c->delivery_address }}</td>
                                    <td class=" ">{{ $c->created_at }}</td>
                                    <td class=" last"><a href="#">Edit</a> | <a href="#">Delete</a></td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            {{ $customer->links() }}
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