<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->helper(array('fechas','imagen','otros'));
        $this->load->model(array('model_cliente','model_usuario','model_archivo','model_puntuacion','model_email'));
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
			array_push($arrListado,
				array(
					'idcliente' => $row['idcliente'],
					'idusuario' => $row['idusuario'],
					'nombres' 	=> $row['nombres'],
					'apellidos'	=> $row['apellidos'],
					'email' 	=> $row['email'],
					'whatsapp' 	=> $row['whatsapp'],
					'hotel' 	=> $row['hotel'],
					'habitacion'=> $row['habitacion'],
					'telefono' 	=> $row['telefono'],
					'monedero' 	=> (int)$row['monedero'],
					'estado_cl'	=> $row['estado_cl'],
					'codigo' 	=> $row['codigo'],
					'ididioma' 	=> $row['ididioma'],
					'idactividadcliente' 	=> $row['idactividadcliente'],
					'fecha_excursion' 	=> darFormatoDMY($row['fecha_excursion']),
					'fecha_salida' 	=> darFormatoDMY($row['fecha_salida']),
					'archivo'	=> ($row['archivo'] > 0) ? TRUE:FALSE
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
    	$idusuario = $this->model_usuario->m_registrar_usuario($allInputs);
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
		if($origen == 'externo'){
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
		}else{
			$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		}
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
    	if(!comprobar_email($allInputs['email'])){
    		$arrData['message'] = 'Correo de Cliente inválido.';
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
    	$idusuario = $this->model_usuario->m_registrar_usuario($allInputs);
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

    			/*envio de correo*/
    			$allInputs['idtipoemail'] = 1;
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
    			}

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

    	if($this->model_usuario->m_anular_usuario($allInputs)){
			if($this->model_cliente->m_anular_cliente($allInputs)){
				$arrData['message'] = 'Se anularon los datos correctamente';
	    		$arrData['flag'] = 1;
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
							$arrData['message'] = 'Se subieron las imagenes correctamente. ';
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

    public function subir_imagenes_carpeta(){
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
	}

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
    	// print_r($allInputs);
    	// print_r($monedero);
    	if($monedero != $allInputs['saldo']){
    		$arrData['message'] = 'El saldo no coincide';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}

		if($this->model_cliente->m_actulizar_monedero($allInputs)){
			$cliente = $this->model_cliente->m_cargar_cliente_cbo($allInputs);
			$arrData['message'] = 'Se actalizaron los datos correctamente';
    		$arrData['cliente'] = $cliente;
    		$arrData['flag'] = 1;
		}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
}