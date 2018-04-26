<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="{{ asset('Common/layui/css/layui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Common/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Admin/css/style.css') }}">
    @section('loadCss')

    @show
    @section('style')

    @show
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

@section('body')

@show

<script src="{{ asset('Common/layui/layui.all.js') }}"></script>
<script src="{{ asset('Common/layui/layuiGlobal.js') }}"></script>
<script src="{{ asset('Common/js/functions.js') }}"></script>
<script type="text/javascript">
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
</script>
@section('script')

@show
</body>
</html>