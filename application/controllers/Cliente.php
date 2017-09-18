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
					'nombres' => $row['nombres'],
					'apellidos' => $row['apellidos'],
					'email' => $row['email'],
					'whatsapp' => $row['whatsapp'],
					'estado_cl' => $row['estado_cl'],
					'codigo' => $row['codigo']
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

	public function upload_cliente(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al subir imagenes';
    	$arrData['flag'] = 0;
    	/*var_dump($allInputs);
    	var_dump($_FILES);
    	var_dump($_REQUEST);
    	exit();*/
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
			    $extensions = array("jpeg","jpg","png");   

			    if(in_array($file_ext,$extensions )=== false){
			     $errors[]="imaagen extension not allowed, please choose a JPEG or PNG file.";
			    }
			    if($file_size > 2097152){
			    $errors[]='File size cannot exceed 2 MB';
			    }               
			    if(empty($errors)){
			    	
			    	$carpeta = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'clientes' . DIRECTORY_SEPARATOR . $codigo;
			    	if (!file_exists($carpeta)) {
					    mkdir($carpeta, 0777, true);
					}
					if (!file_exists($carpeta . DIRECTORY_SEPARATOR . 'originales')) {
					    mkdir($carpeta . DIRECTORY_SEPARATOR . 'originales', 0777, true);
					}
					if (!file_exists($carpeta . DIRECTORY_SEPARATOR .'thumbs')) {
					    mkdir($carpeta . DIRECTORY_SEPARATOR . 'thumbs', 0777, true);
					}
					if (!file_exists($carpeta . DIRECTORY_SEPARATOR .'descargadas')) {
					    mkdir($carpeta . DIRECTORY_SEPARATOR .'descargadas', 0777, true);
					}

					$carpeta_destino = $carpeta . DIRECTORY_SEPARATOR .'originales';
					$file_name = generateRandomString() .'.'. $file_ext ;
					
			        move_uploaded_file($file_tmp, $carpeta_destino . DIRECTORY_SEPARATOR . $file_name);

			        //************ THUMBS *************//

			        /*//Crear variable
					$original = imagecreatefromjpeg($file_tmp);

					//Ancho y alto máximo
					$max_ancho = 600; $max_alto = 400;
					 
					//Medir la imagen
					list($ancho,$alto)=getimagesize($rtOriginal);

					//Ratio
					$x_ratio = $max_ancho / $ancho;
					$y_ratio = $max_alto / $alto;

					//Proporciones
					if(($ancho <= $max_ancho) && ($alto <= $max_alto) ){
					    $ancho_final = $ancho;
					    $alto_final = $alto;
					}
					else if(($x_ratio * $alto) < $max_alto){
					    $alto_final = ceil($x_ratio * $alto);
					    $ancho_final = $max_ancho;
					}
					else {
					    $ancho_final = ceil($y_ratio * $ancho);
					    $alto_final = $max_alto;
					}*/

			        $allInputs = array(
						'idcliente' 	=> $idcliente,
						'idusuario' 	=> $idusuario,
						'nombre_archivo'=> $file_name,
						'size'			=> $file_size,
						'tipo_archivo'	=> 1
					);

			        if($this->model_archivo->m_registrar_archivo($allInputs)){
						$arrData['message'] = 'Se subieron las imagenes correctamente. ';
			    		$arrData['flag'] = 1;
					}
			    }else{
			        
			        if(empty($allInputs['imagen'])){
			    		$arrData['message'] = $errors;
			    		$arrData['flag'] = 0;
			    		$this->output
						    ->set_content_type('application/json')
						    ->set_output(json_encode($arrData));
						return;
			    	}
			    }
			}
		}

		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

}