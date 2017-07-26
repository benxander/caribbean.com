<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registro extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index()
	{
		$this->load->view('partials/registro_view');
	}
	public function crear_usuario(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		// $user_data = $this->input->post();
		$allInputs['user_password'] = sha1($allInputs['user_password']);
		$arrData['message'] = 'Falló el registro inténtelo nuevamente';
    	$arrData['flag'] = 0;
		if ($this->user_model->m_registrar_usuario($allInputs) === true) {
			$arrData['message'] = 'Registro exitoso!!!';
    		$arrData['flag'] = 1;
		}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function facebook(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$facebook_app_id = '197123207485024';
		$facebook_app_secret = 'd0727fe35bdd54585fd8bf24f5ec7b4c';
		// var_dump($allInputs); exit();
		date_default_timezone_set('UTC');
		$fbApp = new Facebook\FacebookApp($facebook_app_id, $facebook_app_secret);
		$signedRequest = new Facebook\SignedRequest($fbApp, $allInputs['signedRequest']);
		$fb = new Facebook\Facebook([
			'app_id' => $facebook_app_id,
			'app_secret' => $facebook_app_secret,
			'default_graph_version' => 'v2.8',
		]);
		$helper = $fb->getJavaScriptHelper();

		try {
			$accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			$arrData['message'] = 'Graph returned an error: ' . $e->getMessage();
	    	$arrData['flag'] = 0;
			$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			$arrData['message'] = 'Facebook SDK returned an error: ' . $e->getMessage();
	    	$arrData['flag'] = 0;
			$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
		}
		if (! isset($accessToken)) {
			$arrData['message'] = 'No cookie set or no Auth data could be obtained from cookie.';
	    	$arrData['flag'] = 0;
			$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
		}
		try {
			$response = $fb->get('/me?fields=id,name,email,friends,first_name,last_name,age_range,link,gender,locale,picture,timezone,updated_time,verified', (string) $accessToken);
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			$arrData['message'] = 'Graph returned an error: ' . $e->getMessage();
	    	$arrData['flag'] = 0;
			$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			$arrData['message'] = 'Facebook SDK returned an error: ' . $e->getMessage();
	    	$arrData['flag'] = 0;
			$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
		}
		$user = $response->getGraphUser();
		$fb->setDefaultAccessToken($accessToken);
		$sess = array(
			'user_name' => $user['name'],
			'user_email' => $user['email'],
			'user_profile_pic' => $user['picture']['url'],
			'user_gender' => $user['gender'],
			'user_language' => $user['locale'],
			'user_social_id' => (int) $user['id'],
			'user_timezone' => $user['timezone'],
			'user_login_type' => 'facebook',
			);
		if ($this->user_model->m_verificar_usuario_social_existe($user['id']) === 0) {
			$this->user_model->m_registrar_usuario($sess);
			$arrData['message'] = 'Registro exitoso!!';
		}else{
			$arrData['message'] = 'Login exitoso!!';
		}
		$sess['fb_access_token'] = (string) $accessToken;
		$this->session->set_userdata( $sess );
    	$arrData['flag'] = 1;
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}


}

/* End of file Registro.php */
/* Location: ./application/controllers/Registro.php */