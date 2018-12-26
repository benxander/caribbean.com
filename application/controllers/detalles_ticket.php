<?php
include("db.php");
ini_set("error_reporting", false);
session_start();
if(!isset($_SESSION["username"])){
header("Location: login.php");
exit(); }

else {
  $tipou=$_SESSION["tipou"];
  $id_u=$_SESSION["idu"];  
  $msjesuccess = 1;
}



$usuario=$_SESSION["nombre"];

$id_t=$_GET['idt'];

$id_ticket=base64_decode($_GET['idt']);


$sql = "SELECT * FROM ticketsdb WHERE id='$id_ticket'";
$result = mysqli_query($con,$sql) or die(mysql_error());

$ticket = $result->fetch_assoc();


$tipoentrega=$ticket['tipo_entrega'];
$poremail=$ticket['por_email'];
$enviado=$ticket['enviadoe'];

$estatus_ticket=$ticket['estatus'];
$nro_t= $ticket['nro_ticket'];

$hotel=$ticket['hotel'];

$fecha2p=$ticket['fecha_pago2'];

if ($fecha2p === Null || $fecha2p == '0000-00-00') {
   $fechap2 = "";
}else
{
    $fechap2 = date('d-m-Y',strtotime($ticket['fecha_pago2']));
}


$sqlhotelh="SELECT * FROM hoteles WHERE nombre='$hotel'";
$resulthh = mysqli_query($con,$sqlhotelh) or die(mysql_error());
$hotleh = $resulthh->fetch_assoc();

$hotel_entrega=$hotleh['detalles'];
$hotel_ruta=$hotleh['ruta'];
$hotel_tipoentrega=$hotleh['entrega'];

$pixelis=$hotleh['pixelis'];



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
    <link href="css/app.css" rel="stylesheet"  type="text/css">
    <!-- end of global css -->
    <!--page level css -->
    <link href="vendors/jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" />
    <link href="vendors/iCheck/css/all.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="vendors/iCheck/css/all.css">
    <link rel="stylesheet" type="text/css" href="vendors/iCheck/css/line/line.css">
    <link rel="stylesheet" type="text/css" href="vendors/bootstrap-switch/css/bootstrap-switch.css">
    <link rel="stylesheet" type="text/css" href="vendors/switchery/css/switchery.css">
    <link rel="stylesheet" type="text/css" href="vendors/awesome-bootstrap-checkbox/css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/pages/radio_checkbox.css">
    <link href="vendors/flatpickr-calendar/css/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/air-datepicker/css/datepicker.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="vendors/sweetalert/css/sweetalert.css" />
    <link href="vendors/daterangepicker/css/daterangepicker.css" rel="stylesheet" type="text/css" />
    <link href="vendors/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<link href="css/jquery-ui.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="vendors/fancybox/jquery.fancybox.css" media="screen" />
    <!-- Add Button helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="vendors/fancybox/helpers/jquery.fancybox-buttons.css" />
    <!-- Add Thumbnail helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="vendors/fancybox/helpers/jquery.fancybox-thumbs.css" />

    <link href="vendors/modal/css/component.css" rel="stylesheet" />
    <link href="css/pages/advmodals.css" rel="stylesheet" />
 <script type="text/javascript" src="js/jquery.js"></script>
    
   

   
</head>



