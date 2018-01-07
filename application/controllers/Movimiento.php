<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Movimiento extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
        $this->load->helper(array('imagen','otros'));
        $this->load->model(array('model_movimiento','model_cliente'));
    }


	public function registrar_pedido()
	{
		ini_set('xdebug.var_display_max_depth', 8);
	    ini_set('xdebug.var_display_max_children', 256);
	    ini_set('xdebug.var_display_max_data', 1024);
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

    	$cliente = $this->model_cliente->m_cargar_cliente_por_sesion();
    	if($cliente['monedero'] != $allInputs['saldo_inicial']){
    		$arrData['message'] = 'El saldo no concuerda. Vuelva a intentarlo';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}
    	$datos = array(
    		'idcliente' => $cliente['idcliente'],
    		'idactividadcliente' => $allInputs['detalle'][0]['imagenes']['idactividadcliente'],
    		'tipo_movimiento' => 2, // pedido
    		'fecha_movimiento' => date('Y-m-d H:i:s'),
    		'total' => $allInputs['total_pedido'],
    		'estado'=> 1
    	);
    	var_dump($allInputs); exit();
    	$this->db->trans_start();
    	$idmovimiento = $this->model_movimiento->m_registrar_pedido($datos);
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
				);
				$iddetalle = $this->model_movimiento->m_registrar_detalle($data);
				// foreach ($variable as $key => $value) {
				// 	# code...
				// }
			}

			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
    	// var_dump($allInputs); exit();
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

}