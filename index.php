<?php
header("Access-Control-Allow-Origin: *");
//include "Backend/Controlador.php";
session_set_cookie_params(["SameSite" => "Strict"]); //none, lax, strict
session_set_cookie_params(["Secure" => "true"]); //false, true
session_set_cookie_params(["HttpOnly" => "true"]); //false, true
session_start();

if (isset($_SESSION['admin']['usuario'])) {
    //$conn=new Controller();
    $p=$_SESSION['admin']['Permisos'];
    for ($i=0; $i < count($p) ; $i++) {
            $permiso[$i]=$p[$i];
    }

    ?>

    <!DOCTYPE HTML>
    <html>
    <head>
        <title>Rizadas HN - Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Baxster Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
		SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <!-- Bootstrap Core CSS -->
        <link href="src/css/bootstrap.css" rel='stylesheet' type='text/css' />
        <!--<link href="src/bootstrap/css/bootstrap.css" rel='stylesheet' type='text/css' />-->


        <!-- Custom CSS -->
        <link href="src/css/style.css" rel='stylesheet' type='text/css' />}
        <link href="src/css/personalizado.css" rel='stylesheet' type='text/css' />
        <!-- font CSS -->
        <link rel="icon" href="img/logo_xs.png" type="image/x-icon" >
        <!-- font-awesome icons -->
        <link href="src/fontawesome/css/all.css" rel="stylesheet">
        <!-- //font-awesome icons -->
        <!-- chart
        <script src="src/js/Chart.js"></script>
 -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>



        <!-- //chart -->
        <!-- js-->
        <script src="src/js/jquery-1.11.1.min.js"></script>
        <script src="src/js/modernizr.custom.js"></script>
        <!--webfonts-->
        <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
        <!--//webfonts-->
        <!--animate-->
        <link href="src/css/animate.css" rel="stylesheet" type="text/css" media="all">
        <script src="src/js/wow.min.js"></script>
        <script>
            new WOW().init();
        </script>
        <!--//end-animate-->
        <!-- Metis Menu -->
        <script src="src/js/metisMenu.min.js"></script>
        <script src="src/js/custom.js"></script>
        <link href="src/css/custom.css" rel="stylesheet">
        <script src="vendor/chart.js/Chart.min.js"></script>
        <!--//Metis Menu -->
    </head>
    <body class="cbp-spmenu-push">
    <div class="main-content">
        <?php include "Backend/nav.php" ?>
        <!-- header-starts -->
        <div class="sticky-header header-section ">
            <div class="header-left">
                <!--logo -->
                <div class="logo">
                    <a href="./">
                        <ul>
                            <li><img src="img/logo_solo.png" class="img-logo" style="width:80%; margin-left: 20%; " /></li>
                            <li><h1>Rizadas</h1><h2>hn</h2></li>
                            <div class="clearfix"> </div>
                        </ul>
                    </a>
                </div>
                <!--//logo-->
                <div class="header-right header-right-grid">
                    <div class="profile_details_left"><!--notifications of menu start -->
                        <!--<ul class="nofitications-dropdown">
                            <li class="dropdown head-dpdn">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i><span class="badge">3</span></a>
                                <ul class="dropdown-menu anti-dropdown-menu">
                                    <li>
                                        <div class="notification_header">
                                            <h3>You have 3 new messages</h3>
                                        </div>
                                    </li>
                                    <li><a href="#">
                                        <div class="user_img"><img src="src/images/1.png" alt=""></div>
                                        <div class="notification_desc">
                                            <p>Lorem ipsum dolor amet</p>
                                            <p><span>1 hour ago</span></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </a></li>
                                    <li class="odd"><a href="#">
                                        <div class="user_img"><img src="src/images/2.png" alt=""></div>
                                        <div class="notification_desc">
                                            <p>Lorem ipsum dolor amet </p>
                                            <p><span>1 hour ago</span></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </a></li>
                                    <li><a href="#">
                                        <div class="user_img"><img src="src/images/3.png" alt=""></div>
                                        <div class="notification_desc">
                                            <p>Lorem ipsum dolor amet </p>
                                            <p><span>1 hour ago</span></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </a></li>
                                    <li>
                                        <div class="notification_bottom">
                                            <a href="#">See all messages</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown head-dpdn">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge blue">3</span></a>
                                <ul class="dropdown-menu anti-dropdown-menu">
                                    <li>
                                        <div class="notification_header">
                                            <h3>You have 3 new notification</h3>
                                        </div>
                                    </li>
                                    <li><a href="#">
                                        <div class="user_img"><img src="src/images/2.png" alt=""></div>
                                        <div class="notification_desc">
                                            <p>Lorem ipsum dolor amet</p>
                                            <p><span>1 hour ago</span></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </a></li>
                                    <li class="odd"><a href="#">
                                        <div class="user_img"><img src="src/images/1.png" alt=""></div>
                                        <div class="notification_desc">
                                            <p>Lorem ipsum dolor amet </p>
                                            <p><span>1 hour ago</span></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </a></li>
                                    <li><a href="#">
                                        <div class="user_img"><img src="src/images/3.png" alt=""></div>
                                        <div class="notification_desc">
                                            <p>Lorem ipsum dolor amet </p>
                                            <p><span>1 hour ago</span></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </a></li>
                                    <li>
                                        <div class="notification_bottom">
                                            <a href="#">See all notifications</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                        <div class="clearfix"> </div>-->
                    </div>
                </div>


                <div class="clearfix"> </div>
            </div>
            <!--search-box-->
            <div class="search-box">

            </div>
            <!--//end-search-box-->
            <div class="header-right">

                <!--notification menu end -->
                <div class="profile_details">
                    <ul>
                        <li class="dropdown profile_details_drop">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <div class="profile_img">
                                    <span class="prfil-img"><img src="img/undraw_profile.svg" alt="" style="    width: 38px;"> </span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                            <ul class="dropdown-menu drp-mnu">
                                <li> <a href="#" data-target="#Modal_cambio" data-toggle="modal" ><i class="fa fa-lock"></i> Cambiar </br>Contraseña</a> </li>
                                <li> <a href="#" data-target="#logoutModal" data-toggle="modal" ><i class="fa fa-sign-out"></i> Cerrar Sesión</a> </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!--toggle button start-->
                <button id="showLeftPush"><i class="fa fa-bars"></i></button>
                <!--toggle button end-->
                <div class="clearfix"> </div>
            </div>
            <div class="clearfix"> </div>
        </div>
        <!-- //header-ends -->
        <!-- main content start-->
        <div id="page-wrapper">
            <!-- main comienza !-->
            <div class="main-page" id="main" style="overflow-y: auto; overflow-x: hidden;">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Dashboard asd</h1>
                    
                </div>



                <div class="row four-grids">
                    <div class="col-md-6 ticket-grid">
                        <div class="tickets">
                            <div class="grid-left">
                                <div class="book-icon">
                                    <i class="fa fa-book"></i>
                                </div>
                            </div>
                            <div class="grid-right">
                                <h3>Ventas <span> del mes</span> </h3>
                                <p>
                                    Pedidos por aprobar: <span id="ventas_aprobar"></span><br>
                                    Ventas Pendientes de enviar:<span id="ventas_pendientes"></span><br>
                                    Ventas enviadas:<span id="ventas_enviadas"></span>
                                </p>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                    </div>
                    <div class="col-md-6 ticket-grid">
                        <div class="tickets">
                            <div class="grid-left">
                                <div class="book-icon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <div class="grid-right">
                                <h3>Estadística Inventario  </h3>
                                <p>Mas vendido: <span id="Citas_Reservadas"></span><br>
                                    Mas pedidos: <span id="Citas_Reprogramadas"></span><br>


                                </p>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                    </div>





                    <!-- Area Chart -->
                    <div class="col-xl-8 col-lg-7 ticket-grid">

                        <div class="tickets">
                            <!-- Card Header - Dropdown -->
                            <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Ventas del ultimo año</h6>

                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="myAreaChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pie Chart -->
                    <?php
                    if ($_SESSION['admin']['id']!=4) {
                        ?>
                        <div class="col-xl-4 col-lg-5 ticket-grid">
                            <div class="tickets">
                                <!-- Card Header - Dropdown -->
                                <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Resumen pedidos del mes</h6>

                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart" height="250"></canvas>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>


                <div class="clearfix"> </div>
            </div>
            <!-- main termina !-->
        </div>
    </div>
    </div>
    <div id="redirect"></div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lista para cerrar sesión?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecciona Salir para cerrar sesión.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="adm/logout.php">Salir</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        //---------------------------------------------------------------------------------------------------------

        $( document ).ready(function() {
            //inicio();
            setInterval('verificar()', 1000);

        });
        //---------------------------------------------------------------------------------------------------------


    </script>


    <!-- Cambio de contraseña -->
    <div class="modal fade" id="Modal_cambio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Modal_titulo_cambio">Mantenimiento Contraseña</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="form_cambio">
                    <input type="hidden" name="request" value="CambiarContra">
                    <input type="hidden" name="tipo" id="tipo">
                    <div class="modal-body" id="Modal_body">
                        <h1>Cambiar de Contraseña</h1>
                        <table style="border:none;">
                            <tr style="border:none;">
                                <td style="border:none">Usuario: </td>
                                <td style="border:none"><input type="text" name="usuario" id="usuario" value="<?= $_SESSION['admin']['usuario'] ?>" readonly="readonly"></td>
                            </tr>
                            <tr style="border:none;">
                                <td style="border:none"><label>Contraseña: </label></td>
                                <td style="border:none;"><input type="Password" name="clave" id="txtPassword" required="required">
                                    <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Guardar</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script src="src/js/classie.js"></script>
    <script>
        var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
            showLeftPush = document.getElementById( 'showLeftPush' ),
            body = document.body;

        showLeftPush.onclick = function() {
            classie.toggle( this, 'active' );
            classie.toggle( body, 'cbp-spmenu-push-toright' );
            classie.toggle( menuLeft, 'cbp-spmenu-open' );
            disableOther( 'showLeftPush' );
        };


        function disableOther( button ) {
            if( button !== 'showLeftPush' ) {
                classie.toggle( showLeftPush, 'disabled' );
            }
        }
    </script>
    <!-- Bootstrap Core JavaScript -->

    <script type="text/javascript" src="src/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="src/js/dev-loaders.js"></script>
    <script type="text/javascript" src="src/js/dev-layout-default.js"></script>
    <script type="text/javascript" src="src/js/jquery.marquee.js"></script>
    <link href="src/css/bootstrap.min.css" rel="stylesheet">


    <!-- datatable -->
    <script type="text/javascript" src="src/datatable/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="src/datatable/buttons.print.min.js"></script>
    <script type="text/javascript" src="src/datatable/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="src/datatable/jszip.min.js"></script>
    <script type="text/javascript" src="src/datatable/pdfmake.min.js"></script>
    <script type="text/javascript" src="src/datatable/buttons.html5.min.js"></script>
    <script type="text/javascript" src="src/datatable/vfs_fonts.js"></script>
    <link rel="stylesheet" type="text/css" href="src/datatable/jquery.dataTables.min.css" />


    <!-- select2 -->
    <script type="text/javascript" src="src/select2/select2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="src/select2/select2.min.css" />
    <!-- //select2 -->

    <!-- candlestick -->
    <script type="text/javascript" src="src/js/jquery.jqcandlestick.min.js"></script>
    <link rel="stylesheet" type="text/css" href="src/css/jqcandlestick.css" />
    <!-- //candlestick -->

    <!--max-plugin-->
    <script type="text/javascript" src="src/js/plugins.js"></script>
    <!--//max-plugin-->

    <!--scrolling js-->
    <script src="src/js/jquery.nicescroll.js"></script>
    <script src="src/js/scripts.js"></script>
    <!--//scrolling js-->

    <!-- real-time-updates -->
    <script language="javascript" type="text/javascript" src="src/js/jquery.flot.js"></script>

    <!-- //real-time-updates -->
    <!-- error-graph -->
    <script language="javascript" type="text/javascript" src="src/js/jquery.flot.errorbars.js"></script>
    <script language="javascript" type="text/javascript" src="src/js/jquery.flot.navigate.js"></script>
    <script language="javascript" type="text/javascript" src="src/js/main.js"></script>



    <script src="src/alertas/sweetalert.min.js"></script>
    <!-- //error-graph -->
    <!-- Skills-graph -->

    <script type="text/javascript">
        //---------------------------------------------------------------------------------------------------------
        var mes=["","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

        //---------------------------------------------------------------------------------------------------------


        function cambiarcontra(id,Nombre,tipo){
            $("#usuario").val(id);
            $("#tipo").val(tipo);
            $('#Modal_titulo_cambio').html('Cambiar Contraseña a usuario: '+Nombre)
            $("#Modal_cambio").modal()

        }
        function mostrarPassword(){
            var cambio = document.getElementById("txtPassword");
            if(cambio.type == "password"){
                cambio.type = "text";
                $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
            }else{
                cambio.type = "password";
                $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
            }
        }






    </script>


    </body>
    </html>

    <?php
} else {
    header('Location: login.php');
}
?>