<!DOCTYPE html>
<html>
<head>

    <title>The Door Store - Oak Doors, Walnut Doors, Door Handles, Pine Doors Northern Ireland</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui" />
    <meta name="distribution" content="global">
    <meta name="rating" content="Safe For Kids">
    <meta name="revisit-after" content="5 days">
    <meta name="description" content="The Door Store is the UK and Ireland's largest door supplier and stockist of white oak doors, walnut doors, mahogany doors, doors handles and wood & laminate floors from our branches in Belfast, Northern Ireland." />
    <meta name="keywords" content="doors ireland, door store, door handles, floor store, doors belfast, door suppliers ireland, northern ireland, internal doors, external doors, door handles, mouldings, stairs, staircasing, lourve doors, mirror doors, flooring, mahogany doors, clear pine doors, knotty pine doors, pitch pine doors, white oak doors, walnut doors, grp doors, upvc doors, laminate flooring, stone flooring, wooden flooring" />

    <link rel="alternate" href="http://www.doorstore.ie" hreflang="en-IE" />
    <link rel="alternate" href="http://www.doorstore.co.uk" hreflang="x-default" />

    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/css/main.css?v=12" media="screen" />
    <link rel="stylesheet" href="/css/mnav.css" media="screen" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Hind+Vadodara:400,300,500,600,700" type="text/css" />
    <link rel="stylesheet" href="/fa/css/font-awesome.min.css" type="text/css" />   
    <!--[if lt IE 9]>
    <link rel="stylesheet" href="/css/ie.css?v=2" type="text/css" />
    <script src="/js/respond.js" type="text/javascript"></script>
    <script src="/js/html5shiv.js"></script>
    <![endif]-->


    <script Language="JavaScript">
        function Form_Validator(theForm)
        {
            if (theForm.name.value == "")
            {
                alert("Please enter your name.");
                theForm.name.focus();
                return (false);
            }
            if (theForm.telephone.value == "" && theForm.email.value == "")
            {
                alert("Please enter your telephone number or email address.");
                theForm.telephone.focus();
                return (false);
            }
            if (theForm.enquiry.value == "")
            {
                alert("Please enter some details about your enquiry.");
                theForm.enquiry.focus();
                return (false);
            }

            return (true);
        }
    </script>
</head>

<body>

        @yield('top')
        @yield('content')
        @yield('footer')

        <script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.sync.bootstrap.min.js"></script>
    	<script src="/js/jquery.min.js" type="text/javascript"></script>
        <script src="{{secure_asset('js/doorstore.js')}}" type="text/javascript"></script>
        <script src="{{secure_asset('js/modernizr.js')}}" type="text/javascript"></script>
        <script src="{{secure_asset('js/mnav.js')}}" type="text/javascript"></script>

        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
            ga('create', 'UA-40557542-1', 'auto');
            ga('send', 'pageview');
        </script>
        <script async="async" src="https://w.uptolike.com/widgets/v1/zp.js?pid=1722775" type="text/javascript"></script>
</body></html>