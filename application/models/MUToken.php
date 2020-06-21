<?php
class MUToken extends CI_Model
{
	public $table = 'u_token';

	public function tokenizer($data)
	{
		$this->db->insert($this->table, $data);
	}


	public function deleteToken($data)
	{
		$this->db->delete($this->table, ['email' => $data]);
	}
}
