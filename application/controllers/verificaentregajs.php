<?php
 include "db.php";

$tickehoy = date('Y-m-d', strtotime('-1 day')) ;

$time = time();
$horaya = date("g:i A", $time);


    $sql2="SELECT nro_ticket, hora_entrega FROM ticketsdb WHERE tipo_entrega='Personal' and fecha='$tickehoy' AND hora_entrega < '$horaya' AND estatus_producto = 'Mensajeria'";
    $result=mysqli_query($con, $sql2);
  //  $count=mysqli_num_rows($result);

while ($row=mysqli_fetch_object($result)){
 $data[]=$row;
}

echo json_encode($data);
 
?>