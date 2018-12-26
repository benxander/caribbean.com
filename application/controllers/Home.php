<?php
include("db.php");
ini_set("error_reporting", false);
session_start();
if(!isset($_SESSION["username"])){
header("Location: login.php");
exit(); }

else {

$tipou=$_SESSION["tipou"];
$zone=$_SESSION["zone"];
$id_u=$_SESSION["idu"];  
  $msjesuccess = 1;
}


$laSemanaPasada = date('Y-m-d', strtotime('-1 week')) ; // resta 1 semana
$elMesPasado = date('Y-m-d', strtotime('-1 month')) ;

$hoy = date('Y-m-d');

$ta=mysqli_query($con,"select * from `ticketsdb` WHERE estatus='Abierto'");
$tabiertos=mysqli_num_rows($ta);
$taw=mysqli_query($con,"select * from `ticketsdb` WHERE fecha between '$laSemanaPasada' and '$hoy' AND estatus = 'Abierto'");
$tabiertosw=mysqli_num_rows($taw);
$tam=mysqli_query($con,"select * from `ticketsdb` WHERE fecha between '$elMesPasado' and '$hoy' AND estatus = 'Abierto'");
$tabiertosm=mysqli_num_rows($tam);


$tp=mysqli_query($con,"select * from `ticketsdb` WHERE estatus='Pagado'");
$pagados=mysqli_num_rows($tp);
$tpw=mysqli_query($con,"select * from `ticketsdb` WHERE fecha between '$laSemanaPasada' and '$hoy' AND estatus = 'Pagado'");
$pagadosw=mysqli_num_rows($tpw);
$tpm=mysqli_query($con,"select * from `ticketsdb` WHERE fecha between '$elMesPasado' and '$hoy' AND estatus = 'Pagado'");
$pagadosm=mysqli_num_rows($tpm);


$tc=mysqli_query($con,"select * from `ticketsdb` WHERE estatus='Cancelado'");
$cancelados=mysqli_num_rows($tc);
$tcw=mysqli_query($con,"select * from `ticketsdb` WHERE fecha between '$laSemanaPasada' and '$hoy' AND estatus = 'Cancelado'");
$canceladosw=mysqli_num_rows($tcw);
$tcm=mysqli_query($con,"select * from `ticketsdb` WHERE fecha between '$elMesPasado' and '$hoy' AND estatus = 'Cancelado'");
$canceladosm=mysqli_num_rows($tcm);


$tn=mysqli_query($con,"select * from `ticketsdb` WHERE estatus='Anulado'");
$anulados=mysqli_num_rows($tn);
$tnw=mysqli_query($con,"select * from `ticketsdb` WHERE fecha between '$laSemanaPasada' and '$hoy' AND estatus = 'Anulado'");
$anuladosw=mysqli_num_rows($tnw);
$tnm=mysqli_query($con,"select * from `ticketsdb` WHERE fecha between '$elMesPasado' and '$hoy' AND estatus = 'Anulado'");
$anuladosm=mysqli_num_rows($tnm);



$totales=mysqli_query($con,"SELECT SUM(tarifaa) AS totalvendido, SUM(deposito1) AS totalpago, SUM(pendiente) AS totaldeuda FROM ticketsdb");

$total = $totales->fetch_assoc();

function dateDiff($start, $end) {

$start_ts = strtotime($start);

$end_ts = strtotime($end);

$diff = $end_ts - $start_ts;

return round($diff / 86400);

}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Goey Studio</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="favicon.ico">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!-- global css -->
    <link href="css/app.css" rel="stylesheet" type="text/css" />
    <!-- end of global css -->
    <!--page level css -->
    <link href="vendors/fullcalendar/css/fullcalendar.css" rel="stylesheet" type="text/css" />
    <link href="css/pages/calendar_custom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" media="all" href="vendors/bower-jvectormap/css/jquery-jvectormap-1.2.2.css" />
    <link rel="stylesheet" href="vendors/animate/animate.min.css">
    <link rel="stylesheet" type="text/css" href="vendors/datetimepicker/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="css/pages/only_dashboard.css" />
      <link rel="stylesheet" type="text/css" href="vendors/datatables/css/dataTables.bootstrap.css" />
    <link href="css/pages/tables.css" rel="stylesheet" type="text/css" />
    <link href="vendors/c3/c3.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/morrisjs/morris.css" rel="stylesheet" type="text/css" />
    <link href="css/pages/piecharts.css" rel="stylesheet" type="text/css" />
     <link rel="stylesheet" type="text/css" href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.css" />
    <!--end of page level css-->
        <link href="vendors/daterangepicker/css/daterangepicker.css" rel="stylesheet" type="text/css" />
    <link href="vendors/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
    <link href="vendors/jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="vendors/iCheck/css/all.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/pages/radio_checkbox.css">
        <link rel="stylesheet" type="text/css" href="vendors/bootstrap-switch/css/bootstrap-switch.css">
    <link rel="stylesheet" type="text/css" href="vendors/switchery/css/switchery.css">
    <link rel="stylesheet" type="text/css" href="vendors/awesome-bootstrap-checkbox/css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" type="text/css" href="vendors/iCheck/css/all.css">
    <link rel="stylesheet" type="text/css" href="vendors/iCheck/css/line/line.css">




</head>

<body class="skin-josh">
<audio id="xyz" src="birds.mp3" preload="auto"></audio>
    <header class="header">
        <a href="home.php" class="logo">
            <img src="img/white-logo.png" alt="Logo">
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <div>
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <div class="responsive_nav"></div>
                </a>
            </div>
            <div class="navbar-right">
                <ul class="nav navbar-nav">



<?php
$count=0;
    $sql2="SELECT * FROM mensajeria WHERE id_usuario='$id_u' AND leido = 0";
    $resultm=mysqli_query($con, $sql2);
    $count=mysqli_num_rows($resultm);
    //header( 'Location: ../' ) ;
