<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'vendor/autoload.php';

use Telegram\Bot\Api as Bot;

class Api_telegrambot_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
		$this->load->helper(array('MY_ribuan', 'MY_bulan'));


        $this->bot = $this->config->item('telegram_bot');

        $this->url = $this->bot['BASE_URL']. $this->bot['TOKEN'];
        

        $this->telegram = new Bot($this->bot['TOKEN']);

    }

    public function getUpdates(){
        $response = $this->telegram->getUpdate();

        // $botId = $response->getId();
        // $firstName = $response->getFirstName();
        // $username = $response->getUsername();

        return $response;
    }


    public function sendMessages(){
        $keyboard = [
            ['7', '8', '9'],
            ['4', '5', '6'],
            ['1', '2', '3'],
                ['0']
        ];

        $reply_markup = $this->telegram->replyKeyboardMarkup([
            'keyboard' => $keyboard, 
            'resize_keyboard' => true, 
            'one_time_keyboard' => true
        ]);

        $response = $this->telegram->sendMessage([
            'chat_id' => $this->bot['CHAT_ID_ADMIN'], 
            'text' => 'Hello World', 
            'reply_markup' => $reply_markup
        ]);

        $messageId = $response->getMessageId();
    }
    
    public function sendMessage(){

        $message = "\xF0\x9F\x9A\xA8 *LOS*\nName : %s\nLocation : %s\n\nHP : %s\nONT Phase : LOS/DyingGasp";
        $dt = sprintf($message,'Agus', 'https://maps.app.goo.gl/bYdqxJmzGSJzz12h6', '085320435480');
        $data = [
            'chat_id'       => $this->bot['CHAT_ID_GROUP'],
            'text'          => $dt,
            'parse_mode'    => 'markdown'
        ];

        $response = $this->telegram->sendMessage($data);


        // $response = file_get_contents(
        //     $this->url."/sendMessage?" .
        //     http_build_query($data)
        // );

        return $response;
    }


    public function sendToGroup($ticket){
        $data = [
            'chat_id'       => $this->bot['CHAT_ID_GROUP'],
            'text'          => $ticket,
            'parse_mode'    => 'markdown'
        ];

        return $this->telegram->sendMessage($data);
    }

    public function sendToAdmin($msg){
        $data = [
            'chat_id'       => $this->bot['CHAT_ID_ADMIN'],
            'text'          => $msg,
            'parse_mode'    => 'markdown'
        ];

        return $this->telegram->sendMessage($data);
    }

    public function sendNewClientToAdmin($data){

        $tmp = "*Terima kasih telah berlangganan POSONET*.\n
Berikut data registrasi Anda.

Nomor Pelanggan : *%s*
Nama Pelanggan : *%s*
HP/WA : *%s*
Tgl Instalasi : %s
Paket Aktif : %s
Harga Paket : %s/bulan
Masa berakhir paket : %s

Pembayaran berikutnya jika melalui transfer = %s";

        $query = "SELECT nama_paket,tarif FROM paket WHERE id_paket=".$data['id_paket'];
        $paket = $this->db->query($query)->row();

        $msg = sprintf($tmp, 
            $data['no_pelanggan'], 
            $data['nama_pelanggan'], 
            $data['telp'],
            $data['tgl_instalasi'],
            $paket->nama_paket,
            ribuan($paket->tarif),
            tgl_lokal($data['expired']),
            ribuan($paket->tarif + $data['no_pelanggan']),
        );

        $data = [
            'chat_id'       => $this->bot['CHAT_ID_ADMIN'],
            'text'          => $msg,
            'parse_mode'    => 'markdown'
        ];

        return $this->telegram->sendMessage($data);
    }

    public function templateMessages($mode){
        $extend = "\xF0\x9F\x95\x93 *Extend Paket*\nName : {}\nExpired at: {}\nProfile : {}";
        $los = "\xF0\x9F\x94\xB4 \xF0\x9F\x86\x98 *LOS*\nName : {}\nLocation : {}\nHP : {}";
    }
    

}