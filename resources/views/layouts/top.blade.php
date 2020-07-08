@section('top')

    <section id="top">
        <div id="rTop">
            <div class="inner cf">
                <div class="c-1 l-c">
                    <ul>
                        <li class="cart cdropl">
                            <div class="inner cf">
                                <a class="viewcart tr-a" onclick="cart();"><i class="fa fa-shopping-cart"
                                                                              aria-hidden="true">:<span class="qtycart">0</span></i><i
                                            class="fa fa-angle-down"></i></a>
                                <a class="tr-a" {{--href="/cart/"--}} onclick="cart();">
                                <span>
                                    Заказ: </span>
                                    <span class="qtycart">
                                    0
                                    </span>шт.<i class="fa fa-angle-down"></i>
                                </a>
                            </div>
                            <ul id="cdrop">
                                <form action="{{secure_url('/cart')}}" method="get" name="Enquiry">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="detinfo cartview">
                                        <div id="list-empty">
                                            <span class="title">Список пуст! Закажите и тогда здесь будет товар.</span>
                                        </div>
                                    </div>
                                </form>
                            </ul>
                        </li>
                        {{--<li>
                            <a class="tr-a" href="{{ secure_url('uslovia-soglashenia') }}">Замер</a>
                        </li>--}}
                        <li>
                            <a class="tr-a @if($cur_alias == 'ustanovka-dverey')disabled @endif"
                               href="{{ secure_url('ustanovka-dverey') }}">Установка</a>
                        </li>
                        <li>
                            <a class="tr-a @if($cur_alias == 'info-dostavka')disabled @endif"
                               href="{{ secure_url('info-dostavka') }}">Доставка</a>
                        </li>
                        <li class="cdropl">
                            <a class="tr-a">Контакты <i class="fa fa-angle-down"></i></a>
                            <ul id="cdrop">
                                <div class="inner cf">
                                    <li class="c-3">
                                    <span class="title">
                                    	ДВЕРИ, ФУРНИТУРА и др. товары:
                                    </span>
                                        <span class="phone">
                                    	<a href="tel:+375 29 608 2085" class="tr-a"> +375 29 608 2085<span
                                                    style="font-size:14px"> Велком</span></a>
                                    </span>
                                        <span class="phone">
                                        <a href="tel:+375 29 608 2085" class="tr-a"> +375 29 748 1613<span
                                                    style="font-size:14px"> МТС (viber)</span></a>
                                    </span>
                                        <span class="phone">
                                    	<a href="tel:+375 25 504 7298" class="tr-a"> +375 25 504 7298<span
                                                    style="font-size:14px"> Лайф</span></a>
                                    </span>
                                    </li>
                                    <!--li class="c-3">
                                    <span class="title">
                                    	ОТДЕЛКА, РЕМОНТ КВАРТИР, ДОМОВ:
                                    </span>
                                        <span class="phone">
                                    	<a href="tel:+375 29 608 2085" class="tr-a"> +375 29 124 4461<span
                                                    style="font-size:14px"> Велком</span></a>
                                    </span>
                                        <span class="phone">
                                    	<a href="tel:+375 29 745 5889" class="tr-a"> +375 44 554 6979<span
                                                    style="font-size:14px"> Велком</span></a>
                                    </span>
                                        <span class="phone">
                                    	<a href="tel:+375 25 504 7298" class="tr-a"> +375 29 757 5550<span
                                                    style="font-size:14px"> МТС</span></a>
                                    </span>
                                    </li-->
                                    <li class="c-3">
                                    <span class="title">
                                    	EMAIL и график работы
                                    </span>
                                        <span class="address">
                                    	zayavki@budynak.by
                                        <br/>
                                    </span>
                                        <span class="address">
                                    	Работаем c 9.00 до 19.00 без выходных
                                        <br/>
                                    </span>
                                        <span class="address">
                                    	Оплату принимаем по наличному и безналичному  расчету
                                        <br/>
                                    </span>
                                        <span class="address">
                                    	Минск, Могилев, Витебск, Гродно, Брест, Гомель
                                        <br/>
                                    </span>
                                        <span class="btn">
                                    	<a href="{{secure_url('/contact/')}}"
                                           class="tr-a @if($cur_alias == 'contact')disabled @endif">Подробнее</a>
                                        <a href="{{secure_url('/spisok-otzyvov/')}}"
                                           class="tr-a @if($cur_alias == 'spisok-otzyvov')disabled @endif">Отзывы</a>
                                    </span>
                                    </li>
                                </div>
                            </ul>
                        </li>
                        <li>
                            {{-- <p>8(029)608 2085 (Велком) | 8(029)748 1613 (МТС)</p>--}}
                        </li>
                        <li class="mobsearch">
                            <a class="tr-a"><i class="fa fa-search"></i></a>
                        </li>
                        <li class="search tr-a">
                            <form id="search-form" method="post" action="{{secure_url('/search')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="text" placeholder="Поиск товара" name="search" id="search"
                                       class="search-box"
                                       autocomplete="off">
                                <input class="search-button tr-a" type="submit" value="Найти" name="sbutton">
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wTop">
            <div class="inner cf">
                <div class="c-1 l-c">
                    <a class="door-store @if($cur_alias == '')disabled @endif" href="{{secure_url('/')}}">
                        <img src="{{secure_asset('/image/logo_231x70.png')}}" alt="budynak.by"/>
                    </a>
                    <nav>
                        <a class="navbtn dl-trigger">
                            <span></span>
                        </a>

                        <div class="dl-menuwrapper" id="navBox">
                            <div class="toptr"></div>
                            <ul class="dl-menu">

                                <li class="li8">
                                    <a href="{{secure_url('/')}}" class="active @if($cur_alias == '')disabled @endif">Главная</a>
                                </li>
                                @foreach((array) $mainmenu as $alias1 => $arr)
                                    @if($alias1 !== 'rasprodaga')
                                        @foreach((array) $arr as $alias2 => $name)
                                            @if($alias2 == '0')
                                                <li class="li8">
                                                    <a class="@if($cur_alias == $alias1)disabled @endif"
                                                       href="{{ secure_url($alias1) }}">{{ $name }}<i
                                                                class="fa fa-angle-right"></i></a>
                                                    <ul class="dl-submenu {{--bck11--}}">
                                                        <div class="inner cf">
                                                            @else
                                                                <li class="c-5 li11">
                                                                    <a class="@if($cur_alias == explode('/', $alias2)[1])disabled @endif"
                                                                       href="{{secure_url($alias2)}}">
                                                                <span class="title tr-a">
                                                                    {{ $name->name }}
                                                                </span>
                                                                    </a>
                                                                </li>
                                            @endif
                                        @endforeach
                                                        </div>
                                                    </ul>
                                                </li>
                                    @else
                                                <li class="li8">
                                                    <a>Бренды<i class="fa fa-angle-right"></i></a>
                                                    <ul class="dl-submenu {{--bck11--}}">
                                                        <div class="inner cf">
                                                            @foreach($brands as $key => $b)
                                                                @if($key >= 30)
                                                                    @break
                                                                @endif
                                                                    <li class="c-5 li11">
                                                                        <a class="@if($cur_alias == $b->alias)disabled @endif"
                                                                           href="{{secure_url($b->par_al .'/'. $b->alias)}}">
                                                                <span class="title tr-a">
                                                                    {{ $b->name }}
                                                                </span>
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                        </div>
                                                    </ul>
                                                </li>
                                                <li class="li8 offers">
                                                    <a href="{{ secure_url($alias1) }}"
                                                       class="tr-a @if($cur_alias == $alias1)disabled @endif">{{ $arr[0] }}</a>
                                                </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </section>
@endsection