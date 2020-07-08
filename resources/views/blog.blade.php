@extends('layouts.layout')
@extends('layouts.top')
@extends('layouts.footer')

@section('content')
    <section class="cf navBlock newsPage">
        <div class="inner">
            <div class="bread">
                {{--<a href="/blog/" class="back tr-a"><i class="fa fa-angle-left"></i> Назад</a>--}}
                <ul>
                    <li><a href="/" class="tr-a">Главная</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    @if(count($back) > 0)
                    <li><a href="{{secure_url($back['alias'])}}" class="tr-a">{{ $back['name'] }}</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    @endif
                    <li>{{ $blog[0]->name }}</li>
                </ul>
            </div>
            <div class="c-1 l-c">
                <div class="webText blogText">
                    @if(count($back) > 0)
                    <a href="{{ secure_url($back['alias']) }}" class="back2 tr-a"><i class="fa fa-angle-left"></i> Назад</a>
                    @endif
                    <header>
                        <h1 class="readmore">{{ $blog[0]->name }}</h1>
                    </header>
                    {{--<span class="date">21/03/2017</span>--}}
                    <div class="text">
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
                        {!! html_entity_decode($blog[0]->content) !!}
                    </div>
                </div>
            </div>
            @if($page->name == 'Контакты компании')
            <div class="c-1">
                <header class="prodCat white mb1">
                    <h2>Отправить отзыв, предложения</h2>
                </header>
                <div class="formbox cformbox">

                    <form name="form1" method="post" action="{{ secure_url('request') }}" class="right-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="inbox">
                            <label for="name">Как Вас зовут? <i>*</i></label>
                            <input id="name" type="text" maxlength="20" size="25" class="tr-a" name="name" required="required">
                        </div>
                        <div class="inbox mt15">
                            <label for="content">Послание <i>*</i></label>
                            <textarea name="content" cols="60" rows="6" class="tr-a" id="content"></textarea>
                        </div>
                        <div class="inbox mt15">
                            <label for="email">Email</label>
                            <input id="email" type="email" maxlength="100" size="25" class="tr-a" name="email">
                        </div>
                        <input type="submit" value="отправить" class="tr-a mt30">
                    </form>
                </div>
            </div>
                @endif
            @include('inc.visited')
        </div>
        @if(Session::has('message'))
            <script>alert('{{ Session::get('message') }}!')</script>
        @endif
    </section>
@endsection