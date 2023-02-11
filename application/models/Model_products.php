<?php 

class Model_products extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the brand data */
	public function getProductData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM products where id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM products ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/* get grand total of products */
	public function get_grand_total(){
		$sql = "SELECT SUM(qty * price) AS grand_total FROM products ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/* get product grand total */

	public function getActiveProductData()
	{
		$sql = "SELECT * FROM products WHERE availability = ? ORDER BY id DESC";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('products', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$this->db->where('store_id', 3);
			// $update_qty = ['name' => $data['name'],
   //              'sku' => $data['sku'],
   //              'price' => $data['price'],
   //              'qty' => $data['qty'],
   //              'description' => $data['description'],
   //              'attribute_value_id' => json_encode($data['attribute_value_id']),
   //              'brand_id' => json_encode($data['brand_id']),
   //              'category_id' => json_encode($data['category_id']),
   //              'store_id' => $data['store_id'],
   //              'supplier_id' => $data['supplier_id'],
   //              'availability' => $data['availability'],
   //              'date' => $data['date'],
   //              'user_id' => $data['user_id']];
			$update = $this->db->update('products', $data);

			$this->db->where('id', $id);
			$this->db->where('store_id', 4);
			$update_add = $this->db->update('products', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('products');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalProducts()
	{
		$sql = "SELECT * FROM products";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

}