?>                       

                      




                    <li class="dropdown messages-menu">
                        <a id="notification-icon" href="#" onclick="myFunction()" class="dropdown-toggle" data-toggle="dropdown"> <i class="livicon" data-name="message-flag" data-loop="true" data-color="#42aaca" data-hovercolor="#42aaca" data-size="28"></i>
                            <span id="notification-count" class="label label-warning"><?php if ($count > 0) {echo $count; }  ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-messages pull-right">
                            <li class="dropdown-title"><?php echo $count;  ?> Comentarios Nuevos</li>


                            <div id="notification-latest"></div>


                            <li class="footer">
                                <a href="mensajeria.php">Ver Todos</a>
                            </li>
                        </ul>
                    </li>




                    
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="img/logouno.jpg" width="35" class="img-circle img-responsive pull-left" height="35">
                            <div class="riot">
                                <div>
                                  <?php echo $_SESSION["nombre"]; ?>
                                    <span>
                                        <i class="caret"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header bg-light-blue">
                                <img src="img/logouno.jpg" width="90" class="img-circle img-responsive" height="90"  />
                                <p class="topprofiletext"><?php echo $_SESSION["nombre"]; ?></p>
                            </li>
                            <!-- Menu Body -->
                            <li>
                                <a href="perfil.php">
                                    <i class="livicon" data-name="user" data-s="18"></i> Mis Datos
                                </a>
                            </li>
                            <li role="presentation"></li>

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="salir.php">
                                        <i class="livicon" data-name="sign-out" data-s="18"></i> Salir
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="wrapper row-offcanvas row-offcanvas-left">
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="left-side sidebar-offcanvas">
            <section class="sidebar ">
                <div class="page-sidebar  sidebar-nav">
                    <div class="nav_icons">
                        &nbsp;&nbsp;<br>&nbsp;&nbsp;
                    </div>
                    <div class="clearfix"></div>
                    <!-- BEGIN SIDEBAR MENU -->
                     <ul class="page-sidebar-menu" id="menu">
                        <li class="active">
                            <a href="home.php">
                                <i class="livicon" data-name="home" data-size="18" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>
                                <span class="title">Escritorio</span>
                            </a>

                       </li>
                        <li>
                            <a href="#">
                                <i class="livicon" data-name="doc-portrait" data-c="#5bc0de" data-hc="#5bc0de" data-size="18" data-loop="true"></i>
                                <span class="title">Tickets</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="inc_ticket.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Cargar Tickets
                                    </a>
                                </li>
                                <li>
                                    <a href="lista_tickets.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Listado de Tickets
                                    </a>
                                </li>
                                <li>
                                    <a href="lista_tickets_cerrados.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Tickets Cerrados
                                    </a>
                                </li>

                                <li>
                                    <a href="lista_tickets_archivados.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Tickets Archivados
                                    </a>
                                </li>
                                                              
                             
                               
                            </ul>
                        </li>


                        <li>
                            <a href="#">
                                <i class="livicon" data-name="image" data-size="18" data-c="#F89A14" data-hc="#F89A14" data-loop="true"></i>
                                <span class="title">Excursiones</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="excursion_nueva.php">
                                        <i class="fa fa-angle-double-right"></i> Reservas de Excursi&oacute;n
                                    </a>
                                </li>
                                <li>
                                    <a href="excursion_lista.php">
                                        <i class="fa fa-angle-double-right"></i> Listar Excursiones
                                    </a>
                                </li>
                            </ul>
                        </li>


                         <li>
                            <a href="#">
                                <i class="livicon" data-name="printer" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                                <span class="title">Reportes</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                

              <?php


                        if ($tipou == 1 || $tipou == 2)

                        {

                        ?>

                                <li>
                                    <a href="#">
                                <i class="livicon" data-name="printer" data-size="18" data-c="#2ddcf0" data-hc="#2ddcf0" data-loop="true"></i>
                                <span class="title"><strong>Facturaci&oacute;n</strong></span>
                                <span class="fa arrow"></span>
                            </a>
                                

                                <ul class="sub-menu">

                                     <li>
                                    <a href="reporte_especial.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Reportes Especiales
                                    </a>
                                </li>
                               

                                 <li>
                                    <a href="reporte_diario_mensajero.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Reporte Mensajer&iacute;a
                                    </a>
                                </li>
                                 <li>
                                    <a href="reporte_acuse_recibo.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Acuse de Recibo
                                    </a>
                                </li>
                                <li>
                                    <a href="reporte_rutas.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Generar Rutas
                                    </a>
                                </li> 
                                <li>
                                    <a href="etiquetas.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Generar Etiquetas
                                    </a>
                                </li>

                                 <li>
                                    <a href="reporte_cuentas_cobrar.php">
                                        <i class="fa fa-angle-double-right"></i>
                                         Cuentas por Cobrar
                                    </a>
                                </li>
                                <li>
                                    <a href="reporte_comisiones.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Com. Fot&oacute;grafos
                                    </a>
                                </li>
                                <li>
                                    <a href="reporte_excursiones.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Reporte de PAX
                                    </a>
                                </li>
                                <li>
                                    <a href="reporte_diario_cierre.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Cierre Diario
                                    </a>
                                </li>
                                <li>
                                    <a href="reporte_ingreso_egreso.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Ingreso / Egreso
                                    </a>
                                </li>
                            </ul>
                            </li>

                            <?php
                        

                        }

                        ?>
                                <li>
                                          <a href="#">
                                <i class="livicon" data-name="printer" data-size="18" data-c="#2ddcf0" data-hc="#2ddcf0" data-loop="true"></i>
                                <span class="title"><strong>Operaciones</strong></span>
                                <span class="fa arrow"></span>
                            </a>
                                

                                <ul class="sub-menu">
                                

                               
                                <li>
                                    <a href="reporte_diario_zona.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Reporte de Venta
                                    </a>
                                </li>
                               </ul>
                               </li>
                                
                            </ul>
                        </li>

                        <?php
                        if ($tipou == 1 || $tipou == 2)
                        {
                        ?>

                         <li>
                            <a href="#">
                                <i class="livicon" data-name="barchart" data-size="18" data-c="#F89A14" data-hc="#F89A14" data-loop="true"></i>
                                <span class="title">Oficina</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="oficina_gastos_categorias.php">
                                        <i class="fa fa-angle-double-right"></i> Categor&iacute;as de Gasto
                                    </a>
                                </li>
                                <li>
                                    <a href="oficina_ingresos_categorias.php">
                                        <i class="fa fa-angle-double-right"></i> Categor&iacute;as de Ingreso
                                    </a>
                                </li>
                                 <li>
                                    <a href="oficina_gastos.php">
                                        <i class="fa fa-angle-double-right"></i> Gastos
                                    </a>
                                </li>
                                <li>
                                    <a href="oficina_ingresos.php">
                                        <i class="fa fa-angle-double-right"></i> Ingresos
                                    </a>
                                </li>
                                <li>
                                    <a href="oficina_estadisticas.php">
                                        <i class="fa fa-angle-double-right"></i> Estad&iacute;sticas
                                    </a>
                                </li>
                                <li>
                                    <a href="oficina_estadisticas_editores.php">
                                        <i class="fa fa-angle-double-right"></i> Est. Editores
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <?php
                          }
                        ?>


                        
                        <li>
                            <a href="#">
                                <i class="livicon" data-name="table" data-c="#418BCA" data-hc="#418BCA" data-size="18" data-loop="true"></i>
                                <span class="title">Recursos</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="directorio_listado.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Directorio de Empresas
                                    </a>
                                </li>
                                <li>
                                    <a href="documentos_listado.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Documentos
                                    </a>
                                </li>
                               
                              
                            </ul>
                        </li>




                        <?php


                        if ($tipou == 1 )

                        {

                        ?>



                         <li>
                            <a href="#">
                                <i class="livicon" data-name="wrench" data-c="#879e0f" data-hc="#879e0f" data-size="18" data-loop="true"></i>
                                <span class="title">Configuraciones</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="usuarios_lista.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Usuarios
                                    </a>
                                </li>
                                <li>
                                    <a href="excursiones_lista.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Excursiones
                                    </a>
                                </li>
                                <li>
                                    <a href="hoteles_lista.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Hoteles
                                    </a>
                                </li>
                                <li>
                                    <a href="fotografos_lista.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Fot&oacute;grafos
                                    </a>
                                </li>
                                <li>
                                    <a href="guias_lista.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Gu&iacute;as / Barcos
                                    </a>
                                </li>                         
                              
                            </ul>
                        </li>

                        <?php
                        

                        }

                        ?>
                         <li>
                                    <a href="mensajeros_estatus.php">
                                        <i class="livicon" data-name="car" data-size="18" data-c="#F89A14" data-hc="#F89A14" data-loop="true"></i>
                                     <span class="title">Estatus Mensajeros</span>
                                    </a>
                                </li>
                        
                       
                        
                        <li>
                            <a href="salir.php">
                                <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="sign-out" data-size="18" data-loop="true"></i>
                               
                                Salir
                            </a>
                        </li>
                       
  
                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
            </section>
            <!-- /.sidebar -->
        </aside>
        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            
  
            <!-- Main content -->
            <section class="content-header">
                <h1>Escritorio</h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <a href="#">
                            <i class="livicon" data-name="home" data-size="14" data-color="#333" data-hovercolor="#333"></i> Escritorio
                        </a>
                    </li>
                </ol>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInLeftBig">
                        <!-- Trans label pie charts strats here-->
                        <div class="lightbluebg no-radius">
                            <div class="panel-body squarebox square_boxs">
                                <div class="col-xs-12 pull-left nopadmar">
                                    <div class="row">
                                        <div class="square_box col-xs-7 text-right">
                                            <span>Tickets Abiertos</span>
                                            <div class="number"><?php echo $tabiertos; ?></div>
                                        </div>
                                        <i class="livicon  pull-right" data-name="eye-open" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <small class="stat-label">Ultima Semana</small>
                                            <h4><?php echo $tabiertosw; ?></h4>
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <small class="stat-label">Ultimo Mes</small>
                                            <h4><?php echo $tabiertosm; ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInUpBig">
                        <!-- Trans label pie charts strats here-->
                        <div class="redbg no-radius">
                            <div class="panel-body squarebox square_boxs">
                                <div class="col-xs-12 pull-left nopadmar">
                                    <div class="row">
                                        <div class="square_box col-xs-7 pull-left">
                                            <span>Tickets Cancelados</span>
                                            <div class="number"><?php echo $cancelados; ?></div>
                                        </div>
                                        <i class="livicon pull-right" data-name="users-ban" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <small class="stat-label">Ultima Semana</small>
                                            <h4><?php echo $canceladosw; ?></h4>
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <small class="stat-label">Ultimo Mes</small>
                                            <h4><?php echo $canceladosm; ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 margin_10 animated fadeInDownBig">
                        <!-- Trans label pie charts strats here-->
                        <div class="goldbg no-radius">
                            <div class="panel-body squarebox square_boxs">
                                <div class="col-xs-12 pull-left nopadmar">
                                    <div class="row">
                                        <div class="square_box col-xs-7 pull-left">
                                            <span>Tickets Anulados</span>
                                            <div class="number"><?php echo $anulados; ?></div>
                                        </div>
                                        <i class="livicon pull-right" data-name="edit" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <small class="stat-label">Ultima Semana</small>
                                            <h4><?php echo $anuladosw; ?></h4>
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <small class="stat-label">Ultimo Mes</small>
                                            <h4><?php echo $anuladosm; ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInRightBig">
                        <!-- Trans label pie charts strats here-->
                        <div class="palebluecolorbg no-radius">
                            <div class="panel-body squarebox square_boxs">
                                <div class="col-xs-12 pull-left nopadmar">
                                    <div class="row">
                                        <div class="square_box col-xs-7 pull-left">
                                            <span>Tickets Pagados</span>
                                            <div class="number"><?php echo $pagados; ?></div>
                                        </div>
                                        <i class="livicon pull-right" data-name="piggybank" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <small class="stat-label">Ultima Semana</small>
                                            <h4><?php echo $pagados; ?></h4>
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <small class="stat-label">Ultimo Mes</small>
                                            <h4><?php echo $pagados; ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/row-->



                <div class="row ">




<?php




                        if ($tipou == 1 || $tipou == 2 || $tipou == 3)

                        {





$sqlde = "SELECT * FROM ticketsdb WHERE destacado = 'SI' ORDER BY fecha DESC";
$resultde = mysqli_query($con,$sqlde) or die(mysql_error());
//$row=mysqli_fetch_array($result);

?>
<div class="col-md-12">

    
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet box warning">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="livicon" data-name="star-full" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Tickets Destacados para Seguimiento
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-striped table-bordered table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="doc-portrait" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>

                                                    Ticket
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="calendar" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Fecha
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="compass" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Excursi&oacute;n - Gu&iacute;a / Barco
                                                </th>


                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="camera" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Fotog. / <i class="livicon" data-name="camcoder" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i> Videog.
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Precio
                                                </th>

                                                 <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Dep&oacute;sito
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="timer" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    E.Ticket
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="timer" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    E.Prod.
                                                </th>
                                                <th class="clearfix visible-xs visible-lg"></th>
                                            </tr>
                                        </thead>
                                        <tbody>




        

<?php

while ($ticketde = $resultde->fetch_assoc()){

    $fechat2 = new DateTime($ticketde['fecha']);
    $fechas2 = new DateTime($ticketde['fecha_salida_cliente']);
    $estat2 = $ticketde['estatus'];

     $sale2=$ticketde['fecha_salida_cliente'];




   $idt = base64_encode($ticketde['id']);
   $idx = base64_encode($ticketde['id_excursion']);


if ($estat2 == 'Por Validar') {$status = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estat2 == 'Abierto') {$status = "<span class='label label-sm label-primary label-mini'>Abierto</span>"; }
    if ($estat2 == 'Pagado') {$status = "<span class='label label-sm label-success label-mini'>Pagado</span>"; }
    if ($estat2 == 'Cancelado') {$status = "<span class='label label-sm label-danger label-mini'>Cancelado</span>"; }
    if ($estat2 == 'Anulado') {$status = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }


  $estap2 = $ticketde['estatus_producto'];
    if ($estap2 == 'Por Validar') {$statup = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estap2 == 'Edicion') {$statup = "<span class='label label-sm label-info label-mini'>Edici&oacute;n</span>"; }
    if ($estap2 == 'Solo Email') {$statup = "<span class='label label-sm label-info label-mini'>Solo Email</span>"; }
    if ($estap2 == 'Mensajeria') {$statup = "<span class='label label-sm label-info label-mini'>Mensajer&iacute;a</span>"; }
    if ($estap2 == 'Meeting Point') {$statup = "<span class='label label-sm label-warning label-mini'>Meeting Point</span>"; }
    if ($estap2 == 'Entregado') {$statup = "<span class='label label-sm label-success label-mini'>Entregado</span>"; }
    if ($estap2 == 'Devuelto') {$statup = "<span class='label label-sm label-danger label-mini'>Devuelto</span>"; }
    if ($estap2 == 'Anulado') {$statup = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }

    




                                            echo "<tr><td class='clearfix visible-xs visible-lg' align=center><a href='detalles_ticket.php?idt=".$idt."'>".$ticketde['nro_ticket']."</a></td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$fechat2->format('d-m-Y')."</td>";


                                            echo "<td class='clearfix visible-xs visible-lg'>".$ticketde['excursion']." ".$ticketde['guia_excur']."</td>";
                                            

                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$ticketde['fotografo1']." / ".$ticketde['fotografo2']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketde['tarifaa']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketde['deposito1']."</td>";

                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$status."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$statup."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center><a data-toggle='tooltip' href='detalles_ticket.php?idt=".$idt."'><img src=img/detalle.png></a></td></tr>";



                                            }




?>




                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END SAMPLE TABLE PORTLET-->
                    </div>



<?php
}

