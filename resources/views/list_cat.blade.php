@extends('layouts.layout')
@extends('layouts.top')
@extends('layouts.footer')

@section('content')
    <section class="cf navBlock catPage">
        <div class="inner">
            <div class="bread">

                {{--<a class="back" href="/products/internal-doors/623/"><i class="fa fa-angle-left"></i> back</a>--}}

                <ul>
                    <li><a href="{{secure_url('/')}}" class="tr-a">Главная</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <?php
                    $uriArr = explode('/', $_SERVER['REQUEST_URI']);
                    $amount = count($uriArr);
                    foreach ($uriArr as $key => $uri) {
                        switch ($key) {
                            case 1:
                                foreach ($cat as $c) {
                                    if ($c->alias == $uri) {
                                        echo '<li><a href="' . secure_url($c->alias) . '">' . $c->name . '</a></li><li><i class="fa fa-angle-right"></i></li>';
                                    }
                                }
                                break;
                            case $key > 1 && $key < $amount - 1:
                                foreach ($cat as $c) {
                                    if ($c->alias == $uri) {
                                        echo '<li><a href="' . secure_url($c->alias) . '">' . $c->name . '</a></li><li><i class="fa fa-angle-right"></i></li>';
                                    }
                                }
                                break;
                            case $key == $amount - 1:
                                echo '<li>' . $page->name . '</li>';
                                break;
                        }
                    }
                    ?>
                </ul>
            </div>
            <header class="prodCat white">
                <h1>{{ $page->name }}</h1>
            </header>
            <link rel="stylesheet" href="{{secure_asset('css/slider.css')}}" media="screen" />
                {!! $products->links() !!}

            <form action="{{ $_SERVER['REQUEST_URI'] }}" method="get">
                <div class="block-left">
                    <label for="sl2">Фильтр цен, руб.:</label>
                    <input type="text" class="span2" name="range_price" data-slider-min="{{ $page->min }}" data-slider-max="{{ $page->max }}"
                           data-slider-step="5" data-slider-value="[{{ ($page->rangeMin) ? $page->rangeMin : $page->min }},{{ ($page->rangeMax) ? $page->rangeMax : $page->max }}]" id="sl2">
                    <input type="submit" value="Принять" class="fr mt20 tr-a">
                </div>
            </form>
            <div class="webText noShadow mb1">
                <h5><strong>Внимание! Предлагаем рассрочку от 1 до 12 месяцев.</strong></h5>
            </div>
        <ul class="products2">
        @foreach($products as $product)<!--
                    --><li>
                <a href="{{ $product->alias }}" class="tr-a">
                    <div class="tr">
                        <div class="td td-img">
                            <img src="{{ secure_url('image/cache/'.$product->image) }}" alt="{{ $product->name }}"
                                 onError="this.onerror=null;this.src='{{secure_url('image/unavailable-sm.jpg')}}';"/>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td">
                            <header>
                                <h2>{{ $product->name }}</h2>
                            </header>
                            @if(array_key_exists('discount', $product) && mb_strlen($product->discount) > 0)
                                <span class="price">
                                    <span class="discount">Акция!</span>
                                    <?php
                                    $price = rtrim($product->discount, 0);
                                    $priceAr = explode('.', $price);
                                    if (empty($priceAr[1])) $priceAr[1] = 0;
                                    elseif (mb_strlen($priceAr[1]) == 1 && (int)$priceAr[1] > 0) $priceAr[1] .= 0;
                                    echo $priceAr[0] . ' руб. ' . $priceAr[1] . ' коп.';

                                    ?>
                                </span>
                                <span class="discount">
                                    <span class="del">
                                    <?php
                                        $price = rtrim($product->price, 0);
                                        $priceAr = explode('.', $price);
                                        if (empty($priceAr[1])) $priceAr[1] = 0;
                                        elseif (mb_strlen($priceAr[1]) == 1 && (int)$priceAr[1] > 0) $priceAr[1] .= 0;
                                        echo $priceAr[0] . ' руб. ' . $priceAr[1] . ' коп.';
                                        ?>
                                </span>
                                    <?php
                                    $skidka = 100 - ($product->discount / $product->price) * 100;
                                    echo ' Скидка: ' . round($skidka) . '%';
                                    ?>
                                </span>

                            @else
                                <span class="price">
                                     <?php
                                    $price = rtrim($product->price, 0);
                                    $priceAr = explode('.', $price);
                                    if (empty($priceAr[1])) $priceAr[1] = 0;
                                    elseif (mb_strlen($priceAr[1]) == 1 && (int)$priceAr[1] > 0) $priceAr[1] .= 0;
                                    echo $priceAr[0] . ' руб. ' . $priceAr[1] . ' коп.';
                                    ?>
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            </li><!--
                -->@endforeach
        </ul>
        {!! $products->links() !!}

        <div class="webText noShadow mb1">
            <div id="share">
                <div class="social" data-url="{{ secure_url($_SERVER['REQUEST_URI']) }}"
                     data-title="{{  $page->title }}">
                    <div class="like">Поделиться с друзьями:</div>
                    <a class="push facebook" data-id="fb"><i class="fa fa-facebook"></i> </a>
                    <a class="push twitter" data-id="tw"><i class="fa fa-twitter"></i> </a>
                    <a class="push vkontakte" data-id="vk"><i class="fa fa-vk"></i> </a>
                    <a class="push google" data-id="gp"><i class="fa fa-google-plus"></i> </a>
                    {{--<a class="push ok" data-id="ok"><i class="fa fa-odnoklassniki"></i> OK</a>--}}
                </div>
            </div>
            {!! html_entity_decode($page->content) !!}
        </div>
        @include('inc.visited')
        </div>
    </section>
@endsection