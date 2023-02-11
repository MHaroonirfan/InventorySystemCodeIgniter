<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends Admin_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'Stores';
		$this->load->model('model_reports');
	}

	/* 
    * It redirects to the report page
    * and based on the year, all the orders data are fetch from the database.
    */
	public function index()
	{
		if(!in_array('viewReports', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
		
		$today_year = date('Y');

		if($this->input->post('select_year')) {
			$today_year = $this->input->post('select_year');
		}

		$parking_data = $this->model_reports->getOrderData($today_year);
		$this->data['report_years'] = $this->model_reports->getOrderYear();
		

		$final_parking_data = array();
		foreach ($parking_data as $k => $v) {
			
			if(count($v) > 1) {
				$total_amount_earned = array();
				foreach ($v as $k2 => $v2) {
					if($v2) {
						$total_amount_earned[] = $v2['gross_amount'];						
					}
				}
				$final_parking_data[$k] = array_sum($total_amount_earned);	
			}
			else {
				$final_parking_data[$k] = 0;	
			}
			
		}
		
		$this->data['selected_year'] = $today_year;
		$this->data['company_currency'] = $this->company_currency();
		$this->data['results'] = $final_parking_data;

                $this->data['page_title'] = 'Reports';
		$this->render_template('reports/index', $this->data);
	}
        
        public function sale()
	{
            if(!in_array('viewSales', $this->permission)) {
                redirect('dashboard', 'refresh');
            }
            if($this->input->post('from_date') && $this->input->post('to_date')) {
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');
            } else {
                $from_date = date('Y-m-d', strtotime('-7 days'));
                $to_date = date('Y-m-d');
            }
            $result = $this->model_reports->getSalesData($from_date, $to_date);
            
            $this->data['to_date'] = $to_date;
            $this->data['from_date'] = $from_date;            
            $this->data['results'] = $result;
            $this->data['page_title'] = 'Sales Report';
		$this->render_template('reports/sales', $this->data);
	}
        
        public function purchase()
	{
            if(!in_array('viewPurchases', $this->permission)) {
                redirect('dashboard', 'refresh');
            }
            if($this->input->post('from_date') && $this->input->post('to_date')) {
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');
            } else {
                $from_date = date('Y-m-d', strtotime('-7 days'));
                $to_date = date('Y-m-d');
            }
            
            $result = $this->model_reports->getPurchasesData($from_date, $to_date);
            
            $this->data['to_date'] = $to_date;
            $this->data['from_date'] = $from_date;            
            $this->data['results'] = $result;
            $this->data['page_title'] = 'Purchases Report';
		$this->render_template('reports/purchases', $this->data);
	}
        
        public function recovery(){
            
            
            if(!in_array('viewRecovery', $this->permission)) {
                redirect('dashboard', 'refresh');
            }	
            if($this->input->post('from_date') && $this->input->post('to_date')) {
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');
            } else {
                // $from_date = date('Y-m-d', strtotime('-7 days'));
                // $to_date = date('Y-m-d');

                $from_date = '1970-01-01';
                $to_date = '3000-01-01';
            }
            $result = $this->model_reports->getRecoveryData($from_date, $to_date);
            
            $this->data['to_date'] = $to_date;
            $this->data['from_date'] = $from_date;            
            $this->data['results'] = $result;
            $this->data['page_title'] = 'Recovery Report';
            // echo "<pre>";
            // print_r($this->data['results']);
            // echo "</pre>";
            $this->render_template('reports/recovery', $this->data);
            
        }
}	