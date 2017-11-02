<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compra extends CI_Controller {
	public function __construct(){
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        // $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
        $this->load->helper(array('fechas','imagen','otros'));
        $this->load->model(array('model_archivo','model_descuento','model_cliente','model_tipo_producto'));
    }

	public function verificar_archivos_seleccion(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);

		$cliente  = $this->model_cliente->m_cargar_cliente_por_idusuario($allInputs['usuario']['idusuario']);
		$descuentos = $this->model_descuento->m_cargar_todos_descuentos();

		/*verifica si sigue en isla*/
		$hoy = strtotime(date('Y-m-d'));
		$fecha_final = strtotime($cliente['fecha_final']);
		$arrData['mostrar_productos'] = FALSE;
		$arrData['lista_productos'] = [];
		if($hoy  <= $fecha_final){
			$arrData['mostrar_productos'] = TRUE;
			$arrData['lista_productos'] = $this->model_tipo_producto->m_cargar_tipo_producto_oferta();
		}

		/*verifica bonificacion*/
		$archivos = $this->model_archivo->m_cargar_galeria_descargados($cliente);		
		if(!empty($archivos) && count($archivos) > 1){
			$arrData['tiene_bonificacion'] = FALSE;
		}else{
			$arrData['tiene_bonificacion'] = TRUE;
		}

		/*verifica descuento*/
		$arrData['tiene_descuento'] = FALSE;
		$arrData['descuento']['descuento'] = 0;
		foreach ($descuentos as $key => $desc) {
			$nuevafecha = strtotime ( '+'.$desc['dias'].' day' , strtotime ( $cliente['fecha_creacion'] ) );
			if( $hoy >= $nuevafecha ){
				$arrData['descuento'] = $desc;
				$arrData['tiene_descuento'] = TRUE;
			}
		}

		//print_r($arrData);	exit();

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

}