@extends('layouts.layout')
@extends('layouts.top')
@extends('layouts.footer')

@section('content')
    <section class="cf navBlock catPage">
        <div class="inner">
            <div class="bread">
                <ul class="nobck">
                    <li><a href="{{secure_url('/')}}" class="tr-a">Главная</a></li><li><i class="fa fa-angle-right"></i></li><li>{{ $page->name }}</li>
                </ul>
            </div>
            <header class="prodCat white">
                <h1>{{ $page->name }}</h1>
            </header>

            <div class="webText noShadow mb1">
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
                {!! html_entity_decode($page->content) !!}
            </div>

            <ul class="products pr-623">
            @foreach($subcats as $sc)<!--
                    --><li class="c-4">
                    <a href="{{ secure_url($sc->alias) }}" class="item tr-a">
                        <div class="category-legend">{{  $sc->price }}</div>
                        <span class="img">
                            <img height="188.2px" width="319.5px" src="{{ secure_asset('image/'.$sc->image) }}" alt="{{ $sc->name }}" onError="this.onerror=null;this.src='{{secure_url('image/unavailable-sm.jpg')}}';" >
                        </span>
                        <span class="title tr-a">
                            <h3>{{ $sc->name }}</h3>
                        </span>
                    </a>
                </li><!--
            -->@endforeach<!--
                -->
            </ul>
            @include('inc.visited')
        </div>
    </section>
@endsection