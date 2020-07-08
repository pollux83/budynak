<!DOCTYPE html>
<html>
<head>

    <title>{{ $page->title }}</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui" />
    <meta name="description" content="{{ $page->meta_description }}" />
    <meta name="keywords" content="{{ $page->keywords }}" />

    <link rel="icon" href="{{secure_asset('/favicon.ico')}}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{secure_asset('/favicon.ico')}}" type="image/x-icon" />
    <link rel="stylesheet" href="{{secure_asset('/css/main.css?v=14')}}" media="screen" />
    <link rel="stylesheet" href="{{secure_asset('/css/mnav.css')}}" media="screen" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Hind+Vadodara:400,300,500,600,700" type="text/css" />
    <link rel="stylesheet" href="{{secure_asset('/fa/css/font-awesome.min.css')}}" type="text/css" />

    <script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.sync.bootstrap.min.js"></script>

    <script src="{{secure_asset('/js/jquery.min.js')}}" type="text/javascript"></script>
    <!--[if lt IE 9]>
    <link rel="stylesheet" href="{{secure_asset('/css/ie.css?v=2')}}" type="text/css" />
    <script src="{{secure_asset('/js/respond.js')}}" type="text/javascript"></script>
    <script src="{{secure_asset('/js/html5shiv.js')}}"></script>
    <![endif]-->

</head>

<body>

        @yield('top')
        @yield('content')
        @yield('footer')

        <script src="{{secure_asset('js/doorstore.js')}}" type="text/javascript"></script>
        <script src="{{secure_asset('js/modernizr.js')}}" type="text/javascript"></script>
        <script src="{{secure_asset('js/mnav.js')}}" type="text/javascript"></script>
        <script type="text/javascript">
            var arrUrl = '{{ ($_SERVER['REQUEST_URI']) }}'.split('cart');
            var data = JSON.parse(localStorage.getItem('budynak_cart'));
            var totlprice = 0;
            for (var i=0;i < data.length;i++){
                var priceArr = data[i].price.split(' ');
                var rub = priceArr[0];
                var cop = priceArr[2];
                totlprice += Number(rub + '.' + cop);
                var html = '';
                html += '<li class="tr-a">';
                html += '<div class="cartimg"><b style="font-size: 400%">'+(Number(i)+1)+'</b></div>';
                html += '<div class="cartinfo"><div class="title">'+data[i].name+'</div>';
                html += '<div class="price"><span class="pr pr1">'+data[i].price+'</span></div></div>';
                html += '<div class="rem"><span class="qty">Кол-во: '+data[i].qty+'</span><a class="remove-btn tr-a" href="#"><i class="fa fa-trash-o" onclick="removeProduct('+"'{{ secure_url($_SERVER["HTTP_REFERER"]) }}'"+', '+i+');"></i></a></div>';
                html += '<input type="hidden" name="product[]" value="'+data[i].name+'|'+data[i].price+'|'+data[i].qty+'">';
                html += '</li>';
                $('.cartlist').append(html);
            }
            var string = totlprice.toString();
            if(string.toString().indexOf('.') > 0){
                priceArr = [];
                priceArr = string.split('.');
                if(priceArr[1].length < 2) priceArr[1] *= 10;
                totlprice = priceArr[0]+' руб. '+priceArr[1]+' коп.';
            } else totlprice += ' руб.';
            html = '<li class="mt20 total"><div class="totrow"><span class="totl bold">Итого:</span><span class="totr bold">'+totlprice+'</span></div></li>';
            html += '<input type="hidden" name="total_amount" value="'+totlprice+'">';
            $('.cartlist').append(html);
        </script>
        <script src="{{secure_asset('js/cartview.js?v2')}}" type="text/javascript"></script>
        <script type="text/javascript">if('{{$customerResult}}') deleteToCart();</script>
        <!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter17370907 = new Ya.Metrika({id:17370907, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/17370907" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-38323358-1']);
            _gaq.push(['_trackPageview']);
            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
        <!-- BEGIN JIVOSITE CODE {literal} -->
        <script type='text/javascript'>
            (function(){ var widget_id = 'UlOZRP0ofU';
                var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
        <!-- {/literal} END JIVOSITE CODE -->
        <script async="async" src="https://w.uptolike.com/widgets/v1/zp.js?pid=1722775" type="text/javascript"></script>
        <script src="{{secure_asset('js/share.js')}}"></script>
        {{--<script src="{{secure_asset("js/easyzoom.js?v=2")}}"></script>--}}
        {{--<script>
            var $easyzoom = $('.easyzoom').easyZoom();
            var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');
            $('.thumbnails').on('click', 'a', function(e) {
                var $this = $(this);
                $('.thumbnails a').removeClass('active');
                $this.addClass('active');
                e.preventDefault();
                api1.swap($this.data('standard'), $this.attr('href'));
            });
        </script>--}}

</body></html>