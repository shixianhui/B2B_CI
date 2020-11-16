<?php
class Cart_model extends CI_Model {

	private $_tableName = 'cart';
	private $_productTName = 'product';
	private $_storeTName = 'store';

	public function __construct() {
		 parent::__construct();
	}

    public function gets($strWhere = NULL, $limit = NULL, $offset = NULL) {
		$ret = array();
		$this->db->select("{$this->_tableName}.*, {$this->_productTName}.path,{$this->_productTName}.brand_name,{$this->_productTName}.title,{$this->_productTName}.market_price, {$this->_productTName}.sell_price, {$this->_productTName}.product_num, {$this->_productTName}.give_score, {$this->_productTName}.consume_score, {$this->_productTName}.color_size_open, {$this->_productTName}.product_color_name, {$this->_productTName}.product_size_name, {$this->_productTName}.weight");
		$this->db->order_by("{$this->_tableName}.id", 'DESC');
		$this->db->join($this->_productTName, "{$this->_tableName}.product_id = {$this->_productTName}.id");
		$query = $this->db->get_where($this->_tableName, $strWhere, $limit, $offset);
	    if ($query->num_rows() > 0) {
            $ret = $query->result_array();
        }

        return $ret;
	}

	public function gets_store_list($strWhere = NULL, $limit = NULL, $offset = NULL) {
		$ret = array();
		$this->db->select("{$this->_tableName}.store_id, {$this->_tableName}.user_id, {$this->_storeTName}.user_id as store_user_id, {$this->_storeTName}.store_name");
		$this->db->order_by("{$this->_tableName}.id", 'DESC');
		$this->db->group_by("{$this->_tableName}.store_id");
		$this->db->join($this->_storeTName, "{$this->_tableName}.store_id = {$this->_storeTName}.id");
		$query = $this->db->get_where($this->_tableName, $strWhere, $limit, $offset);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
		}

		return $ret;
	}

    public function get($select = '*', $strWhere = NULL) {
		$ret = array();
		$this->db->select($select);
		$query = $this->db->get_where($this->_tableName, $strWhere);
		if ($query->num_rows() > 0){
			$ret = $query->result_array();
			return $ret[0];
		}

		return $ret;
	}

	public function get2($strWhere = NULL) {
		$ret = array();
		$this->db->select("{$this->_tableName}.*, {$this->_productTName}.color_size_open, {$this->_productTName}.sell_price, {$this->_productTName}.stock");
		$this->db->join($this->_productTName, "{$this->_tableName}.product_id = {$this->_productTName}.id");
		$query = $this->db->get_where($this->_tableName, $strWhere);
		if ($query->num_rows() > 0){
			$ret = $query->result_array();
			return $ret[0];
		}

		return $ret;
	}

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

	//获取数量
    public function rowSum($strWhere = NULL) {
		$count = 0;
		$this->db->select("sum(buy_number) as 'sum'");
		$query = $this->db->get_where($this->_tableName, $strWhere);
	    if ($query->num_rows() > 0) {
			$ret = $query->result_array();
			$count = $ret[0]['sum'];
		}

		return $count?$count:0;
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

	public function get_total($where = '') {
		$total = 0;
                if($where){
                    $query = $this->db->query("select sum(sell_price*buy_number) as 'total' from cart where $where");
                }else{
                    $query = $this->db->query("select sum(sell_price*buy_number) as 'total' from cart");
                }

		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
			$total = $ret[0]['total'];
		}

		return $total?$total:0;
	}
}
/* End of file advertising_model.php */
/* Location: ./application/admin/models/advertising_model.php */