<?php

class db{
	private $db_host;
	private $db_user;
	private $db_pass;
	private $db_name;
	
	public $connection;
	public $error;
	
	public function __construct(){
		$this->db_host = "localhost";
		$this->db_user = "root";
		$this->db_pass = "";
		$this->db_name = "nowe_hosty";
		$this->connection = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		$this->error = "";
	}
	
	
	public function connect(){
		if(!$this->connection){
			die("Błąd połączenia z bazą: ".mysqli_connect_error());
			$this->error = mysqli_error();
			return false;
		}else{
			return $this->connection;
		}
	}
	
	public function select($sql){
		if($this->connect()){
			if(isset($sql) && !empty($sql)){
				if($result = mysqli_query($this->connect(), $sql)){
					return $result;
				}else{
					$this->error = mysqli_error($this->connect());
					return false;
				}
			}else{
				$this->error = 'Błąd zapytania sql';
				return false;
			}
		}else{
			$this->error = 'Brak połączenia z bazą danych';
			return false;
		}
	}
	
	public function query($sql){
		if(isset($sql) && !empty($sql)){
			if($this->connect()){
				if($result = mysqli_query($this->connect(), $sql)){
					return true;
				}else{
					$this->error = mysqli_error();
					return false;
				}
			}else{
				$this->error = 'Brak połączenia z bazą danych';
				return false;
			}
		}else{
			$this->error = 'Błąd zapytania SQL';
			return false;
		}
	}
	
	
	public function close(){
		if($this->connect()){
			mysqli_close($this->connection);
		}else{
			$this->error = 'Brak aktywnego połączenia';
		}
	}
	
	public function __destruct(){
		$this->close();
	}
	
}




