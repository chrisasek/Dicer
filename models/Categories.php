<?php
class Categories {
	private $_db,
			$_data,
			$_table = 'categories';
			
	
	public function __construct(){
		$this->_db = DB::getInstance();
	}
	
	public function update($fields = array(), $id){
		if(!$this->_db->update($this->_table, $id, $fields)){
			throw new Exception('There was a problem updating...');
		}
	}
	
	public function create($fields = array()){
		if(!$this->_db->insert($this->_table, $fields)){
			throw new Exception('There was a problem creating an account.');
		}
	}
	public function find($id){
			$data = $this->_db->get($this->_table, array('id', '=', $id));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		
		return false;
	} 
	
	public function getAllCategories(){
		$data = $this->_db->get($this->_table, array('id', '>', 0));
			if($data->count()){
				return $data->results();
			}
		return false;
	}
	
	
	public function getCategoryName($id){
		$result = $this->_db->get($this->_table, array('id', '=', $id));
		if($result->count()){
			return $result->first()->category_name;
		}
	}
	
	
	//ends
	public function hasIndustry($id){
		$result = $this->_db->get('categories', array('industry_id', '=', $id));
		if($result->count()){
			return true;
		}
		return false;
	}
	
	public function getMyIndustryId($id){
		$result = $this->_db->get($this->_table, array('id', '=', $id));
		if($result->count()){
			return $result->first()->industry_id;
		}
		return false;
	}
	
	public function exists(){
		return (!empty($this->_data))? True : False;
	}

	public function data(){
		return $this->_data;
	}
	
}
