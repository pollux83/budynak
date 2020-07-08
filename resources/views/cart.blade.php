@extends('layouts.layout_cart')
@extends('layouts.top')
@extends('layouts.footer')

@section('content')

    <section class="cf navBlock">
        <div class="inner">
            <div class="bread">
                <ul class="empty">
                    <ul>
                        <li><a href="/" class="tr-a">Главное</a></li><li><i class="fa fa-angle-right"></i></li><li>Корзина</li>
                    </ul>
                </ul>
            </div>
            <div class="c-1 l-c">
                <header class="prodCat white">
                    <h1>Заказ</h1>
                </header>
                <div class="webText noShadow mb1">
                    @if($customerResult)
                        <p style="text-align: center;"><strong>ВАШ ЗАКАЗ ПРИНЯТ! НАШ МЕНЕДЖЕР СКОРО С ВАМИ СВЯЖЕТСЯ!!!</strong></p>
                        <ul>
                            <li>ФИО: {{ $customerResult['name'] }}</li>
                            <li>Телефон: {{ $customerResult['contact_number'] }}</li>
                            <li>Адрес: {{ $customerResult['delivery_address'] }}</li>
                            <li>Email: {{ $customerResult['email'] }}</li>
                        </ul>
                        <br>
                    @endif
                    <p>Список товаров:</p>
                </div>
                <div class="cartBox">
                    <form action="" method="post" name="cart">
                        <input name="_token" type="hidden" value="{{csrf_token()}}" />
                        <ul class="cartlist">

                        </ul>
                        @if(!$customerResult)
                        <div class="c-1 p05">
                            <div class="formbox">
                                <div class="inbox">
                                    <label for="name">ФИО <font color="#ff0000">*</font></label>
                                    <input id="name" name="name" type="text" class="tr-a" required="required" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                                </div>
                                <div class="inbox mt15">
                                    <label for="contact_number">Телефон <font color="#ff0000">*</font></label>
                                    <input id="contact_number" name="contact_number" type="text" class="normal" placeholder="29 608 2085" required="required">
                                </div>
                                <div class="inbox mt15">
                                    <label for="delivery_address">Адрес</label>
                                    <input id="delivery_address" name="delivery_address" type="text" class="tr-a" placeholder="Город, улица, дом, квартира">
                                </div>
                                <div class="inbox mt15">
                                    <label for="email">Email</label>
                                    <input id="email" name="email" type="email" class="tr-a">
                                </div>
                            </div>
                        </div>
                        
                        <div class="confterm2">
                            <input type="submit" value="Сделать заказ" class="cartbtn tr-a fr" />
                        @else
                        <div class="confterm2">
                        @endif
                        <?php session_start() ?>
                            <input type="button" value="Продолжить покупки" onClick="window.location='{{ session('url_cart_budynak') }}'" class="cartbtn tr-a" />
                        </div>
                    </form>
                </div>
            </div>
            @include('inc.visited')
        </div>
    </section>
@endsection