@extends('layouts.layout_product')
@extends('layouts.top')
@extends('layouts.footer')

@section('content')
    <section class="cf navBlock detPage">
        <div class="inner">
            <div class="bread">
                {{--<a class="back" href="/products/internal-doors/oak-doors/641/"><i class="fa fa-angle-left"></i> back</a>--}}
                <ul>
                    <li><a href="{{secure_url('/')}}" class="tr-a">Главная</a></li><li><i class="fa fa-angle-right"></i></li>
                    <?php
                    $uriArr = explode('/', $_SERVER['REQUEST_URI']);
                    $amount = count($uriArr);
                    foreach($uriArr as $key => $uri){
                        switch($key){
                            case 1:
                                foreach($cat as $c){
                                    if($c->alias == $uri){
                                        echo '<li><a href="'.secure_url($c->alias).'">'.$c->name.'</a></li><li><i class="fa fa-angle-right"></i></li>';
                                    }
                                }
                                break;
                            case $key > 1 && $key < $amount-1:
                                foreach($cat as $c){
                                    if($c->alias == $uri){
                                        echo '<li><a href="'.secure_url($c->alias).'">'.$c->name.'</a></li><li><i class="fa fa-angle-right"></i></li>';
                                    }
                                }
                                break;
                            case $key == $amount-1:
                                echo '<li>'.$page->name.'</li>';
                                break;
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="c-40 p05">               
                <div class="detimg">
                @if(count($image) > 0)
                	<span class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                        <a href="{{secure_url('image/'.$image[0]->image)}}">
                            <img src="{{secure_asset('image/'.$image[0]->image)}}" alt="{{ $product->name }}" class="dimg" />
                        </a>
                    </span>
                @else
                    <span class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                        <a href="{{secure_asset('image/unavailable-sm.jpg')}}">
                            <img src="{{secure_asset('image/unavailable-sm.jpg')}}" alt="" class="dimg" />
                        </a>
                    </span>
                @endif
                </div>
                <ul class="thumbnails">
                @if(count($image) > 0)
                    @foreach($image as $key => $img)
                        @if($img->image !== '')
                    <li>
                        <a href="{{secure_url('image/'.$img->image)}}" data-standard="{{secure_url('image/'.$img->image)}}" class="active">
                            <img alt="" src="{{secure_asset('image/'.$img->image)}}" />
                        </a>
                    </li>
                        @endif
                    @endforeach
                    @else
                    <li>
                        <a href="{{secure_url('image/unavailable-sm.jpg')}}" data-standard="{{secure_url('image/unavailable-sm.jpg')}}" class="active">
                            <img alt="" src="{{secure_asset('image/unavailable-sm.jpg')}}" />
                        </a>
                    </li>
                @endif
                </ul>

            </div>
            <div class="c-60 p05">
                <div class="detinfo">
                    <header class="prodCat">
                        <h4 id="notice-has-product" style="display:none;">Товар добавлен!</h4>
                        <h1>{{ $product->name }}</h1>
                    </header>
                    @if(count($page->brand) > 0)
                    <div class="webText homeText">
                        <p>Брэнд: <a href="{{ $page->brand['alias'] }}">{{ $page->brand['name'] }}</a></p>
                    </div>
                    @endif
                    @if(mb_strlen($product->discount) > 0)
                        <div class="del">
                                <span>Старая цена:
                                <?php
                                    $price = rtrim($product->price, 0);
                                    $priceAr = explode('.', $price);
                                    if(empty($priceAr[1])) $priceAr[1] = 0;
                                    elseif(mb_strlen($priceAr[1]) == 1 && (int)$priceAr[1] > 0) $priceAr[1] .= 0;
                                    echo $priceAr[0].' руб. '.$priceAr[1].' коп.';
                                    ?>
                                </span>
                        </div>
                    @endif
                    <div class="tbl mt20">
                            @if(mb_strlen($product->discount) > 0)
                            <span id="base" class="price">Цена:
                                <?php
                                    $price = rtrim($product->discount, 0);
                                    $priceAr = explode('.', $price);
                                    if(empty($priceAr[1])) $priceAr[1] = 0;
                                    elseif(mb_strlen($priceAr[1]) == 1 && (int)$priceAr[1] > 0) $priceAr[1] .= 0;
                                    echo $priceAr[0].' руб. '.$priceAr[1].' коп.';
                                ?>
                            </span>
                            @else
                                <span id="base" class="price">Цена:
                                <?php
                                    $price = rtrim($product->price, 0);
                                    $priceAr = explode('.', $price);
                                    if(empty($priceAr[1])) $priceAr[1] = 0;
                                    elseif(mb_strlen($priceAr[1]) == 1 && (int)$priceAr[1] > 0) $priceAr[1] .= 0;
                                    echo $priceAr[0].' руб. '.$priceAr[1].' коп.';
                                ?>
                                </span>
                            @endif
                                <div class="empty">
                                    <div id="new-price"></div>
                                    <div id="select-option"></div>
                                </div>
                            <div class="tc tc-title">
                                <span>Количество: </span>
                            </div>
                            <div class="tc tc-qty">
                                <div class="qty">
                                <input type="text" value="1" maxlength="2" size="1" name="4674" id="qty_value_1">
                                <a class="btn top tr-a qty-plus" href="" onclick="qtyProd('plus','qty_value_1');return false;">plus</a>
                                <a class="btn btm tr-a qty-minus" href="" onclick="qtyProd('minus','qty_value_1');return false;">minus</a>
                                </div>
                            </div>
                    </div>
                    <form action="{{secure_url('/cart')}}" method="post" name="Enquiry" >
                        <div class="tbl mt20">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="id" value="{{$product->id}}">
                            <div class="tr tr-spc">
                                <div class="tc"></div>
                                <div class="tc"></div>
                                <div class="tc"></div>
                                <div class="tc"></div>
                                <div class="tc"></div>
                            </div>
                            @foreach($optProds as $key => $optProd)
                                    <div class="tr option">
                                        <div class="tc tc-title">
                                            {{ $optProd->name }}
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <div style="background: #eee;" class="tc tc-spc"></div>
                                        <div class="tc tc-price"></div>
                                    </div>

                                    <div class="tr tr-spc">
                                        <div class="tc"></div>
                                        <div class="tc"></div>
                                        <div class="tc"></div>
                                    </div>
                                <div class="section-values">
                            @foreach($valProds as $valProd)
                                @if($optProd->option_id == $valProd->option_id)
                            <div class="tr">
                                @if($valProd->image !== '' && $valProd->image !== 'no_image.jpg')
                                    <div class="tc"><img src="{{ secure_url('image/'.$valProd->image) }}" alt="{{ $valProd->name }}"></div>
                                    <div class="tc tc-spc"></div>
                                @endif
                                <div class="tc tc-title">
                                    <input type="radio" id="{{ $valProd->name }}" name="value_{{$key}}" value="{{ $valProd->name }}|{{ $valProd->price }}|{{ $valProd->id }}">
                                    <label for="{{ $valProd->name }}">{{ $valProd->name }}</label>
                                </div>
                                <div class="tc tc-spc"></div>
                                @if($valProd->price > 0)
                                <div class="tc tc-price">
                                <?php
                                    $price = rtrim($valProd->price, 0);
                                    $priceAr = explode('.', $price);
                                    if(mb_strlen($priceAr[1]) == 1) $priceAr[1] .= '0';
                                    if(empty($priceAr[1])) $priceAr[1] = 0;
                                    if(mb_strlen($priceAr[1]) == 1 && $priceAr[1] > 0) $priceAr[1] .= '0';
                                    echo '+ '.$priceAr[0].' руб. '.$priceAr[1].' коп.';
                                ?>
                                </div>
                                @endif
                                <div class="tc tc-spc"></div>
                            </div>

                            <div class="tr tr-spc">
                                <div class="tc"></div>
                                <div class="tc"></div>
                                <div class="tc"></div>
                            </div>
                                @endif
                            @endforeach
                            </div>
                            @endforeach
                        </div>
                        <input type="button" value="Заказать" onclick="addToCart();" class="fr mt20 tr-a">
                    </form>
                </div>
            </div>

            <div class="c-1 l-c mt50">
                <div class="webText homeText">
                    <b>Описание товара:</b>
                    <div id="share">
                    <div class="social" data-url="{{ secure_url($_SERVER['REQUEST_URI']) }}" data-title="{{  $page->title }}">
                        <div class="like">Поделиться с друзьями:</div>
                        <a class="push facebook" data-id="fb"><i class="fa fa-facebook"></i> </a>
                        <a class="push twitter" data-id="tw"><i class="fa fa-twitter"></i> </a>
                        <a class="push vkontakte" data-id="vk"><i class="fa fa-vk"></i> </a>
                        <a class="push google" data-id="gp"><i class="fa fa-google-plus"></i> </a>
                        {{--<a class="push ok" data-id="ok"><i class="fa fa-odnoklassniki"></i> OK</a>--}}
                    </div>
                </div>
                    {!! html_entity_decode($product->description) !!}
                </div>
                @include('inc.visited')
            </div>
        </div>
    </section>
@endsection