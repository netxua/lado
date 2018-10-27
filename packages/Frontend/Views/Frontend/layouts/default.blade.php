<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{!! !empty($seoTitle) ? $seoTitle : $website['erp_name'] !!}</title>
        <link rel='shortcut icon' href='{{ url('') }}{{ HelperImages::getUrlImage($website['logo'] , 100) }}' type='image/png' data-domain='coz.vn' />
        <meta charset='utf-8' />
        <meta name='robots' content='noindex, nofollow' >
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' /><![endif]-->
        <link rel='canonical' href='{{ url('') }}' />
        <meta name='dc.created' content='{!! $website['updated_at'] !!}' />
        <meta name='dc.publisher' content='{{ url('') }}' />
        <meta name='dc.rights.copyright' content='{{ url('') }}' />
        <meta name='dc.creator.name' content='{{ url('') }}' />
        <meta name='dc.creator.email' content='{!! $website['erp_email_customer'] !!}' />
        <meta name='dc.identifier' content='{{ url('') }}' />
        <meta name='copyright' content='{{ url('') }}' />
        <meta name='author' content='{{ url('') }}' />
        <meta http-equiv='content-language' content='{!! $lang !!}' />
        <meta http-equiv='X-UA-Compatible' content='IE=EmulateIE7' />
        <meta property='og:site_name' content='{!! !empty($seoTitle) ? $seoTitle : $website['erp_name'] !!}' />
        <meta property='og:type' content='website' />
        <meta name='viewport' content='width=device-width, initial-scale=1' >

        <meta name="keywords" content="{!! !empty($seoKeywords) ? $seoKeywords : $website['keywords'] !!}">
        <meta name="description" content="{!! !empty($seoDescription) ? $seoDescription : $website['description'] !!}" >
        <meta name="twitter:card" content="website" >
        <meta name="twitter:site" content="{{ url('') }}" >
        <meta name="twitter:title" content="{!! !empty($seoTitle) ? $seoTitle : $website['erp_name'] !!}" >
        <meta name="twitter:description" content="{!! !empty($seoDescription) ? $seoDescription : $website['description'] !!}" >
        <meta name="twitter:creator" content="{{ url('') }}" >
        <meta name="twitter:image" content="{{ url('') }}{!! !empty($seoImage) ? $seoImage : HelperImages::getUrlImage($website['logo'] , 500) !!}" >
        <meta property="og:title" content="{!! !empty($seoTitle) ? $seoTitle : $website['erp_name'] !!}" >
        <meta property="og:site_name" content="{{ url('') }}" >
        <meta property="og:description" content="{!! !empty($seoDescription) ? $seoDescription : $website['description'] !!}" >
        <meta property="og:image" content="{{ url('') }}{!! !empty($seoImage) ? $seoImage : HelperImages::getUrlImage($website['logo'] , 500) !!}" >
        <meta property="og:url" content="{!! !empty($seoUrl) ? $seoUrl : url('') !!}" >
        <meta name="article:tag" content="{!! !empty($seoTitle) ? $seoTitle : $website['erp_name'] !!}" >

        <script type="text/javascript" >
            var baseUrl = '{{ url('') }}';
            var _prefixLang = '{{ Session::get('lang') }}';
            var _token = '{!! csrf_token() !!}';
            var _keywords = {!! json_encode($_keywords) !!};
        </script>
    </head>
    <body>
        <div class="pages" >
            @if( $hasHeader )
                @include('FrontEnd::layouts.pie._header')
            @endif

            @yield('content')

            @if( $hasFooter )
                @include('FrontEnd::layouts.pie._footer')
            @endif
        </div>
    </body>
</html>
