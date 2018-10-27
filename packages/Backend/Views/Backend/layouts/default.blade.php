<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{Theme::config('title')}}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="manifest" href="manifest.json" >
        <meta name="eagle_token" content="{!! csrf_token() !!}"/>
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/bootstrap/dist/css/bootstrap.min.css?v=3.3.7">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/css/AdminLTE.css?version=8" >

        <link rel="stylesheet" href="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/css/animate.min.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- jQuery 2.2.3 -->

        <script type="text/javascript" >
            erp = {};
            var base_url = '{{url('')}}';
            var baseUrl = '{{url('')}}';
            var BackEndURL = '{{url(Config::get('app.backendUrl'))}}';
        </script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

        <!--Validation-->
        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/jquery-validation/dist/jquery.validate.min.js?v=1.13.0"></script>
        <!--Jquery Confirm-->
        <link rel="stylesheet" href="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/jquery-confirm2/dist/jquery-confirm.min.css?v=3.3.2">
        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/jquery-confirm2/dist/jquery-confirm.min.js?v=3.3.2"></script>
        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/js/jquery.inputmask.bundle.js"></script>
        
        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/ckeditor/ckeditor.js"></script>
        
        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/jQuery-QueryBuilder/dist/js/query-builder.standalone.min.js"></script>
        <link href="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/select2/dist/js/select2.min.js"></script>

        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/selectize/dist/js/standalone/selectize.js"></script>
        <link rel="stylesheet" href="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/selectize/dist/css/selectize.default.css">

        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/xdan-autocomplete/jquery.autocomplete.js"></script>
        <link rel="stylesheet" href="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/xdan-autocomplete/jquery.autocomplete.css">

        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/magnific-popup/dist/jquery.magnific-popup.js"></script>
        <link rel="stylesheet" href="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/magnific-popup/dist/magnific-popup.css" >
        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/jquery-html5-upload/jquery.html5_upload.js"></script>


        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/icheck/icheck.min.js"></script>
        <link rel="stylesheet" href="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/icheck/skins/minimal/minimal.css" >

        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/daterangepicker/moment.min.js"></script>
        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/daterangepicker/daterangepicker.js"></script>
        <link rel="stylesheet" href="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/daterangepicker/daterangepicker.css" >

        <script src="//maps.google.com/maps/api/js?key=AIzaSyAHa_nwcjR0pfJ6w0S0SGA7MG9jMzNm_K0" ></script>
        <script src="//cdn.coz.vn/gmaps/gmaps.min.js"></script>

        <link rel="stylesheet" href="//cdn.coz.vn/nprogress/nprogress.css" >
        <script src="//cdn.coz.vn/nprogress/nprogress.js"></script>
        <script src="//cdn.coz.vn/jquery-tmpl/jquery.tmpl.min.js"></script>
        <script src="//cdn.coz.vn/jquery-pjax/jquery.pjax.js"></script>

        <link rel="stylesheet" href="//cdn.coz.vn/simditor/styles/simditor.css" >
        <script src="//simditor.tower.im/assets/scripts/module.js"></script>
        <script src="//simditor.tower.im/assets/scripts/uploader.js"></script>
        <script src="//simditor.tower.im/assets/scripts/hotkeys.js"></script>
        <script src="//cdn.coz.vn/simditor/lib/simditor.js"></script>
        <script src="//cdn.coz.vn/html5sortable/jquery.sortable.min.js" ></script>

        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/js/core.js" type="text/javascript"></script>
        <link rel="stylesheet" href="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/css/style.css" >
    </head>
    <body class="skin-blue" >
        <div class="wrapper row-offcanvas row-offcanvas-left" >
            <aside class="left-side sidebar-offcanvas">
                <section class="sidebar">
                    @include('BackEnd::layouts.common.menu');
                </section>
            </aside>
            <aside class="right-side" >
                @if(!empty(Session::get('message')))
                <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible">
                    <button type="button" class="close"  aria-hidden="true">×</button>
                    @if(is_array(Session::get('message')))
                        @foreach (Session::get('message') as $key=>$error)
                            @if(is_array($error))
                                @foreach ($error as $k=>$v)
                                    {!! $v !!}<br>
                                @endforeach
                            @else
                                {!! $error !!}
                            @endif
                        @endforeach
                    @else
                        {{ Session::get('message') }}
                    @endif
                </div>
                @endif
                <div class="clearfix" data-pjax-container="Main" >
                    @yield('content')
                </div>
            </aside>
        </div>
        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/plugins/bootstrap/dist/js/bootstrap.min.js?v=3.3.7"></script>
        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/js/app.js"></script>
        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/js/demo.js"></script>
        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/js/systemJs.js" type="text/javascript"></script>
        <script src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/js/sspJs.js" type="text/javascript"></script>
    </body>
</html>
