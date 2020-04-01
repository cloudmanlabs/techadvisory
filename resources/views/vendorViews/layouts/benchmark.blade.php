<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">

    <title>{{$title ?? 'Tech Advisory Platform'}}</title>

    @section('head')
        <link rel="stylesheet" href="{{url('assets/vendors/core/core.css')}}">
        <link rel="stylesheet" href="{{url('assets/vendors/select2/select2.min.css')}}">
        <link rel="stylesheet" href="{{url('assets/fonts/feather-font/css/iconfont.css')}}">
        <link rel="stylesheet" href="{{url('assets/vendors/dropzone/dropzone.min.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/techadvisory/style.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/techadvisory/extra.css')}}">
        <link rel="stylesheet" href="{{url('css/custom.css')}}">
    @show
</head>

<body>
    @yield('content')

    @section('scripts')
        <script src="{{url('assets/vendors/core/core.js')}}"></script>
        <script src="{{url('assets/vendors/select2/select2.min.js')}}"></script>
        <script src="{{url('assets/vendors/jquery.flot/jquery.flot.js')}}"></script>
        <script src="{{url('assets/vendors/jquery.flot/jquery.flot.resize.js')}}"></script>
        <script src="{{url('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{url('assets/vendors/progressbar.js/progressbar.min.js')}}"></script>
        <script src="{{url('assets/vendors/feather-icons/feather.min.js')}}"></script>
        <script src="{{url('assets/vendors/apexcharts/apexcharts.min.js')}}"></script>
        <script src="{{url('assets/js/template.js')}}"></script>
        <script src="{{url('assets/js/dashboard.js')}}"></script>
        <script src="{{url('assets/js/datepicker.js')}}"></script>
        <script src="{{url('assets/js/select2.js')}}"></script>
        <script src="{{url('assets/js/apexcharts_techadvisory_demo.js')}}"></script>
        <script src="{{url('assets/vendors/chartjs/Chart.min.js')}}"></script>
        <script src="{{url('assets/js/chartsjs_techadvisory_client_benchmarks_view_fitgap.js')}}"></script>
        <script src="{{url('assets/js/chartsjs_techadvisory_client_benchmarks_view_vendor.js')}}"></script>
        <script src="{{url('assets/js/chartsjs_techadvisory_client_benchmarks_view_experience.js')}}"></script>
        <script src="{{url('assets/js/chartsjs_techadvisory_client_benchmarks_view_innovation.js')}}"></script>
        <script src="{{url('assets/js/chartsjs_techadvisory_client_benchmarks_view_implementation.js')}}"></script>
        <script src="{{url('assets/js/chartsjs_techadvisory_vendor.js')}}"></script>
        <script src="{{url('assets/js/chartsjs_techadvisory_client.js')}}"></script>
        <script src="{{url('assets/js/chartsjs_techadvisory_historic.js')}}"></script>
    @show
</body>

</html>
