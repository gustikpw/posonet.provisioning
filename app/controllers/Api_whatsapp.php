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

	public function info()
	{
		// $data = (object) ['no_pelanggan' => '250'];
		$data = json_decode(file_get_contents('php://input'));

		//cek db by no pelanggan
		$res = $this->db->query("SELECT * FROM v_pelanggan WHERE no_pelanggan='$data->no_pelanggan'");
		$d = $res->row();

		if ($res->num_rows() > 0) {
			//cek gpon_onu_detail
			$detail = $this->api->raw_detailinfo($d->gpon_onu)['results'];
			$att = $this->api->raw_attenuation($d->gpon_onu);
			$wanip = $this->api->raw_wanip($d->gpon_onu);

	
			$phase = array('DyingGasp','working','LOS','logging','syncMib','offline');
			$icon = array('🆙','⏰','❌','✔️','📌');

			if ($detail['phase_state'] == 'LOS' || $detail['phase_state'] == 'logging' || $detail['phase_state'] == 'syncMib') {
				$state = "*$detail[phase_state]* ❌";
			} else {
				$state = "*$detail[phase_state]*";
			}

			$reply = "📋 *ONU Information*
	
Interface	: $detail[onu_interface]
Name		: *$detail[Name]*
Type		: $detail[Type]
SN			: $detail[SerialNumber]
Distance	: $detail[ONUDistance]
Phase State	: $state
Online Duration: $detail[online_duration]

OLT Rx		: $att[rx_olt] dBm
ONU Rx		: *$att[rx_onu] dBm*
WAN IP		: *$wanip[current_ip]*
";
	
			echo json_encode($reply);
			
		} else {
			
		}
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
