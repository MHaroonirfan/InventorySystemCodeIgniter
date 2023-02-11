<?php 

class Model_reports extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*getting the total months*/
	private function months()
	{
		return array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
	}

	/* getting the year of the orders */
	public function getOrderYear()
	{
		$sql = "SELECT * FROM orders WHERE paid_status = ?";
		$query = $this->db->query($sql, array(1));
		$result = $query->result_array();
		
		$return_data = array();
		foreach ($result as $k => $v) {
			$date = date('Y', $v['date_time']);
			$return_data[] = $date;
		}

		$return_data = array_unique($return_data);

		return $return_data;
	}

	// getting the order reports based on the year and moths
	public function getOrderData($year)
	{	
		if($year) {
			$months = $this->months();
			
			$sql = "SELECT * FROM orders WHERE paid_status = ?";
			$query = $this->db->query($sql, array(1));
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year.'-'.$month_y;	

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					$month_year = date('Y-m', $v['date_time']);

					if($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}	


			return $final_data;
			
		}
	}
        
        public function getSalesData($from_date, $to_date){
            
            $this->db->select('*');
            $this->db->from('orders');
            $this->db->where('date >=', $from_date);
            $this->db->where('date <=', $to_date);
            $this->db->join('customers','customers.id=orders.customer_id');
            $query=$this->db->get();
            return $query->result_array();

        }
        
        public function getPurchasesData($from_date, $to_date){
            
            $this->db->select('*');
            $this->db->select('suppliers.name AS supplier_name');
            $this->db->from('purchase');
            $this->db->where('date >=', $from_date);
            $this->db->where('date <=', $to_date);
            $this->db->join('suppliers','suppliers.id=purchase.supplier_id');
            $query=$this->db->get();
            return $query->result_array();

        }
        
        public function getRecoveryData ($from_date, $to_date){
            $result = array();
            // $this->db->select('*');
            // $this->db->from('balance');
            // $this->db->where('balance.date >=', $from_date);
            // $this->db->where('balance.date <=', $to_date);
            // $this->db->join('customers','customers.id=balance.customer_id');
            // $this->db->join('orders','orders.id=balance.order_id');
            // $query=$this->db->get();
            // $result['order_data'] = $query->result_array();

            // foreach ($result['order_data'] as $key => $val) {
            // 	$this->db->select('*');
	           //  $this->db->from('balance');
	           //  $this->db->where('balance.date >=', $from_date);
	           //  $this->db->where('balance.date <=', $to_date); 
	           //  $this->db->where('order_id', 0);            
	           //  $this->db->where('balance.customer_id', $val['customer_id']);
	           //  //$this->db->join('orders','orders.id=balance.order_id');
	           //  $query = $this->db->get();
	           //  $result['order_data'][$key]['balance_data'] = $query->result_array();
            // }

            //get customer data
            $this->db->select('*');
            $this->db->from('customers');
            $query=$this->db->get();
            $result['customer_data'] = $query->result_array();

            //get total amount of orders
            foreach ($result['customer_data'] as $key => $customer) {
	            $this->db->select_sum('gross_amount');
	            $this->db->from('orders');
	            // $this->db->where('orders.date >=', $from_date);
	            // $this->db->where('orders.date <=', $to_date);
	            $this->db->where('customer_id', $customer['id']);
	            $query = $this->db->get();
	            $result['customer_data'][$key]['order_amount'] = $query->result_array();

	            //get pending and paid amount
	            foreach($result['customer_data'][$key]['order_amount'] as $key1 => $order){
	            	$this->db->select_sum('paid_amount');
		            $this->db->from('balance');
		            $this->db->where('balance.date >=', $from_date);
	                $this->db->where('balance.date <=', $to_date); 
		            $this->db->where('customer_id', $customer['id']);
		            $query = $this->db->get();
		            $result['customer_data'][$key]['order_amount'][$key1]['balance_data'] = $query->result_array();
	            }
	        }

            return $result;
        }
}