<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laradmin | Larashop Admin Panel</title>

    <link href="{{secure_asset('css/admin/css/custom.css?v1')}}" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="{{secure_asset('css/admin/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="{{secure_asset('css/admin/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{secure_asset('fonts/admin/fonts/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{secure_asset('css/admin/css/animate.min.css')}}" rel="stylesheet">
    <!-- Custom styling plus plugins -->
    <link href="{{secure_asset('css/admin/css/custom.min.css')}}" rel="stylesheet">
    
    <!-- tinyMCE -->
    <script src="{{secure_asset('js/admin/tinymce/tinymce.min.js')}}"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: ".mytextarea",
            theme: "modern",
            width: 900,
            height: 300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking spellchecker",
                "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
            ],

            toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
            toolbar2: "responsivefilemanager | code | image | media | link unlink anchor | print preview",
            image_advtab: true,

            filemanager_title:"Responsive Filemanager",
            external_filemanager_path:"{{secure_asset('/filemanager')}}/",
            external_plugins: { "filemanager" : "plugins/responsivefilemanager/plugin.min.js"}
        });
    </script>
    <!-- jQuery -->
    <script src="{{ secure_asset('js/admin/jquery.min.js') }}"></script>
    <!-view('errors.404')- jQuery Tags Input -->
    <script src="{{secure_asset('js/admin/jquery.tagsinput.js')}}"></script>

    <!-- Script laravel -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>;
    </script>
</head>


<body class="nav-md">

