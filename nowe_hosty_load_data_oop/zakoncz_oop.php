<?php
//require_once "connection.php";
class Zakoncz{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;
    
    private $zapytanie_zakoncz;

    public function __construct(){
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "nowe_hosty";
        $this->zapytanie_zakoncz = "DELETE FROM tmp";
        $this->conn = @mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
	if(!$this->conn){
            die("B³¹d po³¹czenia z baz¹: ".mysqli_connect_error());
	}
    }
    
    
    public function czyscTabele(){
	$rezultat_zakoncz = mysqli_query($this->conn, $this->zapytanie_zakoncz);        
    }
    
    public function __destruct(){
        mysqli_close($this->conn);
	header('Location: index.php');
    }
}
$koniec = new Zakoncz();
$koniec->czyscTabele();

	
