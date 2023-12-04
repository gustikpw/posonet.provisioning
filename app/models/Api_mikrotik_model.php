<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'vendor/autoload.php';

use GuzzleHttp\Client as GClient;

use \RouterOS\Client as RClient;
use \RouterOS\Query;


class Api_mikrotik_model extends CI_Model
{

  private $_client;
  private $_clientMtik;

  function __construct()
  {
    parent::__construct();
    $this->load->database();

    $this->_client = new GClient([
      'base_uri' => 'http://127.0.0.1:5000/v1/'
    ]);

// MIKROTIK
    $this->mikrotik = $this->config->item('mikrotik');

    $this->_mikrotik = new \RouterOS\Config([
      'host' => $this->mikrotik['HOST'],
      'user' => $this->mikrotik['USERNAME'],
      'pass' => $this->mikrotik['PASSWORD'],
      'port' => $this->mikrotik['PORT'],
    ]);

    $this->_clientMtik = new RClient($this->_mikrotik);

  }

  public function close_connection_ppp($username = false)
  {
    // $client = new RClient($this->_mikrotik);
    //get by name for return .id
    $query = (new Query('/ppp/active/print',))
            ->where('name', $username);
    $res = $this->_clientMtik->query($query)->read();
    
    if ($res != null) {
      $query2 = (new Query('/ppp/active/remove',))
      ->equal('.id', $res[0]['.id']);
      $result = $this->_clientMtik->query($query2)->read();
    }
    // /ppp active remove numbers=[/ppp active find where name=PAPA-ENJELC91C27BD]
    return $res;
  }

  public function change_ppp_secret_profile($username = false, $paket)
  {
    //get by name for return .id
    $query = (new Query('/ppp/secret/print',))
    ->where('name', $username);
    $res = $this->_clientMtik->query($query)->read();
    //
    $query2 = (new Query('/ppp/secret/set',))
    ->equal('.id', $res[0]['.id'])
    ->equal('profile', $paket);
    $this->_clientMtik->query($query2)->read();

    return $res;
  }


  public function get_ppp_secret(){
    $query = new Query('/ppp/secret/print');
    return $this->_clientMtik->query($query)->read();
  }

  public function create_ppp_secret($username, $password, $service, $profile){
    $query = new Query('/ppp/secret/add');
    $query->equal('name', $username);
    $query->equal('password', $password);
    $query->equal('service', $service);
    $query->equal('profile', $profile);


    return $this->_clientMtik->query($query)->read();
  }

  public function remove_secret($username){
    //get by name for return .id
    $query = (new Query('/ppp/secret/print',))
      ->where('name', $username);
    $res = $this->_clientMtik->query($query)->read();

    $remove = (new Query('/ppp/secret/remove',))
      ->equal('.id', $res[0]['.id']);
    $rem = $this->_clientMtik->query($remove)->read();

    return $rem;
  }

  public function match_paket(){
    /***
     * apabila paket ppp secret mikrotik tidak sama dengan yang ada di database. 
     * maka ubah ppp secret dengan yang di database
     * kemudian close connection
     */
    $no = 0;
    $changedProfile = '';
    $secretMtik = $this->get_ppp_secret();

    foreach ($secretMtik as $d) {
      $name = $this->db->escape($d['name']);
      $cekdb = $this->db->query("SELECT id_pelanggan, username, mikrotik_profile, status_berlangganan FROM v_pelanggan WHERE username=$name");
      
      // jika name sama maka cek profile
      if ($cekdb->num_rows() > 0 ){
        $data = $cekdb->row();

        if ($data->status_berlangganan == 'Expired' && $d['profile'] != 'Expired') {
          // set to Expired
          $this->change_ppp_secret_profile($name, 'Expired');
          // close connection ppp
          $this->close_connection_ppp($name);
          
          $changedProfile .= "$name, ";
          $no++;
        } elseif ($data->status_berlangganan == 'Active' && $d['profile'] != $data->mikrotik_profile) {
          $this->change_ppp_secret_profile($name, $data->mikrotik_profile);
          
          $changedProfile .= "$name, ";
          $no++;
        } else {
          // nothing changed!
        }
      }
    }
    return "$no Profile changed! [$changedProfile]";
  }

  // public function setProfileExpire()
  // {
  //   $query = $this->db->query("SELECT * FROM v_expired")->result();
  //   $no = 0;
  //   $no2 = 0;
  //   foreach ($query as $cust) {
  //     $this->change_ppp_secret_profile($cust->username,'Expired');
  //     $no++;
  //   }
  //   foreach ($query as $cust) {
  //     $this->close_connection_ppp($cust->username);
  //     $no2++;
  //   }
  //   return ['message'=>"$no Client(s) set to Expire! and $no2 disconnected."];
  // }



}
