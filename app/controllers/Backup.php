<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use Ifsnop\Mysqldump as IMysqldump;

class Backup extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!is_logged_in()) {
			redirect('login?_rdr=' . urlencode(current_url()));
		}
		date_default_timezone_set('Asia/Makassar');
		$this->load->helper(array('MY_ribuan'));
	}

	public function index()
	{
		set_status_header(401);
	}

	public function backup()
	{
		$host = $this->db->hostname;;
		$user = $this->db->username;
		$pass = $this->db->password;
		$db = $this->db->database;

		$path = FCPATH . "assets/backup/";
		if (!is_dir($path)) {
			mkdir(FCPATH . 'assets/backup/', 0777, true);
		}

		$filename = "backup#$db#" . date('Y-m-d#H_i_s') . ".sql";

		try {
			$dump = new IMysqldump\Mysqldump("mysql:host=$host;dbname=$db", "$user", "$pass");
			$dump->start("$path$filename");
			echo json_encode([
				'status' => true,
				'message' => 'Database berhasil dibackup!',
				'path' => base_url() . $path . $filename
			]);
		} catch (\Throwable $e) {
			// echo 'mysqldump-php error: ' . $e->getMessage();
			echo json_encode([
				'status' => true,
				'message' => 'mysqldump-php error: ' . $e->getMessage(),
			]);
		}
	}

	public function listfiles()
	{
		$this->load->helper('MY_bulan');

		$pathFolder = FCPATH . "assets/backup/";
		if (!is_dir($pathFolder)) {
			mkdir(FCPATH . 'assets/backup/', 0777, true);
		}

		$asd = scandir(FCPATH . 'assets/backup/');
		$length = count($asd);
		$data = array();
		$status = FALSE;
		for ($i = 2; $i < $length; $i++) {
			$row = array();
			$fileurl = base_url('assets/backup/') . urlencode($asd[$i]);
			$imageFileType = pathinfo($fileurl, PATHINFO_EXTENSION);
			if ($imageFileType == 'sql') {
				$status = TRUE;
				$dd = explode("#", $asd[$i]);
				$time = str_replace('.sql', '', $dd[3]);
				$row[] = $dd[1];
				$row[] = bulan_tahun($dd[2]);
				$row[] = $dd[2] . ' ' . $time;
				$row[] = ribuan(filesize(FCPATH . 'assets/backup/' . $asd[$i])) . ' bytes';
				$row[] = "	<a class=\"btn btn-xs btn-info\" href=\"$fileurl\" target=\"_blank\"><i class=\"fa fa-eye\"></i> View</a>
									<a class=\"btn btn-xs btn-primary\" href=\"$fileurl\"><i class=\"fa fa-download\"></i> Download</a>";
				// <a class=\"btn btn-xs btn-danger\"  href=\"javascript:void(0)\" title=\"Hapus Kwitansi\" onclick=\"hapusFile('".$asd[$i]."')\"><i class=\"fa fa-trash\"></i> Delete</a>";
			} else {
				$status = FALSE;
			}

			if ($status == TRUE) {
				$data[] = $row;
			}
		}

		$output = array('data' => $data,);
		echo json_encode($output);
	}
}
