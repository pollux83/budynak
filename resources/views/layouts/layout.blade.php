<!DOCTYPE html>
<html>
    <head>
        <title>{{ $page->title }}@if($page->min). Цена от {{ $page->min }} рублей@endif</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui" />
        <meta name="description" content="{{ $page->meta_description }}" />
        <meta name="keywords" content="{{ $page->keywords }}" />
        {!! $page->prev !!}
        {!!  $page->canonical !!}
        {!! $page->next !!}
        <link rel="icon" href="{{secure_asset('public/favicon.ico')}}" type="image/x-icon" />
        <link rel="shortcut icon" href="{{secure_asset('public/favicon.ico')}}" type="image/x-icon" />
        <link rel="stylesheet" href="{{secure_asset('css/main.css')}}" media="screen" />
        <link rel="stylesheet" href="{{secure_asset('css/mnav.css')}}" media="screen" />
        <link rel="stylesheet" href="{{secure_asset('css/slider.css')}}" media="screen" />
        {{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Hind+Vadodara:400,300,500,600,700" type="text/css" />--}}
        <link rel="stylesheet" href="{{secure_asset('fa/css/font-awesome.min.css')}}" type="text/css" />

        <!--[if lt IE 9]>
        <link rel="stylesheet" href="{{secure_asset('css/ie.css')}}" type="text/css" />
        <script src="{{secure_asset('js/respond.js')}}" type="text/javascript"></script>
        <script src="{{secure_asset('js/cartview.js')}}" type="text/javascript"></script>
        <script src="{{secure_asset('js/html5shiv.js')}}"></script>
        <![endif]-->
        <script type="application/ld+json">
            {
              "@context": "http://schema.org",
              "@type": "Store",
              "name": "budynak.by",
              "telephone": "+375 29 608 20 85",
              "image": "https://budynak.by/image/logo_231x70.png",
              "openingHours": "Mo,Tu,We,Th,Fr,Sa,Su 09:00-21:00",
              "address": "Republic of Belarus"
            }
        </script>
    </head>
    <body>

        @yield('top')
        @yield('content')
        @yield('footer')

        <script type="text/javascript" src="https://widget.trustpilot.com/bootstrap/v5/tp.widget.sync.bootstrap.min.js"></script>
        <script src="{{secure_asset('/js/jquery.min.js')}}" type="text/javascript"></script>
        <script src="{{secure_asset('/js/doorstore.js')}}" type="text/javascript"></script>
        <script src="{{secure_asset('/js/modernizr.js')}}" type="text/javascript"></script>
        <script src="{{secure_asset('/js/mnav.js')}}" type="text/javascript"></script>
        <script type="text/javascript">var arrUrl = '{{ $_SERVER['REQUEST_URI'] }}'.split('cart');</script>
        <script src="{{secure_asset('js/cartview.js')}}" type="text/javascript"></script>
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
        <script type="text/javascript" src="{{secure_asset('js/slider.js')}}"></script>
        <script src="{{secure_asset('js/share.js')}}"></script>
        <script src="{{secure_asset('js/bootstrap-slider.js')}}"></script>
        <script>
            $('#sl2').slider();
        </script>
    </body>
</html>