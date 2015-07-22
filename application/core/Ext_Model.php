<?php
class Ext_Model extends CI_Model {

	var $table_name = NULL;
	var $pkey = NULL;
	var $table_record_count = 0;
	var $CI;

	/**
	 * Constructor
	 */
	function __construct($table_name = NULL, $pkey = NULL) {

		parent::__construct();
		$this->CI =& get_instance();
		$this->init_table_info($table_name, $pkey);
	}

	/**
	 * Set table name
	 * @param string table_name
	 * @param string pkey (optional : if table have primary key)
	 */
	function init_table_info($table_name, $pkey = NULL) {

		$this->table_name = $table_name;
		if(!is_null($pkey)){
			$this->pkey = $pkey;
		}
	}

	/** Add new record
	 * @param object data
	 * @return : + The ID generated for an AUTO_INCREMENT column by the previous INSERT query on success.
	 * 			 + 0 if the previous query does not generate an AUTO_INCREMENT value.
	 *           + FALSE if no MySQL connection was established.
	 */
	function create($data){
		$this->db->insert($this->table_name, $data);
		return $this->db->insert_id();
	}
	
	/** Add new record
	* @param object data
	*/
	function create_batch($data) {
		$this->db->insert_batch($this->table_name, $data);
	}
	
	
	
	
	/** Add new record ignore
	* @param object data
	* @return : + The ID generated for an AUTO_INCREMENT column by the previous INSERT query on success.
	* 			 + 0 if the previous query does not generate an AUTO_INCREMENT value.
	*           + FALSE if no MySQL connection was established.
	*/
	function create_ignore($data) {
		$insert_query = $this->db->insert_string($this->table_name, $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
		$this->db->query($insert_query); // QUERY RUNS A SECOND TIME
		
		return $this->db->insert_id();
	}

	/**
	 * Retrieves and return single record from the database with pkey
	 * @param string pkeyvalue
	 */
	function find_by_pkey($pkeyvalue) {
		 
		$filter_rules = array($this->pkey => $pkeyvalue);
		$result = $this->find($filter_rules);
		if(!empty($result)){
			return $result[0];
		}

		return $result;
	}

	/**
	 * Retrieves and returns all data listing from the database
	 * @param int start
	 * @param int count
	 * @param string order
	 * @param string direction
	 * @return : returns data listing from the database
	 */
	function findAll($start = NULL, $count = NULL, $order = NULL, $direction = '') {
		return $this->find(NULL, $start, $count, $order, $direction);
	}

	/**
	 * Retrieves and returns all undeleted data listing from the database
	 * @param int start
	 * @param int count
	 * @param string order
	 * @param string direction
	 * @return : returns data listing from the database
	 */
	function findAllActive($start = NULL, $count = NULL, $order = NULL, $direction = '') {
		return $this->findActive(NULL, $start, $count, $order, $direction);
	}

	/**
	 * Retrieves and returns all data listing from the database with conditions
	 * @param mix filters (filters could be an array or filter values or an SQL string.)
	 * @param int start
	 * @param int count
	 * @param string order
	 * @param string direction
	 * @return : returns data listing from the database
	 */
	function findByFilter($filter_rules, $start = NULL, $count = NULL, $order = NULL, $direction = '') {
		return $this->find($filter_rules, $start, $count, $order, $direction);
	}

	/**
	 * Retrieves and returns data listing from the database with conditions
	 * @param mix filters (filters could be an array or filter values or an SQL string.)
	 * @param int start
	 * @param int count
	 * @param string order
	 * @param string direction
	 * @return : returns data listing from the database
	 */
	function find($filters = NULL, $start = NULL, $count = NULL, $order = NULL, $direction = '') {

		// start cache
		$this->db->start_cache();

		// Filter could be an array or filter values or an SQL string.
		if($filters) {
			$this->db->where($filters);
		}

		// stop cache
		$this->db->stop_cache();

		// get total records before filter by limit
		$this->table_record_count = $this->db->count_all_results($this->table_name);

		if(!is_null($start)) {
			if(!is_null($count)) {
				$this->db->limit($count, $start);
			}
			else {
				$this->db->limit($start);
			}
		}

		// set orderby : default of direction is Asc
		if($order){
			$this->db->order_by($order, $direction);
		}

		$query = $this->db->get($this->table_name);
		 
		$results = array();
		if(!empty($query) && $query->num_rows() > 0) {
			$results = $query->result_array();
		}

		// flush cache
		$this->db->flush_cache();

		return $results;
	}

	/**
	 * Retrieves and returns data listing from the database with conditions
	 * @param mix filters (filters could be an array or filter values or an SQL string.)
	 * @param int start
	 * @param int count
	 * @param string order
	 * @param string direction
	 * @return : returns data listing from the database
	 */
	function findActive($filters = NULL, $start = NULL, $count = NULL, $order = NULL, $direction = '') {

		// start cache
		$this->db->start_cache();

		// Filter could be an array or filter values or an SQL string.
		if($filters) {
			$this->db->where($filters);
		}

		// stop cache
		$this->db->stop_cache();

		// get total records before filter by limit
		$this->table_record_count = $this->db->count_all_results($this->table_name);

		if(!is_null($start)) {
			if(!is_null($count)) {
				$this->db->limit($count, $start);
			}
			else {
				$this->db->limit($start);
			}
		}

		// set orderby : default of direction is Asc
		if($order){
			$this->db->orderby($order, $direction);
		}

		$query = $this->db->get($this->table_name);
		$results = array();
		if(!empty($query) && $query->num_rows() > 0) {
			$results = $query->result_array();
		}

		// flush cache
		$this->db->flush_cache();

		return $results;
	}

	/**
	 * Update data of this table
	 * @param string  pkeyvalue
	 * @param array data
	 */
	function update_by_pkey($pkeyvalue, $data) {

		$filters = array($this->pkey => $pkeyvalue);
		return $this->update($filters, $data);
	}

	/**
	 * Update data of this table
	 * @param mix filters (filters could be an array or filter values or an SQL string.)
	 * @param array data
	 */
	function update($filters, $data) {

		// filters could be an array or filter values or an SQL string.
		if($filters) {
			$this->db->where($filters);
		}

		return $this->db->update($this->table_name, $data);
	}
	
	/**
	 * Update_batch data of this table
	 * @param mix filters (filters could be an array or filter values or an SQL string.)
	 * @param array data
	 */
	function update_batch($data, $where) {
		return $this->db->update_batch($this->table_name, $data, $where);
	}

	/**
	 * Delete data of this table
	 * @param string pkeyvalue
	 */
	function delete_by_pkey($pkeyvalue) {

		$filters = array($this->pkey => $pkeyvalue);
		return $this->delete($filters);
	}

	/**
	 * Delete data of this table
	 * @param array filters
	 */
	function delete($filters) {

		// filters could be an array or filter values or an SQL string.
		if($filters) {
			$this->db->where($filters);
		}

		$this->db->delete($this->table_name);
		return true;
	}

	/**
	 * Get single field_value
	 * @param string field_name
	 * @param string pkeyvalue
	 * @return string field_value (if no exist return FALSE)
	 */
	function getFieldByPkey($pkeyvalue, $field_name){

		$filters = array($this->pkey => $pkeyvalue);
		return $this->getFieldByFilter($filters, $field_name);
	}

	/**
	 * Get single field_value
	 * @param array filters
	 * @param string field_name
	 * @return string field_value (if no exist return FALSE)
	 */
	function getFieldByFilter($filters, $field_name) {
		$this->db->select($field_name . ' AS myfield');
		$this->db->where($filters);

		$query = $this->db->get($this->table_name);
		if (!empty($query) && $query->num_rows() > 0){
			$row = $query->row();

			return $row->myfield;
		}

		return FALSE;
	}

	/**
	 * Get max of primary key
	 * @return int maxid
	 */
	function getMaxId(){

		$max_product_id = 0;
		$query = $this->db->query('SELECT MAX(' . $this->pkey . ') AS maxid FROM ' . $this->table_name);
		if (!empty($query) && $query->num_rows() > 0){
			$row = $query->row();
			$max_product_id = $row->maxid;
		}

		return $max_product_id;
	}
}
?>