?>






<?php






 if ($tipou == 4 || $tipou == 1)  {


$sqle = "SELECT * FROM ticketsdb WHERE excursion LIKE '%$zone%' AND preaprobado = 0  ORDER BY fecha DESC";
$resulte = mysqli_query($con,$sqle) or die(mysql_error());
//$row=mysqli_fetch_array($result);

?>
<div class="col-md-12">

    
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet box danger">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="livicon" data-name="pen" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Tickets del D&iacute;a por Validar
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-striped table-bordered table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="doc-portrait" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>

                                                    Ticket
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="calendar" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Fecha
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="compass" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Excursi&oacute;n - Gu&iacute;a / Barco
                                                </th>


                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="camera" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Fotog. / <i class="livicon" data-name="camcoder" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i> Videog.
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Precio
                                                </th>

                                                 <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Dep&oacute;sito
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="timer" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    E.Ticket
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="timer" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    E.Prod.
                                                </th>
                                                <th class="clearfix visible-xs visible-lg"></th>
                                            </tr>
                                        </thead>
                                        <tbody>




        

<?php

while ($ticketd = $resulte->fetch_assoc()){

    $fechat2 = new DateTime($ticketd['fecha']);
    $fechas2 = new DateTime($ticketd['fecha_salida_cliente']);
    $estat2 = $ticketd['estatus'];

     $sale2=$ticketd['fecha_salida_cliente'];




   $idt = base64_encode($ticketd['id']);
   $idx = base64_encode($ticketd['id_excursion']);


if ($estat2 == 'Por Validar') {$status = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estat2 == 'Abierto') {$status = "<span class='label label-sm label-primary label-mini'>Abierto</span>"; }
    if ($estat2 == 'Pagado') {$status = "<span class='label label-sm label-success label-mini'>Pagado</span>"; }
    if ($estat2 == 'Cancelado') {$status = "<span class='label label-sm label-danger label-mini'>Cancelado</span>"; }
    if ($estat2 == 'Anulado') {$status = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }


  $estap2 = $ticketd['estatus_producto'];
    if ($estap2 == 'Por Validar') {$statup = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estap2 == 'Edicion') {$statup = "<span class='label label-sm label-info label-mini'>Edici&oacute;n</span>"; }
    if ($estap2 == 'Solo Email') {$statup = "<span class='label label-sm label-info label-mini'>Solo Email</span>"; }
    if ($estap2 == 'Mensajeria') {$statup = "<span class='label label-sm label-info label-mini'>Mensajer&iacute;a</span>"; }
    if ($estap2 == 'Meeting Point') {$statup = "<span class='label label-sm label-warning label-mini'>Meeting Point</span>"; }
    if ($estap2 == 'Entregado') {$statup = "<span class='label label-sm label-success label-mini'>Entregado</span>"; }
    if ($estap2 == 'Devuelto') {$statup = "<span class='label label-sm label-danger label-mini'>Devuelto</span>"; }
    if ($estap2 == 'Anulado') {$statup = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }

    




                                            echo "<tr><td class='clearfix visible-xs visible-lg' align=center><a href='detalles_ticket.php?idt=".$idt."'>".$ticketd['nro_ticket']."</a></td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$fechat2->format('d-m-Y')."</td>";


                                            echo "<td class='clearfix visible-xs visible-lg'>".$ticketd['excursion']." ".$ticketd['guia_excur']."</td>";
                                            

                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$ticketd['fotografo1']." / ".$ticketd['fotografo2']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketd['tarifaa']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketd['deposito1']."</td>";

                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$status."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$statup."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center><a data-toggle='tooltip' title='Aprobar Ticket' href='validar_ticket_supervisor.php?idt=".$idt."'><img src=img/actualiza.png></a>    &nbsp;&nbsp; <a data-toggle='tooltip' href='detalles_ticket.php?idt=".$idt."'><img src=img/detalle.png></a></td></tr>";



                                            }


// El script automáticamente liberará el resultado y cerrará la conexión
// a MySQL cuando finalice, aunque aquí lo vamos a hacer nostros mismos




?>




                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END SAMPLE TABLE PORTLET-->
                    </div>


<?php
}

?>







<!-- Termina Tickets por Validar Supervisor -->




<!-- Listado del dia Facturacion -->

<?php