<body class="skin-josh">
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
                            <img src="img/logouno.jpg" width="35" class="img-circle img-responsive pull-left" height="35" >
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
                                <img src="img/logouno.jpg" width="90" class="img-circle img-responsive" height="90" />
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
                        <li>
                            <a href="home.php">
                                <i class="livicon" data-name="home" data-size="18" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>
                                <span class="title">Escritorio</span>
                            </a>

                        </li>
                        <li class="active">
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
                                <li class="active" id="active">
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
                               <!-- <li>
                                    <a href="reporte_rutas.php">
                                        <i class="fa fa-angle-double-right"></i>
                                        Generar Rutas
                                    </a>
                                </li> -->
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
                            <a href="salir.php">
                                <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="sign-out" data-size="18" data-loop="true"></i>
                               
                                Salir
                            </a>
                        </li>
                       
  
                    </ul>
                    <!-- END SIDEBAR MENU --> </div>
            </section>
            <!-- /.sidebar --> </aside>
        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <!--section starts-->
                <h1>Tickets</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="home.php">
                            <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                            Escritorio
                        </a>
                    </li>
                    <li>
                        <a href="#">Tickes</a>
                    </li>
                    <li class="active">Detalle de Ticket</li>
                </ol>
            </section>
            <!--section ends-->
            <section class="content">
                <!--main content-->
                <div class="row">
                    <!--row starts-->
                




                    <!--md-6 ends-->
                    <div class="col-md-12">
                        <!--md-6 starts-->
                        <!--form control starts-->
                        <div class="panel panel-success" id="hidepanel6">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="doc-portrait" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                    Detalle del Ticket: <?php echo $ticket['nro_ticket']; ?>
                                </h3>
                                <span class="pull-right">
                                    <i class="glyphicon glyphicon-chevron-up clickable"></i>
                                </span>
                            </div>

                            <div class="panel-body">
                               
                           

                                <div class="row"><br>

                                    <div class="form-group col-md-2">
                                        <label>Nro. Ticket</label> <?php if ($ticket['destacado'] == 'SI') {echo "<img data-toggle='tooltip' title='Destacado' src='img/star.png'>"; } ?>
                                       <input class="form-control" type="text" value="<?php echo $ticket['nro_ticket']; ?>" readonly />
                                     </div>
                                 <div class="form-group col-md-2">
                                        <label><i class="livicon" data-name="calendar" data-size="14" data-loop="true"></i> Fecha Ticket:</label>
                                        <div class="input-group">

                                            <input type="text" class="form-control" value="<?php echo date('d-m-Y',strtotime($ticket['fecha'])); ?>" readonly />
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label><i class="livicon" data-name="user" data-size="14" data-loop="true"></i> Nombre Cliente</label>
                                        <input class="form-control" type="text" value="<?php echo $ticket['cliente']; ?>" readonly/>
                                     </div>

                                
                                    <div class="form-group col-md-3">
                                        <label><i class="livicon" data-name="mail" data-size="14" data-loop="true"></i> Email Cliente</label>
                                        <input class="form-control" type="email" value="<?php echo $ticket['email']; ?>" readonly/>
                                     </div>

                                    <div class="form-group col-md-2">
                                        <label><i class="livicon" data-name="cellphone" data-size="14" data-loop="true"></i> Whatsapp N.</label>
                                        <input class="form-control" type="text"  value="<?php echo $ticket['telefono']; ?>" readonly>
                                    </div>


                                     </div>



                                      <div class="row"><br>

                                <div class="form-group col-md-3">
                                        <label><i class="livicon" data-name="compass" data-size="14" data-loop="true"></i> Excursi&oacute;n</label>
                                        <input class="form-control" type="text" value="<?php echo $ticket['excursion']; ?>" readonly/>
                                     </div>

                                      <div class="form-group col-md-3">
                                        <label><i class="livicon" data-name="user-flag" data-size="14" data-loop="true"></i> Gu&iacute;a / Barco</label>
                                        <input class="form-control autoguias" type="text" value="<?php echo $ticket['guia_excur']; ?>" readonly/>
                                     </div>

                                      <div class="form-group col-md-3">
                                        <label><i class="livicon" data-name="camera" data-size="14" data-loop="true"></i> Fot&oacute;grafo</label>
                                        <input class="form-control autofotografos" type="text" value="<?php echo $ticket['fotografo1']; ?>" readonly />
                                     </div>

                                      <div class="form-group col-md-3">
                                        <label><i class="livicon" data-name="camcoder" data-size="14" data-loop="true"></i> Vide&oacute;grafo</label>
                                        <input class="form-control autofotografos" type="text" value="<?php echo $ticket['fotografo2']; ?>" readonly/>
                                     </div>

    
                                     </div>








                                    <div class="row"><br>


                                  <div class="form-group col-md-4">
                                        <label><i class="livicon" data-name="home" data-size="14" data-loop="true"></i> Hotel</label>
                                        <input class="form-control autohoteles" type="text" value="<?php echo substr($ticket['hotel'], 3); ?>" readonly>
                                    </div>     
                                     

                                     <div class="form-group col-md-1">
                                        <label><i class="livicon" data-name="key" data-size="14" data-loop="true"></i> Room</label>
                                        <input class="form-control" type="text" value="<?php echo $ticket['room']; ?>" readonly/>
                                     </div>

                                     <div class="form-group col-md-3">
                                        <label>Tipo Entrega</label>
                                        <input class="form-control" type="text" value="<?php echo $ticket['tipo_entrega']; ?>" readonly />
                                     </div>

                                     <div class="form-group col-md-2">
                                     <label><i class="livicon" data-name="alarm" data-size="14" data-loop="true"></i> Hora Entrega:</label>
                                     <div class="input-group">

                                        <input type="text" class="form-control" id="datetime2" value="<?php echo $ticket['hora_entrega']; ?>" readonly />
                                     </div>
                                    <!-- /.input group -->
                                    </div>


                                     <div class="form-group col-md-2">
                                        <label><i class="livicon" data-name="calendar" data-size="14" data-loop="true"></i> Fecha Salida:</label>
                                        <div class="input-group">
                                       
                                            <input type="text" class="form-control" value="<?php echo date('d-m-Y',strtotime($ticket['fecha_salida_cliente'])); ?>" readonly />
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    </div>




                                <div class="row">

                                     <div style="background-color: #c7f0e1;" class="col-md-12">


                                  <div class="form-group col-md-8">
                                        <label><i class="livicon" data-name="info" data-size="14" data-loop="true"></i> Lugar Entrega en Hotel</label><br>
                                        <?php echo $hotel_entrega; ?>
                                    </div>     
                                     

                                     <div class="form-group col-md-2">
                                        <label><i class="livicon" data-name="hand-right" data-size="14" data-loop="true"></i> M&eacute;todo</label><br>
                                        <?php echo $hotel_tipoentrega; ?>
                                     </div>

                                     <div class="form-group col-md-2">
                                        <label><i class="livicon" data-name="location" data-size="14" data-loop="true"></i> Ruta</label><br>
                                        <?php echo $hotel_ruta; ?> <a target=_blank title='Ver en el Mapa' href='<?php echo $pixelis; ?>'><img src=img/map.png></a>
                                     </div>


                                    </div>
                                </div>




                                   <div class="row"><br>

                                     <div class="form-group col-md-6">
                                        <label><i class="livicon" data-name="image" data-size="14" data-loop="true"></i> Paquete o Producto</label>
                                        <input class="form-control autoproductos" type="text" value="<?php echo $ticket['producto']; ?>" readonly />
                                     </div>

                                     <div class="form-group col-md-2">
                                        <label><i class="livicon" data-name="money" data-size="14" data-loop="true"></i> Precio</label>
                                        <input class="form-control" type="text" value="<?php echo $ticket['tarifaa']; ?>" readonly />
                                     </div>

                                     <div class="form-group col-md-2">
                                        <label># Copias</label>
                                        <input class="form-control" type="text" value="<?php echo $ticket['nro_copias']; ?>" readonly />
                                     </div>

                                      <div class="form-group col-md-2">
                                        <label><i class="livicon" data-name="printer" data-size="14" data-loop="true"></i> Fotos Impre.</label>
                                        <input class="form-control" type="text" value="<?php echo $ticket['fotos_print']; ?>" readonly />
                                     </div>

                                    
    

                                     </div>



                                      <div class="row"><br>
                                        <div class="form-group col-md-3">
                                        <label>Tipo de Pago</label>
                                        <input class="form-control autopagos" type="text" value="<?php echo $ticket['tipopago']; ?>" readonly />
                                     </div>


                                    <div class="form-group col-md-2">
                                        <label><i class="livicon" data-name="piggybank" data-size="14" data-loop="true"></i> Dep&oacute;sito</label>
                                        <input class="form-control" type="text" value="<?php echo $ticket['deposito1']; ?>" readonly />
                                     </div>


                                    

                                     <div class="form-group col-md-2">
                                        <label>Descuento</label>
                                        <input class="form-control" type="text" value="<?php echo $ticket['descuento']; ?>" readonly/>
                                     </div>

                                     <div class="form-group col-md-2">
                                        <label><i class="livicon" data-name="spinner-one" data-size="14" data-loop="true"></i> Pendiente</label>
                                        <input class="form-control" style="background-color: #abd5f9;" type="text" value="<?php echo $ticket['pendiente']; ?>" readonly />
                                     </div>

                                      <div class="form-group col-md-3">
                                        <label>C&oacute;d. Transac. TDC / PP</label>
                                        <input class="form-control" type="text" value="<?php echo $ticket['cod_transac_visa']; ?>" readonly/>
                                     </div>

                                     



                                     </div>


                             
                                         <div class="row"><br>
                                    <div class="form-group col-md-12">
                                      <div class="form-group col-md-3">
                                        <label><i class="livicon" data-name="piggybank" data-size="14" data-loop="true"></i> Tipo de Pago 2</label>
                                        <input class="form-control autopagos" type="text"  value="<?php echo $ticket['tipopago2']; ?>" readonly/>
                                     </div>


                                     <div class="form-group col-md-2">
                                        <label><i class="livicon" data-name="money" data-size="14" data-loop="true"></i> Dep&oacute;sito 2</label>
                                        <input class="form-control" type="text" value="<?php echo $ticket['deposito2']; ?>" readonly/>
                                     </div>


                                     <div class="form-group col-md-2">
                                        <label><i class="livicon" data-name="money" data-size="14" data-loop="true"></i> Descuento 2</label>
                                        <input class="form-control" type="text" value="<?php echo $ticket['descuento2']; ?>" readonly />
                                     </div>


                                     <div class="form-group col-md-2">
                                        <label><i class="livicon" data-name="calendar" data-size="14" data-loop="true"></i> Fecha Pago 2:</label>
                                        <input class="form-control" type="text" value="<?php echo $fechap2; ?>" readonly />
                                        <!-- /.input group -->
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label><i class="livicon" data-name="credit-card" data-size="14" data-loop="true"></i> C&oacute;d. Transac. TDC / PP 2</label>
                                        <input class="form-control" type="text" value="<?php echo $ticket['cod_transac_visa2']; ?>" readonly />
                                     </div>
                                        


                                    </div>
                                    </div>
















