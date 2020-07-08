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
                    @foreach($requests as $r)

                    <li>
                        <a class=" tr-a">

                            <div class="rhs">
                                <header>
                                    <h2>{{ $r->name }}</h2>
                                </header>
                                <span class="date">{{ $r->created_at }}</span>
                                <div class="txt">
                                    {{ $r->content }}
                                </div>
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