if ($tipou == 2 || $tipou == 1)  {


 $hoy = date('Y-m-d') ;

$sqlho = "SELECT * FROM ticketsdb WHERE fecha='$hoy' and aprobacion=0 ORDER BY fecha_salida_cliente DESC";
$resultho = mysqli_query($con,$sqlho) or die(mysqli_error());
//$row=mysqli_fetch_array($result);

?>


<div class="col-md-12">
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet box success">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="livicon" data-name="calendar" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Facturaci&oacute;n - Tickets del D&iacute;a por Recibir
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-striped table-bordered table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="doc-portrait" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>

                                                    Ticket
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="calendar" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Fecha
                                                </th>


                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="compass" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Excursi&oacute;n
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i> Precio 
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Dep&oacute;sito
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Deuda
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    T.Pago
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="timer" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    E.Ticket
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="timer" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    E.Prod.
                                                </th>

                                                <th class="clearfix visible-xs visible-lg"></th>
                                            </tr>
                                        </thead>
                                        <tbody>




        

<?php

while ($ticketho = $resultho->fetch_assoc()){

    $fechat = new DateTime($ticketho['fecha']);
    $fechas = new DateTime($ticketho['fecha_salida_cliente']);
    $estat = $ticketho['estatus'];

    $destaca = $ticketho['destacado'];

    if ($destaca == 'SI') {$destai = "<img data-toggle='tooltip' title='Destacado' src='img/star.png'>"; }else{$destai = "";}

     $sale=$ticketho['fecha_salida_cliente'];

    $hoy=date('Y-m-d');
    $restafecha = dateDiff($hoy, $sale);

   if ($restafecha == 0 && $estat == 'Abierto') {
    $fechasal = "<span class='label label-sm label-danger label-mini'>".$fechas->format('d-m-Y')."</span>"; 
    }
    else{
    $fechasal = "<span class='label label-sm label-warning label-mini'>".$fechas->format('d-m-Y')."</span>"; 
    }


   $idt = base64_encode($ticketho['id']);


if ($estat == 'Por Validar') {$status = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estat == 'Abierto') {$status = "<span class='label label-sm label-primary label-mini'>Abierto</span>"; }
    if ($estat == 'Pagado') {$status = "<span class='label label-sm label-success label-mini'>Pagado</span>"; }
    if ($estat == 'Cancelado') {$status = "<span class='label label-sm label-danger label-mini'>Cancelado</span>"; }
    if ($estat == 'Anulado') {$status = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }
    if ($estat == 'Por Recibir') {$status = "<span class='label label-sm label-info label-mini'>Por Recibir</span>"; }

if ($estat == 'Por Recibir') {

    $editalink = "";


}
    else{

      $editalink = "<a data-toggle='tooltip' title='Editar Ticket' href='editar_ticket_facturacion.php?idt=".$idt."'><img src=img/editad.png></a>";


    }

  $estap = $ticketho['estatus_producto'];
    if ($estap == 'Por Validar') {$statup = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estap == 'Edicion') {$statup = "<span class='label label-sm label-info label-mini'>Edici&oacute;n</span>"; }
    if ($estap == 'Solo Email') {$statup = "<span class='label label-sm label-info label-mini'>Solo Email</span>"; }
    if ($estap == 'Mensajeria') {$statup = "<span class='label label-sm label-info label-mini'>Mensajer&iacute;a</span>"; }
    if ($estap == 'Meeting Point') {$statup = "<span class='label label-sm label-warning label-mini'>Meeting Point</span>"; }
    if ($estap == 'Entregado') {$statup = "<span class='label label-sm label-success label-mini'>Entregado</span>"; }
    if ($estap == 'Devuelto') {$statup = "<span class='label label-sm label-danger label-mini'>Devuelto</span>"; }
    if ($estap == 'Anulado') {$statup = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }


$entregar=$ticketho['tipo_entrega'];
if ($entregar == 'Personal') {$entreg = "<span class='label label-sm label-success label-mini'>Personal</span>"; }
if ($entregar == 'Meeting Point') {$entreg = "<span class='label label-sm label-warning label-mini'>Meeting Point</span>"; }
if ($entregar == 'Solo Email') {$entreg = "<span class='label label-sm label-primary label-mini'>Solo Email</span>"; }





$pemail = $ticketho['por_email'];
    if ($pemail == 'NO') {$email = "<span class='label label-sm label-default label-mini'>NO</span>"; }
    if ($pemail == 'SI') {$email = "<span class='label label-sm label-success label-mini'>SI</span>"; }

    $hotel = substr($ticketho['hotel'], 3);

                                            echo "<tr><td class='clearfix visible-xs visible-lg' align=center>".$destai."<a href='detalles_ticket.php?idt=".$idt."'>".$ticketho['nro_ticket']."</a></td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$fechat->format('d-m-Y')."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$ticketho['excursion']."</td>";                                
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketho['tarifaa']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketho['deposito1']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketho['pendiente']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketho['totalpagado']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$status."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$statup."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center><a data-toggle='tooltip' title='Validar Ticket' href='validar_ticket.php?idt=".$idt."'><img src=img/valida.png></a>&nbsp;&nbsp; <a data-toggle='tooltip' title='Detalles del Ticket' href='detalles_ticket.php?idt=".$idt."'><img src=img/detalle.png></a>&nbsp;&nbsp; ".$editalink."</td></tr>";



                                            }



?>




                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- END SAMPLE TABLE PORTLET-->
                    </div>










<!-- Lista de Tickets Pendiente de Pago-->


<?php

$sqlfp = "SELECT * FROM ticketsdb WHERE cerrado=0 and preaprobado=1 AND estatus='Abierto' AND (estatus_producto='Entregado' or estatus_producto='Devuelto') ORDER BY fecha_salida_cliente DESC";
$resultfp = mysqli_query($con,$sqlfp) or die(mysqli_error());
//$row=mysqli_fetch_array($result);

?>


<div class="col-md-12">
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet box success">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="livicon" data-name="calendar" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Facturaci&oacute;n - Tickets Pendientes de Pago

                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-striped table-bordered table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="doc-portrait" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>

                                                    Ticket
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="calendar" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Fecha
                                                </th>


                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="compass" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Excursi&oacute;n
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="image" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i> Producto 
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i> Precio 
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Dep&oacute;sito
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    T.Pagado
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Deuda
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="timer" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    E.Ticket
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="timer" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    E.Prod.
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>




        

<?php

while ($ticketfp = $resultfp->fetch_assoc()){

    $fechat = new DateTime($ticketfp['fecha']);
    $fechas = new DateTime($ticketfp['fecha_salida_cliente']);
    $estat = $ticketfp['estatus'];

     $destacaf = $ticketfp['destacado'];

    if ($destacaf == 'SI') {$destaif = "<img data-toggle='tooltip' title='Destacado' src='img/star.png'>"; }else{$destaif = "";}


     $sale=$ticketfp['fecha_salida_cliente'];

    $hoy=date('Y-m-d');
    $restafecha = dateDiff($hoy, $sale);

   if ($restafecha == 0 && $estat == 'Abierto') {
    $fechasal = "<span class='label label-sm label-danger label-mini'>".$fechas->format('d-m-Y')."</span>"; 
    }
    else{
    $fechasal = "<span class='label label-sm label-warning label-mini'>".$fechas->format('d-m-Y')."</span>"; 
    }


   $idt = base64_encode($ticketfp['id']);


if ($estat == 'Por Validar') {$status = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estat == 'Abierto') {$status = "<span class='label label-sm label-primary label-mini'>Abierto</span>"; }
    if ($estat == 'Pagado') {$status = "<span class='label label-sm label-success label-mini'>Pagado</span>"; }
    if ($estat == 'Cancelado') {$status = "<span class='label label-sm label-danger label-mini'>Cancelado</span>"; }
    if ($estat == 'Anulado') {$status = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }
    if ($estat == 'Por Recibir') {$status = "<span class='label label-sm label-primary label-mini'>Por Recibir</span>"; }

  $estap = $ticketfp['estatus_producto'];
    if ($estap == 'Por Validar') {$statup = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estap == 'Edicion') {$statup = "<span class='label label-sm label-info label-mini'>Edici&oacute;n</span>"; }
    if ($estap == 'Solo Email') {$statup = "<span class='label label-sm label-info label-mini'>Solo Email</span>"; }
    if ($estap == 'Mensajeria') {$statup = "<span class='label label-sm label-info label-mini'>Mensajer&iacute;a</span>"; }
    if ($estap == 'Meeting Point') {$statup = "<span class='label label-sm label-warning label-mini'>Meeting Point</span>"; }
    if ($estap == 'Entregado') {$statup = "<span class='label label-sm label-success label-mini'>Entregado</span>"; }
    if ($estap == 'Devuelto') {$statup = "<span class='label label-sm label-danger label-mini'>Devuelto</span>"; }
    if ($estap == 'Anulado') {$statup = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }


$entregar=$ticketfp['tipo_entrega'];
if ($entregar == 'Personal') {$entreg = "<span class='label label-sm label-success label-mini'>Personal</span>"; }
if ($entregar == 'Meeting Point') {$entreg = "<span class='label label-sm label-warning label-mini'>Meeting Point</span>"; }
if ($entregar == 'Solo Email') {$entreg = "<span class='label label-sm label-primary label-mini'>Solo Email</span>"; }





$pemail = $ticketfp['por_email'];
    if ($pemail == 'NO') {$email = "<span class='label label-sm label-default label-mini'>NO</span>"; }
    if ($pemail == 'SI') {$email = "<span class='label label-sm label-success label-mini'>SI</span>"; }

    $hotel = substr($ticketfp['hotel'], 3);


if ($ticketfp['estatus_producto'] == 'Devuelto') {
$linkcancelar="<a title='Cancelar Ticket' href='cancelar_ticket.php?idt=".$idt."'><img src=img/cancela.png></a>";
}
else
{
    $linkcancelar="";
}




                                            echo "<tr><td class='clearfix visible-xs visible-lg' align=center>".$destaif."<a href='detalles_ticket.php?idt=".$idt."'>".$ticketfp['nro_ticket']."</a></td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$fechat->format('d-m-Y')."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$ticketfp['excursion']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$ticketfp['producto']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketfp['tarifaa']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketfp['deposito1']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketfp['totalpagado']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketfp['pendiente']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$status."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$statup."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center><a data-toggle='tooltip' title='Actualizar Ticket' href='actualizar_ticket.php?idt=".$idt."'><img src=img/ediu.png></a>&nbsp;&nbsp;<a data-toggle='tooltip' title='Detalle de Ticket' href='detalles_ticket.php?idt=".$idt."'><img src=img/detalle.png></a>&nbsp;&nbsp;".$linkcancelar."</td></tr>";



                                            }



?>




                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- END SAMPLE TABLE PORTLET-->
                    </div>






<!-- Ticket por Cerrar -->



<!--Tickets pendiente de cerrar-->


<?php


$sqlfpa = "SELECT * FROM ticketsdb WHERE cerrado=0 and preaprobado=1 AND (estatus_producto='Entregado' or estatus_producto='Solo Email' and enviadoe ='SI') and estatus='Pagado' and pendiente=0 ORDER BY fecha DESC";
$resultfpa = mysqli_query($con,$sqlfpa) or die(mysqli_error());
//$row=mysqli_fetch_array($result);

?>


<div class="col-md-12">
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet box success">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="livicon" data-name="calendar" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Facturaci&oacute;n - Tickets Por Cerrar

                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-striped table-bordered table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="doc-portrait" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>

                                                    Ticket
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="calendar" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Fecha
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="compass" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Excursi&oacute;n
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="image" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i> Producto 
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i> Precio 
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Dep&oacute;sito
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    T.Pagado
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Deuda
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="timer" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    E.Ticket
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="timer" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    E.Prod.
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>




        

<?php

while ($ticketfpa = $resultfpa->fetch_assoc()){

    $fechatp = new DateTime($ticketfpa['fecha']);
    $fechasp = new DateTime($ticketfpa['fecha_salida_cliente']);
    $estatp = $ticketfpa['estatus'];

    $destacap = $ticketfpa['destacado'];

    if ($destacap == 'SI') {$destaip = "<img data-toggle='tooltip' title='Destacado' src='img/star.png'>"; }else{$destaip = "";}

     $salep=$ticketfpa['fecha_salida_cliente'];

    $hoy=date('Y-m-d');
    $restafechap = dateDiff($hoy, $salep);

   if ($restafechap == 0 && $estatp == 'Abierto') {
    $fechasalp = "<span class='label label-sm label-danger label-mini'>".$fechasp->format('d-m-Y')."</span>"; 
    }
    else{
    $fechasalp = "<span class='label label-sm label-warning label-mini'>".$fechasp->format('d-m-Y')."</span>"; 
    }


   $idtp = base64_encode($ticketfpa['id']);


if ($estatp == 'Por Validar') {$statusp = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estatp == 'Abierto') {$statusp = "<span class='label label-sm label-primary label-mini'>Abierto</span>"; }
    if ($estatp == 'Pagado') {$statusp = "<span class='label label-sm label-success label-mini'>Pagado</span>"; }
    if ($estatp == 'Cancelado') {$statusp = "<span class='label label-sm label-danger label-mini'>Cancelado</span>"; }
    if ($estatp == 'Anulado') {$statusp = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }
    if ($estatp == 'Por Recibir') {$statusp = "<span class='label label-sm label-primary label-mini'>Por Recibir</span>"; }

  $estapp = $ticketfpa['estatus_producto'];
    if ($estapp == 'Por Validar') {$statupp = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estapp == 'Edicion') {$statupp = "<span class='label label-sm label-info label-mini'>Edici&oacute;n</span>"; }
    if ($estapp == 'Solo Email') {$statupp = "<span class='label label-sm label-info label-mini'>Solo Email</span>"; }
    if ($estapp == 'Mensajeria') {$statupp = "<span class='label label-sm label-info label-mini'>Mensajer&iacute;a</span>"; }
    if ($estapp == 'Meeting Point') {$statupp = "<span class='label label-sm label-warning label-mini'>Meeting Point</span>"; }
    if ($estapp == 'Entregado') {$statupp = "<span class='label label-sm label-success label-mini'>Entregado</span>"; }
    if ($estapp == 'Devuelto') {$statupp = "<span class='label label-sm label-danger label-mini'>Devuelto</span>"; }
    if ($estapp == 'Anulado') {$statupp = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }


$entregarp=$ticketfpa['tipo_entrega'];
if ($entregarp == 'Personal') {$entregp = "<span class='label label-sm label-success label-mini'>Personal</span>"; }
if ($entregarp == 'Meeting Point') {$entregp = "<span class='label label-sm label-warning label-mini'>Meeting Point</span>"; }
if ($entregarp == 'Solo Email') {$entregp = "<span class='label label-sm label-primary label-mini'>Solo Email</span>"; }



$enviadoem = $ticketfpa['enviadoe'];

$pemailp = $ticketfpa['por_email'];
    
    if ($pemailp == 'SI') {

         if ($enviadoem <> 'SI') {
            $emailp = "<span class='label label-sm label-danger label-mini'>x</span>";
         }
         else
         {
            $emailp = "";
         }
         


    }


    $hotelp = substr($ticketfpa['hotel'], 3);

                                            echo "<tr><td class='clearfix visible-xs visible-lg' align=center>".$destaip."<a href='detalles_ticket.php?idt=".$idt."'>".$ticketfpa['nro_ticket']."</a></td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$fechatp->format('d-m-Y')."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$ticketfpa['excursion']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$ticketfpa['producto']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketfpa['tarifaa']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketfpa['deposito1']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketfpa['totalpagado']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketfpa['pendiente']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$statusp."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$statupp."".$emailp."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center><a data-toggle='tooltip' title='Cerrar Ticket' href='cerrar_ticket.php?idt=".$idtp."'><img src=img/cerrar.png></a></a>&nbsp;&nbsp;<a data-toggle='tooltip' title='Detalle de Ticket' href='detalles_ticket.php?idt=".$idtp."'><img src=img/detalle.png></a></td></tr>";



                                            }



?>




                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- END SAMPLE TABLE PORTLET-->
                    </div>









<?php


// Listado de Tickets donde los clientes ya han salido y estan pendientes por cerrar
$facturahoy = date('Y-m-d');
$sqlfpah = "SELECT * FROM ticketsdb WHERE cerrado=0 and preaprobado=1 AND estatus_producto NOT IN ('Entregado','Devuelto','Anulado') and estatus <> 'Pagado' and fecha_salida_cliente < '$facturahoy' ORDER BY fecha DESC";
$resultfpah = mysqli_query($con,$sqlfpah) or die(mysqli_error());
//$row=mysqli_fetch_array($result);

?>


<div class="col-md-12">
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet box warning">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="livicon" data-name="calendar" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Facturaci&oacute;n - Tickets Por Cerrar - Fecha de Salida Pasada

                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-striped table-bordered table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="doc-portrait" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>

                                                    Ticket
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="calendar" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Fecha
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="compass" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Hotel
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="image" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i> Producto 
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="calendar" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i> Fecha Sal. 
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i> Precio 
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Dep&oacute;sito
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    T.Pagado
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Deuda
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="timer" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    E.Ticket
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="timer" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    E.Prod.
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>




        

<?php

while ($ticketfpah = $resultfpah->fetch_assoc()){

    $fechatph = new DateTime($ticketfpah['fecha']);
    $fechasph = new DateTime($ticketfpah['fecha_salida_cliente']);
    $estatph = $ticketfpah['estatus'];

     $destacaph = $ticketfpah['destacado'];

    if ($destacaph == 'SI') {$destaiph = "<img data-toggle='tooltip' title='Destacado' src='img/star.png'>"; }else{$destaiph = "";}


     $saleph=$ticketfpah['fecha_salida_cliente'];

    $hoyh=date('Y-m-d');
    $restafechaph = dateDiff($hoyh, $saleph);

   if ($restafechaph == 0 && $estatph == 'Abierto') {
    $fechasalph = "<span class='label label-sm label-danger label-mini'>".$fechasph->format('d-m-Y')."</span>"; 
    }
    else{
    $fechasalph = "<span class='label label-sm label-warning label-mini'>".$fechasph->format('d-m-Y')."</span>"; 
    }


   $idtph = base64_encode($ticketfpah['id']);


if ($estatph == 'Por Validar') {$statusph = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estatph == 'Abierto') {$statusph = "<span class='label label-sm label-primary label-mini'>Abierto</span>"; }
    if ($estatph == 'Pagado') {$statusph = "<span class='label label-sm label-success label-mini'>Pagado</span>"; }
    if ($estatph == 'Cancelado') {$statusph = "<span class='label label-sm label-danger label-mini'>Cancelado</span>"; }
    if ($estatph == 'Anulado') {$statusph = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }
    if ($estatph == 'Por Recibir') {$statusph = "<span class='label label-sm label-primary label-mini'>Por Recibir</span>"; }

  $estapph = $ticketfpah['estatus_producto'];
    if ($estapph == 'Por Validar') {$statupph = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estapph == 'Edicion') {$statupph = "<span class='label label-sm label-info label-mini'>Edici&oacute;n</span>"; }
    if ($estapph == 'Solo Email') {$statupph = "<span class='label label-sm label-info label-mini'>Solo Email</span>"; }
    if ($estapph == 'Mensajeria') {$statupph = "<span class='label label-sm label-info label-mini'>Mensajer&iacute;a</span>"; }
    if ($estapph == 'Meeting Point') {$statupph = "<span class='label label-sm label-warning label-mini'>Meeting Point</span>"; }
    if ($estapph == 'Entregado') {$statupph = "<span class='label label-sm label-success label-mini'>Entregado</span>"; }
    if ($estapph == 'Devuelto') {$statupph = "<span class='label label-sm label-danger label-mini'>Devuelto</span>"; }
    if ($estapph == 'Anulado') {$statupph = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }


$entregarph=$ticketfpah['tipo_entrega'];
if ($entregarph == 'Personal') {$entregph = "<span class='label label-sm label-success label-mini'>Personal</span>"; }
if ($entregarph == 'Meeting Point') {$entregph = "<span class='label label-sm label-warning label-mini'>Meeting Point</span>"; }
if ($entregarph == 'Solo Email') {$entregph = "<span class='label label-sm label-primary label-mini'>Solo Email</span>"; }





$pemailph = $ticketfpah['por_email'];
    if ($pemailph == 'NO') {$emailph = "<span class='label label-sm label-default label-mini'>NO</span>"; }
    if ($pemailph == 'SI') {$emailph = "<span class='label label-sm label-success label-mini'>SI</span>"; }

    $hotelph = substr($ticketfpah['hotel'], 3);

                                            echo "<tr><td class='clearfix visible-xs visible-lg' align=center>".$destaiph."<a href='detalles_ticket.php?idt=".$idtph."'>".$ticketfpah['nro_ticket']."</a></td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$fechatph->format('d-m-Y')."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$hotelph."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$ticketfpah['producto']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".date('Y-m-d',strtotime($ticketfpah['fecha_salida_cliente']))."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketfpah['tarifaa']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketfpah['deposito1']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketfpah['totalpagado']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>$ ".$ticketfpah['pendiente']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$statusph."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$statupph."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center><a data-toggle='tooltip' title='Cerrar Ticket' href='cerrar_ticket.php?idt=".$idtph."'><img src=img/cerrar.png></a></a>&nbsp;&nbsp;<a data-toggle='tooltip' title='Detalle de Ticket' href='detalles_ticket.php?idt=".$idtph."'><img src=img/detalle.png></a></td></tr>";



                                            }



?>




                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- END SAMPLE TABLE PORTLET-->
                    </div>
















<?php
}

