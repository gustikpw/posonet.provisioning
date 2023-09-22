<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wa_notif_model extends CI_Model
{

  var $table = 'paket';
  var $column = array('id_paket', 'nama_paket', 'speed_max', 'tarif', 'keterangan');
  var $order = array('id_paket' => 'DESC');

  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function get_pelanggan()
  {
    return $this->db->query("SELECT id_pelanggan,no_pelanggan,nama_pelanggan,nama_paket,tarif,telp,(tarif+no_pelanggan) AS total,kode_wilayah
FROM v_pelanggan
WHERE	telp !=''
ORDER BY no_pelanggan ASC")->result();
  }
}
