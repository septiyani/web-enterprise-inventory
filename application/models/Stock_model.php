<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Profile model
*	
*	
*/
class Stock_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->data_table = 'inv_items';
		$this->stock_table = 'inv_stock';
		$this->loggedinuser    = $this->ion_auth->user()->row();
		
	}
	public function get_items($id='',$limit='', $start='', $order_method='')
	{
		$this->db->select(
			$this->data_table.".code, ".
			$this->data_table.".item_name, "
		);
		$this->db->from($this->data_table);

		$datas = $this->db->get();
		return $datas;
    }
	public function insert_stock($datas, $type)
	{
		// user and datetime
		($type=="in") ? $datas['flag'] = '1' : $datas['flag'] = '0';
		$datas['updated_by'] = $this->loggedinuser->username;
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('created_on', 'NOW()', FALSE);
		$this->db->set('updated_on', 'NOW()', FALSE);

		if ($this->db->insert($this->stock_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}
	
	public function update_items($id, $datas)
	{
		// user and datetime
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('updated_on', 'NOW()', FALSE);

		$this->db->where('id', $id);
		if($this->db->update($this->data_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}


}


// End of profile model