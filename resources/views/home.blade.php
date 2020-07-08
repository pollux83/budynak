@extends('layouts.layout')
@extends('layouts.top')
@extends('layouts.footer')

@section('content')

    <section id="media" class="navBlock">
        <div>
            <a href="#" class="control_next">></a>
            <a href="#" class="control_prev"><</a>
            <img id="slider" src="image/slide/img-1.jpg" alt="">
            <div class="slider_legend">
                <h1>Двери, фурнитура и др. товары с установкой и гарантией</h1>
            </div>
        </div>
    </section>

    <section class="cf">
        <div class="inner">
            @foreach($allSubcats as $key => $subcats)
                @if($key == 0)
            <div class="c-1 l-c mt-32">
                <header class="prodCat white">
                    <h2>{{  $cat[$key]->name }}</h2>
                    <a href="{{ $cat[$key]->alias }}" class="tr-a">Посмотреть все</a>
                </header>
                <ul class="products">
                @foreach($subcats as $uri => $subcat)<!--
                    --><li class="c-4">
                            <a href="{{($uri)}}" class="item tr-a">
                                <div class="category-legend">от {{ round($subcat->min) }} до {{ round($subcat->max) }} руб.</div>
                            <span class="img">
                                <img height="188.2px" width="319.5px" src="image/{{$subcat->image}}" alt="{{$subcat->name}}" onError="this.onerror=null;this.src='{{('image/unavailable-sm.jpg')}}';">
                            </span>
                            <span class="title tr-a">
                                <h3>{{$subcat->name}}</h3>
                            </span>
                            </a>
                        </li><!--
                    -->@endforeach
                </ul>
            </div>
                @elseif($key == 1)
            <div class="c-1 mt20">
                <header class="prodCat white">
                    <h2>{{  $cat[$key]->name }}</h2>
                    <a href="{{ $cat[$key]->alias }}" class="tr-a">Посмотреть все</a>
                </header>
                <ul class="products">
                @foreach($subcats as $uri => $subcat)<!--
                    --><li class="c-4">
                            <a href="{{($uri)}}" class="item tr-a">
                                <div class="category-legend">от {{ round($subcat->min) }} до {{ round($subcat->max) }} руб.</div>
                            <span class="img">
                                <img height="188.2px" width="319.5px" src="image/{{$subcat->image}}" alt="{{$subcat->name}}" onError="this.onerror=null;this.src='{{('image/unavailable-sm.jpg')}}';">
                            </span>
                            <span class="title tr-a">
                                <h3>{{$subcat->name}}</h3>
                            </span>
                            </a>
                        </li><!--
                    -->@endforeach
                </ul>
            </div>
                @elseif($key == 2 || $key == 3)
                    <div class="c-2 1-c mt20">
                        <header class="prodCat">
                            <h2>{{ $cat[$key]->name }}</h2>
                            <a href="{{ $cat[$key]->alias }}" class="tr-a">Посмотреть все</a>
                        </header>
                        <ul class="products">
                        @foreach($subcats as $uri => $subcat)<!--
                            --><li class="c-2">
                                <a href="{{($uri)}}" class="item tr-a">
                                    <div class="category-legend">от {{ round($subcat->min) }} до {{ round($subcat->max) }} руб.</div>
                            <span class="img">
                                <img height="188.2px" width="319.5px" src="image/{{$subcat->image}}" alt="{{$subcat->name}}" onError="this.onerror=null;this.src='{{('image/unavailable-sm.jpg')}}';">
                            </span>
                            <span class="title tr-a">
                                <h3>{{$subcat->name}}</h3>
                            </span>
                                </a>
                            </li><!--
                    -->@endforeach
                </ul>
            </div>
                    @elseif($key == 4)
                    <div class="c-1 l-c mt20">
                        <header class="prodCat">
                            <h2>{{ $cat[$key]->name }}</h2>
                            <a href="{{ $cat[$key]->alias }}" class="tr-a">Посмотреть все</a>
                        </header>
                        <ul class="products pr-629">
                        @foreach($subcats as $uri => $subcat)<!--
                            --><li class="c-4">
                               <a href="{{($uri)}}" class="item tr-a">
                                   <div class="category-legend">{{ $subcat->price }}</div>
                            <span class="img">
                                <img height="188.2px" width="319.5px" src="{{secure_asset('image/'.$subcat->image)}}" alt="{{$subcat->name}}" onError="this.onerror=null;this.src='{{('image/unavailable-sm.jpg')}}';">
                            </span>
                            <span class="title tr-a">
                                <h3>{{$subcat->name}}</h3>
                            </span>
                               </a>
                                </li><!--
                    -->@endforeach
                        </ul>
                    </div>
                @endif
            @endforeach

            <div class="c-1 l-c mt50">
                <div class="webText homeText">
                    <div class="c-25">
                        <header>
                            <h1>{{ $page->name }}</h1>
                        </header>
                        <span class="homeMsg">
                        	{{ $page->meta_description }}
                        </span>

                    </div>
                    <div class="c-75 l-c">
                    	<div id="share">
                            <div class="social" data-url="{{secure_url('/')}}" data-title="{{  $page->title }}">
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
            </div>
        </div>
    </section>


@endsection