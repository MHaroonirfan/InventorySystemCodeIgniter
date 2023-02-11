<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Balance extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Customer Balance';

		$this->load->model('model_orders');
		$this->load->model('model_balance');
		$this->load->model('model_customers');
        $this->load->model('model_company');
        $this->load->model('model_products');
	}

	/* 
	* It only redirects to the manage order page
	*/
	public function index(){
		if(!in_array('viewBalance', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Manage Customer Balance';
		$this->render_template('balance/index', $this->data);		
	}

	/*
	* Fetches the orders data from the orders table 
	* this function is called from the datatable ajax function
	*/
	public function fetchBalanceData(){
		$result = array('data' => array());

		$data = $this->model_balance->getBalanceData();
                
		foreach ($data as $key => $value) {
			// button
			$buttons = '';

			if(in_array('updateBalance', $this->permission)) {
				$buttons .= ' <a href="'.base_url('balance/update/'.$value['balance_id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}
            if(in_array('balanceReport', $this->permission)) {
				$buttons .= ' <a href="'.base_url('balance/report/'.$value['customer_id']).'/'.$value['order_id'].'" class="btn btn-default"><i class="fa fa-file"></i></a>';
			}
			if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['balance_id'].','.$value['order_id'].','.$value['customer_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			$result['data'][$key] = array(
				$value['bill_no'],
				$value['date'],
				$value['name'],
				$value['net_amount'],
				$value['paid_amount'],
				$value['pending_amount'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	* If the validation is not valid, then it redirects to the create page.
	* If the validation for each input field is valid then it inserts the data into the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/
	public function create(){
		if(!in_array('createBalance', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Add Customer Order Balance';

		$this->form_validation->set_rules('customer_id', 'Customer name', 'required');
		//$this->form_validation->set_rules('order_id', 'Order name', 'required');
		$this->form_validation->set_rules('paid_amount', 'Paid Amount', 'required');
		$this->form_validation->set_rules('pending_amount', 'Pending Amount', 'required');
	
        if ($this->form_validation->run() == TRUE) {        	
        	
        	$balance_id = $this->model_balance->create();
        	
        	if($balance_id) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('balance/update/'.$balance_id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('balance/create/', 'refresh');
        	}
        }
        else {
            // false case
            $this->data['customers'] = $this->model_customers->getActiveCustomers();
            $this->render_template('balance/create', $this->data);
        }	
	}

	/*
	* It gets the product id passed from the ajax method.
	* It checks retrieves the particular product data from the product id 
	* and return the data into the json format.
	*/
	public function getProductValueById()
	{
		$product_id = $this->input->post('product_id');
		if($product_id) {
			$product_data = $this->model_products->getProductData($product_id);
			echo json_encode($product_data);
		}
	}

	/*
	* It gets the all the active product inforamtion from the product table 
	* This function is used in the order page, for the product selection in the table
	* The response is return on the json format.
	*/
	public function getTableProductRow()
	{
		$products = $this->model_products->getActiveProductData();
		echo json_encode($products);
	}

	/*
	* If the validation is not valid, then it redirects to the edit orders page 
	* If the validation is successfully then it updates the data into the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/
	public function update($id)
	{
		if(!in_array('updateOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if(!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Update Customer Balance';

		$this->form_validation->set_rules('customer_id', 'Customer name', 'required');
		$this->form_validation->set_rules('order_id', 'Order name', 'required');
		$this->form_validation->set_rules('paid_amount', 'Paid Amount', 'required');
		$this->form_validation->set_rules('pending_amount', 'Pending Amount', 'required');
		
	
        if ($this->form_validation->run() == TRUE) {        	
        	
        	$update = $this->model_balance->update($id);
        	
        	if($update == true) {
        		$this->session->set_flashdata('success', 'Successfully updated');
        		redirect('balance/update/'.$id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('balance/update/'.$id, 'refresh');
        	}
        }
        else {
            // false case

        	$this->data['order_data'] = $this->model_balance->getBalanceData($id);

        	$this->data['customers'] = $this->model_customers->getActiveCustomers(); 

            $this->data['orders'] = $this->model_balance->getCustomerData($this->data['order_data']->customer_id);      	

            // echo "<pre>";
            // print_r($this->data['orders']);
            // echo "</pre>";

            $this->render_template('balance/edit', $this->data);
        }
	}

	/*
	* It removes the data from the database
	* and it returns the response into the json format
	*/
	public function remove()
	{
		if(!in_array('deleteBalance', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$balance_id = $this->input->post('balance_id');
		$order_id = $this->input->post('order_id');
		$customer_id = $this->input->post('customer_id');

        $response = array();
        if($balance_id) {
            $delete = $this->model_balance->remove($balance_id, $order_id, $customer_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the product information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response); 
	}

    public function fetchCustomerDataById()
	{
        $id = $_POST['customer_id'];
		if($id) {
			$data = $this->model_balance->getCustomerData($id);
                        
			echo json_encode($data);
		}

		return false;
	}
        
        public function viewCustomerOrders($id)
        {
            if(!in_array('viewBalance', $this->permission)) {
            redirect('dashboard', 'refresh');
            }

            if(!$id) {
                redirect('dashboard', 'refresh');
            }
            $this->data['page_title'] = 'Customer Balance Records';
            $this->data['customer_id'] = $id;
            $this->render_template('balance/records', $this->data);
        }

	public function fetchCustomerBalanceData($id)
	{
		$result = array('data' => array());

		$data = $this->model_balance->getCustomerBalanceData($id);
                
		foreach ($data as $key => $value) {
			// button
			$buttons = '';

			if(in_array('updateBalance', $this->permission)) {
				$buttons .= ' <a href="'.base_url('balance/update/'.$value['balance_id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['balance_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			$result['data'][$key] = array(
				$value['bill_no'],
				$value['name'],
				$value['net_amount'],
				$value['paid_amount'],
				$value['pending_amount'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
        
     public function report($id){

        if(!in_array('balanceReport', $this->permission) || !$id) {
            redirect('dashboard', 'refresh');
        }
        preg_match("/[^\/]+$/", $_SERVER['REQUEST_URI'], $matches);
		$order_id = $matches[0]; // test

        $data = $this->model_balance->getReportBalanceData($id);
        
        $this->data['data'] = $data;          
		$this->data['page_title'] = 'Customer Balance Report - '.$data[0]['name'];
		$this->data['customer'] = $data[0]['name'];


		for($i = 0; $i < count($data); $i++){
			if($data[$i]['order_id'] != 0){
				$orderdata = $this->model_orders->getOrdersItemData($data[$i]['order_id']);
				$this->data['data'][$i]['orderitems'] = $orderdata;
				for ($j = 0; $j < count($orderdata) ; $j++) { 
					$productdata = $this->model_products->getProductData($orderdata[$j]['product_id']);
					$this->data['data'][$i]['orderitems'][$j]['products'] = $productdata;
				}
			}
		}		

		// echo "<pre>";
		// print_r($this->data['data']);
		// echo "</pre>";
		$this->render_template('balance/report', $this->data);
            
     }

}