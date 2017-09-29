<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {
	public function __construct(){
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
        $this->load->helper(array('fechas','imagen','otros'));
        $this->load->model(array('model_usuario', 'model_cliente','model_acceso'));
    }

    public function listar_usuarios(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];
		$lista = $this->model_usuario->m_cargar_usuario($paramPaginate);
		$totalRows = $this->model_usuario->m_count_usuario($paramPaginate);
		$arrListado = array();
		//var_dump($lista); exit();
		foreach ($lista as $row) {
			if( $row['estado_us'] == 1 ){
				$bool = true;
			}
			if( $row['estado_us'] == 2 ){
				$bool = false;
			}
			array_push($arrListado,
				array(
					'idusuario' => $row['idusuario'],
					'username' => $row['username'],
					'ididioma' => $row['ididioma'],
					'idioma' => $row['nombre_id'],
					'idgrupo' => $row['idgrupo'],
					'grupo' => $row['nombre_gr'],
					'solicita_bonificacion' => $row['solicita_bonificacion'],
					'estado' => array(
						'id'	 =>$row['idusuario'],
						'valor'  =>$row['estado_us'],
						'bool'   =>$bool
					)
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

	public function listar_idioma_cbo(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_usuario->m_cargar_idioma_cbo();
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'id' => $row['ididioma'],
					'descripcion' => $row['nombre_id']
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

	public function listar_grupo_cbo(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_usuario->m_cargar_grupo_cbo();
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'id' => $row['idgrupo'],
					'descripcion' => $row['nombre_gr']
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

	// MANTENIMIENTO
	public function registrar_usuario(){
		// $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al registrar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	 
    	if(empty($allInputs['ididioma'])){
    		$arrData['message'] = 'Debe seleccionar un idioma.';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}

		$codigo = "";
    	$band = true;
    	while ($band) {
    		$codigo = generateRandomString();
    		if(!$this->model_usuario->m_verificar_codigo_usuario($codigo)){
				$band = false;
			}
    	}
    	
    	$allInputs['codigo'] = $codigo; 
    	$this->db->trans_start();   	
    	$idusuario = $this->model_usuario->m_registrar_usuario($allInputs);
		if($idusuario){
			$allInputs['idusuario'] = $idusuario;
			if($this->model_cliente->m_actualizar_cliente_usuario($allInputs)){
				$arrData['message'] = 'Se registraron los datos correctamente';
    			$arrData['flag'] = 1;
			}
		}
		$this->db->trans_complete();
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function editar_usuario(){
		// $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		if( $this->model_usuario->m_editar_usuario($allInputs) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function editar_idioma_usuario(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		if( $this->model_usuario->m_editar_idioma_usuario($allInputs) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function editar_clave_usuario(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

    	$datos = array(
    		'clave' => $allInputs['clave'],
    		'usuario' => $allInputs['username'],
    		);
    	$loggedUser = $this->model_acceso->m_logging_user($datos);
		if( !(isset($loggedUser['logged']) && $loggedUser['logged'] > 0 )){
			$arrData['message'] = 'Debe ingresar contraseña actual valida.';
    		$arrData['flag'] = 0;		
			$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
		}

		if($allInputs['nuevaclave'] != $allInputs['password']){
			$arrData['message'] = 'Nueva contraseña y repeticion deben coincidir.';
    		$arrData['flag'] = 0;		
			$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
		}

		if( $this->model_usuario->m_editar_idioma_usuario($allInputs) ){
			$arrData['message'] = 'Contraseña actualizada correctamente ';
    		$arrData['flag'] = 1;
		}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function anular_usuario(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al anular los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// var_dump($allInputs); exit();
		if($this->model_usuario->m_anular_usuario($allInputs)){
			$arrData['message'] = 'Se anularon los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function habilitar_desabilitar_usuario()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al registrar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	$this->db->trans_start();
    	if( $allInputs['estado']['valor'] == 1 ){
			if( $this->model_usuario->m_deshabilitar($allInputs['idusuario']) ){ 
				$arrData['message'] = 'Se deshabilitaron los datos correctamente';
				$arrData['flag'] = 1;
			}
    	}
    	if( $allInputs['estado']['valor'] == 2 ){
			if( $this->model_usuario->m_habilitar($allInputs['idusuario']) ){ 
				$arrData['message'] = 'Se habilitaron los datos correctamente';
				$arrData['flag'] = 1;
			}
    	}
    	$this->db->trans_complete();
    	$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function enviar_mail_registro(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al enviar email.';
    	$arrData['flag'] = 0;

		$mensaje = '<html> 
		      <head>
		        <title>Usuario en Caribbean</title> 
		      </head>
		      <body style="font-family: sans-serif;padding: 10px 40px; color: #000000" >';
		
		$mensaje .= '<div style="font-size:16px;">  
		        Estimado Sr(a).: '. $allInputs['nombres']. ' '.$allInputs['apellidos'].' <br /> <br /> ';
  		$mensaje .= '<div style="font-size:16px;">  
		         Se ha creado un usuario para que pueda ver sus imagenes : <br />
		         Usuario: '.$allInputs['email'].'<br />
		         Contraseña: '.$allInputs['codigo'];
		$mensaje .= '<br /> Ingrese en esta <a href="">página</a> para iniciar session. <br />';
		$mensaje .= '<br /> Atte: <br /> CARIBBEAN </div></div>';
		$mensaje .= '</body></html>';

		$from = 'soporte@unaisangamer.com';
		$to = $allInputs['email'];
		$asunto = 'Creacion de Usuario en Caribbean';

		if(comprobar_email($allInputs['email'])){
			if(envio_email($to, "",$asunto, $mensaje, $from)){
				$arrData['message'] = 'Notificación de correo enviada exitosamente.';
				$arrData['flag'] = 1;
			}
		}else{
		  	$arrData['message'] = 'Notificación de correo NO enviada. Correo de Cliente inválido.';
			$arrData['flag'] = 0;
		}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));	
	}
}