<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Movimiento extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
        $this->load->helper(array('fechas','otros'));
        $this->load->model(array('model_movimiento','model_cliente'));
    }

    public function listar_pedidos(){
    	$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];
		// $paramDatos = $allInputs['datos'];
		// var_dump($allInputs); exit();
		$lista = $this->model_movimiento->m_cargar_pedidos($paramPaginate);
		$totalRows = $this->model_movimiento->m_count_pedidos($paramPaginate);
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
					'idactividadcliente'=> $row['idactividadcliente'],
					// 'fecha_excursion' 	=> darFormatoDMY($row['fecha_excursion']),
					'fecha_salida' 		=> darFormatoDMY($row['fecha_salida']),

					'idmovimiento' 	=> $row['idmovimiento'],
					'iddetalle' 	=> $row['iddetalle'],
					'fecha_movimiento' 	=> darFormatoDMY($row['fecha_movimiento']),
					'producto' 			=> $row['descripcion_pm'] . $adicional,
					'categoria' 			=> $row['categoria'],
					'cantidad' 			=> $row['cantidad'],
					'total_detalle' 	=> $row['total_detalle'],
					'idcolor' 	=> $row['idcolor'],
					'color' 	=> $row['color'],

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
	public function registrar_movimiento(){
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
    	// var_dump($allInputs); exit();
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
					'tipo_detalle' => 2, // 1: compra online; 2: merchandising (pedido)
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

			$arrData['message'] = 'Se registraron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->db->trans_complete();
    	// var_dump($allInputs); exit();
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

}