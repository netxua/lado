<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Admin Eagle | Log in</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" >
        <link rel="stylesheet" href="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/bootstrap/dist/css/bootstrap.min.css?v=3.3.7">
        <link rel="stylesheet" href="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/css/AdminLTE.css" >
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        @yield('content')
        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/jquery/dist/jquery.min.js?v=3.2.1"></script>
        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/bootstrap/dist/js/bootstrap.min.js?v=3.3.7"></script>
        <script type="text/javascript" src="//cdn.coz.vn/threejs-bg-line/three.min.js"></script>
        <script type="text/javascript" src="//cdn.coz.vn/threejs-bg-line/projector.js"></script>
        <script type="text/javascript" src="//cdn.coz.vn/threejs-bg-line/canvas-renderer.js"></script>
        <script type="text/javascript" src="//cdn.coz.vn/threejs-bg-line/3d-lines-animation.js"></script>
        <script type="text/javascript" src="//cdn.coz.vn/threejs-bg-line/color.js"></script>
    </body>
</html>
