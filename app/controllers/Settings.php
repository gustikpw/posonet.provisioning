<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Settings extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!is_logged_in()) {
			redirect('login?_rdr='.urlencode(current_url()));
		}
		$this->load->model('users_model','users');
	}

	public function index()
	{
		set_status_header(401);
	}

	public function save_rekening(){
		if ($this->input->post('bank') == 'BRI') {
			$data = array(
				array(
					'option_id' => 20,
					'option_value' => $this->input->post('bank'),
				),
				array(
					'option_id' => 21,
					'option_value' => $this->input->post('norek'),
				),
				array(
					'option_id' => 22,
					'option_value' => $this->input->post('nama_pemilik_pekening'),
				)
			);

			$this->db->update_batch('settings', $data, 'option_id'); 

			echo json_encode([
				"status" => true,
				"message" => "Berhasil update rekening!",
			]);
		}
	}

	public function get_rekening(){
		$query = $this->db->query("SELECT * FROM settings where option_name LIKE 'bri_%'")->result();
		$data = array();

		foreach ($query as $key) {
			$row[] = $key->option_value;
		}

		echo json_encode($row);
	}

	/**
	 * Users Access
	 * Create privillege login access
	 * */ 

	public function ajax_list() {
		$list = $this->users->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $br) {
			$no++;
			$row = array();
			$row[] = $br->id_users;
			$row[] = "<span class='font-bold'>$br->username</span>";
			$row[] = "<span class='font-bold'>$br->level</span>";
			$row[] = $br->aktif;
			$row[] = "<div class=\"btn-group\">
								<button data-toggle=\"dropdown\" class=\"btn btn-default btn-xs dropdown-toggle\" aria-expanded=\"false\">Action <span class=\"caret\"></span></button>
								<ul class=\"dropdown-menu\">
									<li><a href=\"javascript:void(0)\" onclick=\"edits('$br->id_users')\"><i class=\"glyphicon glyphicon-pencil\"></i> Edit</a></li>
									<li><a href=\"javascript:void(0)\" onclick=\"deletes('$br->id_users')\"><i class=\"glyphicon glyphicon-trash\"></i> Hapus</a></li>
								</ul>
							</div>";
			$data[] = $row;
		}

		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->users->count_all(),
				"recordsFiltered" => $this->users->count_filtered(),
				"data" => $data,
		);
		echo json_encode($output);
	}

	public function save_users()
	{
		$data = array(
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'id_karyawan' => $this->input->post('id_karyawan'),
			'level' => $this->input->post('level'),
			'aktif' => $this->input->post('aktif'),
			'rules' => 'webapp',
		);
		$insert = $this->users->save($data);
		echo json_encode(array("status" => TRUE, "message" => "Berhasil menambah User"));
	}

	public function update_paket()
	{
		$this->_validate();
		$data = array(
			'nama_paket' => $this->input->post('nama_paket'),
			'mikrotik_profile' => $this->input->post('mikrotik_profile'),
			// 'speed_max' => $this->input->post('speed_max'),
			'tarif' => $this->input->post('tarif'),
			'keterangan' => $this->input->post('keterangan'),
		);
		$this->users->update(array('id_users' => $this->input->post('id_users')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function delete_paket($id_users)
	{
		$this->users->delete_by_id($id_users);
		echo json_encode(array("status" => TRUE));
	}

	public function get_edit($id_users=FALSE)
	{
		$data= $this->users->get_by_id($id_users);
		echo json_encode($data);
	}

}
