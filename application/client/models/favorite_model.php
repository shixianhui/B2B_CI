<?php
class Favorite_model extends CI_Model {

	private $_tableName = 'favorite';

	public function __construct() {
		 parent::__construct();
	}

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

	public function delete($where = '') {
		return $this->db->delete($this->_tableName, $where) > 0 ? TRUE : FALSE;
	}

    public function gets($table = 'product', $strWhere = NULL, $limit = NULL, $offset = NULL) {
		$ret = array();
        if($table == 'product'){
            $this->db->select("{$this->_tableName}.*,{$table}.title,{$table}.path,{$table}.sell_price");
        } else if ($table == 'store'){
            $this->db->select("{$this->_tableName}.*,{$table}.path,{$table}.store_name,{$table}.evaluate_a,{$table}.evaluate_b,{$table}.evaluate_c,{$table}.des_grade,{$table}.serve_grade,{$table}.express_grade");
        }
		$this->db->order_by("{$this->_tableName}.id", 'DESC');
		$this->db->join($table, "{$this->_tableName}.item_id = {$table}.id");
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

	public function get2($table = 'product', $strWhere = NULL) {
		$ret = array();
		$this->db->select("{$this->_tableName}.*");
		$this->db->join($table, "{$this->_tableName}.item_id = {$table}.id");
		$query = $this->db->get_where($this->_tableName, $strWhere);
		if ($query->num_rows() > 0){
			$ret = $query->result_array();
			return $ret[0];
		}

		return $ret;
	}

   /**
	 * select
	 *
	 * @param $strWhere is string
	 * @return int
	 */
	public function rowCount($table = 'product', $strWhere = NULL) {
		$count = 0;
		$this->db->select("count(*) as 'count'");
		$this->db->join($table, "{$this->_tableName}.item_id = {$table}.id");
		$query = $this->db->get_where($this->_tableName, $strWhere);
	    if ($query->num_rows() > 0) {
			$ret = $query->result_array();
			$count = $ret[0]['count'];
		}

		return $count;
	}

      public function get_max_id($table = 'product', $strWhere = NULL) {
        $this->db->select("max({$this->_tableName}.id) as 'max_id'");
        $this->db->join($table, "{$this->_tableName}.item_id = {$table}.id");
        $query = $this->db->get_where($this->_tableName, $strWhere);
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            return $ret[0]['max_id'] ? $ret[0]['max_id'] : 0;
        }
        return 0;
    }
}
/* End of file advertising_model.php */
/* Location: ./application/admin/models/advertising_model.php */