<div class="container body">


    <div class="main_container">

        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <a href="{{secure_asset('admin/dashboard')}}" class="site_title"><i class="fa fa-paw"></i> <span>Larashop Admin Panel!</span></a>
                </div>
                <div class="clearfix"></div>
                <br/>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">
                        <h3>General</h3>
                        <ul class="nav side-menu">
                            <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="{{secure_asset('admin/dashboard')}}">Dashboard</a>
                                    </li>
                                </ul>
                            </li>

                            <li><a><i class="fa fa-edit"></i> E-Shop Data Entry <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a>SEO<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="sub_menu"><a href="{{secure_url('admin/keys')}}">Show Keywords</a>
                                            </li>
                                            <li class="sub_menu"><a href="{{secure_url('admin/error-url')}}">Show error urls</a>
                                            </li>
                                            <li class="sub_menu"><a href="{{secure_url('admin/category-images')}}">Show no optimize category images</a>
                                            </li>
                                            <li class="sub_menu"><a href="{{secure_url('admin/product-images')}}">Show no optimize product images</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a>Categories<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="sub_menu"><a href="{{secure_asset('admin/categories')}}">Show
                                                    Categories</a>
                                            </li>
                                            <?php
                                            session_start();
                                            if (array_key_exists('cat', $_SESSION)) {
                                                $categories = $_SESSION['cat'];
                                                $base_url = $_SESSION['base_url'];
                                                foreach ($categories as $category) {
                                                    echo '<li class="sub_menu"><a href="' . $base_url . 'admin/categories/' . $category->id . '">' . $category->name . '</a>
                                            </li>';
                                                }
                                            }
                                            ?>
                                            <li class="sub_menu"><a href="{{secure_asset('admin/categories/create')}}">Create
                                                    Category</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a>Products<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="sub_menu"><a href="{{secure_asset('admin/products')}}">Show Products</a>
                                            </li>
                                            <?php
                                            //session_start();
                                            if (array_key_exists('cat', $_SESSION)) {
                                                $categories = $_SESSION['cat'];
                                                $base_url = $_SESSION['base_url'];
                                                foreach ($categories as $category) {
                                                    echo '<li class="sub_menu"><a href="' . $base_url . 'admin/products/' . $category->id . '">' . $category->name . '</a>
                                            </li>';
                                                }
                                            }
                                            ?>
                                            <li class="sub_menu"><a href="{{secure_asset('admin/products/create')}}">Create
                                                    Product</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a>Options<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="sub_menu"><a href="{{secure_asset('admin/options')}}">Show Options</a>
                                            </li>
                                            <li class="sub_menu"><a href="{{secure_asset('admin/options/create')}}">Create
                                                    Options</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a>Values<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="sub_menu"><a href="{{secure_asset('admin/values')}}">Show Values</a>
                                            </li>
                                            <li class="sub_menu"><a href="{{secure_asset('admin/values/create')}}">Create
                                                    Values</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a>Brands<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="sub_menu"><a href="{{secure_url('admin/brands')}}">Show Brands</a>
                                            </li>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a><i class="fa fa-edit"></i> Frontend Data Entry <span
                                            class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a>Requests<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="sub_menu"><a href="{{secure_asset('admin/requests')}}">Show Requests</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a>Blog Posts<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="sub_menu"><a href="{{secure_asset('admin/blog-posts')}}">Show Blog Posts</a>
                                            </li>
                                            <li class="sub_menu"><a href="{{secure_asset('admin/blog-posts/create')}}">Create
                                                    Blog Posts</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a>Pages<span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <li class="sub_menu"><a href="{{secure_asset('admin/pages')}}">Show Pages</a>
                                                </li>
                                                <li class="sub_menu"><a href="{{secure_asset('admin/pages/create')}}">Create
                                                        Pages</a>
                                                </li>
                                            </ul>
                                    </li>
                                    <li><a>Brand Descriptions<span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <li class="sub_menu"><a href="{{secure_asset('admin/brand-descriptions')}}">Show Brand Descriptions</a>
                                                </li>
                                                <li class="sub_menu"><a href="{{secure_asset('admin/brand-descriptions/create')}}">Create
                                                        Brand Descriptions </a>
                                                </li>
                                            </ul>
                                    </li>
                                    <li><a>Informations<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="sub_menu"><a href="{{secure_asset('admin/informations')}}">Show Informations</a>
                                            </li>
                                            <li class="sub_menu"><a href="{{secure_asset('admin/informations/create')}}">Create
                                                    Information</a>
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                            <li><a><i class="fa fa-edit"></i> E-Shop Transactions <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none;">
                                    <li><a href="{{secure_url('admin/customers')}}">Customers</a></li>
                                    <li><a href="{{secure_url('admin/orders')}}">Orders</a></li>
                                    <li><a href="{{secure_url('admin/product-sales')}}">Product Sales</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false">
                                {{ Auth::user()->name }}<span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                <!--<li>
                                    <a href="{{ secure_url('/admin/optimaze-image') }}">
                                        Optimaze all images
                                    </a>
                                </li>-->
                                <li>
                                    <a href="{{ secure_url('/logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ secure_url('/logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </nav>
            </div>

        </div>
        <!-- /top navigation -->

        @yield('content')

    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>

<!-- Select2 -->
<script src="{{ secure_asset('js/admin/select2.full.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ secure_asset('js/admin/bootstrap.min.js') }}"></script>

<script src="{{secure_asset('js/admin/custom.js')}}"></script>

<!-- update product price and product title -->
<script>
    function changeTitle(value){
        var title = value.parentNode.children[0].value;
        var id = value.parentNode.parentNode.children[0].innerText;
        $.ajax({
            url: 'edit-product-title/'+id,
            method: 'post',
            data: {
                '_token': "{{csrf_token()}}",
                'title': title
            },
            success: function (result) {
                if(result) value.parentNode.setAttribute('style', 'background-color: green;');
                else value.parentNode.setAttribute('style', 'background-color: red;');
            },
            error: function (e) {
                console.log('error');
                console.log(e);
                value.parentNode.setAttribute('style', 'background-color: red;')
            }
        });
    }
    function changePrice(value){
        var price = value.parentNode.children[0].value;
        var id = value.parentNode.parentNode.children[0].innerText;
        $.ajax({
            url: 'edit-product-price/'+id,
            method: 'post',
            data: {
                '_token': "{{csrf_token()}}",
                'price': price
            },
            success: function (result) {
                if(result) value.parentNode.setAttribute('style', 'background-color: green;');
                else value.parentNode.setAttribute('style', 'background-color: red;');
            },
            error: function (e) {
                console.log('error');
                console.log(e);
                value.parentNode.setAttribute('style', 'background-color: red;')
            }
        });
    }
