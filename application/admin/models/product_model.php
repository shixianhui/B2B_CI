<?php
class Product_model extends CI_Model {

	private $_tableName = 'product';
	private $_storeTName = 'store';

    public function __construct() {
		parent::__construct();
	}

	/**
	 * save data
	 *
	 * @param $data is array
	 * @param $where is array or string
	 * @return boolean
	 */
	public function save($data, $where = NULL) {
		$ret = 0;
		if (! empty($where)) {
			$ret = $this->db->update($this->_tableName, $data, $where);
		} else {
			$this->db->insert($this->_tableName, $data);
			$ret = $this->db->insert_id();
		}

		return $ret > 0 ? $ret : FALSE;
	}

	/**
	 * delete data
	 *
	 * @param $where is array or string
	 * @return boolean
	 */
	public function delete($where = '') {
		return $this->db->delete($this->_tableName, $where) > 0 ? TRUE : FALSE;
	}

	/**
	 * select data
	 *
	 * @param $strWhere is string
	 * @param $limit is int
	 * @param $offset is int
	 * @return array
	 */
	public function gets($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL) {
		$ret = array();
		$this->db->select($select);
		$this->db->order_by("{$this->_tableName}.id", 'DESC');
		$query = $this->db->get_where($this->_tableName, $strWhere, $limit, $offset);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
		}

		return $ret;
	}

   /**
	 * select info
	 *
	 * @param $select is string
	 * @param $strWhere is string
	 * @return array
	 */
	public function get($strWhere = NULL) {
		$this->db->select("{$this->_tableName}.*, {$this->_storeTName}.store_name");
		$this->db->join($this->_storeTName, "{$this->_storeTName}.id = {$this->_tableName}.store_id", "left");
		$query = $this->db->get_where($this->_tableName, $strWhere);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
			return $ret[0];
		}

		return array();
	}

	public function get2($select = '*', $strWhere = NULL) {
		$this->db->select($select);
		$query = $this->db->get_where($this->_tableName, $strWhere);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
			return $ret[0];
		}

		return array();
	}

	public function attribute($attribute, $attributeStr = 'h,c') {
		$strAttribute = '';
		if (! empty($attributeStr)) {
			$attributeArray = explode(',', $attributeStr);
			$strAttribute = '[';
			foreach ($attributeArray as $key=>$value) {
			    $strAttribute .= ''.$attribute[$value];
			}
			$strAttribute .= ']';
		}
		return $strAttribute;
	}

	/**
	 * select
	 *
	 * @param $strWhere is string
	 * @return int
	 */
	public function rowCount($strWhere = NULL) {
		$count = 0;
		$this->db->select("count(*) as 'count'");
		$query = $this->db->get_where($this->_tableName, $strWhere);
	    if ($query->num_rows() > 0) {
			$ret = $query->result_array();
			$count = $ret[0]['count'];
		}

		return $count;
	}
}
/* End of file product_model.php */
/* Location: ./application/admin/models/product_model.php */