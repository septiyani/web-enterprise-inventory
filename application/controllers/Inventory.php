<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Inventory Controller
*
*	@author Noerman Agustiyan
* 				noerman.agustiyan@gmail.com
*					@anoerman
*
*	@link 	https://github.com/anoerman
*		 			https://gitlab.com/anoerman
*
*	Accessible for admin and member user group
*
*/
class Inventory extends CI_Controller {

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
				'profile_model',
				'items_model',
				'logs_model',
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
	*	Showing add new data form and links to another locations.
	*
	*	@return 	void
	*
	*/
	public function index($page="")
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else{
			 
			$this->data['item_list']   = $this->items_model->get_items('','','','asc');
			$filters = array();
			if (isset($_POST) && !empty($_POST)) {
			$filters  = array(
						'id' => $this->input->post('item'),
						'from_date' => "",
						'end_date' => "",
						
					);
			
			$this->data['data_list'] = $this->items_model->get_items_by_keyword($filters,"","");
			
			}else{
			
			$this->data['data_list'] = $this->items_model->get_items_by_keyword($filters,"","");
			 
			 
			}
			
		}
			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_data/index');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_data/js');
			$this->load->view('js_script');
		 
	}
	
	public function download($filter){
		$filters  = array(
						'id' => $filter,
						'from_date' => "",
						'end_date' => "",
						
					);
			
			 
	 $data = array( 'title' => 'Laporan Stock',
	 'data_list' => $this->items_model->get_items_by_keyword($filters,"",""));
			 
			$this->load->view('inv_data/laporan_excel', $data);
		 
	 
	 }
	
}

/* End of Inventory.php */
