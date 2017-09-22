<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->helper(array('fechas','imagen','otros'));
        $this->load->model(array('model_cliente','model_usuario','model_archivo'));
    }

    public function listar_clientes(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];
		$lista = $this->model_cliente->m_cargar_cliente($paramPaginate);
		$totalRows = $this->model_cliente->m_count_cliente($paramPaginate);
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
					'estado_cl'	=> $row['estado_cl'],
					'codigo' 	=> $row['codigo'],
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

	// MANTENIMIENTO
	public function registrar_cliente(){
		$this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al registrar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		if($this->model_cliente->m_registrar_cliente($allInputs)){
			$arrData['message'] = 'Se registraron los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function editar_cliente(){
		$this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		if( $this->model_cliente->m_editar_cliente($allInputs) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function anular_cliente(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al anular los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;


    	if(!empty($allInputs['idusuario'])){
    		if($this->model_usuario->m_consultar_usuario($allInputs)){
    			$arrData['message'] = 'Este cliente tiene un usuario asociado';
	    		$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($arrData));
				return;
    		}
    	}

		if($this->model_cliente->m_anular_cliente($allInputs)){
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
			deleteArchivos($carpeta. DIRECTORY_SEPARATOR .'originales');
			deleteArchivos($carpeta. DIRECTORY_SEPARATOR .'thumbs');
			$arrData['message'] = 'Se eliminaron los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function upload_cliente(){
		$arrData['message'] = 'Error al subir imagenes/videos';
    	$arrData['flag'] = 0;
    	/*var_dump($_FILES);
    	var_dump($_REQUEST);
    	var_dump($_POST);*/
    	
    	
    	$cliente = "";

		if(!empty( $_FILES )  && isset($_FILES['file'])){

			if(!empty( $_REQUEST )){
				$codigo = $_REQUEST['codigo'];
				$idcliente = $_REQUEST['idcliente'];
				$idusuario = $_REQUEST['idusuario'];

			    $errors= array();
			    $file_name = $_FILES['file']['name'];
			    $file_size =$_FILES['file']['size'];
			    $file_tmp =$_FILES['file']['tmp_name'];
			    $file_type=$_FILES['file']['type'];
			    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			    $extensions_image = array("jpeg","jpg","png");
			    $extensions_video = array("mp4", "mkv", "avi", "dvd", "wmv", "mov");

			    $contenido = '<!DOCTYPE html><html><head>
									<title>403 Forbidden</title>
									<style type="text/css">
										body{background-color:#ffffff;font-family:verdana,sans-serif;
											font-size: 35px}
									</style>
								</head>
								<body>
									<p>Acceso denegado</p>
								</body></html>';

				// CREAR CARPESTAS CLIENTE				
		    	$carpeta = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'clientes' . DIRECTORY_SEPARATOR . $codigo;
		    	if (!file_exists($carpeta)) {
				    mkdir($carpeta, 0777, true);
				    file_put_contents($carpeta . DIRECTORY_SEPARATOR .'index.html', $contenido);
				}
				if (!file_exists($carpeta . DIRECTORY_SEPARATOR . 'originales')) {
				    mkdir($carpeta . DIRECTORY_SEPARATOR . 'originales', 0777, true);
					file_put_contents($carpeta . DIRECTORY_SEPARATOR . 'originales'. DIRECTORY_SEPARATOR .'index.html', $contenido);
				}
				if (!file_exists($carpeta . DIRECTORY_SEPARATOR .'thumbs')) {
				    mkdir($carpeta . DIRECTORY_SEPARATOR . 'thumbs', 0777, true);
				    file_put_contents($carpeta . DIRECTORY_SEPARATOR . 'thumbs'. DIRECTORY_SEPARATOR .'index.html', $contenido);
				}
				if (!file_exists($carpeta . DIRECTORY_SEPARATOR .'descargadas')) {
				    mkdir($carpeta . DIRECTORY_SEPARATOR .'descargadas', 0777, true);
				    file_put_contents($carpeta . DIRECTORY_SEPARATOR . 'descargadas'. DIRECTORY_SEPARATOR .'index.html', $contenido);
				}

				$carpeta_destino = $carpeta . DIRECTORY_SEPARATOR .'originales';
				$file_name = generateRandomString() .'.'. $file_ext ;
								
				// IMAGENES
			    if(in_array($file_ext,$extensions_image)){
			    
			    	if($file_size < 10485760){

				        redimencionMarcaAgua(600, $file_tmp, $carpeta, $file_name);
						move_uploaded_file($file_tmp, $carpeta_destino . DIRECTORY_SEPARATOR . $file_name);  
						
						$allInputs = array(
							'idcliente' 	=> $idcliente,
							'idusuario' 	=> $idusuario,
							'nombre_archivo'=> $file_name,
							'size'			=> $file_size,
							'idtipoproducto'=> 1
						);
						array_push($allInputs,array('idtipoproducto'=> 1));
				        if($this->model_archivo->m_registrar_archivo($allInputs)){
							$arrData['message'] = 'Se subieron las imagenes correctamente. ';
				    		$arrData['flag'] = 1;
						}
			    	}else{
			    		$arrData['message'] = 'El tamaño es mayor a 10Mb';
			    		$this->output
						    ->set_content_type('application/json')
						    ->set_output(json_encode($arrData));
						return;
			    	} 

				//VIDEOS	
			    }elseif(in_array($file_ext,$extensions_video)){
			    	if($file_size < 104857600){
				    	/*$frame = 10;
						$movie = $file_name;
						$thumbnail = $carpeta_destino . DIRECTORY_SEPARATOR . $file_name;

						$mov = new ffmpeg_movie($movie);
						$frame = $mov->getFrame($frame);
						if ($frame) {
						    $gd_image = $frame->toGDImage();
						    if ($gd_image) {
						        imagepng($gd_image, $thumbnail);
						        imagedestroy($gd_image);
						    }
						}*/
						move_uploaded_file($file_tmp, $carpeta_destino . DIRECTORY_SEPARATOR . $file_name);
						$allInputs = array(
							'idcliente' 	=> $idcliente,
							'idusuario' 	=> $idusuario,
							'nombre_archivo'=> $file_name,
							'size'			=> $file_size,
							'idtipoproducto'=> 2
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

}