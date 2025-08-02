<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load models, helpers, libraries as needed
        // $this->load->model('Your_model');
        $this->load->helper(array('MY_auth_bearer'));

        $this->api = $this->config->item('public_api');
        // get_auth_bearer();
    }



    public function index()
    {
        // Default endpoint
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'API Controller is working']));
    }

    public function getInvoice()
    {
        // activate the following line if you need to check authentication
        // get_auth_bearer();

        // Get query parameter 'no_internet'
        $noInternet = $this->input->get('no_internet');

        // Prepare response
        $data = $this->db->query("SELECT v.no_pelanggan, v.nama_pelanggan, v.wilayah, v.nama_paket,v.tarif,(v.tarif + v.no_pelanggan) AS trx_amount, 
v.expired AS expired_date,t.expired AS next_expired,
IF(v.expired < CURDATE(),'ISOLIR','AKTIF') AS status_berlangganan, 
v.telp , 
IF(v.expired>=CURDATE(), 'BELUM ADA TAGIHAN/LUNAS', 'BELUM BAYAR') AS payment_status, 
t.kode_invoice

FROM v_pelanggan v 
LEFT JOIN temp_invoice t 
ON v.no_pelanggan=t.no_pelanggan
WHERE v.no_pelanggan=?
ORDER BY id_trx DESC
LIMIT 1", [$noInternet]);

        if ($data->num_rows() > 0) {
            $res = array(
                'data' => $data->row(),
                'status' => true,
                'message' => 'Invoice found(s)',
            );
        } else {
            $res = array(
                'data' => null,
                'status' => false,
                'message' => 'No invoice found(s)',
            );
        }

        $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($res));
    }

}