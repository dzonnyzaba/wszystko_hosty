<?php
require_once "connection.php";

class Generuj{
    private $do_pliku;
    private $nazwa_pliku;
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;
    
    public function __construct() {
        $this->do_pliku = "";
        $this->nazwa_pliku = "kat/hosty_z_bazy.conf";
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "nowe_hosty";
        $this->conn = @mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
	if(!$this->conn){
            die("B³¹d po³¹czenia z baz¹: ".mysqli_connect_error());
	}
    }
    
    public function generujPlik(){
        $zapytanie_generuj = "SELECT * FROM znane_hosty";
        
        $rezultat_generuj = mysqli_query($this->conn, $zapytanie_generuj);
        
        while($row = mysqli_fetch_array($rezultat_generuj)){
            $this->do_pliku .= "host ".$row['nazwa_hosta']." {fixed address ".$row['ip_address'].
            ";hardware ethernet ".$row['mac_address'].";}"."\r\n";
	}
        
        mysqli_free_result($rezultat_generuj);
	
	mysqli_close($this->conn);
        file_put_contents($this->nazwa_pliku, $this->do_pliku);
        header('location: index.php');
    }
}
$generuj = new Generuj();
$generuj->generujPlik();
