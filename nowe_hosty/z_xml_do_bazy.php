<?php
	
	ob_start();
	$suma = 0;
	$start = microtime(true);
	require_once "connection.php";
	require_once "funkcje.php";
   
	$conn = @mysqli_connect($servername, $username, $password, $dbname);
	if(!$conn){
		die("Błąd połączenia z bazą: ".mysqli_connect_error());
	}
	//echo microtime();
	$zapytanie_tworz_tabele = "CREATE TABLE `nowe_hosty`.`tmp` 
	( `id_nowego_hosta` INT(10) NOT NULL AUTO_INCREMENT , 
	`nowy_ip` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL , 
	`nowy_mac` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL , 
	`data` DATE NOT NULL , `VLAN` INT(10) NOT NULL, PRIMARY KEY (`id_nowego_hosta`), UNIQUE (`nowy_mac`)) 
	ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_polish_ci";
	$tworz = mysqli_query($conn, $zapytanie_tworz_tabele);
	
    $xml = simplexml_load_file('out.xml');
	$attrdate = $xml->runstats->finished->attributes();
	$datatab = $attrdate['timestr'];
	$data = utworzDate($datatab);
	$licznik_wierszy = 0;
    foreach($xml->host as $host){
		$licznik_wierszy++;
        if(isset($host->address[1])){
    $atrmac = $host->address[1]->attributes();
    //echo "mac: ".$atrmac['addr']." ip: ";
        }
        if(isset($host->address[0])){
    $atrip = $host->address[0]->attributes();
        }
	$zapytanie_insert = "INSERT INTO tmp(nowy_ip, nowy_mac, data, VLAN) VALUES 
	('$atrip', '$atrmac', '$data')";
	$rezultat_insert = mysqli_query($conn, $zapytanie_insert);
	if($rezultat_insert){
		echo "wstawiono $licznik_wierszy wiersz<br>";
    }else{
		echo "nie udało się wstawić wiersza $licznik_wierszy.<br>";
		}
	}
	mysqli_close($conn);
	echo "<br>";
	$stop = microtime(true);
	$suma = $stop - $start;
	echo $suma;
	header('Location: roznice.php');
	ob_end_flush();
?>