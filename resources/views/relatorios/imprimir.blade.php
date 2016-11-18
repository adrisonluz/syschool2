<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{{ $page_title or "Aline Rosa | Admin" }}</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
     
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue layout-top-nav">
        <style>
            .navbar-header {
                width: 200px;
                background: #367fa9;
                padding-top: 15px;
                padding-right: 20px;
                padding-left: 20px;
                padding-bottom: 15px;
            }
            .navbar button{
                display: none;
            }
            .navbar{
                background: #3c8dbc;
            }
            .navbar a {
                color: #ffffff;
                text-decoration: none;
            }
            .content-wrapper{
                height: 100px;
            }
            table{
                border: 1px solid;
                width: 100%;
            }
            table td{
                border: 1px solid;
                padding: 5px;
            }
            .box-footer{
                padding-top: 20px;
                text-align: right;
            }
        </style>
        <div class="wrapper">

            <!-- Header -->
            @include('layout/headerlogin')

            <!-- Content -->
            <div class="content-wrapper">

                <!-- Main content -->
                <section class="content">
                    <div class='row'>
                        <div class='col-md-12'>
                            <!-- Box -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3>Relatório: {{ $tipo }}</h3>
                                </div>
                                <div class="box-body">
                                    {!! $dados !!}
                                </div>    
                                <div class="box-footer">
                                    <hr>
                                    emitido em: <strong>{{ date('d/m/Y - H:i') }}</strong>
                                </div>
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

        </div><!-- ./wrapper -->

        <script src="{{ asset ("/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
        
        <!-- QR CODE -->   
        <script src="{{ asset ("assets/js/webcodecamjs-master/js/qrcodelib.js") }}" type="text/javascript"></script>
        <script src="{{ asset ("assets/js/webcodecamjs-master/js/webcodecamjquery.js") }}" type="text/javascript"></script>
        <script src="{{ asset ("/assets/js/functions_qrcode.js") }}" type="text/javascript"></script>
    </body>
</html>