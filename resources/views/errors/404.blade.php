@extends('layouts.layout')
@extends('layouts.top')
@extends('layouts.footer')


@section('content')

    <section class="cf navBlock catPage">
        <div class="inner">
            <header class="prodCat white">
                <h1>Извините, ошибка 404! Страница не найдена</h1>
            </header>

            <div class="webText noShadow mb1">
                <p>Возможно такого товара и категории больше нет на сайте. Возможно найдете альтернативные товара зайдя
                    на нашу
                    <a href="{{ secure_url('/') }}">главную страницу</a>.</p>
                <p>
                <ul>
                    <li>
                        <a>Категории товаров:</a>
                    </li>
                    @foreach($cat as $key => $c)
                        @if($key !== 6)
                            <li>
                                <a href="{{ url($c->alias) }}" class="tr-a">
                                    {{ $c->name }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                </p>

            </div>
        </div>
    </section>
@endsection