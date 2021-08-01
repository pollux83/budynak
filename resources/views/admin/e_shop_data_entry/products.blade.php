@extends('admin.layouts.layout')

@section('title', 'Page Title')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>
                        Products
                        <small>
                            products management
                        </small>
                    </h3>
                </div>
                @if(Session::has('message'))
                    <p><b><span id="flash-message">{{  Session::get('message') }}!</span></b></p>
                @endif
                <br/>
                <form method="get" action="{{ action('EShopDataEntry\ProductsController@searchProduct') }}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" name="product" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">Go!</button>
                        </span>
                            </div>
                        </div>
                    </div>
                </form>
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
                            <button class="btn btn-default"
                                    onclick="window.location.href = '{{ secure_asset('admin/products') }}'"> Очистить
                                фильтр
                            </button>
                            <?php
                            $categories = \App\Category::all()->pluck('name', 'id');
                            $brands = \App\Brand::all()->pluck('name', 'id');
                            $gridData = [
                                'dataProvider' => $dataProvider,
                                'useFilters' => true,
                                'columnFields' => [
                                    'id',
                                    'name',
                                    [
                                        'label' => 'Активный',
                                        'attribute' => 'status',
                                        'value' => function ($row) {
                                            return $row->getStatusLabel();
                                        },
                                        'filter' => [
                                            'class' => Itstructure\GridView\Filters\DropdownFilter::class,
                                            'data' => [0 => 'Нет', 1 =>'Да'],
                                        ]
                                    ],
                                    [
                                        'label' => 'Цена',
                                        'attribute' => 'price',
                                        'format' => Itstructure\GridView\Columns\BaseColumn::FORMATTER_HTML,
                                        'value' => function ($row) {
                                            return "<input type=\"number\" step=\"any\" min=\"0\" name=\"price\" value=\"$row->price\"><button onclick=\"changePrice(this);\">Update</button>";
                                        }
                                    ],
                                    [
                                        'label' => 'Категории',
                                        'attribute' => 'category_id',
                                        'value' => function ($row) {
                                            $output = [];
                                            foreach ($row->categories()->get() as $category) {
                                                $output[] = $category->name;
                                            }
                                            return implode(', ', $output);
                                        },
                                        'filter' => [
                                            'class' => Itstructure\GridView\Filters\DropdownFilter::class,
                                            'data' => $categories
                                        ]
                                    ],
                                    [
                                        'label' => 'Брэнд',
                                        'attribute' => 'brand_id',
                                        'value' => function ($row) {
                                            $output = [];
                                            foreach ($row->brand()->get() as $brand) {
                                                $output[] = $brand->name;
                                            }
                                            return implode(', ', $output);
                                        },
                                        'filter' => [
                                            'class' => Itstructure\GridView\Filters\DropdownFilter::class,
                                            //'name' => 'Категории',
                                            'data' => $brands,
                                        ]
                                    ],
                                    [
                                        'label' => '', // Optional
                                        'class' => Itstructure\GridView\Columns\ActionColumn::class, // Required
                                        'actionTypes' => [ // Required
                                            /*'view' => function ($data) {
                                                return '/admin/products/' . $data->id . '_copy/edit';
                                            },*/
                                            /*'edit' => function ($data) {
                                                return '/admin/products/' . $data->id . '/edit';
                                            },*/
                                            [
                                                /** copy button */
                                                'class' => Itstructure\GridView\Actions\View::class, // Required
                                                'url' => function ($data) { // Optional
                                                    return '/admin/products/' . $data->id . '_copy/edit';
                                                },
                                                'htmlAttributes' => [ // Optional
                                                    'target' => '_blank',
                                                    'style' => 'color: white; font-size: 10px;',
                                                ]
                                            ],
                                            [
                                                'class' => Itstructure\GridView\Actions\Delete::class, // Required
                                                'url' => function ($data) { // Optional
                                                    return '/admin/product/' . $data->id . '/delete';
                                                },
                                                'htmlAttributes' => [ // Optional
                                                    //'target' => '_blank',
                                                    'style' => 'color: white; font-size: 10px;',
                                                    'onclick' => 'return confirm("Удалить?")',
                                                ]
                                            ]
                                        ]
                                    ]


                                ]
                            ];
                            ?>
                            @gridView($gridData)
{{--                                                  <table class="table table-striped responsive-utilities jambo_table">--}}
{{--                                <thead>--}}
{{--                                <tr class="headings">--}}
{{--                                    <th>ID</th>--}}
{{--                                    <th>Name</th>--}}
{{--                                    <th>Title</th>--}}
{{--                                    <th>On/Off</th>--}}
{{--                                    <th>Price</th>--}}
{{--                                    <th class=" no-link last"><span class="nobr">Action</span>--}}
{{--                                    </th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}

{{--                                <tbody>--}}
{{--                                @foreach($products as $product)--}}
{{--                            @if($product->id %2 == 0)--}}
{{--                                <tr class="even pointer">--}}
{{--@else--}}
{{--                                <tr class="odd pointer">--}}
{{--@endif--}}
{{--                                    <td class=" ">{{ $product->id }}</td>--}}
{{--                                            <td class=" ">{{ $product->name }}</td>--}}
{{--                                            <td class=" "><input type="text" class="form-control" name="title" value="@if(isset($product->title)){{ $product->title }}@else null @endif"><button onclick="changeTitle(this);">Update</button></td>--}}
{{--                                            @if($product->status == 1)--}}
{{--                                <td class=" ">On</td>--}}
{{--@else--}}
{{--                                <td class=" ">Off</td>--}}
{{--@endif--}}
{{--                                    <td class=" "><input type="number" step="any" min="0" name="price" value="{{ $product->price }}"><button onclick="changePrice(this);">Update</button></td>--}}
{{--                                            <td class=" last"><a href="{{ secure_url('admin/products/'.$product->id.'_copy/edit') }}">Copy</a>--}}
{{--                                                | <a href="{{ secure_asset('admin/products/'.$product->id.'/edit') }}">Edit</a>--}}
{{--                                                | <span class="del">Delete</span></td>--}}
{{--                                        </tr>--}}
{{--                                        @endforeach--}}
{{--                                </tbody>--}}
{{--                            </table>--}}

                            {{ $products->links() }}

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