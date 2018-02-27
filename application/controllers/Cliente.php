<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cliente extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->helper(array('fechas','imagen','otros'));
        $this->load->model(array('model_cliente','model_usuario','model_archivo','model_puntuacion','model_email'));
        $this->load->library('excel');
    }
    public function listar_clientes(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];
		$paramDatos = $allInputs['datos'];
		// var_dump($allInputs); exit();
		$lista = $this->model_cliente->m_cargar_cliente($paramPaginate,$paramDatos);
		$totalRows = $this->model_cliente->m_count_cliente($paramPaginate,$paramDatos);
		$arrListado = array();
		//var_dump($lista); exit();
		foreach ($lista as $row) {
			$objEstado = array();
			if( $row['descargados'] == $row['archivo'] && $row['archivo'] != 0 ){
				$estado = 'COMPLETO';
				$clase = 'label-success';
			}elseif( $row['descargados'] < $row['archivo'] ){
				$estado = 'PARCIAL';
				$clase = 'label-warning';
			}else{
				$estado = 'NO PROCESADO';
				$clase = 'label-default';
			}
			array_push($arrListado,
				array(
					'idcliente' => $row['idcliente'],
					// 'idusuario' => $row['idusuario'],
					// 'nombres' 	=> $row['nombres'],
					// 'apellidos'	=> $row['apellidos'],
					// 'email' 	=> $row['email'],
					// 'whatsapp' 	=> $row['whatsapp'],
					// 'hotel' 	=> $row['hotel'],
					// 'habitacion'=> $row['habitacion'],
					// 'telefono' 	=> $row['telefono'],
					'monedero' 	=> (int)$row['monedero'],
					'estado_cl'	=> $row['estado_cl'],
					'codigo' 	=> $row['codigo'],
					// 'ididioma' 	=> $row['ididioma'],
					'idactividadcliente' 	=> $row['idactividadcliente'],
					'idactividad' 	=> $row['idactividad'],
					'excursion' 	=> $row['titulo_act'],
					'fecha_excursion' 	=> darFormatoDMY($row['fecha_excursion']),
					// 'fecha_salida' 	=> darFormatoDMY($row['fecha_salida']),
					'archivo'	=> ($row['archivo'] > 0) ? TRUE:FALSE,
					'monto'=>	$row['monto'],
					'estado_obj' => array(
						'string' => $estado,
						'clase' =>$clase
					),
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
	public function listar_cliente_por_idusuario(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$row = $this->model_cliente->m_cargar_cliente_por_idusuario($allInputs['idusuario']);
		//var_dump($lista); exit();
		$arrListado =	array(
			'idcliente' => $row['idcliente'],
			'idusuario' => $row['idusuario'],
			'username' => $row['username'],
			'nombres' => $row['nombres'],
			'apellidos' => $row['apellidos'],
			'cliente' => strtoupper_total($row['nombres'] . ' ' .$row['apellidos']),
			'email' => $row['email'],
			'whatsapp' => $row['whatsapp'],
			'hotel' 	=> $row['hotel'],
			'habitacion'=> $row['habitacion'],
			'telefono' 	=> $row['telefono'],
			'estado_cl' => $row['estado_cl'],
			'ididioma' => $row['ididioma'],
			'idioma' => $row['idioma'],

			'solicita_bonificacion' => $row['solicita_bonificacion'],
			'nombre_foto' => empty($row['nombre_foto']) ? 'sin-imagen.png' : $row['nombre_foto'],
		);

    	$arrData['datos'] = $arrListado;
    	$arrData['flag'] = 1;
		if(empty($row['idcliente'])){
			$arrData['flag'] = 0;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function reg_cliente(){
		$allInputs['nombres'] = $this->input->post_get('nombres');
		$allInputs['apellidos'] = $this->input->post_get('apellidos');
		$allInputs['email'] = $this->input->post_get('email');
		$allInputs['codigo'] = $this->input->post_get('codigo');
		$allInputs['telefono'] = $this->input->post_get('telefono');
		$allInputs['actividades'][] = $this->input->post_get('idexcursion');
		$allInputs['hotel'] = $this->input->post_get('hotel');
		$allInputs['habitacion'] = $this->input->post_get('habitacion');
		$allInputs['ididioma'] = $this->input->post_get('ididioma');
		$allInputs['fecha_excursion'] = $this->input->post_get('fecha_excursion');
		$allInputs['fecha_salida'] = $this->input->post_get('fecha_salida');
		$allInputs['monedero'] = $this->input->post_get('deposito');
		// var_dump($allInputs); exit();
		$arrData['message'] = 'Error al registrar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// var_dump($allInputs); exit();
    	if(empty($allInputs['email'])){
    		$arrData['message'] = 'Debe seleccionar un email.';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}
    	if(empty($allInputs['ididioma'])){
    		$arrData['message'] = 'Debe seleccionar un idioma.';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}
    	if(empty($allInputs['actividades'])){
    		$arrData['message'] = 'Debe seleccionar una excursión.';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}
    	if($this->model_cliente->m_cargar_cliente_por_email($allInputs)){
    		$arrData['message'] = 'Ya existe un cliente registrado con el email: '.$allInputs['email'];
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}

    	$this->db->trans_start();
    	$idusuario = $this->model_usuario->m_registrar_usuario_cliente($allInputs);
		if($idusuario){
			$allInputs['idusuario'] = $idusuario;
			$idcliente = $this->model_cliente->m_registrar_cliente($allInputs);
			// var_dump($allInputs);
			if($idcliente){
				foreach ($allInputs['actividades'] as $row) {
					$data = array(
						'idcliente' => $idcliente,
						'idactividad' => $row
					);
					$this->model_cliente->m_registrar_actividad_cliente($data);
				}
				$arrData['message'] = 'Se registraron los datos correctamente';
    			$arrData['flag'] = 1;
			}
		}
		$this->db->trans_complete();

		if($arrData['flag'] == 1){
			$carpeta = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'clientes' . DIRECTORY_SEPARATOR . $allInputs['codigo'];
		    createCarpetas($carpeta);
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
		// http://localhost/caribbean.com/ci.php/cliente/reg_cliente?nombres=Ruben&email=rguevara@hotmail.es&codigo=1122
	}
	// MANTENIMIENTO
	public function registrar_cliente($origen=''){
		// $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		if($origen == 'externo'){ // para colocar en un formulario externo
			$allInputs['nombres'] = $this->input->post_get('nombres');
			// $allInputs['apellidos'] = $this->input->post_get('apellidos');
			// $allInputs['email'] = $this->input->post_get('email');
			$allInputs['codigo'] = $this->input->post_get('codigo');
			$allInputs['telefono'] = $this->input->post_get('telefono');
			$allInputs['idactividad'] = $this->input->post_get('idexcursion');
			// $allInputs['hotel'] = $this->input->post_get('hotel');
			// $allInputs['habitacion'] = $this->input->post_get('habitacion');
			// $allInputs['ididioma'] = $this->input->post_get('ididioma');
			$allInputs['fecha_excursion'] = $this->input->post_get('fecha_excursion');
			// $allInputs['fecha_salida'] = $this->input->post_get('fecha_salida');
			$allInputs['monedero'] = $this->input->post_get('deposito');
		}else{
			$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		}
		$arrData['message'] = 'Error al registrar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// var_dump($allInputs); exit();
    	/*if(empty($allInputs['email'])){
    		$arrData['message'] = 'Debe seleccionar un email.';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}*/
    	/*if(empty($allInputs['ididioma'])){
    		$arrData['message'] = 'Debe seleccionar un idioma.';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}*/
    	if(empty($allInputs['idactividad'])){
    		$arrData['message'] = 'Debe seleccionar una excursión.';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}
    	/*if(!comprobar_email($allInputs['email'])){
    		$arrData['message'] = 'Correo de Cliente inválido.';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}*/
    	/*if($this->model_cliente->m_cargar_cliente_por_email($allInputs)){
    		$arrData['message'] = 'Ya existe un cliente registrado con el email: '.$allInputs['email'];
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}*/

    	$this->db->trans_start();
    	$idusuario = $this->model_usuario->m_registrar_usuario_cliente($allInputs);
		if($idusuario){
			$allInputs['idusuario'] = $idusuario;
			$idcliente = $this->model_cliente->m_registrar_cliente($allInputs);
			// var_dump($allInputs);
			if($idcliente){
				$data = array(
					'idcliente' => $idcliente,
					'idactividad' => $allInputs['idactividad']
				);
				$this->model_cliente->m_registrar_actividad_cliente($data);
				/*foreach ($allInputs['actividades'] as $row) {
					$this->model_cliente->m_registrar_actividad_cliente($data);
				}*/
				$arrData['message'] = 'Se registraron los datos correctamente';
    			$arrData['flag'] = 1;

    			/*envio de correo*/
    			/*$allInputs['idtipoemail'] = 1;
    			$lista = $this->model_email->m_cargar_email($allInputs);
    			if(empty($lista)){
    				$arrData['message2'] = 'Email no configurado para el idioma seleccionado';
    				$arrData['flag2'] = 0;
    			}else{
			    	$mensaje = $lista[0]['contenido'];
					$mensaje .= '<br /> Atte: <br /> '.DESCRIPCION.' </div></div>';
					$from = 'soporte@unaisangamer.com';
					$to = $allInputs['email'];
					$asunto = $lista[0]['asunto'];
					// if(false){
					if(envio_email($to, "",$asunto, $mensaje, $from)){
						$arrData['message2'] = 'Notificación de correo enviada exitosamente.';
	    				$arrData['flag2'] = 1;
					}else{
						$arrData['message2'] = 'Error en envio de correo';
	    				$arrData['flag2'] = 0;
					}
    			}*/

			}
		}
		$this->db->trans_complete();
		$arrData['message2'] = '';
    	$arrData['flag2'] = 1;
		if($arrData['flag'] == 1){
			$carpeta = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'clientes' . DIRECTORY_SEPARATOR . $allInputs['codigo'];
		    createCarpetas($carpeta);
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function editar_cliente(){
		// $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		if( $this->model_cliente->m_editar_cliente($allInputs) ){
			if( $this->model_usuario->m_editar_usuario_cliente($allInputs) ){
				$arrData['message'] = 'Se editaron los datos correctamente ';
	    		$arrData['flag'] = 1;
			}
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function editar_datos_adicionales_cliente(){
		// $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		if( $this->model_cliente->m_editar_datos_adicionales($allInputs) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function editar_perfil_cliente(){
		$this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		if( $this->model_cliente->m_editar_perfil_cliente($allInputs) ){
			if( $this->model_usuario->m_editar_idioma_usuario($allInputs) ){
				$arrData['message'] = 'Se editaron los datos correctamente ';
	    		$arrData['flag'] = 1;
			}
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function anular_cliente(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al anular los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	foreach ($allInputs as $row) {
	    	if($this->model_usuario->m_anular_usuario($row)){
				if($this->model_cliente->m_anular_cliente($row)){
					$arrData['message'] = 'Se anularon los datos correctamente';
		    		$arrData['flag'] = 1;
				}
			}
    	}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function anular_archivo(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al anular los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	$carpeta = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'clientes' . DIRECTORY_SEPARATOR;

    	if($allInputs['descargado']){
    		$arrData['message'] = 'Este archivo fue descargado. Esta en la carpeta de descargadas';
    		$arrData['flag'] = 0;
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}
		if($this->model_archivo->m_anular_archivo($allInputs)){
			unlink($carpeta.$allInputs['codigo_usuario'].DIRECTORY_SEPARATOR.'originales'.DIRECTORY_SEPARATOR.$allInputs['nombre_archivo']);
			unlink($carpeta.$allInputs['codigo_usuario'].DIRECTORY_SEPARATOR.'originales'.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.$allInputs['nombre_archivo']);
			if($allInputs['tipo_archivo'] == 2){
				unlink($carpeta.$allInputs['codigo_usuario'].DIRECTORY_SEPARATOR.'originales'.DIRECTORY_SEPARATOR.explode(".", $allInputs['nombre_archivo'])[0].'.jpg');
			}else{
				unlink($carpeta.$allInputs['codigo_usuario'].DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.$allInputs['nombre_archivo']);
			}
			$arrData['message'] = 'Se anularon los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function delete_archivo(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al eliminar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		if($this->model_archivo->m_delete_archivo($allInputs)){
			$carpeta = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'clientes' . DIRECTORY_SEPARATOR . $allInputs['codigo'];
			deleteArchivos($carpeta. DIRECTORY_SEPARATOR .'descargadas'. DIRECTORY_SEPARATOR .'thumbs');
			deleteArchivos($carpeta. DIRECTORY_SEPARATOR .'descargadas');
			deleteArchivos($carpeta. DIRECTORY_SEPARATOR .'originales'. DIRECTORY_SEPARATOR .'thumbs');
			deleteArchivos($carpeta. DIRECTORY_SEPARATOR .'originales');
			deleteArchivos($carpeta. DIRECTORY_SEPARATOR .'thumbs');
			$arrData['message'] = 'Se eliminaron los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function delete_archivo_select(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al eliminar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	$carpeta = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'clientes' . DIRECTORY_SEPARATOR;

    	foreach ($allInputs as $key => $value) {
    		if($value['selected'] && !$value['descargado']){
    			if($this->model_archivo->m_anular_archivo($value)){
    				unlink($carpeta.$value['codigo_usuario'].DIRECTORY_SEPARATOR.'originales/thumbs'.DIRECTORY_SEPARATOR.$value['nombre_archivo']);
    				unlink($carpeta.$value['codigo_usuario'].DIRECTORY_SEPARATOR.'originales'.DIRECTORY_SEPARATOR.$value['nombre_archivo']);
					if($value['tipo_archivo'] == 2){
						unlink($carpeta.$value['codigo_usuario'].DIRECTORY_SEPARATOR.'originales'.DIRECTORY_SEPARATOR.explode(".", $value['nombre_archivo'])[0].'.jpg');
					}else{
						unlink($carpeta.$value['codigo_usuario'].DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.$value['nombre_archivo']);
					}
					$arrData['message'] = 'Se eliminaron los datos correctamente';
		    		$arrData['flag'] = 1;
				}
    		}
    	}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function upload_cliente(){
		ini_set('memory_limit','1G');
		$arrData['message'] = 'Error al subir imagenes/videos';
    	$arrData['flag'] = 0;
    	$errors = array(
		    '0' => 'There is no error, the file uploaded with success',
		    '1' => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
		    '2' => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
		    '3' => 'The uploaded file was only partially uploaded',
		    '4' => 'No file was uploaded',
		    '6' => 'Missing a temporary folder',
		    '7' => 'Failed to write file to disk.',
		    '8' => 'A PHP extension stopped the file upload.',
		);
    	$cliente = "";
		if(!empty( $_FILES )  && isset($_FILES['file'])){

			if(!empty( $_REQUEST )){
				$codigo = $_REQUEST['codigo'];
				$idcliente = $_REQUEST['idcliente'];
				$idusuario = $_REQUEST['idusuario'];
				$idactividadcliente = $_REQUEST['idactividadcliente'];

			    $file_name = $_FILES['file']['name'];
			    $file_size =$_FILES['file']['size'];
			    $file_tmp =$_FILES['file']['tmp_name'];
			    $file_type=$_FILES['file']['type'];
			    $file_error=$_FILES['file']['error'];

			    if($file_error > 0){
			    	$arrData['message'] = $errors[$file_error];
		    		$this->output
					    ->set_content_type('application/json')
					    ->set_output(json_encode($arrData));
					return;
			    }
			    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			    $extensions_image = array("jpeg","jpg");
			    $extensions_video = array("mp4", "mkv", "avi", "dvd", "mov");

				// CREAR CARPETAS CLIENTE
		    	$carpeta = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'clientes' . DIRECTORY_SEPARATOR . $codigo;
		    	createCarpetas($carpeta);
				$carpeta_destino = $carpeta . DIRECTORY_SEPARATOR .'originales';
				// $random = generateRandomString();
				// $file_name = $random .'.'. $file_ext;

				// IMAGENES
			    if(in_array($file_ext,$extensions_image)){
			    	if($file_size < 13*_1MB){ //12MB (1 MB = 1048576)
			    		list($width_orig, $height_orig) = getimagesize($file_tmp);
				        redimencionMarcaAgua(600, $file_tmp, $carpeta, $file_name);
				       	redimenciona(300, $file_tmp, $carpeta_destino . DIRECTORY_SEPARATOR .'thumbs', $file_name);
				        if($file_size > 2*_1MB){
				        	redimenciona(4000, $file_tmp, $carpeta_destino, $file_name);
				        }else{
				        	move_uploaded_file($file_tmp, $carpeta_destino . DIRECTORY_SEPARATOR . $file_name);
				        }
				        // redimencionMarcaAgua2(500, $carpeta, $file_name);

						$allInputs = array(
							'idcliente' 	=> $idcliente,
							'idusuario' 	=> $idusuario,
							'idactividadcliente' 	=> $idactividadcliente,
							'nombre_archivo'=> $file_name,
							'size'			=> $file_size,
							'tipo_archivo'=> 1
						);
						array_push($allInputs,array('tipo_archivo'=> 1));
				        if($this->model_archivo->m_registrar_archivo($allInputs)){
							$arrData['message'] = 'La imagen se subió correctamente. ';
				    		$arrData['flag'] = 1;
						}
			    	}else{
			    		$arrData['message'] = 'El tamaño es mayor a 13Mb';
			    		$this->output
						    ->set_content_type('application/json')
						    ->set_output(json_encode($arrData));
						return;
			    	}

				//VIDEOS
			    }elseif(in_array($file_ext,$extensions_video)){
			    	if($file_size < 104857600){


						move_uploaded_file($file_tmp, $carpeta_destino . DIRECTORY_SEPARATOR . $file_name);
						imagenVideo($carpeta_destino . DIRECTORY_SEPARATOR . $file_name, $random, $carpeta_destino. DIRECTORY_SEPARATOR);

						$allInputs = array(
							'idcliente' 	=> $idcliente,
							'idusuario' 	=> $idusuario,
							'idactividadcliente' 	=> $idactividadcliente,
							'nombre_archivo'=> $file_name,
							'size'			=> $file_size,
							'tipo_archivo'=> 2
						);
						if($this->model_archivo->m_registrar_archivo($allInputs)){
							$arrData['message'] = 'Se subieron videos correctamente. ';
				    		$arrData['flag'] = 1;
						}
					}else{
			    		$arrData['message'] = 'El tamaño es mayor a 100Mb';
			    		$this->output
						    ->set_content_type('application/json')
						    ->set_output(json_encode($arrData));
						return;
			    	}

			    }else{
			    	$arrData['message'] = 'No es el formato correcto';
		    		$this->output
					    ->set_content_type('application/json')
					    ->set_output(json_encode($arrData));
					return;
			    }
			}
		}


		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function lista_imagenes(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_archivo->m_cargar_imagenes($allInputs);
		$arrListado = array();
		//var_dump($lista); exit();
		foreach ($lista as $row) {
			$src_image ='';
			if($row['tipo_archivo'] == 2){
				$src_image = '../uploads/clientes/'.$row['codigo'].'/originales/'.explode(".", $row['nombre_archivo'])[0].'.jpg';
			}

			if($row['descargado'] == 1){
				$descargado = TRUE;
				$src = '../uploads/clientes/'.$row['codigo'].'/descargadas/'.$row['nombre_archivo'];
				$src_thumb = '../uploads/clientes/'.$row['codigo'].'/descargadas/thumbs/'.$row['nombre_archivo'];
			}else{
				$descargado = FALSE;
				$src = '../uploads/clientes/'.$row['codigo'].'/originales/'.$row['nombre_archivo'];
				$src_thumb = '../uploads/clientes/'.$row['codigo'].'/originales/thumbs/'.$row['nombre_archivo'];
			}
			array_push($arrListado,
				array(
					'idarchivo' => $row['idarchivo'],
					'idusuario' => $row['idusuario'],
					'idcliente' => $row['idcliente'],
					'nombre_archivo' => $row['nombre_archivo'],
					'size' => $row['size'],
					'tipo_archivo' => $row['tipo_archivo'],
					'codigo_usuario' => $row['codigo'],
					'selected' => FALSE,
					'descargado' => $descargado,
					'src' => $src,
					'src_image' => $src_image,
					'src_thumb' => $src_thumb,
					'title' => '',
				)
			);
		}

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
    /*public function subir_imagenes_carpeta(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'No se pudieron cargar las imagen/videos correctamente';
    	$arrData['flag'] = 0;

        $this->load->helper('file');
        $this->load->library('image_lib');
        $extensions_image = array("jpeg","jpg");
		$extensions_video = array("mp4", "mkv", "avi", "dvd", "mov");
     	$lista = $this->model_archivo->m_cargar_nombre_imagenes($allInputs);
     	$archivos = array();
		$carpeta = './uploads/clientes/' . $allInputs['codigo'];

		if (!file_exists($carpeta)) {
			$arrData['message'] = 'No existe el directorio';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
		}

		if (!file_exists($carpeta.'/originales/')) {
			$arrData['message'] = 'No existe el directorio';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
		}

		foreach ($lista as $key => $value) {
			array_push($archivos,explode(".", $value['nombre_archivo'])[0]);
		}

       	foreach (get_filenames('./uploads/clientes/'.$allInputs['codigo'].'/originales/') as $archivo) {
       		$file_ext = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));

		    if(in_array($file_ext,$extensions_image) || in_array($file_ext,$extensions_video) ){
            	if(!in_array(explode(".", $archivo)[0],$archivos)){
            		$carpeta = './uploads/clientes/'.$allInputs['codigo'];
				    $archivo_or = './uploads/clientes/'.$allInputs['codigo'].'/originales/'.$archivo;
				    $var = filesize($carpeta);

            		$allInputs['nombre_archivo'] = $archivo;
					$allInputs['size'] = $var;
					if(in_array($file_ext,$extensions_image)){
						$allInputs['tipo_archivo'] = 1;
					}else{
						$allInputs['tipo_archivo'] = 2;
					}

				   	if(in_array($file_ext,$extensions_image)){
		   				redimencionMarcaAgua(600, $archivo_or, $carpeta, $archivo);
		   				redimenciona(300, $archivo_or, $carpeta .'/originales/thumbs', $archivo);
				   	}else{
				   		imagenVideo($archivo_or, explode(".", $archivo)[0], $carpeta.'/originales/');
				   	}

            		if($this->model_archivo->m_registrar_archivo($allInputs)){
						$arrData['message'] = 'Se subieron las imagen/videos correctamente. ';
			    		$arrData['flag'] = 1;
					}
            	}
            }
        }
    	//exit();
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}*/
	public function registrar_puntuacion(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'No se pudo registrar la calificacion.';
    	$arrData['flag'] = 0;

    	//print_r($allInputs); exit();

    	if($this->model_puntuacion->m_registrar_puntuacion($allInputs)){
    		$arrData['message'] = 'Calificacion registrada exitosamente.';
    		$arrData['flag'] = 1;
    	}

    	$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function actualizar_monedero(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al actualizar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

    	$monedero = $this->model_cliente->m_monedero_cliente_cbo($allInputs);
    	if($monedero != $allInputs['saldo']){
    		$arrData['message'] = 'El saldo no coincide';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}

		if($this->model_cliente->m_actualizar_monedero($allInputs)){
			$cliente = $this->model_cliente->m_cargar_cliente_cbo($allInputs);
			$arrData['message'] = 'Se actualizaron los datos correctamente';
    		$arrData['cliente'] = $cliente;
    		$arrData['flag'] = 1;
		}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function upload_excel(){
		$arrData['message'] = 'Error al subir archivo';
    	$arrData['flag'] = 0;
    	$errors = array(
		    '0' => 'There is no error, the file uploaded with success',
		    '1' => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
		    '2' => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
		    '3' => 'The uploaded file was only partially uploaded',
		    '4' => 'No file was uploaded',
		    '6' => 'Missing a temporary folder',
		    '7' => 'Failed to write file to disk.',
		    '8' => 'A PHP extension stopped the file upload.',
		);
    	// var_dump($_FILES['file']); exit();
		if(!empty( $_FILES )  && isset($_FILES['file'])){
			$file_name = $_FILES['file']['name'];
		    $file_size =$_FILES['file']['size'];
		    $file_tmp =$_FILES['file']['tmp_name'];
		    $file_type=$_FILES['file']['type'];
		    $file_error=$_FILES['file']['error'];
		    if(!$file_tmp){
		    	$arrData['message'] = 'Temporal no existe';
	    		$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($arrData));
				return;
		    }
		    if($file_error > 0){
		    	$arrData['message'] = $errors[$file_error];
	    		$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($arrData));
				return;
		    }
		 //    $inputFile = $_FILES['spreadsheet']['tmp_name'];
			// $extension = strtoupper(pathinfo($inputFile, PATHINFO_EXTENSION));
		    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
		    $extensions_archivo = array("xls","xlsx");
		    $carpeta = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'clientes';
		    $file_name = 'clientes.'. $file_ext;
		    if(in_array($file_ext,$extensions_archivo)){
		    	move_uploaded_file($file_tmp, $carpeta . DIRECTORY_SEPARATOR . $file_name);
		    	if($this->registrar_clientes_excel($carpeta . DIRECTORY_SEPARATOR . $file_name )){
		    		$arrData['message'] = 'Se registraron los datos correctamente';
	    			$arrData['flag'] = 1;
		    	}else{
		    		$arrData['message'] = 'Error al registrar los datos.';
		    	}

		    }else{
		    	$arrData['message'] = 'No es el formato correcto';
	    		$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($arrData));
				return;
		    }
		}
		$arrData['message'] = 'Seleccione un archivo';
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	private function registrar_clientes_excel($inputFile){
		ini_set('xdebug.var_display_max_depth', 10);
	    ini_set('xdebug.var_display_max_children', 1024);
	    ini_set('xdebug.var_display_max_data', 1024);
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		$objPHPExcel = $objReader->load($inputFile);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$arrListado = array();
		foreach ($objWorksheet->getRowIterator() as $row) {
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false);

			$arrAux = array();
			foreach ($cellIterator as $cell) {
				$arrAux[] = $cell->getValue();
			}
			if( !empty($arrAux[0]) && !empty($arrAux[1]) ){
				array_push($arrListado, array(
					'codigo' => $arrAux[0],
					'excursion' => $arrAux[1],
					'monedero' => $arrAux[2],
					'fecha_excursion' => NULL,
					// 'fecha_excursion' => $arrAux[3],
					)
				);
			}
		}
		// var_dump($arrListado); exit();
		unset($arrListado[0]);
		$registro_exitoso = TRUE;
		$this->db->trans_begin();
		foreach ($arrListado as $row) {
	  		$idusuario = $this->model_usuario->m_registrar_usuario_cliente($row);
	  		if($idusuario){
	  			$row['idusuario'] = $idusuario;
				$idcliente = $this->model_cliente->m_registrar_cliente($row);
				if($idcliente){
					$data = array(
						'idcliente' => $idcliente,
						'idactividad' => $row['excursion']
					);
					$this->model_cliente->m_registrar_actividad_cliente($data);
					$carpeta = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'clientes' . DIRECTORY_SEPARATOR . $row['codigo'];
		    		createCarpetas($carpeta);
	    		}
	  		}else{
	  			$registro_exitoso = FALSE;
	  		}
		}
		if ($this->db->trans_status() == FALSE || $registro_exitoso == FALSE){
			$this->db->trans_rollback();
			$arrData['message'] = 'Error al registrar los datos, inténtelo nuevamente';
	    	$arrData['flag'] = 0;
		}else{
			$this->db->trans_commit();
		}

		return $registro_exitoso;
	}
	public function organizar_imagenes_temporales($allInputs){
		// $allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$this->load->helper('file');
        $this->load->library('image_lib');
        // $extensions_image = array("jpeg","jpg");
        // $archivos = array();
		$carpeta = './uploads/temporal/tmp';

		if (!file_exists('./uploads/temporal/' . $allInputs['archivoZip'])) {
			$arrData['message'] = 'No subió el archivo zip';
			$arrData['flag'] = 0;
    		// $this->output
			   //  ->set_content_type('application/json')
			   //  ->set_output(json_encode($arrData));
			return $arrData;
		}
		$error = FALSE;
		$i = 0;
		$zip = new ZipArchive;
		if ($zip->open('./uploads/temporal/' . $allInputs['archivoZip']) === TRUE) {
		    $zip->extractTo($carpeta);
		    $zip->close();
		} else {
		   	$arrData['message'] = 'No se pudo abrir el archivo zip';
			$arrData['flag'] = 0;
    		// $this->output
			   //  ->set_content_type('application/json')
			   //  ->set_output(json_encode($arrData));
			return $arrData;
		}
		unlink('./uploads/temporal/' . $allInputs['archivoZip']);

		foreach (get_filenames($carpeta) as $archivo) {
			if( $archivo != 'index.html'){
				++$i;
	       		// $file_ext = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
				$codigo = explode("-", $archivo)[0];

				$url_origen = $carpeta.'/'.$archivo;
				$url_destino = 'uploads/clientes/'.$codigo.'/originales/'.$archivo;

				if(rename($url_origen,$url_destino)){
					$carpeta_or = './uploads/clientes/'.$codigo;
				    $archivo_or = $carpeta_or.'/originales/'.$archivo;

	   				$rowCliente = $this->model_cliente->m_cargar_cliente_por_codigo($codigo);
	        		$allInputs['nombre_archivo'] = $archivo;
					$allInputs['size'] = filesize($archivo_or);
					$allInputs['tipo_archivo'] = 1;
					$allInputs['idcliente'] = $rowCliente['idcliente'];
					$allInputs['idusuario'] = $rowCliente['idusuario'];
					$allInputs['idactividadcliente'] = $rowCliente['idactividadcliente'];
					// var_dump($allInputs);

	   				redimencionMarcaAgua(600, $archivo_or, $carpeta_or, $archivo);
	   				redimenciona(300, $archivo_or, $carpeta_or .'/originales/thumbs', $archivo);


	        		if(!$this->model_archivo->m_registrar_archivo($allInputs)){
						$error = TRUE;
					}
				}else{
					$error = TRUE;
				}

			}
       	}
       	if( $i == 0 ){
       		$arrData['message'] = 'No hay nada que organizar';
			$arrData['flag'] = 0;
       	}elseif($error){
       		$arrData['message'] = 'Ocurrió un error';
			$arrData['flag'] = 0;
       	}else{
       		$arrData['message'] = 'Se organizaron ' . $i . ' imágenes correctamente. ';
			$arrData['flag'] = 1;
       	}
       	return $arrData;
 		// $this->output
		 //    ->set_content_type('application/json')
		 //    ->set_output(json_encode($arrData));
	}
	public function upload_zip_ftp(){
		$this->load->library('ftp');
		// $allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al subir archivo';
    	$arrData['flag'] = 0;
    	$errors = array(
		    '0' => 'There is no error, the file uploaded with success',
		    '1' => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
		    '2' => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
		    '3' => 'The uploaded file was only partially uploaded',
		    '4' => 'No file was uploaded',
		    '6' => 'Missing a temporary folder',
		    '7' => 'Failed to write file to disk.',
		    '8' => 'A PHP extension stopped the file upload.',
		);
		if(!empty( $_FILES )  && isset($_FILES['file'])){
			$file_name = $_FILES['file']['name'];
		    $file_size =$_FILES['file']['size'];
		    $file_tmp =$_FILES['file']['tmp_name'];
		    $file_type=$_FILES['file']['type'];
		    $file_error=$_FILES['file']['error'];
		    if(!$file_tmp){
		    	$arrData['message'] = 'Temporal no existe';
	    		$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($arrData));
				return;
		    }
		    if($file_error > 0){
		    	$arrData['message'] = $errors[$file_error];
	    		$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($arrData));
				return;
		    }
		    // $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
		    $file_ext = strtolower(pathinfo($allInputs['ruta'], PATHINFO_EXTENSION));
		    $extensions_archivo = array("zip");
		    $carpeta = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'temporal';
		    $file_name = 'clientes-'.date('YmdHis').'.'. $file_ext;
		    // $file_tmp = $allInputs['ruta'];
		    // $file_tmp = $carpeta . '/clientes2.zip';
    		// var_dump($file_name); exit();
		    if(in_array($file_ext,$extensions_archivo)){

		        $config['hostname'] = '37.252.96.44';
		        $config['username'] = 'subida';
		        $config['password'] = 'unai2018';
		        $config['debug'] = TRUE;
		        $config['passive'] = TRUE;

		        $this->ftp->connect($config);

		       /* $list = $this->ftp->list_files('/');
				print_r($list);*/

		        $this->ftp->upload($file_tmp, $file_name, "auto", 0775);


		    	$arrData['archivoZip'] = $file_name;
		        $this->ftp->close();
		        $rpta = $this->organizar_imagenes_temporales($arrData);
		        if($rpta['flag'] == 1){
		        	$arrData['message'] = $rpta['message'];
    				$arrData['flag'] = 1;
		        }else{
		        	$arrData['message'] = $rpta['message'];
    				$arrData['flag'] = 0;
		        }
		    }

		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));

	}
}