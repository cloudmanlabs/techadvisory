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
        <link rel="stylesheet" href="{{url('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
        <link rel="stylesheet" href="{{url('assets/vendors/jquery-steps/jquery.steps.css')}}">
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
        <script src="{{url('assets/vendors/jquery-steps/jquery.steps.min.js')}}"></script>
        <script src="{{url('assets/js/wizard.js')}}"></script>
        <script src="{{url('assets/vendors/select2/select2.min.js')}}"></script>
        <script src="{{url('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{url('assets/vendors/feather-icons/feather.min.js')}}"></script>
        <script src="{{url('assets/js/template.js')}}"></script>
        <script src="{{url('assets/vendors/dropzone/dropzone.min.js')}}"></script>
        <script src="{{url('assets/js/dropzone.js')}}"></script>
        <script src="{{url('assets/js/select2.js')}}"></script>
        <script src="{{url('assets/js/datepicker.js')}}"></script>
    @show
</body>

</html>
