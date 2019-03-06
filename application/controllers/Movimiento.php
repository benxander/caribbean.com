<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Movimiento extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->helper(array('fechas','otros'));
        $this->load->model(
			array(
				'model_movimiento',
				'model_cliente',
				'model_email',
				'model_puntuacion'
			)
		);
        $this->load->library('Fpdfext');
        $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
        $this->sessionCI = @$this->session->userdata('sess_ci_'.substr(base_url(),-14,9));
    }

    public function listar_pedidos(){
    	$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];
		$paramDatos = $allInputs['datos'];
		// var_dump($paramDatos); exit();
		$lista = $this->model_movimiento->m_cargar_pedidos($paramPaginate, $paramDatos);
		$totalRows = $this->model_movimiento->m_count_pedidos($paramPaginate, $paramDatos);
		$arrListado = array();

		foreach ($lista as $row) {
			if($row['genero']){
				$adicional = $row['genero'] == 'H'? ' - HOMBRE' : ' - MUJER';
			}else{
				$adicional = '';
			}
			array_push($arrListado,
				array(
					'idcliente' => $row['idcliente'],
					'nombres' 	=> $row['nombres'],
					'codigo' 	=> $row['codigo'],
					'apellidos'	=> $row['apellidos'],
					'email' 	=> $row['email'],
					'hotel' 	=> $row['hotel'],
					'habitacion'=> $row['habitacion'],
					// 'telefono' 	=> $row['telefono'],
					// 'monedero' 	=> (int)$row['monedero'],
					'ididioma' 	=> $row['ididioma'],
					'excursion'=> $row['excursion'],
					'fecha_excursion' 	=> darFormatoDMY($row['fecha_excursion']),
					'fecha_salida' 		=> darFormatoDMY($row['fecha_salida']),

					'idmovimiento' 	=> $row['idmovimiento'],
					'iddetalle' 	=> $row['iddetalle'],
					'fecha_movimiento' 	=> darFormatoDMYHora($row['fecha_movimiento']),
					'fecha_pedido' 	=> darFormatoDMY($row['fecha_movimiento']),
					'hora_pedido' 	=> darFormatoHora2($row['fecha_movimiento']),
					'producto' 			=> $row['descripcion_pm'] . $adicional,
					'imagen_producto' 	=> $row['imagen_producto'],
					'categoria' 		=> $row['categoria'],
					'cantidad' 			=> $row['cantidad'],
					'total_detalle' 	=> $row['total_detalle'],
					'idcolor' 	=> $row['idcolor'],
					'color' 	=> $row['color'],
					'size' 	=> $row['size'],

				)
			);
		}
		$arrData['datos'] = $arrListado;
    	$arrData['paginate']['totalRows'] = $totalRows['contador'];
    	$arrData['message'] = '';
    	$arrData['flag'] = 1;
		if(empty($lista)){
			$arrData['flag'] = 0;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
    }
    public function listar_imagenes_pedido(){
    	$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_movimiento->m_cargar_imagenes_pedidos($allInputs);
		$arrListado = array();

		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'idarchivo' => $row['idarchivo'],
					'nombre_archivo' 	=> $row['nombre_archivo'],
					'src' => 'clientes/'.$allInputs['codigo'].'/descargadas/'.$row['nombre_archivo'],

				)
			);
		}
		// var_dump($arrListado); exit();
		$arrData['datos'] = $arrListado;
    	$arrData['message'] = '';
    	$arrData['flag'] = 1;
		if(empty($lista)){
			$arrData['flag'] = 0;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
    }
	public function registrar_pedido(){
		ini_set('xdebug.var_display_max_depth', 8);
	    ini_set('xdebug.var_display_max_children', 256);
	    ini_set('xdebug.var_display_max_data', 1024);
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

    	$cliente = $this->model_cliente->m_cargar_cliente_por_sesion();
    	$allInputs['idcliente'] = $cliente['idcliente'];
    	$monedero = $this->model_cliente->m_monedero_cliente_cbo($allInputs);
    	if($monedero != $allInputs['saldo_inicial']){
    		$arrData['message'] = 'El saldo no coincide';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}

    	$allInputs['monedero'] = $allInputs['saldo_final'];

    	if($allInputs['detalle'][0]['tipo_seleccion'] == 2){
	    	$idactividadcliente = $allInputs['detalle'][0]['imagenes'][0]['idactividadcliente'];
    	}else{
	    	$idactividadcliente = $allInputs['detalle'][0]['imagenes']['idactividadcliente'];
    	}
    	$datos = array(
    		'idcliente' => $cliente['idcliente'],
    		'idactividadcliente' => $idactividadcliente,
    		'tipo_movimiento' => 2, // pedido
    		'fecha_movimiento' => date('Y-m-d H:i:s'),
    		'total' => $allInputs['total_pedido'],
    		'estado'=> 1
    	);
    	// var_dump($allInputs); exit();
    	$this->db->trans_start();
    	$idmovimiento = $this->model_movimiento->m_registrar_movimiento($datos);
		if( $idmovimiento ){
			foreach ($allInputs['detalle'] as $row) {
				$data = array(
					'idmovimiento' => $idmovimiento,
					// 'idpaquete' => NULL,
					'idproducto' => $row['idproducto'],
					// 'tipo_adicional' => NULL,
					'cantidad' => $row['cantidad'],
					'precio' => $row['precio'],
					'total_detalle' => $row['total_detalle'],
					'idcolor' => $row['idcolor'],
					'genero' => $row['genero'],
					'tipo_detalle' => 2, // 1: compra online; 2: merchandising (pedido)
					'estado_det' => 1, // pendiente
				);
				$iddetalle = $this->model_movimiento->m_registrar_detalle($data);
				if( $row['tipo_seleccion'] == 1 ){
					$data = array(
						'iddetalle' => $iddetalle,
						'idarchivo' => $row['imagenes']['idarchivo']
					);
					$this->model_movimiento->m_registrar_detalle_archivo($data);
				}else{
					foreach ($row['imagenes'] as $row_imagen) {
						$data = array(
							'iddetalle' => $iddetalle,
							'idarchivo' => $row_imagen['idarchivo']
						);
						$this->model_movimiento->m_registrar_detalle_archivo($data);
					}
				}
			}

			$arrData['message'] = 'The data was recorded correctly ';
    		$arrData['flag'] = 1;
		}
		if($this->model_cliente->m_actualizar_monedero($allInputs)){

		}
		$this->db->trans_complete();

		/*envio de correo*/
			$cliente['idtipoemail'] = 6; // confirmacion
			$lista = $this->model_email->m_cargar_email($cliente);
			if(empty($lista)){
				$arrData['message2'] = 'Email no configurado para el idioma seleccionado';
				$arrData['flag2'] = 0;
			}else{
		    	$mensaje = $lista[0]['contenido'];
		    	$mensaje .= '<table>';
		    	$mensaje .= '<tr><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Total</th>';
		    	foreach ($allInputs['detalle'] as $row) {
		    		$mensaje .= '<tr>';
		    		$mensaje .= '<td>'.$row['producto'].' - '.$row['categoria'].' - '.$row['talla'].' - '.$row['color'].'</td>';
		    		$mensaje .= '<td>'.$row['cantidad'].'</td>';
		    		$mensaje .= '<td>'.$row['precio'].'</td>';
		    		$mensaje .= '<td>'.$row['total_detalle'].'</td>';
		    	}
		    	$mensaje .= '</table>';
		    	$mensaje .= 'TOTAL A PAGAR: US$' . $allInputs['total_pedido'];

				$mensaje .= '<br /> Atte: <br /> '.DESCRIPCION.' </div></div>';
				$from = CORREO;
				$to = $cliente['email'];
				$cc = CORREO;
				$asunto = $lista[0]['asunto'];
				// if(false){
				if(envio_email($to, $cc,$asunto, $mensaje, $from)){
					$arrData['message2'] = 'Notificación de correo enviada exitosamente.';
					$arrData['flag2'] = 1;
				}else{
					$arrData['message2'] = 'Error en envio de correo';
					$arrData['flag2'] = 0;
				}
			}

    	// var_dump($allInputs); exit();
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function registrar_venta(){
		ini_set('xdebug.var_display_max_depth', 8);
	    ini_set('xdebug.var_display_max_children', 256);
	    ini_set('xdebug.var_display_max_data', 1024);
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	$cliente = $this->model_cliente->m_cargar_cliente_por_sesion();
    	$monedero = $this->model_cliente->m_monedero_cliente_cbo($allInputs);
    	if($monedero != $allInputs['saldo']){
    		$arrData['message'] = 'El saldo no coincide';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}
    	$datos_venta = array(
    		'idcliente' => $allInputs['idcliente'],
    		'idexcursion' => $allInputs['idexcursion'],
    		'tipo_movimiento' => 1, // pedido
    		'fecha_movimiento' => date('Y-m-d H:i:s'),
    		'total' => $allInputs['detalle'][0]['total_detalle'],
    		'tipo_pack'=> $allInputs['tipo_pack'],
    		'estado'=> ($allInputs['porConfirmar'])? 2 : 1,
    	);
    	// var_dump($allInputs['detalle']); exit();
    	$this->db->trans_start();
    	$idmovimiento = $this->model_movimiento->m_registrar_movimiento($datos_venta);
		if( $idmovimiento ){
			foreach ($allInputs['detalle'] as $row) {
				$data = array(
					'idmovimiento' => $idmovimiento,
					'idpaquete' => NULL,
					'idproducto' => NULL,
					// 'tipo_adicional' => NULL,
					'cantidad' => $row['cantidad'],
					'precio' => $row['precio'],
					'total_detalle' => $row['total_detalle'],

					'tipo_detalle' => 1, // 1$row['genero']: compra online; 2: merchandising (pedido)
					'estado_det' => 1, // pendiente
				);
				$iddetalle = $this->model_movimiento->m_registrar_detalle($data);
				if(!empty($row['imagenes'])){
					if( $row['tipo_seleccion'] == 1 ){
						$data = array(
							'iddetalle' => $iddetalle,
							'idarchivo' => $row['imagenes']['idarchivo']
						);
						$this->model_movimiento->m_registrar_detalle_archivo($data);
					}else{
						foreach ($row['imagenes'] as $row_imagen) {
							$data = array(
								'iddetalle' => $iddetalle,
								'idarchivo' => $row_imagen['idarchivo']
							);
							$this->model_movimiento->m_registrar_detalle_archivo($data);
						}
					}
				}

			}

			$arrData['message'] = 'The data was recorded correctly ';
    		$arrData['flag'] = 1;
		}
		if($allInputs['porConfirmar']){
			/*genera token*/
			$arrData['token'] = hash('md5',$cliente['codigo']);
			$_SESSION['sess_cp_'.substr(base_url(),-14,9) ]['token'] = $arrData['token'];
		}else{
			$this->model_cliente->m_actualizar_monedero($allInputs);
		}
		$this->db->trans_complete();
		$arrData['idmovimiento'] = $idmovimiento;
    	// var_dump($allInputs); exit();
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function email_prueba(){
		$from = CORREO;
		$to = 'rguevara@villasalud.pe';
		$cc = CORREO;
		$asunto = 'Prueba';
		$mensaje = 'Mensaje Prueba';
		if(envio_email($to, $cc,$asunto, $mensaje, $from)){
			echo 'Notificación de correo enviada exitosamente.';
		}else{
			// echo 'Error en envio de correo';
			echo 'Mailer Error: ' . $this->email->print_debugger();
		}
	}
	/* IMPRIMIR */
	public function imprimir_pedido(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData = array();
		$arrData['message'] = '';
    	$arrData['flag'] = 1;
    	// DATOS
    	$pedido = $this->model_movimiento->m_cargar_pedido($allInputs);
    	$imagenes = $this->model_movimiento->m_cargar_imagenes_pedidos($allInputs);
    	if($pedido['genero']){
			$adicional = $pedido['genero'] == 'H'? ' - HOMBRE' : ' - MUJER';
		}else{
			$adicional = '';
		}
    	// var_dump($allInputs); exit();
    	// CREACION PDF
    	$this->pdf = new Fpdfext();
    	$this->pdf->AddPage('P','A4');
		$this->pdf->SetFont('Arial','B',16);

		$this->pdf->Cell(0,11,'',0,15);
		$this->pdf->Cell(0,7,utf8_decode('Pedido Nº ' . $pedido['iddetalle']),0,7,'C');
		$this->pdf->Ln(4);


		/* SECCION */
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->SetTextColor(255,255,255);
		$this->pdf->SetFillColor(38,147,193);
		$this->pdf->SetDrawColor(38,147,193);
		$this->pdf->Cell(40,6,'   ' . utf8_decode('Datos Cliente'),0,7,'L',TRUE);
		$this->pdf->SetLineWidth(.1);
		$x=$this->pdf->GetX();
    	$y=$this->pdf->GetY();
		$this->pdf->Line($x, $y, $x+190, $y);

		$this->pdf->Ln();
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(40,6,utf8_decode('Código: '));
		$this->pdf->SetTextColor(043,043,054);
		$this->pdf->SetFont('Arial','',11);
		$this->pdf->Cell(65,6,utf8_decode($pedido['codigo']));
		$this->pdf->Ln();
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Cell(40,6,utf8_decode('Nombre y Apellidos: '));
		$this->pdf->SetTextColor(043,043,054);
		$this->pdf->SetFont('Arial','',11);
		$this->pdf->Cell(65,6,utf8_decode(ucwords(strtolower_total($pedido['nombres'])) . ' ' .ucwords(strtolower_total($pedido['apellidos']))));
		$this->pdf->Ln();
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Cell(40,6,utf8_decode('Hotel: '));
		$this->pdf->SetTextColor(043,043,054);
		$this->pdf->SetFont('Arial','',11);
		$this->pdf->Cell(65,6,utf8_decode(ucwords(strtolower_total($pedido['hotel']))));
		$this->pdf->Ln();
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Cell(40,6,utf8_decode('Habitación: '));
		$this->pdf->SetTextColor(043,043,054);
		$this->pdf->SetFont('Arial','',11);
		$this->pdf->Cell(65,6,utf8_decode(ucwords(strtolower_total($pedido['habitacion']))));
		$this->pdf->Ln();
		// IZQUIERDA
		$ancho = $this->pdf->GetPageWidth();
		$medio = ($ancho / 2)+10;

		$this->pdf->SetXY($medio,$y+6);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Cell(40,6,utf8_decode('Excursion: '));
		$this->pdf->SetTextColor(043,043,054);
		$this->pdf->SetFont('Arial','',11);
		$this->pdf->Cell(65,6,utf8_decode(ucwords(strtolower_total($pedido['excursion']))));
        $y=$this->pdf->GetY();
		$this->pdf->SetXY($medio,$y+6);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Cell(40,6,utf8_decode('Fecha excursión: '));
		$this->pdf->SetTextColor(043,043,054);
		$this->pdf->SetFont('Arial','',11);
		$this->pdf->Cell(65,6,darFormatoDMY($pedido['fecha_excursion']));
		$y=$this->pdf->GetY();
		$this->pdf->SetXY($medio,$y+6);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Cell(40,6,utf8_decode('Fecha salida: '));
		$this->pdf->SetTextColor(043,043,054);
		$this->pdf->SetFont('Arial','',11);
		$this->pdf->Cell(65,6,darFormatoDMY($pedido['fecha_salida']));

		$this->pdf->Ln(18);
		/* SECCION */
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->SetTextColor(255,255,255);
		$this->pdf->SetFillColor(38,147,193);
		$this->pdf->Cell(40,6,'   ' . utf8_decode('Datos del Pedido'),0,7,'L',TRUE);
		$x=$this->pdf->GetX();
    	$y=$this->pdf->GetY();
		$this->pdf->Line($x, $y, $x+190, $y);

		$this->pdf->Ln();
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(40,6,utf8_decode('Producto: '));
		$this->pdf->SetFont('Arial','',11);
		$this->pdf->SetTextColor(043,043,054);
		$this->pdf->Cell(65,6,utf8_decode(ucwords(strtolower_total($pedido['descripcion_pm'] . $adicional))));
		$this->pdf->Ln();
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(40,6,utf8_decode('Categoria: '));
		$this->pdf->SetFont('Arial','',11);
		$this->pdf->SetTextColor(043,043,054);
		$this->pdf->Cell(65,6,utf8_decode(ucwords(strtolower_total($pedido['categoria']))));
		$this->pdf->Ln();
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(40,6,utf8_decode('Tamaño: '));
		$this->pdf->SetFont('Arial','',11);
		$this->pdf->SetTextColor(043,043,054);
		$this->pdf->Cell(65,6,utf8_decode($pedido['size']));
		$this->pdf->Ln();
		if(!empty($pedido['color'])){
			$this->pdf->SetFont('Arial','B',11);
			$this->pdf->SetTextColor(0,0,0);
			$this->pdf->Cell(40,6,utf8_decode('Color: '));
			$this->pdf->SetFont('Arial','',11);
			$this->pdf->SetTextColor(043,043,054);
			$this->pdf->Cell(65,6,utf8_decode(ucwords(strtolower_total($pedido['color']))));
			$this->pdf->Ln();
		}

		$this->pdf->Ln();
		$this->pdf->Ln();
		// IZQUIERDA
		// $y=$this->pdf->GetY();
		$this->pdf->SetXY($medio,$y+6);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Cell(40,6,utf8_decode('Fecha de Pedido: '));
		$this->pdf->SetTextColor(043,043,054);
		$this->pdf->SetFont('Arial','',11);
		$this->pdf->Cell(65,6,darFormatoDMY($pedido['fecha_movimiento']));
		$y=$this->pdf->GetY();
		$this->pdf->SetXY($medio,$y+6);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Cell(40,6,utf8_decode('Hora de Pedido: '));
		$this->pdf->SetTextColor(043,043,054);
		$this->pdf->SetFont('Arial','',11);
		$this->pdf->Cell(65,6,darFormatoHora2($pedido['fecha_movimiento']));
		$y=$this->pdf->GetY();
		$this->pdf->SetXY($medio,$y+6);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Cell(40,6,utf8_decode('Cantidad: '));
		$this->pdf->SetTextColor(043,043,054);
		$this->pdf->SetFont('Arial','',11);
		$this->pdf->Cell(65,6,$pedido['cantidad']);
		$y=$this->pdf->GetY();
		$this->pdf->SetXY($medio,$y+6);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Cell(40,6,utf8_decode('Total: '));
		$this->pdf->SetTextColor(043,043,054);
		$this->pdf->SetFont('Arial','',11);
		$this->pdf->Cell(65,6,'US$ ' . $pedido['total_detalle']);

		/* SECCION */
		$this->pdf->Ln(18);
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->SetTextColor(255,255,255);
		$this->pdf->SetFillColor(38,147,193);
		$this->pdf->Cell(40,6,'   ' . utf8_decode('Fotografías'),0,7,'L',TRUE);
		$x=$this->pdf->GetX();
    	$y=$this->pdf->GetY();
		$this->pdf->Line($x, $y, $x+190, $y);
		$this->pdf->SetFont('Arial','',11);
		$this->pdf->SetTextColor(043,043,054);
		foreach ($imagenes as $row) {
			$url = base_url().'uploads/clientes/'.$pedido['codigo'].'/descargadas/'.$row['nombre_archivo'];
			$this->pdf->Ln();
			$this->pdf->Cell(0,8 ,$url,'','','',false, $url);
			// $this->pdf->Link(100,10,10,10, $url);
			// $this->pdf->Cell(0,6,$url);

		}

		$timestamp = date('YmdHis');
		$result = $this->pdf->Output( 'F','admin/assets/images/dinamic/pdfTemporales/tempPDF_'. $timestamp .'.pdf' );

		$arrData['urlTempPDF'] = 'assets/images/dinamic/pdfTemporales/tempPDF_'. $timestamp .'.pdf';
	    // $arrData = array(
	    //   'urlTempPDF'=> 'assets/images/dinamic/pdfTemporales/tempPDF_'. $timestamp .'.pdf'
	    // );

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	/*PUNTUACION*/
	/**
	 * Carga la lista de puntajes para la vista de ENCUESTA
	 *
	 * @return [type] [description]
	 */
	public function listar_puntuacion(){
		if( empty($this->sessionCI) ){
			$arrData['flag'] = -1;
			$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
		}
		$lista = $this->model_movimiento->m_cargar_puntuacion();
		$arrListado = array();
		$total = 0;
		$peso = 0;
		for ($i=5; $i >=1 ; $i--) {
			array_push($arrListado, array(
				'puntos'=> $i,
				'puntaje'=> 0,
				)
			);
		}
		foreach ($lista as $row) {
			$total += $row['puntaje'];
			$peso += $row['puntos'] * $row['puntaje'];
		}
		foreach ($arrListado as $key => $value) {
			foreach ($lista as $row) {
				if( $value['puntos'] == $row['puntos'] ){
					$arrListado[$key]['puntaje'] = $row['puntaje'];
				}
			}
		}
		foreach ($arrListado as $key => $row) {
			$arrListado[$key]['porcentaje'] = round(($row['puntaje'] / $total)*100);
		}
		$promedio = $peso / $total;
		$porcentaje = round($promedio*20);
		$promedio = round(($peso / $total),1);

		$arrData['datos'] = $arrListado;
    	$arrData['total'] = $total;
    	$arrData['promedio'] = $promedio;
    	$arrData['porcentaje'] = $porcentaje;
    	$arrData['message'] = '';
    	$arrData['flag'] = 1;
		if(empty($lista)){
			$arrData['flag'] = 0;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));

	}

	public function listar_comentarios()
	{
		$lista = $this->model_movimiento->m_cargar_comentarios();
		if(empty($lista)){
			$arrData['flag'] = 0;
			$arrData['message'] = 'No hay comentarios.';
			$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
		}

		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'codigo'	=> $row['codigo'],
					'idcliente'	=> $row['idcliente'],
					'fecha'		=> darFormatoDMY($row['fecha_registro']),
					'comentarios' => $row['comentarios']
				)
			);
		}
		$arrData['datos'] = $arrListado;
    	$arrData['message'] = '';
    	$arrData['flag'] = 1;
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function listar_detalle_puntuacion()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);

		$paramPaginate = $allInputs['paginate'];
		$paramDatos = $allInputs['datos'];
		$lista = $this->model_puntuacion->m_cargar_detalle_puntuacion($paramPaginate, $paramDatos);
		if(!empty($lista)){
			$totalRows = $this->model_puntuacion->m_count_detalle_puntuacion($paramPaginate, $paramDatos);
		}
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'idpuntuacion' => $row['idpuntuacion'],
					'codigo' => $row['codigo'],
					'fecha_registro' => darFormatoDMYHora($row['fecha_registro']),
				)
			);
		}

		$arrData['datos'] = $arrListado;
    	$arrData['paginate']['totalRows'] = $totalRows['contador'];
    	$arrData['message'] = '';
    	$arrData['flag'] = 1;
		if(empty($lista)){
			$arrData['flag'] = 0;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
}