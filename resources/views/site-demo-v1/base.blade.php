<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Cloud MLM Software') }}</title>
    @show @section('meta_description')
    <meta name="description" content="@lang('site.site_description_value')"/>@show 
    @show @section('og_title')
    <meta property="og:title" content="">@show 
    @show @section('og_type')
    <meta property="og:type" content="website">@show 
    @show @section('og_url')
    <meta property="og:url" content="">@show 
    @show @section('og_sitename')
    <meta property="og:site_name" content="">@show 
    @show @section('og_description')
    <meta property="og:description" content="">@show 

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body id="site">
@include('site.partials.header')
<div id="app"></div>
@yield('content')
@include('site.partials.footer')




@yield('topscripts')
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
@if (isset($errors) && !$errors->isEmpty())
<script type="text/javascript">
swal("","@foreach ($errors->all() as $error){{ $error }}@endforeach","error");
</script>
@endif
@if (session()->has('flash_notification.message'))
  @if (session()->has('flash_notification.overlay'))
      <script type="text/javascript">
       swal("{!! Session::get('flash_notification.title') !!}","{!! Session::get('flash_notification.message') !!}","{!! Session::get('flash_notification.level') !!}");
      </script>
  @else
      <script type="text/javascript">
       swal("{!! session('flash_notification.level') !!}"," {!! session('flash_notification.message') !!}","{!! session('flash_notification.level') !!}");
      </script>
  @endif
@endif
</body>
</html>