<div class="row"><br>

<div class="form-group col-md-2">
                                        <label>Estatus del Ticket</label><br>
                                         <?php


 if ($ticket['estatus'] == 'Por Validar') {$status = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
  if ($ticket['estatus'] == 'Por Recibir') {$status = "<span class='label label-sm label-info label-mini'>Por Recibir</span>"; }
    if ($ticket['estatus'] == 'Abierto') {$status = "<span class='label label-sm label-primary label-mini'>Abierto</span>"; }
    if ($ticket['estatus'] == 'Pagado') {$status = "<span class='label label-sm label-success label-mini'>Pagado</span>"; }
    if ($ticket['estatus'] == 'Cancelado') {$status = "<span class='label label-sm label-danger label-mini'>Cancelado</span>"; }
    if ($ticket['estatus'] == 'Anulado') {$status = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }

                                      ?>


                                        
                                        <label><?php echo $status; ?></label>
                                    </div>


                                    <div class="form-group col-md-2">
                                        <label><i class="livicon" data-name="money" data-size="14" data-loop="true"></i> Total Pagado</label><br>
                                        
                                        <label>$ <?php echo $ticket['totalpagado']; ?></label>
                                      
                                    
                                        
                                    </div>


                                    <div class="form-group col-md-2">
                                        <label>Estatus del Producto</label><br>
                                        <?php
                                    
    if ($ticket['estatus_producto'] == 'Por Validar') {$statup = "<span class='label label-sm label-default label-mini'>Por Validar</span>"; }
    if ($ticket['estatus_producto'] == 'Edicion') {$statup = "<span class='label label-sm label-info label-mini'>Edici&oacute;n</span>"; }
    if ($ticket['estatus_producto'] == 'Solo Email') {$statup = "<span class='label label-sm label-info label-mini'>Solo Email</span>"; }
    if ($ticket['estatus_producto'] == 'Mensajeria') {$statup = "<span class='label label-sm label-info label-mini'>Mensajer&iacute;a</span>"; }
    if ($ticket['estatus_producto'] == 'Meeting Point') {$statup = "<span class='label label-sm label-warning label-mini'>Meeting Point</span>"; }
    if ($ticket['estatus_producto'] == 'Entregado') {$statup = "<span class='label label-sm label-success label-mini'>Entregado</span>"; }
    if ($ticket['estatus_producto'] == 'Devuelto') {$statup = "<span class='label label-sm label-danger label-mini'>Devuelto</span>"; }
    if ($ticket['estatus_producto'] == 'Anulado') {$statup = "<span class='label label-sm label-warning label-mini'>Anulado</span>"; }

                                    ?>

                                    <label><?php echo $statup; ?></label>
                                        
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label>Enviar por Email</label><br>

                      <?php
    $pemail = $ticket['por_email'];
    if ($pemail == 'NO') {$email = "<span class='label label-sm label-default label-mini'>NO</span>"; }
    if ($pemail == 'SI') {$email = "<span class='label label-sm label-success label-mini'>SI</span>"; }

   $envioe = $ticket['enviadoe'];
if ($envioe == 'SI') {$esi = "<span class='glyphicon glyphicon-ok'></span>"; }
else
{$esi = ""; }



?>

<label><?php echo $email." ".$esi; ?></label>
                                        
                                    </div>





</div>




                                    <div class="row"><br>


                                    <?php
                                   

                                   if ($ticket['fotot'] == "") {
                                       $fototic="sinfoto.jpg";
                                    }else
                                    {
                                        $fototic=$ticket['fotot'];
                                    }

                                    ?>
                                       <div class="form-group col-md-3">
                                        <label>Foto Ticket</label> 
                                       <?php if ($tipou == 1 || $tipou == 2 || $tipou == 4) {
                                          
                                            ?>
                                        <a class="btn btn-md btn-info" data-toggle="modal" data-href="#fototicket" href="#fototicket"><span class="glyphicon glyphicon-camera"></span></a>

                                        <?php 
                                        } 
                                        ?>


                                        <div>
                                            
                                            <a class="fancybox-effects-a" href="fototicket/<?php echo $fototic; ?>"><img src = fototicket/<?php echo $fototic; ?> width=100 height=100 ></a>
                                        
                                    </div>
                                     </div>
                                        


                   






                                     <?php
                                      if ($ticket['fotoc'] == "") {
                                       $fotocli="sinfoto.jpg";
                                    }else
                                    {
                                        $fotocli=htmlspecialchars_decode($ticket['fotoc'], ENT_NOQUOTES);

                                    }

                                    ?>

                                    <div class="form-group col-md-3">
                                        <label>Foto Cliente</label>
                                        <div>

                                        <a class="fancybox-effects-a" href="fotocliente/<?php echo $fotocli; ?>"><img src = fotocliente/<?php echo $fotocli; ?> width=100 height=100 ></a>
                                    </div>
                                     </div>


                          <div class="form-group col-md-2">
                                        <label><i class="livicon" data-name="calendar" data-size="14" data-loop="true"></i> Ultimo Contacto</label>
                                        <?php 

                                        if (is_null($ticket['contactado']))
{
echo '<br>Pendiente';
}
else
{

                                        echo "<br>Dia: ".date('d-m-Y', strtotime($ticket['contactado']))."<br>Hora: ".date('H:i:s', strtotime($ticket['contactado']))."<br>".$ticket['si_no'];


}

                                         ?>

                                     </div>

                           <?php  if ($tipou == 3)  {    ?>
                            <div class="form-group col-md-2">


                                      <div class="input-group-btn">
                                                     <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                <i class="livicon" data-name="phone" data-size="14" data-loop="true"></i>Contest&oacute;
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="registra_contacto.php?idt=<?php echo $id_t; ?>&r=SI">SI</a>
                                                    <a href="registra_contacto.php?idt=<?php echo $id_t; ?>&r=NO">NO</a>
                                                </li>
                                             </ul>
                                        </div>


                                </div>

                                <?php
                                
                                }
                                ?>



                           <?php
                           


                             if ($tipou == 3)  {  

                             

                             if (($tipoentrega == 'Solo Email' || $poremail == 'SI') && $estatus_ticket == 'Pagado' && $enviado <> 'SI') {
                                 
                             




                               ?>
                            <div class="form-group col-md-2">


                                      <div class="input-group-btn">
                                                     <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                <i class="livicon" data-name="mail" data-size="14" data-loop="true"></i>Enviado
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="cambia_estatus_atc.php?idt=<?php echo $id_t; ?>&r=SI&entrega=<?php echo $tipoentrega; ?>&ticket=<?php echo $nro_t; ?>">SI</a>
                                                    <a href="cambia_estatus_atc.php?idt=<?php echo $id_t; ?>&r=NO&entrega=<?php echo $tipoentrega; ?>&ticket=<?php echo $nro_t; ?>">NO</a>
                                                </li>
                                             </ul>
                                        </div>


                                </div>

                                <?php
                                }

                                }
                                ?>





                                    </div>




                                <?php
                                

                                if ($ticket['estatus'] == 'Cancelado' && $ticket['estatus_producto'] == 'Devuelto') {

                                    if ($ticket['emailcobranza']=='SI') {$emailc='SI';}else{$emailc='NO';}
                                    if ($ticket['fecha_emailcobranza'] =='') {$fechac='';}else{$fechac=date('d-m-Y', strtotime($ticket['fecha_emailcobranza']));}
                                    if ($ticket['usuario_emailcobranza']=='') {$usuarioc='';}else{$usuarioc=$ticket['usuario_emailcobranza'];}
                                                                    
                                ?>

                                    





                                    <div class="row"><br>
                                    <div style="text-align: center;" class="form-group col-md-6">
                                        
                                    </div>
                                    <div style="text-align: center;" class="form-group col-md-3">
                                        <a data-toggle='tooltip' title='Enviar Email de Cobranza' href="enviar_email_cobranza.php?idt=<?php echo $id_t; ?>"><img src="img/e-mail.png"></a>
                                    </div>
                                    <div style="background-color: #b9fcc9;" class="form-group col-md-3">
                                        Envio de Email: <?php echo $emailc; ?><br>
                                        Fecha de Email: <?php echo $fechac; ?><br>
                                        Email Por: <?php echo $usuarioc; ?><br>
                                    </div>
                                    </div>

                                    <?php
                                

                                }
                                ?>







                                    <div class="row"><br>
                                    <div class="form-group col-md-12">
                                        <label>Comentarios Etiqueta <span class="text-info">(P&uacute;blico para Cliente)</span></label>
                                        <textarea class="form-control resize_vertical" rows="3" readonly><?php echo $ticket['comentarios']; ?></textarea>
                                    </div>
                                    <div class="form-group col-md-12" style="text-align: right;">
                                       <i class="livicon" data-name="user" data-size="14" data-loop="true"></i> <b>Ticket Cargado Por:</b>&nbsp;<i><?php echo $ticket['cargadopor']; ?></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="livicon" data-name="user" data-size="14" data-loop="true"></i> <b>Ticket Actualizado Por:</b>&nbsp;<i><?php echo $ticket['actualizadopor']; ?></i>

                                       <?php
                                       if ($ticket['cerrado'] ==1) {

                                        $fechacierre = $ticket['fecha_cierre'];
                                        if ($fechacierre == '') {
                                            $cierre="";
                                        }else
                                        {

                                            $cierre=date('d-m-Y',strtotime($ticket['fecha_cierre']));


                                        }
                                         
                                         echo "&nbsp;&nbsp;<i class='livicon' data-name='calendar' data-size='14' data-loop='true'></i> <b>Ticket Cerrado:</b>&nbsp;<i> ".$cierre."</i>";
                                       }
                                       ?>
                                    </div>
                                    </div>
     
                                    <a href="javascript:window.history.back();" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Volver al Listado</a>
                             
                            </div>

                        </div>
                        </div> 

                        <?php


                        if ($tipou == 1 || $tipou == 2  || $tipou == 3 || $tipou == 4 || $tipou == 5 )

                        {

                        ?>

<div style="text-align: center;" class="row">




 </div>



<div class="row">
                                    <div style="text-align: center;" class="form-group col-md-4">

                                         <?php

                                        
                                

                                if ($ticket['cerrado'] == 1) {
                                  
                                ?>

                                        <a data-toggle='tooltip' title='Archivar Ticket' href="ticket_archivado.php?idt=<?php echo $id_t; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-briefcase"></span> Enviar Ticket al Archivo</a>

                          <?php                                    
                                }
                                ?>

                                    </div>
                                    <div style="text-align: center;" class="form-group col-md-4">
                                        <a class="btn btn-md btn-warning" data-toggle="modal" data-href="#stack1" href="#stack1"><span class="glyphicon glyphicon-share-alt"></span> Agregar Comentario de Seguimiento</a>
                                    </div>
                                    <div style="text-align: center;" class="form-group col-md-4">


                                         <?php

                                        
                                

                                if ($ticket['destacado'] == 'SI') {
                                  
                                ?>

                                    

                                           <a data-toggle='tooltip' title='Marcar Ticket Como Procesado' href="ticket_procesado.php?idt=<?php echo $id_t; ?>" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Marcar Como Procesado</a>
         

                                    <?php
                                

                                }
                                else
                                {

                                ?>




                                        <a data-toggle='tooltip' title='Marcar Ticket Como Destacado' href="ticket_destacado.php?idt=<?php echo $id_t; ?>" class="btn btn-primary"><span class="glyphicon glyphicon-star"></span> Marcar Como Destacado</a>



                                <?php                                    
                                }
                                ?>


 
                                    </div>
                                    </div>








 

 <div class="row">
    &nbsp;&nbsp;
 </div>



    <div class="row">
                    <div id="coment" class="col-md-12">
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet box warning">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="livicon" data-name="timer" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Comentarios de Seguimiento para este Ticket!   
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th><i class="livicon" data-name="calendar" data-size="14" data-loop="true"></i> Fecha</th>
                                                <th><i class="livicon" data-name="comments" data-size="14" data-loop="true"></i> Comentarios</th>
                                                <th><i class="livicon" data-name="user" data-size="14" data-loop="true"></i> Usuario</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                          
<?php
$sqlc = "SELECT * FROM crmticket where id_ticket='$id_ticket' ORDER BY id DESC";
$resultc = mysqli_query($con,$sqlc) or die(mysql_error());
while ($ticketc = $resultc->fetch_assoc()) {

    $fechat = new DateTime($ticketc['fecha']);


     $estap = $ticket['estatus_producto'];
    if ($estap == 'Enviado') {$statup = "<span class='label label-sm label-info label-mini'>Enviado</span>"; }
    if ($estap == 'Meeting Point') {$statup = "<span class='label label-sm label-warning label-mini'>Meeting Point</span>"; }
    if ($estap == 'Entregado') {$statup = "<span class='label label-sm label-success label-mini'>Entregado</span>"; }
    if ($estap == 'Devuelto') {$statup = "<span class='label label-sm label-danger label-mini'>Devuelto</span>"; }

                                            echo "<tr><td>".$fechat->format('d-m-Y H:i:s')."</td>";
                                            echo "<td>".$ticketc['incidencia']."</td>";
                                            echo "<td>".$ticketc['usuario']."</td></tr>";



                                            }


// El script automáticamente liberará el resultado y cerrará la conexión
// a MySQL cuando finalice, aunque aquí lo vamos a hacer nostros mismos
$result->free();
$con->close();
?>








                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END SAMPLE TABLE PORTLET-->
                    </div>
                </div>
<div class="modal fade bs-example-modal-sm in" id="fototicket" tabindex="-1" role="dialog" aria-hidden="false">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Agregar Foto Ticket: <?php echo $ticket['nro_ticket']; ?></h4>
                                </div>
                                <div class="modal-body">

                                    <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
                                         <input id="idticket" name="idticket" type="hidden" class="form-control" value="<?php echo $id_ticket; ?>">

                                  
                                    <div class="form-group label-floating">
                                        
                                       
                                        
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Foto Ticket:</label>
                                       
                                        <input type="file" name="file" id="file" class="btn btn-success" required />
                                    </div>
                                  
                                 
                                </div>
                            </form>
                            <div id="respuesta"></div>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="modal" id="cerrar" class="btn btn-default">Cerrar</button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

<!--- stack1 model -->
                    <div class="modal fade bs-example-modal-sm in" id="stack1" tabindex="-1" role="dialog" aria-hidden="false">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Agregar Comentario: <?php echo $ticket['nro_ticket']; ?></h4>
                                </div>
                                <div class="modal-body">
                                  <form role="form" name="insert">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Fecha y Hora: <?php echo date('d-m-Y H:i:s'); ?></label>
                                        <input id="fecha" name="fecha" type="hidden" class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>">
                                        <input id="idticket" name="idticket" type="hidden" class="form-control" value="<?php echo $id_ticket; ?>">
                                        <input id="usuario" name="usuario" type="hidden" class="form-control" value="<?php echo $_SESSION["nombre"]; ?>">
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Comentarios:</label>
                                       
                                        <textarea id="comentarios" name="comentarios"  class="form-control resize_vertical" rows="3"></textarea>
                                    </div>

                                    <div class="form-group label-floating">
                                        <label>Notificar A:</label><br>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="facturacion" name="facturacion" value="SI" >Facturaci&oacute;n&nbsp;&nbsp;&nbsp;</label>
                                        <label class=" checkbox-inline">
                                            <input type="checkbox" id="edicion" name="edicion" value="SI" >Edici&oacute;n&nbsp;&nbsp;&nbsp;</label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="mensajeria" name="mensajeria" value="SI" >Mensajer&iacute;a&nbsp;&nbsp;&nbsp;</label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="operaciones" name="operaciones" value="SI" >Operaciones&nbsp;&nbsp;&nbsp;</label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="atcliente" name="atcliente" value="SI" >Serv. al Cliente&nbsp;&nbsp;&nbsp;</label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="gerencia" name="gerencia" value="SI" >Gerencia&nbsp;&nbsp;&nbsp;</label>
                                    </div>
                                  
                                    <input type="button" id="insert" value="Agregar Comentarios" class="btn btn-success" />
                                </div>
                            </form>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>




  <?php




}

                        ?>


                        </div>
                    </div>
                    <!--md-6 ends-->
                    </div>
                
                <!--main content ends--> </section>
            <!-- content --> </aside>
        <!-- right-side --> </div>
    <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Subir" data-toggle="tooltip" data-placement="left">
        <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
    </a>
    <!-- global js -->
    <script src="js/app.js" type="text/javascript"></script>
    <!-- end of global js -->
    <!-- begining of page level js -->
    <script src="vendors/favicon/favicon.js"></script>
    <script src="vendors/jasny-bootstrap/js/jasny-bootstrap.js"></script>
    <script src="vendors/iCheck/js/icheck.js"></script>
    <script src="js/pages/form_examples.js"></script>
    <script type="text/javascript" src="js/pages/radio_checkbox.js"></script>
    <script src="vendors/moment/js/moment.min.js" type="text/javascript"></script>
    <script src="vendors/daterangepicker/js/daterangepicker.js" type="text/javascript"></script>
    <script src="vendors/datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="vendors/clockface/js/clockface.js" type="text/javascript"></script>
    <script src="vendors/jasny-bootstrap/js/jasny-bootstrap.js" type="text/javascript"></script>
    <script src="js/pages/datepicker.js" type="text/javascript"></script>
    <script type="text/javascript" src="vendors/sweetalert/js/sweetalert.min.js"></script>
    <script type="text/javascript" src="vendors/sweetalert/js/sweetalert-dev.js"></script>

 <script type="text/javascript" src="vendors/fancybox/jquery.fancybox.pack.js"></script>
    <script type="text/javascript" src="vendors/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script type="text/javascript" src="vendors/fancybox/helpers/jquery.fancybox-thumbs.js"></script>
    <!-- Add Media helper (this is optional) -->
    <script type="text/javascript" src="vendors/fancybox/helpers/jquery.fancybox-media.js"></script>
    <!-- end of page level js -->
<script type="text/javascript" src="js/pages/gallery.js"></script>


 <script type="text/javascript">
    $(document).ready(function() {
        $("#insert").click(function() {
            var ticket = $("#idticket").val();
            var fecha = $("#fecha").val();        
            var facturacion = $('input:checkbox[name=facturacion]:checked').val();
            if( facturacion == 'SI' ){
                  var facturaciony = 'SI';
              } else {
             var facturaciony = '';
              }

            var edicion = $('input:checkbox[name=edicion]:checked').val();
            if( edicion == 'SI' ){
                  var ediciony = 'SI';
              } else {
             var ediciony = '';
              }

            var mensajeria = $('input:checkbox[name=mensajeria]:checked').val();
            if( mensajeria == 'SI' ){
                  var mensajeriay = 'SI';
              } else {
             var mensajeriay = '';
              }

            var operaciones = $('input:checkbox[name=operaciones]:checked').val();
            if( operaciones == 'SI' ){
                  var operacionesy = 'SI';
              } else {
             var operacionesy = '';
              }

            var atcliente = $('input:checkbox[name=atcliente]:checked').val();
            if( atcliente == 'SI' ){
                  var atclientey = 'SI';
              } else {
             var atclientey = '';
              }

            var gerencia = $('input:checkbox[name=gerencia]:checked').val();
            if( gerencia == 'SI' ){
                  var gerenciay = 'SI';
              } else {
             var gerenciay = '';
              }

            var comentarios = $("#comentarios").val();
            var usuario = $("#usuario").val();
            var dataString = "idticket=" + ticket + "&fecha=" + fecha + "&comentarios=" + comentarios + "&fact=" + facturaciony + "&edic=" + ediciony + "&mens=" + mensajeriay + "&oper=" + operacionesy + "&atcl=" + atclientey + "&gere=" + gerenciay + "&usuario=" + usuario + "&insert=";
            if ($.trim(ticket).length > 0 & $.trim(fecha).length > 0 & $.trim(comentarios).length > 0 & $.trim(usuario).length > 0) {
                $.ajax({
                    type: "POST",
                    url: "insertcomentarios.php",
                    data: dataString,
                    crossDomain: true,
                    cache: false,
                    beforeSend: function() {
                        $("#insert").val('Conectando...');
                    },
                    success: function(data) {
                        if (data == "success") {
                            alert("Comentarios Guardados Exitosamente!");
                            $("#insert").val('Guardar Comentarios');
                            $("#comentarios").val('');
                            $('input:checkbox[name=facturacion]').attr('checked',false);
                            $('input:checkbox[name=edicion]').attr('checked',false);
                            $('input:checkbox[name=mensajeria]').attr('checked',false);
                            $('input:checkbox[name=operaciones]').attr('checked',false);
                            $('input:checkbox[name=atcliente]').attr('checked',false);
                            $('input:checkbox[name=gerencia]').attr('checked',false);
                            $("#coment").load(" #coment");


                        } else if (data == "error") {
                            $("#insert").val('Guardar Comentarios');
                            alert("Error al procesar Comentarios");
                        }
                    }
                });
            }
            else
                {
            alert("Debe Agregar un Comentario");
             }

        
            return false;
        });
    });
    </script>

<script>
     $(function(){
        $("input[name='file']").on("change", function(){
            var formData = new FormData($("#uploadimage")[0]);
            var ruta = "imagen-ticket.php";
            $.ajax({
                url: ruta,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(datos)
                {
                    $("#respuesta").html(datos);

                     $('#cerrar').on('click',function(){

           window.location.reload();

    });


                }
            });
        });
     });



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

</body>
</html>