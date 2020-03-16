<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">

    <title>{{$title ?? 'Tech Advisory Platform'}}</title>


    @section('head')
        <link href="{{url('/assets/vendors/core/core.css')}}" rel="stylesheet">
        <link href="{{url('/assets/fonts/feather-font/css/iconfont.css')}}" rel="stylesheet">
        <link href="{{url('/assets/vendors/dropzone/dropzone.min.css')}}" rel="stylesheet">
        <link href="{{url('/assets/css/techadvisory/style.css')}}" rel="stylesheet">
        <link href="{{url('/assets/css/techadvisory/extra.css')}}" rel="stylesheet">
        <link href="{{url('/assets/vendors_techadvisory/countdown/countdown.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{url('assets/vendors/select2/select2.min.css')}}">
    @show
</head>

<body>
    @yield('content')

    @section('scripts')
        <script src="{{url('/assets/vendors/core/core.js')}}"></script>
        <script src="{{url('/assets/vendors/chartjs/Chart.min.js')}}"></script>
        <script src="{{url('/assets/vendors/jquery.flot/jquery.flot.js')}}"></script>
        <script src="{{url('/assets/vendors/jquery.flot/jquery.flot.resize.js')}}"></script>
        <script src="{{url('/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{url('/assets/vendors/apexcharts/apexcharts.min.js')}}"></script>
        <script src="{{url('/assets/vendors/progressbar.js/progressbar.min.js')}}"></script>
        <script src="{{url('/assets/vendors/feather-icons/feather.min.js')}}"></script>
        <script src="{{url('/assets/js/template.js')}}"></script>
        <script src="{{url('/assets/js/dashboard.js')}}"></script>
        <script src="{{url('/assets/js/datepicker.js')}}"></script>
        <script src="{{url('/assets/vendors_techadvisory/countdown/countdown.js')}}"></script>
        <script src="{{url('/assets/vendors/dropzone/dropzone.min.js')}}"></script>
        <script src="{{url('/assets/js/dropzone.js')}}"></script>
    @show
</body>

</html>