</script>
<!-- get ajax for job of forms with method "delete" -->
<script>$('document').ready(function () {
        $('.del').on('click', function () {
            parent = $(this).parent().parent();//получаем родителя нашего span. parent будет содержать объект tr (строку нашей таблицы)
            id = parent.children().first().html(); //id будет содержать id нашей категории, которое берется из первой ячейки строки
            var val_url = $(this).parent()[0].baseURI.split('?')[0];
            var urlArr = val_url.split('/');
            var lastItem = urlArr[urlArr.length-1];
            if(Number(lastItem)) {
                delete(urlArr[urlArr.length-1]);
                val_url = urlArr.join('/');
                val_url += id;
            } else val_url += '/' + id;
            name = parent[0].children[1].innerText;
            confirm_var = confirm('Delete ' + name + '?');//запрашиваем подтверждение на удаление
            if (!confirm_var) return;
            $.ajax({
                url: val_url, //url куда мы передаем delete запрос
                method: 'DELETE',
                data: {
                    '_token': "{{csrf_token()}}",
                    'id': id
                }, //не забываем передавать токен, или будет ошибка.
                success: function (value) {
                    parent.remove();// удаляем строчку tr из таблицы
                    alert(value);
                },
                error: function (e) {
                    console.log('error');
                    console.log(e);
                }
            });
        });
    });
    let deleteAjaxObj = {
        deleteAjax: function () {
            let parent = $(this).parent();
            confirm_var = confirm('Delete?');//запрашиваем подтверждение на удаление
            if (!confirm_var) return false;
            $.ajax({
                url: this.href, //url куда мы передаем delete запрос
                method: 'DELETE',
                data: {'_token': "{{csrf_token()}}"}, //не забываем передавать токен, или будет ошибка.
                success: function (msg) {
                    parent.remove(); // удаляем строчку tr из таблицы
                    alert('Record ' + msg + ' destroy');
                },
                error: function (msg) {
                    console.log(msg); // в консоле  отображаем информацию об ошибки, если они есть
                }
            });
            return false;
        }
    }
</script>
<script>
    //create fields for options and it values
    setNameClass();
    //var count = 0;
    $(document).on('click', '.option_button', function () {
        var newDiv = '<div class="get">' + $(this).parent().parent()[0].outerHTML + '</div>';
        $('div.get:last').last().after(newDiv);
        setNameClass();
    });

    //delete fields value and option
    $(document).on('click', '.remove_button', function () {
        var block;
        block = $(this).parent().parent().parent();
        var amountBlock = document.getElementsByClassName('get').length;
        if (amountBlock == 2) {
            if (confirm("You remove $('input.pathimage') options!")) {
                $('.get').remove();
                $('div.form-inline:last').append('<h4><span class="label label-danger">Without options!</span></h4>');
            }
        } else {
            if (confirm('Delete?')) {
                block.remove();
            }
        }
    });
    function setNameClass(){
        var length = $('select.select-value').length;
        for (var i = 0; i < length; i++) {
            $('select.select-value')[i].name = 'value_' + i;
        }
        length = $('select.select-option').length;
        for (i = 0; i < length; i++) {
            $('select.select-option')[i].name = 'option_' + i;
        }
        length = $('input.price_option').length;
            for (i = 0; i < length; i++) {
                $('input.price_option')[i].name = 'price_option_' + i;
            }
        length = $('input.require_option').length;
            for (i = 0; i < length; i++) {
                $('input.require_option')[i].name = 'require_option_' + i;
            }
    }
