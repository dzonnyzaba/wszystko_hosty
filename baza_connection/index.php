<?php
//require_once 'db.php';

class test{
	public $db;
	
	public function __construct(){
		$class_db_file = 'db.php';
		
		if(file_exists($class_db_file)){
			require_once($class_db_file);
			$this->db = new db();
		}else{
			echo "brak pliku z klasą do łączenia z db";
		}
	}
	/*
	public function zaciagnij($sql){
		if($this->db->connection){
			if($results = $this->db->select($sql)){
				$row = mysqli_fetch_array($results);
				echo $row['fname']." ".$row['lname'];
			}else{
				echo 'Błąd pobrania danych z bazy: '.$this->db->error;
				return false;
			}
		}else{
			echo "Błąd połączenia mysql: ". $this->db->error;
			return false;
		}
	}
	*/
	
/*	public function insertuj($sql){
		$res = $this->db->pobierz_rezultat($sql);
		var_dump($res);
	}
	*/
	public function ins($sql){
		$this->db->insertuj($sql);
	}
	
	public function sel($sql){
		var_dump($this->db->selektuj($sql));
		$tab = $this->db->selektuj($sql);
		var_dump($tab);
	}
}


$zapytanie = "select * from person";
$t = new test();
$t->sel($zapytanie);