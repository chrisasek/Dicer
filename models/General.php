<?php
class General
{
	private $_db, $_data, $_table = 'constants';

	function __construct($data)
	{
		$this->_db = DB::getInstance();
		$this->_table = $data;
	}

	public function find($id)
	{
		$data = $this->_db->get($this->_table, array('id', '=', $id));
		if ($data->count()) {
			$this->_data = $data->first();
			return $this;
		}
		return false;
	}

	public function create($fields = array())
	{
		if (!$this->_db->insert($this->_table, $fields)) {
			throw new Exception('There was a problem creating an account.');
		}
	}

	public function update($fields = array(), $id, $keyfield = 'id')
	{
		if (!$this->_db->update($this->_table, $id, $fields, $keyfield)) {
			throw new Exception('There was a problem updating...');
		}
	}

	public function remove($id, $field = 'id')
	{
		$result = $this->_db->delete($this->_table, array($field, '=', $id));
		if ($result) {
			return true;
		}
		return false;
	}



	public function getAll($val = '0', $field = 'id', $check = '>')
	{
		$text = $this->_db->get($this->_table, array($field, $check, $val));
		if ($text) {
			return $text->results();
		}
		return false;
	}

	public function get($val, $field = 'id', $check = '=')
	{
		$text = $this->_db->get($this->_table, array($field, $check, $val));
		if ($text && $text->count()) {
			return $text->first();
		}
		return false;
	}

	public function getter($value, $field = 'id', $comp = "=", $all = true, $table = null)
	{
		$table = $table ? $table : $this->_table;
		if (!$this->_db->query("SELECT * FROM $table WHERE {$field} {$comp} ? ", array($value))->error()) {
			return $all ? $this->_db->results() : $this->_db->results()[0];
		}
		return false;
	}

	public function getRand($val, $field = 'id', $check = '=', $no_rand = 1)
	{
		$text = $this->_db->get($this->_table, array($field, $check, $val));
		if ($text && $text->count()) {
			return $text->random($no_rand);
		}
		return false;
	}

	public function getAllOrderBy($value = 0, $field = 'id', $comp = '>', $by = 'id', $order = 'ASC')
	{
		if (!$this->_db->query("SELECT * FROM {$this->_table} WHERE {$field} {$comp} ? ORDER BY {$by} {$order}", array($value))->error()) {
			return $this->_db->results();
		}
		return false;
	}

	public function getAllWhere($where = "id > 0", $order = 'id ASC', $limit = null)
	{
		if (!$this->_db->query("SELECT * FROM {$this->_table} WHERE ? ORDER BY {$order} {$limit}", array($where))->error()) {
			return $this->_db->results();
		}
		return false;
	}

	public function getAllByUser($value, $field = 'id', $user_id)
	{
		if (!$this->_db->query("SELECT * FROM {$this->_table} WHERE user_id = ? AND {$field} = ? ", array($user_id, $value))->error()) {
			return $this->_db->results();
		}
		return false;
	}

	public function getAllCount($value, $field = 'id', $limit = 3, $except_id = 0)
	{
		if (!$this->_db->query("SELECT * FROM {$this->_table} WHERE  {$field} = ? AND id <> {$except_id} LIMIT {$limit}", array($value))->error()) {
			return $this->_db->results();
		}
		return false;
	}

	public function getLatest($limit = 3)
	{
		if (!$this->_db->query("SELECT * FROM {$this->_table} WHERE  id > 0 LIMIT ? ORDER by date_added", array($limit))->error()) {
			return $this->_db->results();
		}
		return false;
	}

	public function getByUser($value, $field = 'id', $user_id)
	{
		if (!$this->_db->query("SELECT * FROM {$this->_table} WHERE user_id = ? AND {$field} = ? ", array($user_id, $value))->error()) {
			return $this->_db->first();
		}
		return false;
	}

	public function getCountByUser($value, $field = 'id', $user_id)
	{
		if (!$this->_db->query("SELECT * FROM {$this->_table} WHERE user_id = ? AND {$field} = ? ", array($user_id, $value))->error()) {
			return $this->_db->count();
		}
		return false;
	}

	public function getCount($value, $field = 'id', $status = "")
	{
		if (!$this->_db->query("SELECT * FROM {$this->_table} WHERE {$field} = ? {$status}", array($value))->error()) {
			return $this->_db->count();
		}
		return false;
	}

	public function getPages($per_page, $off_set, $where = null, $order = "ORDER BY id DESC")
	{
		return $this->_db->getPerPage($per_page, $off_set, $this->_table, $where, $order);
	}

	public function data()
	{
		return $this->_data;
	}
}
