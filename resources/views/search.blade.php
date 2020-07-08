@extends('layouts.layout')
@extends('layouts.top')
@extends('layouts.footer')

@section('content')

    <section class="cf navBlock catPage">
        <div class="inner">
            <div class="bread">

                <ul>
                    <li><a href="/" class="tr-a">Главное</a></li><li><i class="fa fa-angle-right"></i></li><li>Результат поиска</li>
                </ul>
            </div>
            <header class="prodCat white">

                <h1>Результат поиска по словам: "{{ $word }}"</h1>

            </header>
            @if(count($products) > 0)
                <ul class="products2">
                @foreach($products as $product)<!--
                    --><li>
                        <a href="{{ $product->al_cat . '/' . $product->alias }}" class="tr-a">
                            <div class="tr">
                                <div class="td td-img">
                                    <img src="{{ url('image/cache/'.$product->image) }}" alt="{{ $product->name }}" onError="this.onerror=null;this.src='{{url('image/unavailable-sm.jpg')}}';" />
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
                                            if(empty($priceAr[1])) $priceAr[1] = 0;
                                            elseif(mb_strlen($priceAr[1]) == 1 && (int)$priceAr[1] > 0) $priceAr[1] .= 0;
                                            echo $priceAr[0].' руб. '.$priceAr[1].' коп.';

                                            ?>
                                </span>
                                        <span class="discount">
                                    <span class="del">
                                    <?php
                                        $price = rtrim($product->price, 0);
                                        $priceAr = explode('.', $price);
                                        if(empty($priceAr[1])) $priceAr[1] = 0;
                                        elseif(mb_strlen($priceAr[1]) == 1 && (int)$priceAr[1] > 0) $priceAr[1] .= 0;
                                        echo $priceAr[0].' руб. '.$priceAr[1].' коп.';
                                        ?>
                                </span>
                                            <?php
                                            $skidka = 100 - ($product->discount / $product->price)*100;
                                            echo ' Скидка: '.round($skidka).'%';
                                            ?>
                                </span>

                                    @else
                                        <span class="price">
                                     <?php
                                            $price = rtrim($product->price, 0);
                                            $priceAr = explode('.', $price);
                                            if(empty($priceAr[1])) $priceAr[1] = 0;
                                            elseif(mb_strlen($priceAr[1]) == 1 && (int)$priceAr[1] > 0) $priceAr[1] .= 0;
                                            echo $priceAr[0].' руб. '.$priceAr[1].' коп.';
                                            ?>
                                </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </li><!--
                -->@endforeach
                </ul>
            @else
            <ul class="searchres products2">
                <span class="nonefound">Такой товар не найден</span>
            </ul>
            @endif
        </div>
    </section>
@endsection