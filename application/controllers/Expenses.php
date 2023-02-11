<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Expenses extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Expenses';

		$this->load->model('model_expenses');
	}

	/* 
	* It only redirects to the manage product page and
	*/
	public function index()
	{
		if(!in_array('viewExpense', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$result = $this->model_expenses->getExpenseData();

		$this->data['results'] = $result;

		$this->render_template('expenses/index', $this->data);
	}

	/*
	* Fetches the expense data from the expense table 
	* this function is called from the datatable ajax function
	*/
	public function fetchExpenseData()
	{
		$result = array('data' => array());

		$data = $this->model_expenses->getExpenseData();
		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			if(in_array('viewExpense', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editExpense('.$value['id'].')" data-toggle="modal" data-target="#editExpenseModal"><i class="fa fa-pencil"></i></button>';	
			}
// 			if(in_array('expenseReport', $this->permission)) {
// 				$buttons .= ' <a href="'.base_url('expenses/report/').'" class="btn btn-default"><i class="fa fa-file"></i></a>';
// 			}
			if(in_array('deleteExpense', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeExpense('.$value['id'].')" data-toggle="modal" data-target="#removeExpenseModal"><i class="fa fa-trash"></i></button>
				';
			}				

			$status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['name'],
				$value['description'],
				$value['amount'],
				$value['date'],
				$value['time'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	* It checks if it gets the expense id and retreives
	* the expense information from the expense model and 
	* returns the data into json format. 
	* This function is invoked from the view page.
	*/
	public function fetchExpenseDataById($id)
	{
		if($id) {
			$data = $this->model_expenses->getExpenseData($id);
			echo json_encode($data);
		}

		return false;
	}

	/*
	* Its checks the expense form validation 
	* and if the validation is successfully then it inserts the data into the database 
	* and returns the json format operation messages
	*/
	public function create()
	{

		if(!in_array('createExpense', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('expense_name', 'Expense name', 'trim|required');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'name' => $this->input->post('expense_name'),
        		'description' => $this->input->post('expense_description'),
        		'amount' => $this->input->post('expense_amount'),
        		'date' => $this->input->post('expense_date'),
        		'time' => $this->input->post('expense_time'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->model_expenses->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Succesfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the expense information';			
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);

	}

	/*
	* Its checks the expense form validation 
	* and if the validation is successfully then it updates the data into the database 
	* and returns the json format operation messages
	*/
	public function update($id)
	{
		if(!in_array('updateExpense', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_expense_name', 'Expense name', 'trim|required');
			$this->form_validation->set_rules('edit_active', 'Active', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'name' => $this->input->post('edit_expense_name'),
                                'description' => $this->input->post('expense_description'),
                        	'amount' => $this->input->post('expense_amount'),
                		'date' => $this->input->post('expense_date'),
                		'time' => $this->input->post('expense_time'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_expenses->update($data, $id);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Succesfully updated';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updated the expense information';			
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Error please refresh the page again!!';
		}

		echo json_encode($response);
	}

	/*
	* It removes the expense information from the database 
	* and returns the json format operation messages
	*/
	public function remove()
	{
		if(!in_array('deleteExpense', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$expense_id = $this->input->post('expense_id');
		$response = array();
		if($expense_id) {
			$delete = $this->model_expenses->remove($expense_id);

			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Successfully removed";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the expense information";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Refersh the page again!!";
		}

		echo json_encode($response);
	}

        public function report(){
            if(!in_array('expenseReport', $this->permission)) {
                redirect('dashboard', 'refresh');
            }
            if($this->input->post('from_date') && $this->input->post('to_date')) {
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');
            } else {
                $from_date = date('Y-m-d', strtotime('-7 days'));
                $to_date = date('Y-m-d');
            }
            $result = $this->model_expenses->getReportExpenseData($from_date, $to_date);
            
            $this->data['to_date'] = $to_date;
            $this->data['from_date'] = $from_date;            
            $this->data['results'] = $result;
            $this->data['page_title'] = 'Expenses Report';
            $this->render_template('expenses/report', $this->data);
            
        }
}