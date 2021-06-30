<!DOCTYPE html>
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="{{ !empty($description) ? $description : '' }}">
    <meta name="author" content="TWEB.COM.VN">
    <meta name="keyword" content="{{ !empty($keyword) ? $keyword : '' }}">
    <title>{{ !empty($title) ? $title : '' }}</title>

    <link rel="shortcut icon" href="{{ !empty($config['favicon']) ? $config['favicon'] : base_url('favicon.ico') }}"
          type="image/x-icon">
    <link rel="icon" href="{{ !empty($config['favicon']) ? $config['favicon'] : base_url('favicon.ico') }}"
          type="image/x-icon">

    @include('layout.default.layouts.head')
    @include('site.element.head')
</head>

<body id="page-top">
@include('layout.default.layouts.header')
@include('layout.default.layouts.sidebar')
<section>@yield('content')</section>
@include('layout.default.layouts.footer')
@include('site.element.alert')
</body>
</html>
