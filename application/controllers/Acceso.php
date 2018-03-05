<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Acceso extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('security','otros_helper'));
		$this->load->model(array('model_acceso','model_cliente'));
		//cache
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
		// date_default_timezone_set("America/Lima");
	}

	public function index(){
		//$this->load->library('encrypt');
		$allInputs = json_decode(trim(file_get_contents('php://input')),true);
		// var_dump($_SESSION['sess_cp_'.substr(base_url(),-14,9) ]); exit();
		$arrData['flag'] = 0;
    	$arrData['message'] = 'No se encontraron datos.';
		if(!empty($allInputs['usuario']) && !empty($allInputs['clave']) ){
			$loggedUser = $this->model_acceso->m_logging_user($allInputs);
			if( isset($loggedUser['logged']) && $loggedUser['logged'] > 0 ){
    			if($loggedUser['estado_us'] == 1){

					$arrPerfilUsuario = array();
					$arrPerfilUsuario['idusuario'] = $loggedUser['idusuario'];
					$arrPerfilUsuario['idgrupo'] = $loggedUser['idgrupo'];
					$arrPerfilUsuario['key_grupo'] = $loggedUser['key_grupo'];
					$arrPerfilUsuario['username'] = strtoupper($loggedUser['username']);
					$arrPerfilUsuario['monedero'] = NULL;
					$arrPerfilUsuario['ididioma'] = $loggedUser['ididioma'];;
					$arrPerfilUsuario['logged'] = true;
					$arrPerfilUsuario['nombre_foto'] = empty($loggedUser['nombre_foto']) ? 'sin-imagen.png' : $loggedUser['nombre_foto'];

						$arrPerfilUsuario['cliente'] = $arrPerfilUsuario['username'];
						$arrPerfilUsuario['email'] = $arrPerfilUsuario['key_grupo'] =='key_admin' ? 'Administrador':'Supremo';
						$this->session->set_userdata('sess_cp_'.substr(base_url(),-14,9),$arrPerfilUsuario);
						$arrData['flag'] = 1;
						$arrData['message'] = 'Usuario inició sesión correctamente';



				}elseif($loggedUser['estado_us'] == 2){
					$arrData['flag'] = 2;
					$arrData['message'] = 'Su cuenta se encuentra deshabilitada.';
				}
			}else{
    			$arrData['flag'] = 0;
    			$arrData['message'] = 'Usuario o contraseña invalida. Inténtelo nuevamente.';
    		}
		}

		// var_dump($arrData); exit();
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function acceder_cliente(){
		$allInputs = json_decode(trim(file_get_contents('php://input')),true);
		$arrData['flag'] = 0;
    	$arrData['message'] = 'No se encontraron datos.';
    	if(empty($allInputs['codigo'])){
    		$arrData['message'] = 'Ingrese codigo';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}
    	$loggedUser = $this->model_acceso->m_logging_cliente($allInputs);
    	if($loggedUser){
    		$arrPerfilUsuario = array();
			// $arrPerfilUsuario['idusuario'] = $loggedUser['idusuario'];
			$arrPerfilUsuario['idcliente'] = $loggedUser['idcliente'];
			$arrPerfilUsuario['idgrupo'] = 3;
			$arrPerfilUsuario['key_grupo'] = 'key_cliente';
			$arrPerfilUsuario['ididioma'] = $loggedUser['ididioma'];
			$arrPerfilUsuario['username'] = NULL;
			$arrPerfilUsuario['monedero'] = $loggedUser['monedero'];
			$arrPerfilUsuario['logged'] = true;
			$arrPerfilUsuario['cliente'] = empty($loggedUser['nombres'])?$loggedUser['codigo'] : strtoupper_total($cliente['nombres']);
			$arrPerfilUsuario['email'] = empty($loggedUser['email'])?$loggedUser['codigo'] : $cliente['email'];
			$arrPerfilUsuario['nombre_foto'] = empty($loggedUser['nombre_foto']) ? 'sin-imagen.png' : $loggedUser['nombre_foto'];
			$this->session->set_userdata('sess_cp_'.substr(base_url(),-14,9),$arrPerfilUsuario);
			$arrData['flag'] = 1;
			$arrData['message'] = 'Usuario inició sesión correctamente';
    	}
    	// var_dump($loggedUser); exit();
    	$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function getSessionCI(){
		$arrData['flag'] = 0;
		$arrData['datos'] = array();
			// var_dump($_SESSION); exit();

		if( $this->session->has_userdata( 'sess_cp_'.substr(base_url(),-14,9) ) &&
			!empty($_SESSION['sess_cp_'.substr(base_url(),-14,9) ]['logged']) ){
			if( $_SESSION['sess_cp_'.substr(base_url(),-14,9) ]['idgrupo'] == 3 ){
				$this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
				// $idcliente = $_SESSION['sess_cp_'.substr(base_url(),-14,9) ]['idcliente'];
				$fila = $this->model_cliente->m_cargar_cliente_por_sesion();
			}/*else{
				$idusuario = $_SESSION['sess_cp_'.substr(base_url(),-14,9) ]['idusuario'];
				$fila = $this->model_cliente->m_cargar_cliente_por_idusuario($idusuario);
			}*/
			if( !empty($fila) ){
				$_SESSION['sess_cp_'.substr(base_url(),-14,9) ]['monedero'] = $fila['monedero'];
			}

			$arrData['flag'] = 1;
			$arrData['datos'] = $_SESSION['sess_cp_'.substr(base_url(),-14,9) ];
		}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function logoutSessionCI(){
		$this->session->unset_userdata('sess_cp_'.substr(base_url(),-14,9));
        //$this->cache->clean();
        $arrData['flag'] = 1;
		$arrData['datos'] = 'Salida OK';
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

}