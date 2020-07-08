@extends('admin.layouts.layout')

@section('title', 'Page Title')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>
                    Brands
                    <small>
                        products brands management
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
                        <table class="table table-striped responsive-utilities jambo_table">
                            <thead>
                                <tr class="headings">
                                    <th>ID </th>
                                    <th>Name </th>
                                    <th>Sort brand </th>
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
                                        <td class=" ">{{ $brand->name }}</td>
                                        <td class=" "><input class="form-control" type="number" step="any" min="0" name="price" value="{{  $brand['sort_brand'] }}"><button class="btn" onclick="changeBrandSort(this);">Update</button></td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>

                        {{ $brands->links() }}

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
<script>
    function changeBrandSort(value){
        var id = value.parentNode.parentNode.children[0].innerText;
        var brand_sort = value.parentNode.children[0].value;
        $.ajax({
         url: 'products/edit-brand-sort/'+id,
         method: 'post',
         data: {
         '_token': "{{csrf_token()}}",
         'brand_sort': brand_sort
         },
         success: function (result) {
         if(result) value.parentNode.setAttribute('style', 'background-color: green;');
         else value.parentNode.setAttribute('style', 'background-color: red;');
         },
         error: function (e) {
         console.log('error');
         console.log(e.responseText);
         value.parentNode.setAttribute('style', 'background-color: red;')
         }
         });
    }
</script>
@endsection