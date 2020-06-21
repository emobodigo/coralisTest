<?php
class MUsers extends CI_Model
{
	public $table = 'users';

	public function daftar($data)
	{
		$this->db->insert($this->table, $data);
	}


	public function updateActivation($data)
	{
		$this->db->set('is_active', 1);
		$this->db->where('email', $data);
		$this->db->update($this->table);
	}

	public function updatePassword($pass, $email)
	{
		$this->db->set('password', $pass);
		$this->db->where('email', $email);
		$this->db->update($this->table);
	}
}
