<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// set error delimeters
		$this->form_validation->set_error_delimiters(
			$this->config->item('error_start_delimiter', 'ion_auth'),
			$this->config->item('error_end_delimiter', 'ion_auth')
		);

		// model
		$this->load->model(
			array(
				'stock_model',
				'profile_model'
			)
		);

		// default datas
		// used in every pages
		if ($this->ion_auth->logged_in()) {
			// user detail
			$loggedinuser = $this->ion_auth->user()->row();
			$this->data['user_full_name'] = $loggedinuser->first_name . " " . $loggedinuser->last_name;
			$this->data['user_photo']     = $this->profile_model->get_user_photo($loggedinuser->username)->row();
		}
	}

	/**
	*	Index Page for this controller.
	*	Showing list of items and add new form
	*
	*	@param 		string 		$page
	*	@return 	void
	*
	*/
	public function index($page="")
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/items', 'refresh');
		}
		// Logged in
		else{
			$this->data['data_list'] = $this->stock_model->get_items();

			// Set pagination
			$config['base_url']         = base_url('items/index');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);

			// Get datas and limit based on pagination settings
			// if ($page=="") { $page = 1; }
			// $this->data['data_list'] = $this->items_model->get_items("",
			// 	$config['per_page'],
			// 	( $page - 1 ) * $config['per_page']
			// );
			// $this->data['last_query'] = $this->db->last_query();
			$this->data['pagination'] = $this->pagination->create_links();

			// set the flash data error message if there is one
			$this->data['message']   = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_item/index');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_item/js');
			$this->load->view('js_script');
		}
	}
	
	 public function update()
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/items', 'refresh');
		}
		// Logged in
		else {
			// input validation rules
			$this->form_validation->set_rules('qty', 'Qty', 'numeric|trim|required');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// validation run
				if ($this->form_validation->run() === TRUE) {
					$data = array(
						'item_id'    => $this->input->post('item'),
						'qty'    => $this->input->post('qty')
					);
					// echo json_encode($_POST);die;
					$type = $this->input->post('type');

					// check to see if we are inserting the data
					if ($this->stock_model->insert_stock($data, $type)) {
						// Success message
						$this->session->set_flashdata('message',
							$this->config->item('success_start_delimiter', 'ion_auth')
							."Stock Successfully Updated!".
							$this->config->item('success_end_delimiter', 'ion_auth')
						);

						
					}
					else {
						// Error message
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Failed To Update!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('items', 'refresh');
				}
			}
			$this->data['data_list'] = $this->stock_model->get_items();
			$this->data['open_form'] = "open";

			// Set pagination
			$config['base_url']         = base_url('items/index');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_item/index');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_item/js');
			$this->load->view('js_script');
		}
	}
	
	public function _code_check($code)
	{
		$datas = $this->items_model->code_check($code);
		$total = count($datas->result());
		if ($total == 0) {
			return TRUE;
		}
		else {
			$this->form_validation->set_message(
				'_code_check', 'The {field} already exists.'
			);
			return FALSE;
		}
	}

	public function stock_in(){
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/items', 'refresh');
		}
		// Logged in
		else{
			$this->data['data_list'] = $this->stock_model->get_items();

			// Set pagination
			$config['base_url']         = base_url('stock/index');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);

			// set the flash data error message if there is one
			$this->data['message']   = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->data['qty'] = array(
				'name' => 'qty',
				'id' => 'qty',
				'type' => 'number',
				'min' => "0",
				'value' => $this->form_validation->set_value('qty'),
                'class' => 'form-control',
                'required' => 'required',
			);
			// var_dump($this->data['data_list']);

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('stock/stock_in');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_item/js');
			$this->load->view('js_script');
		}
	}

	public function stock_out(){
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/items', 'refresh');
		}
		// Logged in
		else{
			$this->data['data_list'] = $this->stock_model->get_items();

			// Set pagination
			$config['base_url']         = base_url('stock/index');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);

			// set the flash data error message if there is one
			$this->data['message']   = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->data['qty'] = array(
				'name' => 'qty',
				'id' => 'qty',
				'type' => 'number',
				'min' => "0",
				'value' => $this->form_validation->set_value('qty'),
                'class' => 'form-control',
                'required' => 'required',
			);
			// var_dump($this->data['data_list']);

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('stock/stock_out');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_item/js');
			$this->load->view('js_script');
		}
	}
}

/* End of items.php */
