<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentellela Alela! | </title>

    <!-- Bootstrap -->
    <link href="css/admin/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="fonts/admin/fonts/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="css/admin/css/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="css/admin/css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="css/admin/css/custom.css" rel="stylesheet">
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>;
    </script>
</head>
        @yield('content')
</html>
