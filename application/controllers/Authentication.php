<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authentication extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('MUsers');
		$this->load->model('MUToken');
	}

	public function index()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|trim', [
			'required' => 'Email tidak boleh kosong',
		]);
		$this->form_validation->set_rules('password', 'Password', 'required|trim', [
			'required' => 'Masukkan password'
		]);

		if ($this->form_validation->run() == false) {
			$this->load->view('layout/header');
			$this->load->view('auth/login');
			$this->load->view('layout/footer');
		} else {
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			$user = $this->db->get_where('users', ['email' => $email])->row_array();
			if ($user) {
				if ($user['is_active'] == 1) {
					if (password_verify($password, $user['password'])) {
						$data = [
							'nama' => $user['name'],
							'email' => $user['email']
						];

						$this->session->set_userdata($data);
						redirect('main');
					} else {
						$this->session->set_flashdata('mssg', '<div class="session-gagal"><p>Email dan Password tidak sesuai</p></div>');
						redirect('authentication');
					}
				} else {
					$this->session->set_flashdata('mssg', '<div class="session-gagal"><p>Akun anda belum diaktivasi!</p></div>');
					redirect('authentication');
				}
			} else {
				$this->session->set_flashdata('mssg', '<div class="session-gagal"><p>Email belum terdaftar!</p></div>');
				redirect('authentication');
			}
		}
	}

	public function register()
	{
		$this->form_validation->set_rules('nama', 'Nama', 'required|trim', [
			'required' => 'Nama tidak boleh kosong'
		]);
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]|trim|valid_email', [
			'required' => 'Email tidak boleh kosong',
			'is_unique' => 'Email anda sudah terdaftar',
			'valid_email' => 'Masukkan email yang valid'
		]);
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[kpassword]|trim', [
			'required' => 'Masukkan password',
			'min_length' => 'Password setidaknya 6 karakter',
			'matches' => 'Password tidak cocok',
		]);
		$this->form_validation->set_rules('kpassword', 'Password', 'required|matches[password]|trim');

		if ($this->form_validation->run() == false) {
			$this->load->view('layout/header');
			$this->load->view('auth/register');
			$this->load->view('layout/footer');
		} else {
			$data = [
				'name' => htmlspecialchars($this->input->post('nama', true)),
				'email' => htmlspecialchars($this->input->post('email', true)),
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'is_active' => 0,
				'created_at' => time(),
			];

			$token = base64_encode(random_bytes(20));
			$utoken = [
				'email' => $this->input->post('email', true),
				'token' => $token,
			];

			$this->MUsers->daftar($data);
			$this->MUToken->tokenizer($utoken);
			$this->_emailFUnction($token, 'activation');
			$this->session->set_flashdata('mssg', '<div class="session-sukses"><p>Selamat, akun terdaftar silahkan aktivasi melalui email!</p></div>');
			redirect('authentication');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('nama');
		redirect('authentication');
	}

	private function _emailFunction($token, $type)
	{
		$config = [
			'protocol' => 'smtp',
			'mailtype' => 'html',
			'newline' => "\r\n",
			'charset' => 'utf-8',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_user' => 'webmanager069@gmail.com',
			'smtp_pass' => 'Kampung1',
			'smtp_port' => 465,
		];

		$this->email->initialize($config);
		$this->email->from('webmanager069@gmail.com', 'Coralis Test');
		$this->email->to($this->input->post('email'));
		if ($type == 'activation') {
			$this->email->subject('Coralis Test Email Activation');
			$this->email->message('Klik link ini untuk aktivasi akun : <a href="' . base_url() . 'authentication/activation?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Aktivasi</a>');
		} else if ($type == 'forget') {
			$this->email->subject('Reset Password');
			$this->email->message('Klik link ini untuk reset Password : <a href="' . base_url() . 'authentication/reset?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
		}
		$this->email->send();
	}

	public function activation()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('users', ['email' => $email])->row_array();

		if ($user) {
			$tokenUser = $this->db->get_where('u_token', ['token' => $token]);
			if ($tokenUser) {
				$this->MUsers->updateActivation($email);
				$this->MUToken->deleteToken($email);
				$this->session->set_flashdata('mssg', '<div class="session-sukses"><p>Akun sudah aktif, silahkan login!</p></div>');
				redirect('authentication');
			} else {
				$this->session->set_flashdata('mssg', '<div class="session-gagal"><p>Aktivasi gagal, token anda salah!</p></div>');
				redirect('authentication');
			}
		} else {
			$this->session->set_flashdata('mssg', '<div class="session-gagal"><p>Aktivasi gagal, email anda salah!</p></div>');
			redirect('authentication');
		}
	}

	public function forgetPasswordView()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		if ($this->form_validation->run() == false) {
			$this->load->view('layout/header');
			$this->load->view('auth/forgetPassword');
			$this->load->view('layout/footer');
		} else {
			$email = $this->input->post('email');
			$cekuser = $this->db->get_where('users', ['email' => $email, 'is_active' => 1])->row_array();

			if ($cekuser) {

				$token = base64_encode(random_bytes(20));
				$utoken = [
					'email' => $this->input->post('email', true),
					'token' => $token,
				];
				$this->MUToken->tokenizer($utoken);
				$this->_emailFunction($token, 'forget');
				$this->session->set_flashdata('mssg', '<div class="session-sukses"><p>Cek email anda untuk reset password</p></div>');
				redirect('authentication/forgetPasswordView');
			} else {
				$this->session->set_flashdata('mssg', '<div class="session-gagal"><p>Email belum terdaftar, silahkan registrasi</p></div>');
				redirect('authentication/forgetPasswordView');
			}
		}
	}

	public function reset()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');
		$user = $this->db->get_where('users', ['email' => $email])->row_array();

		if ($user) {
			$uToken = $this->db->get_where('u_token', ['token' => $token]);
			if ($uToken) {
				$this->session->set_userdata('passReset', $email);
				$this->viewForPasswordChange();
			} else {
				$this->session->set_flashdata('mssg', '<div class="session-gagal"><p>Reset password gagal, token salah!</p></div>');
				redirect('authentication');
			}
		} else {
			$this->session->set_flashdata('mssg', '<div class="session-gagal"><p>Reset password gagal, email anda salah</p></div>');
			redirect('authentication');
		}
	}

	public function viewForPasswordChange()
	{
		if (!$this->session->userdata('passReset')) {
			redirect('authentication');
		}

		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[kpassword]|trim', [
			'required' => 'Masukkan password',
			'min_length' => 'Password setidaknya 6 karakter',
			'matches' => 'Password tidak cocok',
		]);
		$this->form_validation->set_rules('kpassword', 'Password', 'required|matches[password]|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('layout/header');
			$this->load->view('auth/changePassword');
			$this->load->view('layout/footer');
		} else {
			$password = $this->input->post('password');
			$email = $this->session->userdata('passReset');
			$pass = password_hash($password, PASSWORD_DEFAULT);
			$this->MUsers->updatePassword($pass, $email);

			$this->session->unset_userdata('passReset');
			$this->session->set_flashdata('mssg', '<div class="session-sukses"><p>Password berhasil diubah, silahkan Login!</p></div>');
			redirect('authentication');
		}
	}
}
