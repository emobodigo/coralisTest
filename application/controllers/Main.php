<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('email')) {
			$this->session->set_flashdata('mssg', '<div class="session-gagal"><p>Anda harus login terlebih dahulu</p></div>');
			redirect('authentication');
		}
	}

	public function index()
	{
		$data['home'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('layout/header');
		$this->load->view('main/home', $data);
		$this->load->view('layout/footer');
	}
}
