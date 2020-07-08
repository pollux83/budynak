@section('footer')
<footer class="cf">
    <div class="inner cf">
        <div class="c-5">
            <ul>
                <li>
                    <a>Категории товаров</a>
                </li>
                @foreach($cat as $key => $c)
                <li>
                    <a href="{{ secure_url($c->alias) }}" class="tr-a @if($cur_alias == $c->alias)disabled @endif">
                        {{ $c->name }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="c-5">
            <ul>
                <li>
                    <a href="{{secure_url('/spisok-otzyvov')}}" class="tr-a @if($cur_alias == 'spisok-otzyvov')disabled @endif">
                        Отзывы
                    </a>
                </li>
                @foreach($requests as $r)
                <li>
                    <a href="#" class="tr-a">
                        {{ $r->name }}: "{{ str_limit($r->content, 20) }}"
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="c-5">
            <ul>

                <li>
                    <a>Акции</a>
                </li>

                <li>
                    <a href="{{ secure_url($raspr->alias) }}" class="tr-a @if($cur_alias == $raspr->alias)disabled @endif">
                        {{ $raspr->name }}
                    </a>
                </li>


            </ul>
            <ul class="mt40">
                <li>
                    <a href="{{secure_url('/all-news')}}" class="tr-a @if($cur_alias == 'all-news')disabled @endif">
                        Последние новости, статьи
                    </a>
                </li>
                @foreach($post as $p)
                <li>
                    <a href="{{ secure_url('dver/'.$p->alias_post->alias) }}" class="tr-a @if($cur_alias == $p->alias_post->alias)disabled @endif">
                        {{ $p->name }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="c-5">
            <ul>
                <li>
                    <a>Брэнды</a>
                </li>
                @foreach($brands as $key => $b)
                    @if($key > 8)
                    @break
                    @endif
                    <li>
                        <a href="{{ secure_url($b->par_al.'/'.$b->alias) }}" class="tr-a @if($cur_alias == $b->alias)disabled @endif">
                            {{ $b->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="c-5 l-c">
            <ul>
                <li>
                    <a>Информация</a>
                </li>
                @foreach($info as $i)
                <li>
                    <a href="{{ secure_url($i->alias_information->alias) }}" class="tr-a @if($cur_alias == $i->alias_information->alias)disabled @endif">
                        {{ $i->name }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="mspc2"></div>
    </div>
    <div id="btm">
        <div class="inner cf">
            <div class="c-2">
                © budynak.by 2013-2018.
            </div>
            {{--<div class="c-2 l-c">
                create by <a class="tr-a" target="_parent">Salanevich</a>
            </div>--}}
        </div>
    </div>
</footer>
@endsection