?>



<!--COMIENZA LISTADO GENERAL DE EXCURSIONES -->
<?php

if ($tipou == 1 || $tipou == 5 || $tipou == 6) {


$sqle = "SELECT excursiones_reservas.id as id, excursiones_reservas.fecha as fecha, excursiones_reservas.hora as hora, excursiones_reservas.excursion as excursion, excursiones_reservas.guia_barco as guia_barco, excursiones_reservas.fotografo1 as fotografo1, excursiones_reservas.fotografo2 as fotografo2, excursiones_reservas.personas as personas, excursiones_reservas.meta_proyectada as meta_proyectada, excursiones_reservas.meta_real as meta_real, excursiones_reservas.cerrado as cerrado, ticketsdb.id_excursion as id_excursion FROM excursiones_reservas LEFT JOIN ticketsdb ON excursiones_reservas.id=ticketsdb.id_excursion where (excursiones_reservas.memocierra is Null or excursiones_reservas.memocierra=0) and excursiones_reservas.excursion LIKE '%Saona%' GROUP BY excursiones_reservas.id";
$resulte = mysqli_query($con,$sqle) or die(mysql_error());
//$row=mysqli_fetch_array($result);




?>


<div class="col-md-12">
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet box warning">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="livicon" data-name="sun" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Listado de Memorias por Verificar
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-striped table-bordered table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="calendar" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>

                                                    Fecha
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="alarm" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Hora 
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="sun" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Excursi&oacute;n
                                                </th>

                                                 <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="user-flag" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Gu&iacute;a / Barco
                                                </th>

                                                <th class="hidden-xs">
                                                    <i class="livicon" data-name="camera" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Fotog. / <i class="livicon" data-name="camcoder" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i> Videog.
                                                </th>
                                               
                                                <th class="clearfix visible-xs visible-lg">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

<?php

while ($exce = $resulte->fetch_assoc()) {

   
 $idexe = base64_encode($exce['id']);

 $fechaexc=$exce['fecha'];

    $hoye=date('Y-m-d');
    $restafechae = dateDiff($hoye, $fechaexc);
   
   if ($restafechae < 0) {$fechaex = "<span class='label label-sm label-danger label-danger'>"; }
   if ($restafechae == 0) {$fechaex = "<span class='label label-sm label-warning label-warning'>"; }
   if ($restafechae > 0) {$fechaex = "<span class='label label-sm label-success label-success'>"; }

                                            echo "<tr><td align=center>".$fechaex.date('d-m-Y', strtotime($exce['fecha']))."</span></td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$exce['hora']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".strtoupper($exce['excursion'])."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$exce['guia_barco']."</td>";
                                            echo "<td class='hidden-xs' align=center>".$exce['fotografo1']." / ".$exce['fotografo2']."</td>";

                                            echo "<td class='clearfix visible-xs visible-lg' align=center><a data-toggle='tooltip' title='Verificar Memorias' href='editor_excursion_sd.php?idex=".$idexe."'><img src=img/sd.png></a></td></tr>";



                                            }


// El script automáticamente liberará el resultado y cerrará la conexión
// a MySQL cuando finalice, aunque aquí lo vamos a hacer nostros mismos

?>




                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END SAMPLE TABLE PORTLET-->
                    </div>



<?php
}
?>
<!--FINALIZA LISTADO GENERAL DE EXCURSIONES -->




<!-- Comienza Tabla de Tickets por validar Supervisor -->


<?php




