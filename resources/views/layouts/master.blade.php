<!DOCTYPE html5>
<html>
    <head>
        <!-- Meta Tags
        ========================== -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- Site Title
        ========================== -->
        <title> THUNDER | الصفحة الرئيسية</title>

        <!-- Favicon
		===========================-->
<!--		<link rel="shortcut icon" type="image/x-icon" href="images/fav.jpg">-->

        <!-- Web Fonts
        ========================== -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">

        <!-- Base & Vendors
        ========================== -->
        <link href="{{asset('assets/vendor/bootstrap/css/bootstrap-ar.css') }}" rel="stylesheet">
        <link href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
        <!-- Data table-->
        <link href="{{asset('assets/vendor/data-table-plugin/datatables/datatables.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendor/data-table-plugin/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet">
        <!--Dropzone-->
        <link href="{{asset('assets/vendor/dropzone/dropzone.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendor/dropzone/basic.min.css')}}" rel="stylesheet">
        <!--DateRangPicker-->
        <link href="{{asset('assets/vendor/daterangepicker/daterangepicker.css')}}" rel="stylesheet">
        <!--SummerNote Editor-->
        <link href="{{asset('assets/vendor/bootstrap-summernote/summernote.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap-select.css')}}">

        <!-- Site Style
        ========================== -->
        <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="wrapper">
            @include('layouts.header')
            @include('layouts.sidebar')
            <div class="main">
                <div class="page-content">
                    @yield('content')
                    {{-- <section>
                        <div class="box-item">
                            <div class="box-item-head">
                                <h3 class="title">لوحة التحكم</h3>
                                <i class="fa fa-angle-down"></i>
                            </div><!-- End Box-Item-Head -->
                            <div class="box-item-content">

                            </div><!-- End Box-Item-Content -->
                        </div><!-- End Box-Item -->
                    </section><!--End Section--> --}}
                </div><!--End page-content-->

                @include('layouts.footer')
            </div><!-- End Main -->
        </div><!-- End Wrapper -->

        <!-- JS Base And Vendor
        ========================== -->
        <script src="{{asset('assets/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
        <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.js')}}"></script>

        <!-- Data table -->
        <script src="{{asset('assets/vendor/data-table-plugin/datatable.js')}}"></script>
        <script src="{{asset('assets/vendor/data-table-plugin/datatables/datatables.min.js')}}"></script>
        <script src="{{asset('assets/vendor/data-table-plugin/datatables/plugins/bootstrap/datatables.bootstrap.js')}}"></script>
        <script src="{{asset('assets/vendor/data-table-plugin/script/table-datatables-editable.min.js')}}"></script>

        <!-- Dropzone -->
        <script src="{{asset('assets/vendor/dropzone/dropzone.min.js')}}"></script>
        <script src="{{asset('assets/vendor/dropzone/form-dropzone.js')}}"></script>

        <!-- date-range-picker -->
        <script src="{{asset('assets/vendor/daterangepicker/moment.js')}}"></script>
        <script src="{{asset('assets/vendor/daterangepicker/daterangepicker.js')}}"></script>

        <!-- date-range-picker -->
        <script src="{{asset('assets/vendor/jquery-repeater/jquery.repeater.min.js')}}"></script>
        <script src="{{asset('assets/vendor/jquery-repeater/form-repeater.js')}}"></script>

        <!--SummerNote Editor-->
        <script src="{{asset('assets/vendor/bootstrap-summernote/summernote.min.js')}}"></script>

        <!-- Site JS
        ========================== -->
        <script src="{{asset('assets/js/main.js')}}"></script>
        <script>
            $("div#mydropzone").dropzone({ url: "/file/post" });
        </script>

        @yield('scripts')
    </body>
</html>
