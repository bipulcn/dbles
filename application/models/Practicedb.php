<?php
	/**
	*
	*/
	class Practicedb extends CI_Model
	{
		var $pdb;
		var $tables;
		function __construct()
		{
			parent::__construct();
			$this->pdb = $this->load->database('practice', TRUE);
			$dt = $this->pdb->query("show tables");
			$hd = 'Tables_in_'.$this->pdb->database;
			$tabs = array();
			foreach ($dt->result() as $row) {
				$tnam = str_replace('_bk', '', $row->$hd);
				$tabs[] = $tnam;
				$this->pdb->query("CREATE TEMPORARY TABLE IF NOT EXISTS ".$tnam." AS (SELECT * FROM ".$row->$hd.")");
				$lst = $this->query("SHOW KEYS FROM ".$row->$hd." WHERE Key_name = 'PRIMARY'");
				$fld = '';
				foreach ($lst as $k => $v) {
					if($fld!='') $fld .=',';
					$fld .= $v->Column_name;
				}
				if($fld!='') $this->rquery("ALTER TABLE ".$tnam." ADD PRIMARY KEY(".$fld.")");
			}
			$this->tables = $tabs;
		}
    function query($query) {
      $q = $this->pdb->query($query);
			return $q->result();
    }
	function test() {
		$ts = $this->pdb->query("SELECT now()");
		return $ts->result();
	}
    // function equery($query) {
    //   $q = $this->pdb->query($query);
		// 	$error = $this->pdb->error();
		// 	return $error;
		// 	return $q->result();
    // }
		function insert($query) {
			$this->pdb->query($query);
		}
		function rquery($query) { return $this->pdb->query($query);}
		function tablist() { return $this->tables; }
	}
