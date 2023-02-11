<?php 

class Model_expenses extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*get the active expenses information*/
	public function getActiveExpenses()
	{
		$sql = "SELECT * FROM expenses WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	/* get the expense data */
	public function getExpenseData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM expenses WHERE id = ? ORDER BY date DESC";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM expenses ORDER BY date DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('expenses', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('expenses', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('expenses');
			return ($delete == true) ? true : false;
		}
	}
        
        public function getReportExpenseData($from_date, $to_date)
	{
            $this->db->select('*');
            $this->db->from('expenses');
            $this->db->where('date >=', $from_date);
            $this->db->where('date <=', $to_date);
            $query=$this->db->get();
            return $query->result_array();
	}

}