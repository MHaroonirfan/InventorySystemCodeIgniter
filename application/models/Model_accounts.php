<?php 

class Model_accounts extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
        
//        public function getOrdersData($id = null)
//	{
//		if($id) {
//			$sql = "SELECT * FROM orders WHERE id = ?";
//			$query = $this->db->query($sql, array($id));
//			return $query->row_array();
//		}
//
//		$sql = "SELECT * FROM orders ORDER BY id DESC";
//		$query = $this->db->query($sql);
//		return $query->result_array();
//	}
	/*get the active brands information*/
	public function getActiveBrands()
	{
		$sql = "SELECT * FROM brands WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	/* get the brand data */
	public function getAccountsData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM brands WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM brands";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('brands', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('brands', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('brands');
			return ($delete == true) ? true : false;
		}
	}
        public function getOrdersData($payment_method)
	{
            $sql = "SELECT * FROM orders where payment_method='$payment_method' ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
        
	}

}