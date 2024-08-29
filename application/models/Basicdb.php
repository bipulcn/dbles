<?php

/**
 *
 */
class Basicdb extends CI_Model
{
	var $data;
	function __construct()
	{
		parent::__construct();
		$this->data = array(
			// "datafile"=>"SELECT * FROM datafile"
		);
	}
	function view_data($table)
	{
		$exeq = $this->db->get($table);
		return $exeq->result();
	}
	function wheres($table, $aray)
	{
		$exeq = $this->db->get_where($table, $aray);
		return $exeq->result();
	}
	function whereby($table, $aray, $by)
	{
		$this->db->order_by($by, "DESC");
		$exeq = $this->db->get_where($table, $aray);  // this was depacted
		return $exeq->result();
	}
	function getlike($table, $col, $val)
	{
		$this->db->like($col, $val);
		$exeq = $this->db->get($table);
		return $exeq->result();
	}
	function insert($table, $data)
	{
		$this->db->insert($table, $data);
	}
	function update($table, $data, $whr)
	{
		$this->db->where($whr);
		$this->db->update($table, $data);
	}
	function query($query)
	{
		$q = $this->db->query($query);
		return $q->result();
	}
	function blnkquery($query)
	{
		$this->db->query($query);
	}
	function bool_query($query)
	{
		$q = $this->db->query($query);
		$exist = false;
		if ($q->num_rows() > 0) $exist = true;
		return $exist;
	}
	function delete($table, $array)
	{
		$this->db->delete($table, $array);
	}
	function lstAutoId()
	{
		return $this->db->insert_id();
	}
	function lstQuery()
	{
		return $this->db->last_query();
	}
}