if ($tipou == 5 || $tipou == 4 || $tipou == 1 || $tipou == 6) {

$sqle = "SELECT * FROM ticketsdb WHERE estatus_producto = 'Edicion'  ORDER BY fecha DESC";

$resulte = mysqli_query($con,$sqle) or die(mysql_error());
//$row=mysqli_fetch_array($result);

?>
<div class="col-md-12">

    
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet box info">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="livicon" data-name="pen" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Tickets Pendientes por Edici&oacute;n
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-striped table-bordered table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="doc-portrait" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>

                                                    Ticket
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="calendar" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Fecha
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="compass" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Excursi&oacute;n
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="user" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Cliente
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="camera" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Producto Adquirido
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="calendar" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Fecha de Salida
                                                </th>
                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="timer" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Estatus
                                                </th>

                                                <th class="clearfix visible-xs visible-lg">
                                                    <i class="livicon" data-name="timer" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Producto
                                                </th>
                                                <th clearfix visible-xs visible-lg></th>
                                            </tr>
                                        </thead>
                                        <tbody>




        

<?php

while ($ticketd = $resulte->fetch_assoc()){

    $fechat2 = new DateTime($ticketd['fecha']);
    $fechas2 = new DateTime($ticketd['fecha_salida_cliente']);
    $estat2 = $ticketd['estatus'];

    $destaca2 = $ticketd['destacado'];

    if ($destaca2 == 'SI') {$destai2 = "<img data-toggle='tooltip' title='Destacado' src='img/star.png'>"; }else{$destai2 = "";}

     $sale2=$ticketd['fecha_salida_cliente'];




   $idt = base64_encode($ticketd['id']);
   $idx = base64_encode($ticketd['id_excursion']);


if ($estat2 == 'Por Validar') {$status = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estat2 == 'Abierto') {$status = "<span class='label label-sm label-primary label-mini'>Abierto</span>"; }
    if ($estat2 == 'Pagado') {$status = "<span class='label label-sm label-success label-mini'>Pagado</span>"; }
    if ($estat2 == 'Cancelado') {$status = "<span class='label label-sm label-danger label-mini'>Cancelado</span>"; }
    if ($estat2 == 'Anulado') {$status = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }
 if ($estat2 == 'Por Recibir') {$status = "<span class='label label-sm label-info label-mini'>Por Recibir</span>"; }

  $estap2 = $ticketd['estatus_producto'];
    if ($estap2 == 'Por Validar') {$statup = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estap2 == 'Edicion') {$statup = "<span class='label label-sm label-info label-mini'>Edici&oacute;n</span>"; }
    if ($estap2 == 'Solo Email') {$statup = "<span class='label label-sm label-info label-mini'>Solo Email</span>"; }
    if ($estap2 == 'Mensajeria') {$statup = "<span class='label label-sm label-info label-mini'>Mensajer&iacute;a</span>"; }
    if ($estap2 == 'Meeting Point') {$statup = "<span class='label label-sm label-warning label-mini'>Meeting Point</span>"; }
    if ($estap2 == 'Entregado') {$statup = "<span class='label label-sm label-success label-mini'>Entregado</span>"; }
    if ($estap2 == 'Devuelto') {$statup = "<span class='label label-sm label-danger label-mini'>Devuelto</span>"; }
    if ($estap2 == 'Anulado') {$statup = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }

    




                                            echo "<tr><td class='clearfix visible-xs visible-lg' align=center>".$destai2."<a href='detalles_ticket.php?idt=".$idt."'>".$ticketd['nro_ticket']."</a></td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$fechat2->format('d-m-Y')."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg'><a href='editor_excursion_sd.php?idex=".$idx."'><strong>".$ticketd['excursion']." ".$ticketd['guia_excur']."</strong></a></td>";
                                            echo "<td>".$ticketd['cliente']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$ticketd['producto']."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$fechas2->format('d-m-Y')."</td>";

                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$status."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center>".$statup."</td>";
                                            echo "<td class='clearfix visible-xs visible-lg' align=center><a data-toggle='tooltip' title='Actualizar Estatus' href='actualizar_ticketedicion.php?idt=".$idt."'><img src=img/actualiza.png></a>    &nbsp;&nbsp; <a data-toggle='tooltip' title='Detalle de Ticket' href='detalles_ticket.php?idt=".$idt."'><img src=img/detalle.png></a></td></tr>";



                                            }


// El script automáticamente liberará el resultado y cerrará la conexión
// a MySQL cuando finalice, aunque aquí lo vamos a hacer nostros mismos




?>




                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END SAMPLE TABLE PORTLET-->
                    </div>


<?php
}

?>










<!-- listado del dia actual para ATC-->



<?php

