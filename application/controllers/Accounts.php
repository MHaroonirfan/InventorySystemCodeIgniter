<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Accounts';

                $this->load->model('model_orders');
		$this->load->model('model_products');
		$this->load->model('model_company');
		$this->load->model('model_customers');
		$this->load->model('model_accounts');
	}

	/* 
	* It only redirects to the manage product page and
	*/
	public function cash()
	{
		if(!in_array('accounts', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$result = $this->model_accounts->getAccountsData();

		$this->data['results'] = $result;

		$this->render_template('accounts/cash', $this->data);
                
	}
        
	public function bank()
	{
		if(!in_array('accounts', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$result = $this->model_accounts->getAccountsData();

		$this->data['results'] = $result;

		$this->render_template('accounts/bank', $this->data);
                
	}

	/*
	* Fetches the account data from the accounts table 
	* this function is called from the datatable ajax function
	*/
	public function fetchcashData()
	{
		$result = array('data' => array());
                // 1 is using for cash in orders
                $payment_method = 1;
		$data = $this->model_accounts->getOrdersData($payment_method);

		foreach ($data as $key => $value) {
                        $customer_data = $this->model_customers->getCustomerData($value['customer_id']);
			$count_total_item = $this->model_orders->countOrderItem($value['id']);
			$date = date('d-m-Y', $value['date_time']);
			$time = date('h:i a', $value['date_time']);

			$date_time = $date . ' ' . $time;

			// button
			$buttons = '';

			if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a target="__blank" href="'.base_url('orders/printDiv/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}

			if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			if($value['paid_status'] == 1) {
				$paid_status = '<span class="label label-success">Paid</span>';	
			}
			else {
				$paid_status = '<span class="label label-warning">Not Paid</span>';
			}

			$result['data'][$key] = array(
				$value['bill_no'],
				$customer_data['name'],
				$customer_data['phone'],
				$date_time,
				$count_total_item,
				$value['net_amount'],
				$paid_status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
        }
	
        public function fetchbankData()
	{
		$result = array('data' => array());
                // 2 is using for bank in orders
                $payment_method = 2;
		$data = $this->model_accounts->getOrdersData($payment_method);

		foreach ($data as $key => $value) {
                        $customer_data = $this->model_customers->getCustomerData($value['customer_id']);
			$count_total_item = $this->model_orders->countOrderItem($value['id']);
			$date = date('d-m-Y', $value['date_time']);
			$time = date('h:i a', $value['date_time']);

			$date_time = $date . ' ' . $time;

			// button
			$buttons = '';

			if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a target="__blank" href="'.base_url('orders/printDiv/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}

			if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			if($value['paid_status'] == 1) {
				$paid_status = '<span class="label label-success">Paid</span>';	
			}
			else {
				$paid_status = '<span class="label label-warning">Not Paid</span>';
			}

			$result['data'][$key] = array(
				$value['bill_no'],
				$customer_data['name'],
				$customer_data['phone'],
				$date_time,
				$count_total_item,
				$value['net_amount'],
				$paid_status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
        }
}