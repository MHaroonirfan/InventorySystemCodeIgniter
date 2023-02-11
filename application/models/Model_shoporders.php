<?php 

class Model_shoporders extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the shop orders data */
	public function getShopOrdersData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM shoporders WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM shoporders ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// get the shop orders item data
	public function getShopOrdersItemData($order_id = null)
	{
		if(!$order_id) {
			return false;
		}

		$sql = "SELECT * FROM shoporders_item WHERE order_id = ?";
		$query = $this->db->query($sql, array($order_id));
		return $query->result_array();
	}

	public function create()
	{
            $user_id = $this->session->userdata('id');
            $data = array(
    		'date' => $this->input->post('date'),
    		'time' => $this->input->post('time'),
    		'user_id' => $user_id
            );

            $insert = $this->db->insert('shoporders', $data);
            $order_id = $this->db->insert_id();

            $this->load->model('model_products');

            $count_product = count($this->input->post('product'));
            for($x = 0; $x < $count_product; $x++) {
    		$items = array(
    			'order_id' => $order_id,
    			'product_id' => $this->input->post('product')[$x],
    			'qty' => $this->input->post('qty')[$x],
    		);
    		$this->db->insert('shoporders_item', $items);

    		// now decrease the stock from the product
    		$product_data = $this->model_products->getProductData($this->input->post('product')[$x]);
    		$qty = (int) $product_data['qty'] - (int) $this->input->post('qty')[$x];

    		$update_product = array('qty' => $qty);


    		$this->model_products->update($update_product, $this->input->post('product')[$x]);
    	}

		return ($order_id) ? $order_id : false;
	}

	public function countShopOrderItem($order_id)
	{
		if($order_id) {
			$sql = "SELECT * FROM shoporders_item WHERE order_id = ?";
			$query = $this->db->query($sql, array($order_id));
			return $query->num_rows();
		}
	}

	public function update($id)
	{
		if($id) {
			$user_id = $this->session->userdata('id');
			// fetch the order data 

			$data = array(
    			'date' => $this->input->post('date'),
    			'time' => $this->input->post('time'),
	    		'user_id' => $user_id
	    	);

			$this->db->where('id', $id);
			$update = $this->db->update('shoporders', $data);

			// now the order item 
			// first we will replace the product qty to original and subtract the qty again
			$this->load->model('model_products');
			$get_order_item = $this->getShopOrdersItemData($id);
			foreach ($get_order_item as $k => $v) {
				$product_id = $v['product_id'];
				$qty = $v['qty'];
				// get the product 
				$product_data = $this->model_products->getProductData($product_id);
				$update_qty = $qty + $product_data['qty'];
				$update_product_data = array('qty' => $update_qty);
				
				// update the product qty
				$this->model_products->update($update_product_data, $product_id);
			}

			// now remove the order item data 
			$this->db->where('order_id', $id);
			$this->db->delete('shoporders_item');

			// now decrease the product qty
			$count_product = count($this->input->post('product'));
	    	for($x = 0; $x < $count_product; $x++) {
	    		$items = array(
	    			'order_id' => $id,
	    			'product_id' => $this->input->post('product')[$x],
	    			'qty' => $this->input->post('qty')[$x],
	    		);
	    		$this->db->insert('shoporders_item', $items);

	    		// now decrease the stock from the product
	    		$product_data = $this->model_products->getProductData($this->input->post('product')[$x]);
	    		$qty = (int) $product_data['qty'] - (int) $this->input->post('qty')[$x];

	    		$update_product = array('qty' => $qty);
	    		$this->model_products->update($update_product, $this->input->post('product')[$x]);
	    	}

			return true;
		}
	}



	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('shoporders');

			$this->db->where('order_id', $id);
			$delete_item = $this->db->delete('shoporders_item');
			return ($delete == true && $delete_item) ? true : false;
		}
	}

	public function countTotalPaidOrders()
	{
		$sql = "SELECT * FROM orders WHERE paid_status = ?";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}

//        On order remove from shop stock
        
        public function update_shopstock($data, $id)
	{
		if($data && $id) {
			$this->db->where('product_id', $id);
			$update = $this->db->update('shoporders_item', $data);
			return ($update == true) ? true : false;
		}
	}
        
        public function getShopStockData($id)
        {
            if($id) {
				$sql = "SELECT * FROM shoporders_item where product_id = ?";
				$query = $this->db->query($sql, array($id));
				return $query->row_array();
			}else{
				$sql = "SELECT * FROM shoporders_item order BY id DESC";
				$query = $this->db->query($sql);
				return $query->result_array();
			}
        }
}