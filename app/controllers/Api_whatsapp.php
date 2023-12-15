<?php defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Makassar");

require 'vendor/autoload.php';

use GuzzleHttp\Client;

class Api_whatsapp extends CI_Controller
{

	private $_client;

	function __construct()
	{
		parent::__construct();
		
		$this->olt = $this->config->item('olt');

		$this->_client = new Client([
			'base_uri' => $this->olt['BASE_URI']
		]);

		$this->load->model('api_rest_client_model', 'api');
		$this->load->model('api_mikrotik_model', 'routermodel');
		$this->load->model('api_kirimwaid_model', 'kirimwa');
		$this->load->model('api_telegrambot_model', 'telegrambot');
		$this->load->helper(array('MY_ribuan', 'MY_bulan'));
	}

	public function index()
	{
		set_status_header(401);
	}

	public function get_info()
	{
		// $nopel = $this->input->post('nopel');
		echo json_encode("dari server web");
	}
	
	public function reply()
	{
		$nopel = $this->input->post('username');
		$sn = $this->input->post('email');
		echo json_encode("dari server web $nopel dan $sn");
	}



	public function nodewa(){
		$this->load->model('Api_whatsapp_model','nodewa');
		$data = "⏰ Perubahan Masa aktif Paket
Name : 112. DIDIK SETYADI
Profile : UPTO-15M
Expired to : 2023-11-20
Tgl Input : 2023-10-19 08:49:08";
		echo json_encode($this->nodewa->sendWa($data));
	}

	public function testnodewa(){
		// $this->load->model('Api_whatsapp_model','nodewa');
		$data = "⏰ Perubahan Masa aktif Paket
Name : 112. DIDIK SETYADI
Profile : UPTO-15M
Expired to : 2023-11-20
Tgl Input : 2023-10-19 08:49:08";
		echo json_encode($data);
	}

	

}
