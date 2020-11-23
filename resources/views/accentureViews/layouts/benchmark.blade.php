<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">

    <title>{{$title ?? 'Tech Advisory Platform'}}</title>

    <meta name="_token" content="{{ csrf_token() }}" />

    @section('head')
        <link rel="stylesheet" href="{{url('assets/vendors/core/core.css')}}">
        <link rel="stylesheet" href="{{url('assets/vendors/select2/select2.min.css')}}">
        <link rel="stylesheet" href="{{url('assets/fonts/feather-font/css/iconfont.css')}}">
        <link rel="stylesheet" href="{{url('assets/vendors/dropzone/dropzone.min.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/techadvisory/style.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/techadvisory/extra.css')}}">
        <link rel="stylesheet" href="{{url('css/custom.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/jquery.toast.min.css')}}">

        <link rel="stylesheet" href="{{url('assets/fonts/graphik/font.css')}}">
        <style>
            * {
                font-family: 'Graphik'
            }
        </style>
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
        <script src="{{url('assets/vendors/chartjs/Chart.min.js')}}"></script>
        <script src="{{url('assets/js/jquery.toast.min.js')}}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/ramda/0.27.1/ramda.min.js" integrity="sha512-rZHvUXcc1zWKsxm7rJ8lVQuIr1oOmm7cShlvpV0gWf0RvbcJN6x96al/Rp2L2BI4a4ZkT2/YfVe/8YvB2UHzQw==" crossorigin="anonymous"></script>

        <script>
            $(function () {
                $.ajaxSetup({
                    headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
            });
        </script>
    @show
</body>

</html>