</script>

<!-- get function add options and image for a product -->
<script>
    $('div.form-inline:last').on('change', '.select-option', function () {
        var selectValue = '';
        $(this).next()[0].innerHTML = '';
        $(this).next().next()[0].value = 0;//set a price of a value of an option
        var idOption = $(this).val()/*.split('_')[1]*/;
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {
                '_token': "{{csrf_token()}}",
                'id_option': idOption,
            },
            success: function (data) {
                for (var key in data) {
                    selectValue += '<option value="' + key + '">' + data[key] + '</option>\n';
                }
                $('select:empty')[0].innerHTML = selectValue;
            },
            error: function (e) {
                console.log('error:');
                console.log(e);
            }
        });
    });
    // get function add image
    $('.add_images').on('click',function()
    {
        if($('input.pathimage').length==11) return; //ограничим количество картинок 1 превью и 10 дополнительных картинок.
        field=$('div.block-image:last').parent().clone(true); // клонируем поле preview с добавлением обработчика
        $(this).after(field); //вставляем поле после кнопки
        setNameClassImage();
    });
    function setNameClassImage(){
        var inputs = $('input.pathimage');
        var i = inputs.length-1;
        var aNodes = $('a.pathimage');
        var href = aNodes[i].href.replace(/fieldID\d*/, 'fieldID'+i);
        inputs[i].id = 'fieldID'+i;
        aNodes[i].href = href;
    }
   
</script>
<!-- multiple select2 -->
<!-- Select2 -->
<script>
    $(document).ready(function() {
        $(".select2_multiple").select2({
            maximumSelectionLength: 8,
            placeholder: "With Max Selection limit 8",
            allowClear: true
        });
    });
</script>

<!-- filemanager -->
<script type="text/javascript">
// preview of image
    function getPreviewImg(input){
    	input.parentElement.nextElementSibling.src = input.value;
    }
	jQuery(document).ready(function($) {
	    if($('.iframe-btn').length){
            $('.iframe-btn').fancybox({
                'width': 880,
                'height': 570,
                'type': 'iframe',
                'autoScale': false
            });
        }


    function OnMessage(e) {
        var event = e.originalEvent;
        if (event.data.sender === 'responsivefilemanager') {
            if (event.data.field_id) {
                var fieldID = event.data.field_id;
                var url = event.data.url;
                $('#' + fieldID).val(url).trigger('change');
                $.fancybox.close();
                $(window).off('message', OnMessage);
            }
        }
    }
    $('.iframe-btn').on('click', function() {
        $(window).on('message', OnMessage);
    });
    $('#download-button').on('click', function() {
        ga('send', 'event', 'button', 'click', 'download-buttons');
    });
    $('.toggle').click(function() {
        var _this = $(this);
        $('#' + _this.data('ref')).toggle(200);
        var i = _this.find('i');
        if (i.hasClass('icon-plus')) {
            i.removeClass('icon-plus');
            i.addClass('icon-minus');
        } else {
            i.removeClass('icon-minus');
            i.addClass('icon-plus');
        }
    });
});

function open_popup(url) {
    var w = 880;
    var h = 570;
    var l = Math.floor((screen.width - w) / 2);
    var t = Math.floor((screen.height - h) / 2);
    var win = window.open(url, 'ResponsiveFilemanager', "scrollbars=1,width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);
}
</script>
<!-- jQuery Tags Input -->
<script>
    function onAddTag(tag) {
        alert("Added a tag: " + tag);
    }
    function onRemoveTag(tag) {
        alert("Removed a tag: " + tag);
    }
    function onChangeTag(input, tag) {
        alert("Changed a tag: " + tag);
    }
    $(document).ready(function() {
        $('#tags_1').tagsInput({
            width: 'auto'
        });
    });
</script>
<!-- /jQuery Tags Input -->

<!-- /footer content -->
</body>
</html>

