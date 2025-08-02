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

    public function updateInvoiceStatus(){
        $noInternet = $this->input->post('no_internet');
        $kodeInvoice = $this->input->post('kode_invoice');
        $status = ($this->input->post('status') == 'settlement') ? 'LUNAS' : 'BELUM BAYAR';
        $orderId = $this->input->post('order_id');

        // Validate input
        if (empty($noInternet) || empty($kodeInvoice) || empty($status) || empty($orderId)) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'message' => 'Invalid input']));
            return;
        }
        // Call the model method to update invoice status
        try {
            $cek = $this->db->query("SELECT * FROM temp_invoice WHERE order_id = ?", [$order_id]);
            if ($cek->num_rows() > 0) {
                $this->db->query("UPDATE temp_invoice SET status = ?, transaction_status = ? WHERE order_id = ?", [$order_id, $this->input->post('status')]);
                // Update the order_id in the database
                $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['status' => true, 'message' => 'Invoice status updated successfully']));
                return;
            } else {
                $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['status' => false, 'message' => 'Invoice not found']));
                return;
            }
        } catch (Exception $e) {
            $res = array(
                'status' => false,
                'message' => 'Error updating invoice status: ' . $e->getMessage(),
            );
        }

    }

    public function updateInvoiceOrderId(){
        $kodeInvoice = $this->input->post('kode_invoice');
        $orderId = $this->input->post('order_id');

        // Validate input
        if (empty($kodeInvoice) || empty($orderId)) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode((object) ['status' => false, 'message' => 'Invalid input']));
            return;
        }
        // Call the model method to update invoice status
        try {
            $cek = $this->db->query("SELECT * FROM temp_invoice WHERE kode_invoice = ?", [$kodeInvoice]);
            if ($cek->num_rows() > 0) {
                $this->db->query("UPDATE temp_invoice SET order_id = ? WHERE kode_invoice = ?", [$order_id, $kodeInvoice]);
                // Update the order_id in the database
                $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['status' => true, 'message' => 'Invoice Order_ID updated successfully']));
                return;
            } else {
                $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['status' => false, 'message' => 'Invoice not found']));
                return;
            }
        } catch (Exception $e) {
            $res = array(
                'status' => false,
                'message' => 'Error updating invoice status: ' . $e->getMessage(),
            );
            $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($res));
            return;
        }

    }

}