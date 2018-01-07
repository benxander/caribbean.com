<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->helper(array('imagen','otros'));
        $this->load->model(array('model_producto'));
    }
    public function listar_producto_cbo(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_producto->m_cargar_producto_cbo();
		$arrListado = array();
		//var_dump($lista); exit();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'id' => $row['idproductomaster'],
					'descripcion' => $row['descripcion_pm'],

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
	public function listar_tipo_medida_cbo(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_producto->m_cargar_tipo_medida_cbo();
		$arrListado = array();
		//var_dump($lista); exit();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'id' => $row['idtipomedida'],
					'descripcion' => $row['descripcion_tm'],

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
    public function listar_productos(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];
		$lista = $this->model_producto->m_cargar_productos($paramPaginate);
		$totalRows = $this->model_producto->m_count_productos($paramPaginate);
		$arrListado = array();
		foreach ($lista as $row) {
			if( $row['estado_pm'] == 1 ){
				$bool = true;
			}
			elseif( $row['estado_pm'] == 2 ){
				$bool = false;
			}
			array_push($arrListado,
				array(
					'idproductomaster' => $row['idproductomaster'],
					'descripcion_pm' => $row['descripcion_pm'],
					'imagen' 		=> $row['imagen'],
					'imagen_bas' 		=> $row['imagen_bas'],
					'imagen_pre' 		=> $row['imagen_pre'],
					'si_genero' 		=> $row['si_genero'],
					'si_color' 		=> $row['si_color'],
					'tipo_seleccion' 		=> $row['tipo_seleccion'],
					'descripcion_basico' 		=> $row['descripcion_basico'],
					'descripcion_premium' 		=> $row['descripcion_premium'],
					'idtipomedida' => $row['idtipomedida'],
					'estado' => array(
						'id'	 =>$row['idproductomaster'],
						'valor'  =>$row['estado_pm'],
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
	public function listar_producto_pedido(){
		ini_set('xdebug.var_display_max_depth', 8);
	    ini_set('xdebug.var_display_max_children', 256);
	    ini_set('xdebug.var_display_max_data', 1024);
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_producto->m_cargar_producto_pedido();
		$arrListado = array();
		foreach ($lista as $row) {
			$arrListado[$row['idproductomaster']] =	array(
				'idproductomaster' 	=> $row['idproductomaster'],
				'descripcion_pm' 	=> $row['descripcion_pm'],
				'imagen' 			=> $row['imagen'],
				'si_genero' 		=> $row['si_genero'],
				'si_color' 			=> $row['si_color'],
				'tipo_seleccion' 			=> $row['tipo_seleccion'],
				'idtipomedida' 		=> $row['idtipomedida'],
				'tipo_medida' 		=> $row['descripcion_tm'],
				'colores'			=> array(),
				'categorias' 		=> array()
			);
		}
		foreach ($arrListado as $key => $value) {
			$arrAuxColor = array();
			$arrAuxCat = array();
			foreach ($lista as $row) {
				if( $row['idproductomaster'] == $key ){
					$arrAuxColor[$row['idcolor']] = array(
						'idcolor' => $row['idcolor'],
						'nombre' => $row['nombre'],
						'rgba' => $row['rgba']
					);
					$arrAuxCat[$row['categoria']] = array(
						'categoria' => $row['categoria'],
						'descripcion_ca' => $row['categoria'] == '1'? 'BASICO':'PREMIUM',
						'texto_ca' => $row['categoria'] == '1'? $row['descripcion_basico']:$row['descripcion_premium'],
						'medidas' => array()
					);
				}
			}
			$arrListado[$key]['colores'] = $arrAuxColor;
			$arrListado[$key]['categorias'] = $arrAuxCat;
		}
		foreach ($arrListado as $key => $value) {
			foreach ($value['categorias'] as $key2 => $value2) {
				$arrAuxMedida = array();
				foreach ($lista as $row) {
					if($row['idproductomaster'] == $key && $row['categoria'] == $key2){
						$arrAuxMedida[$row['idmedida']] = array(
							'idmedida' => $row['idmedida'],
							'idproducto' => $row['idproducto'],
							'denominacion' => $row['denominacion'],
							'cantidad_fotos' => $row['cantidad_fotos'],
							'precio' => $row['precio_unitario'],
							'precio_2_5' => $row['precio_2_5'],
							'precio_mas_5' => $row['precio_mas_5'],
						);
					}
				}
				$arrListado[$key]['categorias'][$key2]['medidas'] = $arrAuxMedida;
			}
		}
		foreach ($arrListado as $key1 => $row) {
			foreach ($row['categorias'] as $key2 => $categoria) {
				$arrListado[$key1]['categorias'][$key2]['medidas'] = array_values($arrListado[$key1]['categorias'][$key2]['medidas']);
			}
			$arrListado[$key1]['colores'] = array_values($arrListado[$key1]['colores']);
			$arrListado[$key1]['categorias'] = array_values($arrListado[$key1]['categorias']);
		}
		$arrListado = array_values($arrListado);
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
	public function listar_colores_producto(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_producto->m_cargar_colores_producto($allInputs);
		$arrListado = array();
		foreach ($lista as $row) {
			$arrListado[] = $row['idcolor'];
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
	public function listar_producto_precios(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_producto->m_cargar_precios_por_producto($allInputs);
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado, array(
				'idproducto' => $row['idproducto'],
				'idproductomaster' => $allInputs['idproductomaster'],
				'idmedida' => $row['idmedida'],
				'medida' => $row['medida'],
				'categoria' => $allInputs['categoria'],
				// 'categoria' => $row['categoria'] == '2'?'PREMIUM':'BASICO',
				'precio_unitario' => (int)$row['precio_unitario'],
				'precio_2_5' => (int)$row['precio_2_5'],
				'precio_mas_5' => (int)$row['precio_mas_5'],
				'estado_p' => $row['estado_p'],
				'es_nuevo' => empty($row['idproducto'])? TRUE:FALSE,
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
	public function listar_colores_cbo(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_producto->m_cargar_colores_cbo();
		$arrListado = array();
		//var_dump($lista); exit();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'id' => $row['idcolor'],
					'descripcion' => $row['nombre'],

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
	public function registrar_producto(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	if(empty($allInputs['imagen'])){
    		$arrData['message'] = 'Debe subir una imagen';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}
    	if(empty($allInputs['imagen_bas'])){
    		$arrData['message'] = 'Debe subir una imagen para Básico';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}
    	if(empty($allInputs['imagen_pre'])){
    		$arrData['message'] = 'Debe subir una imagen para Premium';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}
    	// var_dump($allInputs); exit();
		$ruta = 'uploads/producto/';
    	// preparacion y subida de imagen
		$extension = strrchr($allInputs['nombre_imagen'], ".");
		$nombre = substr($allInputs['nombre_imagen'], 0, -strlen($extension));
		$nombre .= '-'. date('YmdHis') . $extension;
		// preparacion y subida de imagen
		$extension = strrchr($allInputs['nombre_imagen_bas'], ".");
		$nombre_bas = substr($allInputs['nombre_imagen_bas'], 0, -strlen($extension));
		$nombre_bas .= '-'. date('YmdHis') . $extension;
		// preparacion y subida de imagen
		$extension = strrchr($allInputs['nombre_imagen_pre'], ".");
		$nombre_pre = substr($allInputs['nombre_imagen_pre'], 0, -strlen($extension));
		$nombre_pre .= '-'. date('YmdHis') . $extension;
		subir_imagen_Base64($allInputs['imagen'], $ruta , $nombre);
		subir_imagen_Base64($allInputs['imagen_bas'], $ruta , $nombre_bas);
		subir_imagen_Base64($allInputs['imagen_pre'], $ruta , $nombre_pre);
    	$data = array(
    		'descripcion_pm' => strtoupper_total(trim($allInputs['descripcion_pm'])),
    		'imagen' => $nombre,
    		'imagen_bas' => $nombre_bas,
    		'imagen_pre' => $nombre_pre,
    		'si_genero' => $allInputs['si_genero'],
    		'si_color' => $allInputs['si_color'],
    		'tipo_seleccion' => $allInputs['tipo_seleccion'],
    		'idtipomedida' => $allInputs['tipo_medida']['id'],
    		'descripcion_basico' => $allInputs['descripcion_basico'],
    		'descripcion_premium' => $allInputs['descripcion_premium'],

    	);
		if( $this->model_producto->m_registrar_producto($data) ){
			$arrData['message'] = 'Se registraron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function editar_producto(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	$data = array(
    		'descripcion_pm' => strtoupper_total(trim($allInputs['descripcion_pm'])),
    		'si_genero' => $allInputs['si_genero'],
    		'si_color' => $allInputs['si_color'],
    		'tipo_seleccion' => $allInputs['tipo_seleccion'],
    		'idtipomedida' => $allInputs['tipo_medida']['id'],
    		'descripcion_basico' => $allInputs['descripcion_basico'],
    		'descripcion_premium' => $allInputs['descripcion_premium'],
    	);
    	// VALIDACIONES
		$ruta = 'uploads/producto/';
    	if( $allInputs['canvas']){
    		if( empty($allInputs['imagen']) ){
	    		$arrData['message'] = 'Debe subir una imagen';
	    		$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($arrData));
				return;
	    	}
	    	// preparacion y subida de imagen
			$extension = strrchr($allInputs['nombre_imagen'], ".");
			$nombre = substr($allInputs['nombre_imagen'], 0, -strlen($extension));
			$nombre .= '-'. date('YmdHis') . $extension;
			subir_imagen_Base64($allInputs['imagen'], $ruta , $nombre);
			$data_imagen = array(
				'imagen' => $nombre,
			);
			$data = array_merge($data,$data_imagen);
    	}
    	if( $allInputs['canvas_bas']){
    		if( empty($allInputs['imagen_bas']) ){
	    		$arrData['message'] = 'Debe subir una imagen para Básico';
	    		$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($arrData));
				return;
	    	}
	    	// preparacion y subida de imagen
			$extension = strrchr($allInputs['nombre_imagen_bas'], ".");
			$nombre = substr($allInputs['nombre_imagen_bas'], 0, -strlen($extension));
			$nombre .= '-'. date('YmdHis') . $extension;
			subir_imagen_Base64($allInputs['imagen_bas'], $ruta , $nombre);
			$data_imagen = array(
				'imagen_bas' => $nombre,
			);
			$data = array_merge($data,$data_imagen);
    	}
    	if( $allInputs['canvas_pre']){
    		if( empty($allInputs['imagen_pre']) ){
	    		$arrData['message'] = 'Debe subir una imagen para Premium';
	    		$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($arrData));
				return;
	    	}
	    	// preparacion y subida de imagen
			$extension = strrchr($allInputs['nombre_imagen_pre'], ".");
			$nombre = substr($allInputs['nombre_imagen_pre'], 0, -strlen($extension));
			$nombre .= '-'. date('YmdHis') . $extension;
			subir_imagen_Base64($allInputs['imagen_pre'], $ruta , $nombre);
			$data_imagen = array(
				'imagen_pre' => $nombre,
			);
			$data = array_merge($data,$data_imagen);
    	}

    	// var_dump($data); exit();
		if( $this->model_producto->m_editar_producto($data,$allInputs['idproductomaster']) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
    	// var_dump($allInputs); exit();
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function habilitar_deshabilitar_producto(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	$this->db->trans_start();
    	if( $allInputs['estado']['valor'] == 1 ){
			if( $this->model_producto->m_deshabilitar($allInputs['idproductomaster']) ){
				$arrData['message'] = 'Se deshabilitaron los datos correctamente';
				$arrData['flag'] = 1;
			}
    	}
    	if( $allInputs['estado']['valor'] == 2 ){
			if( $this->model_producto->m_habilitar($allInputs['idproductomaster']) ){
				$arrData['message'] = 'Se habilitaron los datos correctamente';
				$arrData['flag'] = 1;
			}
    	}
    	$this->db->trans_complete();
    	$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function anular_producto(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al anular los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// var_dump($allInputs); exit();
		if($this->model_producto->m_anular($allInputs)){
			$arrData['message'] = 'Se anularon los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	/*precios*/
	public function registrar_producto_precios(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al anular los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// var_dump($allInputs); exit();
    	$error = FALSE;
    	if( $allInputs['si_color'] == '1' ){
	    	if( empty($allInputs['colores']) ){
	    		$arrData['message'] = 'Seleccione al menos un color';
	    		$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($arrData));
			    return;
	    	}
	    	if($allInputs['cambio_color']){
	    		$this->model_producto->m_eliminar_colores_producto($allInputs);
		    	foreach ($allInputs['colores'] as $row) {
		    		$data = array(
		    			'idproductomaster' => $allInputs['idproductomaster'],
		    			'idcolor' => $row
		    		);

		    		if(!$this->model_producto->m_registrar_colores_producto($data)){
		    			$error = TRUE;
		    		}
		    	}
	    	}
    	}
    	foreach ($allInputs['basico'] as $row) {
    		if($row['es_nuevo']){
	    		$data = array(
	    			'idproductomaster' => $row['idproductomaster'],
	    			'categoria' => $row['categoria'],
	    			'idmedida' => $row['idmedida'],
	    			'precio_unitario' => $row['precio_unitario'],
	    			'precio_2_5' => $row['precio_2_5'],
	    			'precio_mas_5' => $row['precio_mas_5'],
	    		);
	    		if(!$this->model_producto->m_registrar_producto_precio($data)){
		    		$error = TRUE;
		    	}
    		}else{
    			$data = array(
	    			'precio_unitario' => $row['precio_unitario'],
	    			'precio_2_5' => $row['precio_2_5'],
	    			'precio_mas_5' => $row['precio_mas_5'],
	    		);
	    		if(!$this->model_producto->m_editar_producto_precio($data,$row['idproducto'])){
		    		$error = TRUE;
		    	}
    		}
    	}
    	foreach ($allInputs['premium'] as $row) {
    		if($row['es_nuevo']){
	    		$data = array(
	    			'idproductomaster' => $row['idproductomaster'],
	    			'categoria' => $row['categoria'],
	    			'idmedida' => $row['idmedida'],
	    			'precio_unitario' => $row['precio_unitario'],
	    			'precio_2_5' => $row['precio_2_5'],
	    			'precio_mas_5' => $row['precio_mas_5'],
	    		);
	    		if(!$this->model_producto->m_registrar_producto_precio($data)){
		    		$error = TRUE;
		    	}
    		}else{
    			$data = array(
	    			'precio_unitario' => $row['precio_unitario'],
	    			'precio_2_5' => $row['precio_2_5'],
	    			'precio_mas_5' => $row['precio_mas_5'],
	    		);
	    		if(!$this->model_producto->m_editar_producto_precio($data,$row['idproducto'])){
		    		$error = TRUE;
		    	}
    		}
    	}
    	if(!$error){
    		$arrData['message'] = 'Se registraron los datos correctamente';
    		$arrData['flag'] = 1;
    	}

    	$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function editar_producto_precios(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al anular los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// var_dump($allInputs); exit();
    	$error = FALSE;
    	if( $allInputs['si_color'] == '1' ){
	    	if( empty($allInputs['colores']) ){
	    		$arrData['message'] = 'Seleccione al menos un color';
	    		$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($arrData));
			    return;
	    	}
	    	foreach ($allInputs['colores'] as $row) {
	    		$data = array(
	    			'idproductomaster' => $allInputs['idproductomaster'],
	    			'idcolor' => $row
	    		);

	    		if(!$this->model_producto->m_registrar_colores_producto($data)){
	    			$error = TRUE;
	    		}
	    	}
    	}
    	foreach ($allInputs['basico'] as $row) {
    		$data = array(
    			'idproductomaster' => $row['idproductomaster'],
    			'categoria' => $row['categoria'],
    			'idmedida' => $row['idmedida'],
    			'precio_unitario' => $row['precio_unitario'],
    			'precio_2_5' => $row['precio_2_5'],
    			'precio_mas_5' => $row['precio_mas_5'],
    		);
    		if(!$this->model_producto->m_registrar_producto_precio($data)){
	    			$error = TRUE;
	    		}
    	}
    	foreach ($allInputs['premium'] as $row) {
    		$data = array(
    			'idproductomaster' => $row['idproductomaster'],
    			'categoria' => $row['categoria'],
    			'idmedida' => $row['idmedida'],
    			'precio_unitario' => $row['precio_unitario'],
    			'precio_2_5' => $row['precio_2_5'],
    			'precio_mas_5' => $row['precio_mas_5'],
    		);
    		if(!$this->model_producto->m_registrar_producto_precio($data)){
	    			$error = TRUE;
	    		}
    	}
    	if(!$error){
    		$arrData['message'] = 'Se registraron los datos correctamente';
    		$arrData['flag'] = 1;
    	}

    	$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
}