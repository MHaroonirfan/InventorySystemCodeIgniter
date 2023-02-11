<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shoporders extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = ' Shop Orders';

		$this->load->model('model_shoporders');
		$this->load->model('model_products');
                $this->load->model('model_users');
	}

	/* 
	* It only redirects to the manage order page
	*/
	public function index()
	{
		if(!in_array('viewShopOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Manage Shop Orders';
		$this->render_template('shoporders/index', $this->data);		
	}

	/*
	* Fetches the shop orders data from the shop orders table 
	* this function is called from the datatable ajax function
	*/
	public function fetchShopOrdersData()
	{
		$result = array('data' => array());

		$data = $this->model_shoporders->getShopOrdersData();

                $users = $this->model_users->getUsers();
                
		foreach ($data as $key => $value) {
                        $count_total_item = $this->model_shoporders->countShopOrderItem($value['id']);
			
			// button
			$buttons = '';

			if(in_array('viewShopOrder', $this->permission)) {
				$buttons .= '<a target="__blank" href="'.base_url('shoporders/printDiv/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}

			if(in_array('updateShopOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('shoporders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if(in_array('deleteShopOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

                        foreach ($users as $user){
                            if($user['id'] == $value['user_id']){
                                $user_name = $user['firstname'] . ' ' . $user['lastname'];
                            }
                        }
			$result['data'][$key] = array(
                                $user_name,
				$count_total_item,
				$value['date'],
				$value['time'],
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
	public function create()
	{
		if(!in_array('createShopOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Add Shop Order';

		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) {        	
        	
        	$order_id = $this->model_shoporders->create();
        	
        	if($order_id) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('shoporders/update/'.$order_id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('shoporders/create/', 'refresh');
        	}
        }
        else {
            // false case

        	$this->data['products'] = $this->model_products->getActiveProductData();
            $this->render_template('shoporders/create', $this->data);
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
		if(!in_array('updateShopOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
            }

		if(!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Update Shop Order';

		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
		
	
            if ($this->form_validation->run() == TRUE) {        	

                    $update = $this->model_shoporders->update($id);

                    if($update == true) {
                            $this->session->set_flashdata('success', 'Successfully updated');
                            redirect('shoporders/update/'.$id, 'refresh');
                    }
                    else {
                            $this->session->set_flashdata('errors', 'Error occurred!!');
                            redirect('shoporders/update/'.$id, 'refresh');
                    }
            }
            else {
                // false case
                    $result = array();
                    $orders_data = $this->model_shoporders->getShopOrdersData($id);

                    $result['order'] = $orders_data;
                    $orders_item = $this->model_shoporders->getShopOrdersItemData($orders_data['id']);

                    foreach($orders_item as $k => $v) {
                            $result['order_item'][] = $v;
                    }

                    $this->data['order_data'] = $result;

                    $this->data['products'] = $this->model_products->getActiveProductData();      	

                    $this->render_template('shoporders/edit', $this->data);
            }
	}

	/*
	* It removes the data from the database
	* and it returns the response into the json format
	*/
	public function remove()
	{
		if(!in_array('deleteShopOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$order_id = $this->input->post('order_id');

        $response = array();
        if($order_id) {
            $delete = $this->model_shoporders->remove($order_id);
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

	/*
	* It gets the product id and fetch the order data. 
	* The order print logic is done here 
	*/
	public function printDiv($id)
	{
		if(!in_array('viewShopOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		if($id) {
			$order_data = $this->model_shoporders->getShopOrdersData($id);
			$orders_items = $this->model_shoporders->getShopOrdersItemData($id);

			$order_date = $order_data['date'];

			$html = '<!-- Main content -->
			<!DOCTYPE html>
			<html>
			<head>
			  <meta charset="utf-8">
			  <meta http-equiv="X-UA-Compatible" content="IE=edge">
			  <title>AdminLTE 2 | Invoice</title>
			  <!-- Tell the browser to be responsive to screen width -->
			  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
			  <!-- Bootstrap 3.3.7 -->
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css').'">
			  <!-- Font Awesome -->
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/font-awesome/css/font-awesome.min.css').'">
			  <link rel="stylesheet" href="'.base_url('assets/dist/css/AdminLTE.min.css').'">
			</head>
			<body onload="window.print();">
			
			<div class="wrapper">
			  <section class="invoice">
			    <!-- title row -->
			    <div class="row">
			      <div class="col-xs-12">
			        <h2 class="page-header">
			          <small class="pull-right">Date: '.$order_date.'</small>
			        </h2>
			      </div>
			      <!-- /.col -->
			    </div>

			    <!-- Table row -->
			    <div class="row">
			      <div class="col-xs-12 table-responsive">
			        <table class="table table-striped">
			          <thead>
			          <tr>
			            <th>Product name</th>
			            <th>Qty</th>
			          </tr>
			          </thead>
			          <tbody>'; 

			          foreach ($orders_items as $k => $v) {

			          	$product_data = $this->model_products->getProductData($v['product_id']); 
			          	
			          	$html .= '<tr>
				            <td>'.$product_data['name'].'</td>
				            <td>'.$v['qty'].'</td>
			          	</tr>';
			          }
			          
			          $html .= '</tbody>
			        </table>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->
			  </section>
			  <!-- /.content -->
			</div>
		</body>
	</html>';

			  echo $html;
		}
	}

}