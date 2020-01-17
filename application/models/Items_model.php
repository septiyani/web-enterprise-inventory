<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Profile model
*	
*	
*/
class Items_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->data_table = 'inv_items';
		$this->data_table2 = 'inv_stock';
		$this->users_table     = 'users';
		$this->loggedinuser    = $this->ion_auth->user()->row();
		
	}
	public function get_items($id='',$limit='', $start='', $order_method='desc')
	{
		$this->db->select(
			$this->data_table.".id, ".
			$this->data_table.".code, ".
			$this->data_table.".item_name, ".
			$this->data_table.".desc, ".
			$this->users_table.".username, ".
			$this->users_table.".first_name, ".
			$this->users_table.".last_name".
			", COALESCE(b.qty,0) as qty"
		);
		$this->db->from($this->data_table);

		// join user table
		$this->db->join(
			$this->users_table,
			$this->data_table.'.created_by = '.$this->users_table.'.username',
			'left');

		$this->db->join(
			'(SELECT a.item_id, a.qty_in - COALESCE(b.qty_out, 0) as qty FROM (SELECT item_id, SUM(qty) as qty_in FROM inv_stock WHERE flag = 1 GROUP BY item_id) a LEFT JOIN (SELECT item_id, SUM(qty) as qty_out FROM inv_stock WHERE flag = 0 GROUP BY item_id) b ON a.item_id = b.item_id) AS b',
			$this->data_table.'.code = b.item_id',
			'left');
		
		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->data_table.'.id', $order_method);
		}

		$datas = $this->db->get();
		return $datas;
	}
	
	public function insert_items($datas)
	{
		// user and datetime
		$datas['created_by'] = $this->loggedinuser->username;
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('created_on', 'NOW()', FALSE);
		$this->db->set('updated_on', 'NOW()', FALSE);

		if ($this->db->insert($this->data_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}
	
	public function code_check($code)
	{
		$this->db->where('code', trim($code));
		$datas = $this->db->get($this->data_table);

		return $datas;
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
	
	public function delete_item($id)
	{
		// user and datetime
		

		$this->db->where('id', $id);
		if($this->db->delete($this->data_table)) {
			return TRUE;
		}
		return FALSE;
	}

}


// End of profile model