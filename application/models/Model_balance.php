<?php 

class Model_balance extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

	}

	/* get the orders data */
	public function getBalanceData($id = null)
	{
		if($id) {
                    
            $this->db->select('*');
            $this->db->from('balance');
            $this->db->where('balance.id', $id);
//            $this->db->join('customers','customers.id=balance.customer_id');
//            $this->db->join('orders','orders.id=balance.order_id');
            $this->db->order_by('date','ASC');
            $query=$this->db->get();
            return $query->row();
		}
                
            $this->db->select('*');
            $this->db->select('balance.id AS balance_id');
            $this->db->from('balance');
            $this->db->join('customers','customers.id=balance.customer_id');
            $this->db->join('orders','orders.id=balance.order_id');
            $query=$this->db->get();
            return $query->result_array();
	}

    public function getReportBalanceData($id = null)
	{
            $this->db->select('*');
            $this->db->select('balance_backlog.id AS balance_id');
            $this->db->select('balance_backlog.payment_method AS payment_by');
            $this->db->select('balance_backlog.date AS balance_paid_on');
            $this->db->select('orders.date AS order_paid_on');
            $this->db->from('balance_backlog');
            $this->db->join('customers','customers.id=balance_backlog.customer_id', 'left');
            $this->db->join('orders','orders.id=balance_backlog.order_id', 'left');
            $this->db->order_by('balance_backlog.date', 'ASC');
            //$this->db->order_by('orders.date', 'ASC');
            $this->db->where('customers.id', $id);
            //$this->db->where('balance_backlog.order_id', $order_id);
            $query=$this->db->get();
            return $query->result_array();
            //return $this->db->last_query();
	}
        
	// get the orders item data
	public function getOrdersItemData($order_id = null)
	{
		if(!$order_id) {
			return false;
		}

		$sql = "SELECT * FROM orders_item WHERE order_id = ?";
		$query = $this->db->query($sql, array($order_id));
		return $query->result_array();
	}

	public function create()
	{
    	$data = array(
    		'customer_id' => $this->input->post('customer_id'),
    		'order_id' => 0,
    		'paid_amount' => $this->input->post('lease_amount'),
            'created_at' => date('Y-m-d h:i:s a'),
            'date' => $this->input->post('date'),
            'time' => $this->input->post('time'),
            'pending_amount' => $this->input->post('pending_amount'),
    		'payment_method' => $this->input->post('payment_method')
    	);

        $data1 = array(
            'customer_id' => $this->input->post('customer_id'),
            'order_id' => 0,
            'paid_amount' => $this->input->post('lease_amount'),
            'lease' => 0,
            'created_at' => date('Y-m-d h:i:s a'),
            'date' => $this->input->post('date'),
            'time' => $this->input->post('time'),
            'pending_amount' => $this->input->post('pending_amount'),
            'payment_method' => $this->input->post('payment_method')
        );

        $this->db->insert('balance_backlog', $data1);

		$insert = $this->db->insert('balance', $data);
		$balance_id = $this->db->insert_id();

		return ($balance_id) ? $balance_id : false;
	}

	public function update($id)
	{
		if($id) {
			$data = array(
			'customer_id' => $this->input->post('customer_id'),
            'order_id' => $this->input->post('order_id'),
            'paid_amount' => $this->input->post('paid_amount')+$this->input->post('add_lease'),
            'updated_at' => date('Y-m-d h:i:s a'),
            'date' => $this->input->post('date'),
    		'time' => $this->input->post('time'),
            'pending_amount' => $this->input->post('pending_amount')-$this->input->post('add_lease'),
            'payment_method' => $this->input->post('payment_method')
            );

			$this->db->where('id', $id);
			$update = $this->db->update('balance', $data);
            $data1 = array(
                'customer_id' => $this->input->post('customer_id'),
                'order_id' => $this->input->post('order_id'),
                'paid_amount' => $this->input->post('paid_amount')+$this->input->post('add_lease'),
                'lease' => $this->input->post('add_lease'),
                'created_at' => date('Y-m-d h:i:s a'),
                'date' => $this->input->post('date'),
                'time' => $this->input->post('time'),
                'pending_amount' => $this->input->post('pending_amount')-$this->input->post('add_lease'),
                'payment_method' => $this->input->post('payment_method')
            );
            $this->db->insert('balance_backlog', $data1);
                        
			return true;
		}
	}



	public function remove($id, $order_id, $customer_id)
	{
		if($id) {
            $this->db->where('order_id', $order_id);
            $this->db->where('customer_id', $customer_id);
            $this->db->delete('balance_backlog');
                    
			$this->db->where('order_id', $order_id);
            $this->db->where('customer_id', $customer_id);
			$delete = $this->db->delete('balance');

            //delete order
            $this->db->where('id', $order_id);
            $this->db->delete('orders');

            //delete order item
            $this->db->where('order_id', $order_id);
            $this->db->delete('orders_item');

			return ($delete == true) ? true : false;
		}
	}

	public function countTotalPaidOrders()
	{
		$sql = "SELECT * FROM orders WHERE paid_status = ?";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}
        
        /* get the customer data */
	public function getCustomerData($id)
	{
            $response = array();
            
            $this->db->select('SUM(orders.net_amount) AS order_amount');
            $this->db->from('orders');
            $this->db->where('orders.customer_id', $id);
            
            $query=$this->db->get();
            $response['order_data'] = $query->row_array();

            $this->db->select('SUM(balance.paid_amount) AS paid_amount');
            $this->db->from('balance');
            $this->db->where('balance.customer_id', $id);

            $query1=$this->db->get();
            $response['balance_data'] = $query1->row_array();

            
            if($id) {
    			$sql = "SELECT * FROM customers WHERE id = ?";
    			$query = $this->db->query($sql, array($id));
    			$response['customer_data'] = $query->row_array();
    		}
            return $response;
        //return $this->db->last_query();
	}

        public function getCustomerOrders($id)
	{
            $this->db->select('id, bill_no, net_amount');
            $this->db->from('orders');
            $this->db->where('customer_id', $id);
            $query=$this->db->get();
            return $query->result_array();
	}
        
        public function getCustomerBalanceData($id = null)
	{
		if($id) {
                    
                    $this->db->select('*');
                    $this->db->select('balance.id AS balance_id');
            $this->db->from('balance');
            $this->db->where('balance.customer_id', $id);
            $this->db->join('customers','customers.id=balance.customer_id');
            $this->db->join('orders','orders.id=balance.order_id');
            $query=$this->db->get();
            return $query->result_array();
		}
                
            $this->db->select('*');
            $this->db->select('balance.id AS balance_id');
            $this->db->from('balance');
            $this->db->join('customers','customers.id=balance.customer_id');
            $this->db->join('orders','orders.id=balance.order_id');
            $query=$this->db->get();
            return $query->result_array();
	}
}