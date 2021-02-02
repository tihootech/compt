
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>داشبرد</title>

    <!-- Site favicon -->
    <!-- <link rel='shortcut icon' type='image/x-icon' href='images/favicon.ico' /> -->
    <!-- /site favicon -->

    <!-- Entypo font stylesheet -->
    <link href="{{asset('assets/css/entypo.css')}}" rel="stylesheet">
    <!-- /entypo font stylesheet -->
    <!-- Font awesome stylesheet -->
    <link href="{{asset('assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- /font awesome stylesheet -->
    <!-- CSS3 Animate It Plugin Stylesheet -->
    <link href="{{asset('assets/css/animations.css')}}" rel="stylesheet">
    <!-- /css3 animate it plugin stylesheet -->
    <!-- Bootstrap stylesheet min version -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- /bootstrap stylesheet min version -->
    <!-- Mouldifi core stylesheet -->
    <link href="{{asset('assets/css/mouldifi-core.css')}}" rel="stylesheet">
    <!-- /mouldifi core stylesheet -->

    <link href="{{asset('assets/css/mouldifi-forms.css')}}" rel="stylesheet">

    <!-- Bootstrap RTL stylesheet min version -->
    <link href="{{asset('assets/css/bootstrap-rtl.min.css')}}" rel="stylesheet">
    <!-- /bootstrap rtl stylesheet min version -->
    <!-- Mouldifi RTL core stylesheet -->
    <link href="{{asset('assets/css/mouldifi-rtl-core.css')}}" rel="stylesheet">
    <!-- /mouldifi rtl core stylesheet -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.min.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <!--[if lte IE 8]>
    <script src="js/plugins/flot/excanvas.min.js"></script>
    <![endif]-->

    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
</head>
<body>

    <!-- Page container -->
    <div class="page-container">

        @include('template.sidebar')

        <!-- Main container -->
        <div class="main-container gray-bg">

            @include('template.header')

            <!-- Main content -->
            <div id="vue-app" class="main-content">

                <dashboard-manager></dashboard-manager>

                <!-- Footer -->
                <footer class="animatedParent animateOnce z-index-10">
                    <div class="footer-main animated fadeInUp slow"> متن فوتر... </div>
                </footer>
                <!-- /footer -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /main container -->

    </div>
    <!-- /page container -->
    <!--Load JQuery-->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <!-- Load CSS3 Animate It Plugin JS -->
    <script src="{{asset('assets/js/css3-animate-it.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('assets/js/jquery-ui.js')}}"></script>
    <script src="{{asset('assets/js/jquery.blockUI.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>

</body>
</html>
