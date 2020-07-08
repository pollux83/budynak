@extends('layouts.layout')
@extends('layouts.top')
@extends('layouts.footer')

@section('content')
    <section class="cf navBlock">
        <div class="inner">
            <div class="bread">
                <ul class="empty">
                    <li>&nbsp;</li>
                </ul>
            </div>
            <div class="c-1 l-c">
                <header class="prodCat white">
                    <h1>{{ $page->name }}</h1>
                </header>
                <ul class="blog">
                    @foreach($listBlog as $lb)

                    <li>
                        <a href="{{ secure_url('dver/'.$lb->alias) }}" class=" tr-a">
                                                    	<div class="img">
                                                            <img src="{{ secure_url('image/'.$lb->image) }}" onerror="this.onerror=null;this.src='{{secure_url('image/unavailable-sm.jpg')}}';" alt="{{ $lb->name }}" />
                                                        </div>
                            <div class="rhs">
                                <header>
                                    <h2>{{ $lb->name }}</h2>
                                </header>
                                <span class="date">{{ $lb->created_at }}</span>
                                {{--<div class="txt">
                                    {!! str_limit(html_entity_decode($lb->content), 100) !!}
                                </div>--}}
                            </div>
                        </a>
                    </li>
                    @endforeach

                </ul>
            </div>
            @include('inc.visited')
        </div>
    </section>
@endsection