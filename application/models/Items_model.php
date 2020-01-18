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
		$this->data_stock = 'inv_stock';
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
	
	
	public function get_items_by_keyword($filters,$limit='', $start='', $order_method='desc')
	{
		$id="";
		$from_date="";
		$end_date="";
		if ($filters!="") {
			foreach ($filters as $key => $value) {
			if ($value !="" ) {
				if($key =="id" && $value !="null"){
					$id= "and id = $value";
				}
				if($key =="from_date" ){
					$from_date= "and stock_date >= $value ";
				}
				
				if($key =="end_date"){
					$end_date= "and stock_date <= $value ";
				}
				
			}
		}
			
		}
		$query = $this->db->query(
            "select id,item_name,code,stock_date,sum(qty_in) as qty_in, sum(qty_out) as qty_out from(
			SELECT b.id,b.item_name,b.code,DATE_FORMAT(a.stock_date, '%d/%m/%Y') as stock_date,SUM(qty) as qty_in, 0 as qty_out 
			FROM inv_stock a, inv_items b 
			where a.item_id = b.id 
			and a.flag ='1'
			group by DATE_FORMAT(a.stock_date, '%d%m%Y'),b.code,b.id

			union all

			SELECT b.id,b.item_name,b.code,DATE_FORMAT(a.stock_date, '%d/%m/%Y') as stock_date,0 as qty_in, sum(a.qty) as qty_out 
			FROM inv_stock a, inv_items b 
			where a.item_id = b.id 
			and a.flag ='0'
			group by DATE_FORMAT(a.stock_date, '%d%m%Y'),b.code,b.id
			) x
			where 1=1
			$id
			$from_date 
			$end_date 
			group by code,stock_date,id
			");
		
		return $query->result_array();
    }
	
	 

}


// End of profile model