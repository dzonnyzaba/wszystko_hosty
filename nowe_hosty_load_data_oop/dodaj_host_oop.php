<?php
if(isset($_GET['id'])){
	$id = $_GET['id'];
?>
<form method="post">
    nazwa: <input type="text" name="nazwa"/>
    lokalizacja: <input type="text" name="lokalizacja"/>
    uwagi: <input type="text" name="uwagi"/>
    <input type="submit" value="dodaj"/>
</form>
<a href="roznice_oop.php">Powr�t do tabelki</a>
<?php        
if((isset($_POST['nazwa']) && !empty($_POST['nazwa'])) && 
(isset($_POST['lokalizacja']) && !empty($_POST['lokalizacja'])) && 
(isset($_POST['uwagi']) && !empty($_POST['uwagi']))){
    
class Dodaj{
    private $nowa_nazwa;
    private $nowa_lokalizacja;
    private $nowe_uwagi;
    private $id;
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;
    
    public function __construct(){
        $this->nowa_nazwa = $_POST['nazwa'];
        $this->nowa_lokalizacja = $_POST['lokalizacja'];
        $this->nowe_uwagi = $_POST['uwagi'];        
        $this->id = $_GET['id'];
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "nowe_hosty";
        $this->conn = @mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
	if(!$this->conn){
            die("B��d po��czenia z baz�: ".mysqli_connect_error());
	}
    }
    
    public function pobierzPozostaleDane(){
        $zapytanie_nowe = "SELECT * FROM tmp WHERE id_nowego_hosta=$this->id";
	$rezultat_nowe = mysqli_query($this->conn, $zapytanie_nowe);
	$row = mysqli_fetch_array($rezultat_nowe);
        return $row;
    }
    
    public function dodajRekord(){
        $row_sel = $this->pobierzPozostaleDane();
        $zapytanie_znane = "INSERT INTO znane_hosty(nazwa_hosta, mac_address, 
	data_dodania, lokalizacja, uwagi, VLAN, ip_address) 
	VALUES('".$this->nowa_nazwa."', '".$row_sel['nowy_mac']."', '".$row_sel['data']."', '".
        $this->nowa_lokalizacja."', '".$this->nowe_uwagi."', '".$row_sel['VLAN']."', '"
        .$row_sel['nowy_ip']."')";
        $rezultat_znane = mysqli_query($this->conn, $zapytanie_znane);
        if($rezultat_znane){
		echo "do��czono host do bazy";
	}else{
		echo "nie uda�o si� do��czyc hosta do bazy";
	}
        //mysqli_free_result($rezultat_znane);
        return 0;
    }
    
    public function kasujRekord(){
        //$this->dodajRekord();
	$zapytanie_nowe_kasuj = "DELETE FROM tmp WHERE id_nowego_hosta=$this->id";
	mysqli_query($this->conn, $zapytanie_nowe_kasuj);
	
	mysqli_close($this->conn);
        header('location: roznice_oop.php');        
    }
}
$dodaj = new Dodaj();
$dodaj->dodajRekord();
$dodaj->kasujRekord();
//header('location: roznice_oop.php');
}else{
    echo "<p>wype�nij wszystkie pola</p>";
}
}else{
	header('location: roznice_oop.php');
	exit();
}