if ($tipou == 3 || $tipou == 1)  {


 $tickehoy = date('Y-m-d', strtotime('-1 day')) ;

$sqlh = "SELECT * FROM `ticketsdb` WHERE `estatus_producto` IN ('Meeting Point', 'Mensajeria','Solo Email') AND `cerrado` = '0' AND `fecha` = '$tickehoy' ";
$resulth = mysqli_query($con,$sqlh) or die(mysqli_error());
//$row=mysqli_fetch_array($result);

?>


<div class="col-md-12">
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet box warning">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="livicon" data-name="phone" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> ATC - Tickets del D&iacute;a por Llamar
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-striped table-bordered table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <i class="livicon" data-name="doc-portrait" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>

                                                    Ticket
                                                </th>
                                                <th>
                                                    <i class="livicon" data-name="calendar" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Fecha
                                                </th>

                                                <th>
                                                    <i class="livicon" data-name="user" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Cliente
                                                </th>

                                                <th>
                                                    <i class="livicon" data-name="home" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Hotel
                                                </th>

                                                <th class="hidden-xs">
                                                    <i class="livicon" data-name="calendar" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Fecha de Salida
                                                </th>
                                                <th class="hidden-xs">
                                                    <i class="livicon" data-name="sandglass" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i> Entrega 
                                                </th>

                                                <th class="hidden-xs">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i> Hora 
                                                </th>
                                                <th>
                                                    <i class="livicon" data-name="timer" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Deuda
                                                </th>
                                                <th class="hidden-xs">
                                                    <i class="livicon" data-name="timer" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Estatus
                                                </th>

                                                <th class="hidden-xs">
                                                    <i class="livicon" data-name="camera" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Producto
                                                </th>
                                                <th class="hidden-xs">
                                                    <i class="livicon" data-name="mail" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Email
                                                </th>

                                                <th class="hidden-xs">
                                                    <i class="livicon" data-name="phone" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    
                                                </th>

                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>




        

<?php

while ($ticketh = $resulth->fetch_assoc()){

    $fechat = new DateTime($ticketh['fecha']);
    $fechas = new DateTime($ticketh['fecha_salida_cliente']);
    $estat = $ticketh['estatus'];

    $destacat = $ticketh['destacado'];

    if ($destacat == 'SI') {$destait = "<img data-toggle='tooltip' title='Destacado' src='img/star.png'>"; }else{$destait = "";}

     $sale=$ticketh['fecha_salida_cliente'];

    $hoy=date('Y-m-d');
    $restafecha = dateDiff($hoy, $sale);

   if ($restafecha == 0 && $estat == 'Abierto') {
    $fechasal = "<span class='label label-sm label-danger label-mini'>".$fechas->format('Y-m-d')."</span>"; 
    }
    else{
    $fechasal = "<span class='label label-sm label-warning label-mini'>".$fechas->format('Y-m-d')."</span>"; 
    }


   $idt = base64_encode($ticketh['id']);


if ($estat == 'Por Validar') {$status = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estat == 'Abierto') {$status = "<span class='label label-sm label-primary label-mini'>Abierto</span>"; }
    if ($estat == 'Pagado') {$status = "<span class='label label-sm label-success label-mini'>Pagado</span>"; }
    if ($estat == 'Cancelado') {$status = "<span class='label label-sm label-danger label-mini'>Cancelado</span>"; }
    if ($estat == 'Anulado') {$status = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }
    if ($estat == 'Por Recibir') {$status = "<span class='label label-sm label-info label-mini'>Por Recibir</span>"; }

  $estap = $ticketh['estatus_producto'];
    if ($estap == 'Por Validar') {$statup = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estap == 'Edicion') {$statup = "<span class='label label-sm label-info label-mini'>Edici&oacute;n</span>"; }
    if ($estap == 'Solo Email') {$statup = "<span class='label label-sm label-info label-mini'>Solo Email</span>"; }
    if ($estap == 'Mensajeria') {$statup = "<span class='label label-sm label-info label-mini'>Mensajer&iacute;a</span>"; }
    if ($estap == 'Meeting Point') {$statup = "<span class='label label-sm label-warning label-mini'>Meeting Point</span>"; }
    if ($estap == 'Entregado') {$statup = "<span class='label label-sm label-success label-mini'>Entregado</span>"; }
    if ($estap == 'Devuelto') {$statup = "<span class='label label-sm label-danger label-mini'>Devuelto</span>"; }
    if ($estap == 'Anulado') {$statup = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }


$entregar=$ticketh['tipo_entrega'];
if ($entregar == 'Personal') {$entreg = "<span class='label label-sm label-success label-mini'>Personal</span>"; }
if ($entregar == 'Meeting Point') {$entreg = "<span class='label label-sm label-warning label-mini'>Meeting Point</span>"; }
if ($entregar == 'Solo Email') {$entreg = "<span class='label label-sm label-primary label-mini'>Solo Email</span>"; }








$pemail = $ticketh['por_email'];

    if ($pemail == 'NO') {$email = "<span class='label label-sm label-default label-mini'><i class='livicon' data-name='mail' data-size='16' data-c='#ffffff' data-hc='#ffffff' data-loop='true'></i></span>"; }
   if ($pemail == 'SI') {$email = "<span class='label label-sm label-success label-mini'><i class='livicon' data-name='mail' data-size='16' data-c='#ffffff' data-hc='#ffffff' data-loop='true'></i></span>"; }

   $envioe = $ticketh['enviadoe'];
if ($envioe == 'SI') {$esi = "<span class='glyphicon glyphicon-ok'></span>"; }
else
{$esi = ""; }




    $contact = date('Y-m-d', strtotime($ticketh['contactado']));

     
  $fechacontacto = dateDiff($hoy, $contact);

     $si_nos=$ticketh['si_no'];

    if ($fechacontacto == 0 && $si_nos == 'SI') {$contactado = "<a data-toggle='tooltip' title='Cliente Contactado Hoy'><span class='label label-sm label-success label-mini'>SI</span></a>"; }
    if ($fechacontacto < 0 && $si_nos == 'SI') {$contactado = "<a data-toggle='tooltip' title='Cliente Por Volver a Contactar'><span class='label label-sm label-warning label-mini'>SI</span></a>"; }

    if ($fechacontacto == 0 && $si_nos == '') {$contactado = "<a data-toggle='tooltip' title='Cliente Por Contactar'><span class='label label-sm label-info label-mini'>--</span></a>"; }
    if ($fechacontacto < 0 && $si_nos == '') {$contactado = "<a data-toggle='tooltip' title='Cliente Por Contactar'><span class='label label-sm label-default label-mini'>--</span></a>"; }


    if ($fechacontacto == 0 && $si_nos == 'NO') {$contactado = "<a data-toggle='tooltip' title='Cliente No Ha Respondido Hoy'><span class='label label-sm label-primary label-mini'>NO</span></a>"; }
    if ($fechacontacto < 0 && $si_nos == 'NO') {$contactado = "<a data-toggle='tooltip' title='Cliente Por Volver a Contactar'><span class='label label-sm label-danger label-mini'>NO</span></a>"; }

    $hotel = substr($ticketh['hotel'], 3);

                                            echo "<tr><td align=center>".$destait."<a href='detalles_ticket.php?idt=".$idt."'>".$ticketh['nro_ticket']."</a></td>";
                                            echo "<td align=center>".$fechat->format('d-m-Y')."</td>";
                                            echo "<td align=center>".$ticketh['cliente']."</td>";
                                            echo "<td align=center>".$hotel."</td>";
                                            echo "<td align=center>".$fechasal."</td>";
                                            echo "<td align=center>".$entreg."</td>";
                                            echo "<td align=center>".$ticketh['hora_entrega']."</td>";
                                            echo "<td align=center>$ ".$ticketh['pendiente']."</td>";
                                            echo "<td align=center>".$status."</td>";
                                            echo "<td align=center>".$statup."</td>";
                                            echo "<td align=center>".$email." ".$esi."</td>";
                                            echo "<td align=center>".$contactado."</td>";
                                            echo "<td align=center><a data-toggle='tooltip' title='Detalle de Ticket' href='detalles_ticket.php?idt=".$idt."'><img src=img/detalle.png></a></td></tr>";



                                            }


?>




                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- END SAMPLE TABLE PORTLET-->
                    </div>










<!-- FINALIZA LISTADO DIA ACTUAL-->

<?php



$sql = "SELECT * FROM ticketsdb WHERE fecha_salida_cliente BETWEEN DATE_SUB(CURDATE(), INTERVAL 0 DAY) and DATE_SUB(CURDATE(), INTERVAL -1 DAY) and cerrado=0 AND estatus_producto IN ('Meeting Point', 'Mensajeria', 'Solo Email') ORDER BY fecha_salida_cliente DESC";
$result = mysqli_query($con,$sql) or die(mysqli_error());
//$row=mysqli_fetch_array($result);

?>


<div class="col-md-12">
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet box danger">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="livicon" data-name="pen" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> ATC - Tickets Pendientes, Clientes con Salida entre Hoy y Mañana
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-striped table-bordered table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <i class="livicon" data-name="doc-portrait" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>

                                                    Ticket
                                                </th>
                                                <th>
                                                    <i class="livicon" data-name="calendar" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Fecha
                                                </th>

                                                <th>
                                                    <i class="livicon" data-name="user" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Cliente
                                                </th>

                                                <th>
                                                    <i class="livicon" data-name="home" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Hotel
                                                </th>

                                                <th class="hidden-xs">
                                                    <i class="livicon" data-name="calendar" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Fecha de Salida
                                                </th>
                                                <th class="hidden-xs">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i> Pagado 
                                                </th>

                                                <th class="hidden-xs">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i> Deuda 
                                                </th>
                                                <th class="hidden-xs">
                                                    <i class="livicon" data-name="timer" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Estatus
                                                </th>

                                                <th class="hidden-xs">
                                                    <i class="livicon" data-name="camera" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Producto
                                                </th>
                                                <th class="hidden-xs">
                                                    <i class="livicon" data-name="mail" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Email
                                                </th>
                                                 <th class="hidden-xs">
                                                    <i class="livicon" data-name="phone" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    
                                                </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>




        

<?php

while ($ticket = $result->fetch_assoc()){

    $fechat = new DateTime($ticket['fecha']);
    $fechas = new DateTime($ticket['fecha_salida_cliente']);
    $estat = $ticket['estatus'];

    $destacatt = $ticket['destacado'];

    if ($destacatt == 'SI') {$destaitt = "<img data-toggle='tooltip' title='Destacado' src='img/star.png'>"; }else{$destaitt = "";}

     $sale=$ticket['fecha_salida_cliente'];

    $hoy=date('Y-m-d');
    $restafecha = dateDiff($hoy, $sale);

   if ($restafecha == 0 && $estat == 'Abierto') {
    $fechasal = "<span class='label label-sm label-danger label-mini'>".$fechas->format('d-m-Y')."</span>"; 
    }
    else{
    $fechasal = "<span class='label label-sm label-warning label-mini'>".$fechas->format('d-m-Y')."</span>"; 
    }


   $idt = base64_encode($ticket['id']);


if ($estat == 'Por Validar') {$status = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estat == 'Abierto') {$status = "<span class='label label-sm label-primary label-mini'>Abierto</span>"; }
    if ($estat == 'Pagado') {$status = "<span class='label label-sm label-success label-mini'>Pagado</span>"; }
    if ($estat == 'Cancelado') {$status = "<span class='label label-sm label-danger label-mini'>Cancelado</span>"; }
    if ($estat == 'Anulado') {$status = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }
     if ($estat == 'Por Recibir') {$status = "<span class='label label-sm label-info label-mini'>Por Recibir</span>"; }

  $estap = $ticket['estatus_producto'];
    if ($estap == 'Por Validar') {$statup = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estap == 'Edicion') {$statup = "<span class='label label-sm label-info label-mini'>Edici&oacute;n</span>"; }
    if ($estap == 'Solo Email') {$statup = "<span class='label label-sm label-info label-mini'>Solo Email</span>"; }
    if ($estap == 'Mensajeria') {$statup = "<span class='label label-sm label-info label-mini'>Mensajer&iacute;a</span>"; }
    if ($estap == 'Meeting Point') {$statup = "<span class='label label-sm label-warning label-mini'>Meeting Point</span>"; }
    if ($estap == 'Entregado') {$statup = "<span class='label label-sm label-success label-mini'>Entregado</span>"; }
    if ($estap == 'Devuelto') {$statup = "<span class='label label-sm label-danger label-mini'>Devuelto</span>"; }
    if ($estap == 'Anulado') {$statup = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }


$pemail = $ticket['por_email'];

   if ($pemail == 'NO') {$email = "<span class='label label-sm label-default label-mini'><i class='livicon' data-name='mail' data-size='16' data-c='#ffffff' data-hc='#ffffff' data-loop='true'></i></span>"; }
   if ($pemail == 'SI') {$email = "<span class='label label-sm label-success label-mini'><i class='livicon' data-name='mail' data-size='16' data-c='#ffffff' data-hc='#ffffff' data-loop='true'></i></span>"; }

   $envioe = $ticket['enviadoe'];
if ($envioe == 'SI') {$esi = "<span class='glyphicon glyphicon-ok'></span>"; }
else
{$esi = ""; }


       $contacts = date('Y-m-d', strtotime($ticket['contactado']));

     
  $fechacontactos = dateDiff($hoy, $contacts);

  $si_no=$ticket['si_no'];

    if ($fechacontactos == 0 && $si_no == 'SI') {$contactados = "<a data-toggle='tooltip' title='Cliente Contactado Hoy'><span class='label label-sm label-success label-mini'>SI</span></a>"; }
    if ($fechacontactos < 0 && $si_no == 'SI') {$contactados = "<a data-toggle='tooltip' title='Cliente Por Volver a Contactar'><span class='label label-sm label-warning label-mini'>SI</span></a>"; }

    if ($fechacontactos == 0 && $si_no == '') {$contactados = "<a data-toggle='tooltip' title='Cliente Por Contactar'><span class='label label-sm label-info label-mini'>--</span></a>"; }
    if ($fechacontactos < 0 && $si_no == '') {$contactados = "<a data-toggle='tooltip' title='Cliente Por Contactar'><span class='label label-sm label-default label-mini'>--</span></a>"; }


    if ($fechacontactos == 0 && $si_no == 'NO') {$contactados = "<a data-toggle='tooltip' title='Cliente No Ha Respondido Hoy'><span class='label label-sm label-primary label-mini'>NO</span></a>"; }
    if ($fechacontactos < 0 && $si_no == 'NO') {$contactados = "<a data-toggle='tooltip' title='Cliente Por Volver a Contactar'><span class='label label-sm label-danger label-mini'>NO</span></a>"; }


    $hotel = substr($ticket['hotel'], 3);

                                            echo "<tr><td align=center>".$destaitt."<a href='detalles_ticket.php?idt=".$idt."'>".$ticket['nro_ticket']."</a></td>";
                                            echo "<td align=center>".$fechat->format('d-m-Y')."</td>";
                                            echo "<td align=center>".$ticket['cliente']."</td>";
                                            echo "<td align=center>".$hotel."</td>";
                                            echo "<td align=center>".$fechasal."</td>";
                                            echo "<td align=center>$ ".$ticket['totalpagado']."</td>";
                                            echo "<td align=center>$ ".$ticket['pendiente']."</td>";
                                            echo "<td align=center>".$status."</td>";
                                            echo "<td align=center>".$statup."</td>";
                                            echo "<td align=center>".$email." ".$esi."</td>";
                                            echo "<td align=center>".$contactados."</td>";
                                            echo "<td align=center><a data-toggle='tooltip' title='Detalle de Ticket' href='detalles_ticket.php?idt=".$idt."'><img src=img/detalle.png></a></td></tr>";



                                            }



?>




                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- END SAMPLE TABLE PORTLET-->
                    </div>





















<!-- FINALIZA LISTADO DIA ACTUAL-->

<?php



$sql = "SELECT * FROM ticketsdb WHERE estatus_producto <>'Anulado' and estatus NOT IN ('Cancelado','Abierto','Por Validar','Por Recibir') and (tipo_entrega='Solo Email' or por_email='SI') and enviadoe is NULL";
$result = mysqli_query($con,$sql) or die(mysqli_error());
//$row=mysqli_fetch_array($result);

?>


<div class="col-md-12">
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet box primary">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="livicon" data-name="mail" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> ATC - Pendientes de Enviar por Email
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-striped table-bordered table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <i class="livicon" data-name="doc-portrait" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>

                                                    Ticket
                                                </th>
                                                <th>
                                                    <i class="livicon" data-name="calendar" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Fecha
                                                </th>

                                                <th>
                                                    <i class="livicon" data-name="user" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Cliente
                                                </th>

                                                <th>
                                                    <i class="livicon" data-name="mail" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Email
                                                </th>

                                                <th class="hidden-xs">
                                                    <i class="livicon" data-name="calendar" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Tipo Entrega
                                                </th>
                                                <th class="hidden-xs">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i> Pagado 
                                                </th>

                                                <th class="hidden-xs">
                                                    <i class="livicon" data-name="money" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i> Deuda 
                                                </th>

                                                <th class="hidden-xs">
                                                    <i class="livicon" data-name="camera" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    Producto
                                                </th>

                                                 <th class="hidden-xs">
                                                    <i class="livicon" data-name="phone" data-size="16" data-c="#666666" data-hc="#666666" data-loop="true"></i>
                                                    
                                                </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>




        

<?php

while ($ticket = $result->fetch_assoc()){

    $fechat = new DateTime($ticket['fecha']);
    $fechas = new DateTime($ticket['fecha_salida_cliente']);
    $estat = $ticket['estatus'];

    $destacat1 = $ticket['destacado'];

    if ($destacat1 == 'SI') {$destait1 = "<img data-toggle='tooltip' title='Destacado' src='img/star.png'>"; }else{$destait1 = "";}

     $sale=$ticket['fecha_salida_cliente'];

    $hoy=date('Y-m-d');
    $restafecha = dateDiff($hoy, $sale);

   if ($restafecha == 0 && $estat == 'Abierto') {
    $fechasal = "<span class='label label-sm label-danger label-mini'>".$fechas->format('d-m-Y')."</span>"; 
    }
    else{
    $fechasal = "<span class='label label-sm label-warning label-mini'>".$fechas->format('d-m-Y')."</span>"; 
    }


   $idt = base64_encode($ticket['id']);


if ($estat == 'Por Validar') {$status = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estat == 'Abierto') {$status = "<span class='label label-sm label-primary label-mini'>Abierto</span>"; }
    if ($estat == 'Pagado') {$status = "<span class='label label-sm label-success label-mini'>Pagado</span>"; }
    if ($estat == 'Cancelado') {$status = "<span class='label label-sm label-danger label-mini'>Cancelado</span>"; }
    if ($estat == 'Anulado') {$status = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }
     if ($estat == 'Por Recibir') {$status = "<span class='label label-sm label-info label-mini'>Por Recibir</span>"; }

  $estap = $ticket['estatus_producto'];
    if ($estap == 'Por Validar') {$statup = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($estap == 'Edicion') {$statup = "<span class='label label-sm label-info label-mini'>Edici&oacute;n</span>"; }
    if ($estap == 'Solo Email') {$statup = "<span class='label label-sm label-info label-mini'>Solo Email</span>"; }
    if ($estap == 'Mensajeria') {$statup = "<span class='label label-sm label-info label-mini'>Mensajer&iacute;a</span>"; }
    if ($estap == 'Meeting Point') {$statup = "<span class='label label-sm label-warning label-mini'>Meeting Point</span>"; }
    if ($estap == 'Entregado') {$statup = "<span class='label label-sm label-success label-mini'>Entregado</span>"; }
    if ($estap == 'Devuelto') {$statup = "<span class='label label-sm label-danger label-mini'>Devuelto</span>"; }
    if ($estap == 'Anulado') {$statup = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }


$pemail = $ticket['por_email'];

   if ($pemail == 'NO') {$email = ""; }
   if ($pemail == 'SI') {$email = "<span class='label label-sm label-success label-mini'>SI</span>"; }

   $envioe = $ticket['enviadoe'];
if ($envioe == 'SI') {$esi = "<span class='glyphicon glyphicon-ok'></span>"; }
else
{$esi = ""; }


       $contacts = date('Y-m-d', strtotime($ticket['contactado']));

     
  $fechacontactos = dateDiff($hoy, $contacts);

  $si_no=$ticket['si_no'];

    if ($fechacontactos == 0 && $si_no == 'SI') {$contactados = "<a data-toggle='tooltip' title='Cliente Contactado Hoy'><span class='label label-sm label-success label-mini'>SI</span></a>"; }
    if ($fechacontactos < 0 && $si_no == 'SI') {$contactados = "<a data-toggle='tooltip' title='Cliente Por Volver a Contactar'><span class='label label-sm label-warning label-mini'>SI</span></a>"; }

    if ($fechacontactos == 0 && $si_no == '') {$contactados = "<a data-toggle='tooltip' title='Cliente Por Contactar'><span class='label label-sm label-info label-mini'>--</span></a>"; }
    if ($fechacontactos < 0 && $si_no == '') {$contactados = "<a data-toggle='tooltip' title='Cliente Por Contactar'><span class='label label-sm label-default label-mini'>--</span></a>"; }


    if ($fechacontactos == 0 && $si_no == 'NO') {$contactados = "<a data-toggle='tooltip' title='Cliente No Ha Respondido Hoy'><span class='label label-sm label-primary label-mini'>NO</span></a>"; }
    if ($fechacontactos < 0 && $si_no == 'NO') {$contactados = "<a data-toggle='tooltip' title='Cliente Por Volver a Contactar'><span class='label label-sm label-danger label-mini'>NO</span></a>"; }


    $hotel = substr($ticket['hotel'], 3);

                                            echo "<tr><td align=center>".$destait1."<a href='detalles_ticket.php?idt=".$idt."'>".$ticket['nro_ticket']."</a></td>";
                                            echo "<td align=center>".$fechat->format('d-m-Y')."</td>";
                                            echo "<td align=center>".$ticket['cliente']."</td>";
                                            echo "<td align=center>".$ticket['email']."</td>";
                                            echo "<td align=center>".$ticket['tipo_entrega']."</td>";
                                            echo "<td align=center>$ ".$ticket['totalpagado']."</td>";
                                            echo "<td align=center>$ ".$ticket['pendiente']."</td>";
                                            echo "<td align=center>".$statup."</td>";
                                            echo "<td align=center>".$contactados."</td>";
                                            echo "<td align=center><a data-toggle='tooltip' title='Detalle de Ticket' href='detalles_ticket.php?idt=".$idt."'><img src=img/detalle.png></a></td></tr>";



                                            }



?>




                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- END SAMPLE TABLE PORTLET-->
                    </div>








</div>




                <div class="clearfix"></div>
                <div class="row">



<div class="col-md-12">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="table" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Tickets Abierto S&oacute;lo Email
                                </h3>
                                <span class="pull-right clickable">
                                    <i class="glyphicon glyphicon-chevron-up"></i>
                                </span>
                            </div>
                            <div class="panel-body">
                                <div class="box-body">
                                    <form role="form" method="GET" action="listar_abiertos_solo_email.php" data-parsley-validate>


                                    <div class="row ">
                                       
                                    <div style="text-align: center;" class="col-md-12">
                                    <div class="form-group">
                                        <label>Listar por:</label>
                                        <label class="radio-inline">
                                            &nbsp;<input type="radio" class="square" name="buscapor" value="1" checked>&nbsp; Rango de Fechas</label>
                                        <label class="radio-inline">
                                            <input type="radio" class="square" name="buscapor" value="2">&nbsp;Todos los Tickets</label>
                                        
                                    </div>
                                    </div>

                                    </div>

           
                                    
                             <div class="row ">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Fecha Inicial:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="livicon" data-name="calendar" data-size="14" data-loop="true"></i>
                                            </div>
                                            <input type="text" class="form-control" name="fecha_inicio" id="rangepicker4" />
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                   </div>


                                   <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Fecha Final:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="livicon" data-name="calendar" data-size="14" data-loop="true"></i>
                                            </div>
                                            <input type="text" class="form-control" name="fecha_fin" id="rangepicker2" />
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                   </div>

                                   </div>
                                   <div class="clearfix"></div>
                                   <div style="text-align: center;" class="row"><br>
                                    <button type="submit" class="btn btn-responsive btn-danger"><span class="glyphicon glyphicon-share"></span> Listar Tickets</button>
                                
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>

                      </div>




    <?php
}

?>                  
                      
   <!-- Termina Editores-->                     
                        


    <?php

$con->close();
    ?>









                </div>
                            
                <div class="clearfix"></div>
                <div class="row ">
                   
                 
                </div>
            </section>
        </aside>
        <!-- right-side -->
    </div>
    <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Subir" data-toggle="tooltip" data-placement="left">
        <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
    </a>
    <!-- global js -->
    <script src="js/app.js" type="text/javascript"></script>
    <!-- end of global js -->
    <!-- begining of page level js -->

    <!--end easy pie chart -->
    <!--for calendar-->


    <!--   Realtime Server Load  -->

<script type='text/javascript' src="vendors/bootstrap-progressbar/js/bootstrap-progressbar.js"></script>

    <!--  todolist-->
 
    <script src="js/pages/dashboard.js" type="text/javascript"></script>
    <!-- end of page level js -->
    <script type="text/javascript" src="vendors/datatables/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="vendors/datatables/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="vendors/datatables/js/dataTables.responsive.js"></script>
    <script src="js/pages/table-responsive.js"></script>
    <script src="vendors/moment/js/moment.min.js" type="text/javascript"></script>
    <script src="vendors/daterangepicker/js/daterangepicker.js" type="text/javascript"></script>
    <script src="vendors/datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="vendors/clockface/js/clockface.js" type="text/javascript"></script>
    <script src="vendors/jasny-bootstrap/js/jasny-bootstrap.js" type="text/javascript"></script>
    <script src="js/pages/datepicker.js" type="text/javascript"></script>
    <script src="js/pages/form_examples.js"></script>
    <script type="text/javascript" src="vendors/iCheck/js/icheck.js"></script>
    <script type="text/javascript" src="vendors/bootstrap-switch/js/bootstrap-switch.js"></script>
    <script type="text/javascript" src="vendors/switchery/js/switchery.js"></script>
    <script type="text/javascript" src="vendors/bootstrap-maxlength/js/bootstrap-maxlength.js"></script>
    <script type="text/javascript" src="vendors/card/lib/js/jquery.card.js"></script>
    <script type="text/javascript" src="js/pages/radio_checkbox.js"></script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/0.0.11/push.min.js"></script>
    
    <script type="text/javascript" src="js/pages/general.js"></script>


<script>
    
if(x > 10)
{
    document.getElementById('xyz').play();
    alert("Hay Entregas fuera de Tiempo!");
}

</script>

    <script type="text/javascript">
      function myFunction() {
        $.ajax({
          url: "system_mensajes.php",
          type: "POST",
          processData:false,
          success: function(data){
            $("#notification-count").remove();                  
            $("#notification-latest").show();$("#notification-latest").html(data);            
          },
          error: function(){}           
        });
      }
                                 
      $(document).ready(function() {
        $('body').click(function(e){
          if ( e.target.id != 'notification-icon'){
            $("#notification-latest").hide();
          }
        });
      });                                     
    </script>



<?php

if ($tipou == 3)  {

  ?>  

<script type="text/javascript">


$(document).ready(function() {
    function ticketspasados(){
   var url = "verificaentregajs.php";
        $.getJSON(url, function(result) {
            console.log(result);
            $.each(result, function(i, field) {
                var ticket = field.nro_ticket;
                var hora = field.hora_entrega;


                if (isNaN(ticket)) {

                    //no pasa nada
                }
                else
                {

                     document.getElementById('xyz').play();
                    alert("El Ticket " + ticket + " de la hora  " + hora + ", No se ha Entregado. Revisar y Contactar con Mensajeros!");

                }



            });
        });
    }





    setInterval(ticketspasados, 3500000);
});


</script>


<script type="text/javascript">
window.onload = function() {
          var url = "verificaentregajs.php";
        $.getJSON(url, function(result) {
            console.log(result);
            $.each(result, function(i, field) {
                var ticket = field.nro_ticket;
                var hora = field.hora_entrega;


                if (isNaN(ticket)) {

                    //no pasa nada
                }
                else
                {

                     document.getElementById('xyz').play();
                    alert("El Ticket " + ticket + " de la hora  " + hora + ", No se ha Entregado. Revisar y Contactar con Mensajeros!");

                }



            });
        });
};

</script>






<?php


}

  ?> 


</body>

</html>
