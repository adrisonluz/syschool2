<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{{ $page_title or "Aline Rosa | Admin" }}</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("/bower_components/admin-lte/dist/css/skins/skin-blue.min.css")}}" rel="stylesheet" type="text/css" />

        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue layout-top-nav">
        <div class="wrapper">

            <!-- Header -->
            @include('layout/headerlogin')

            <!-- Content -->
            <div class="content-wrapper">

                <!-- Main content -->
                <section class="content">

                    @yield('content')
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

            <!-- Footer -->
            @include('layout/footer')

        </div><!-- ./wrapper -->

        <script src="{{ asset ("/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
        <script src="{{ asset ("/bower_components/admin-lte/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
        <script src="{{ asset ("/bower_components/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js") }}" type="text/javascript"></script>
        <script src="{{ asset ("/bower_components/admin-lte/dist/js/app.min.js") }}" type="text/javascript"></script>

        <!-- QR CODE -->   
        <script src="{{ asset ("assets/js/webcodecamjs-master/js/qrcodelib.js") }}" type="text/javascript"></script>
        <script src="{{ asset ("assets/js/webcodecamjs-master/js/webcodecamjquery.js") }}" type="text/javascript"></script>
        <script src="{{ asset ("/assets/js/functions_qrcode.js") }}" type="text/javascript"></script>
    </body>
</html>