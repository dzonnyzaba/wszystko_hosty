<?php

	require_once "connection.php";
	require_once "funkcje.php";
	
	$conn = @mysqli_connect($servername, $username, $password, $dbname);
	if(!$conn){
		die("Błąd połączenia z bazą: ".mysqli_connect_error());
	}
	$file_path = '../../mysql/data/nowe_hosty/dane_xml.txt';
	$xml = simplexml_load_file('out.xml');
	$attrdate = $xml->runstats->finished->attributes();
	$datatab = $attrdate['timestr'];
	$data = utworzDate($datatab);
	$vlan = 10;
	$licznik_wierszy = 0;
	$tablica = array();
	$string = "";
    foreach($xml->host as $host){
        if(isset($host->address[1]) && isset($host->address[0])){
            $attrmac = $host->address[1]->attributes();
            $ajpi = $host->address[0]->attributes();
            $mac = (string)$attrmac['addr'];
            $ip = (string)$ajpi['addr'];
            // $tablica[$licznik_wierszy]['data'] = $data;
            $licznik_wierszy++;
			$string .= $licznik_wierszy."a,".$mac.",".$ip.",".$data.",".$vlan."\r\n";
        }
	}
	file_put_contents($file_path, $string);
	
	$sql = "LOAD DATA INFILE '$file_path' INTO TABLE tmp 
	FIELDS TERMINATED BY ',' LINES TERMINATED BY '\r\n'";
	
	$result = mysqli_query($conn, $sql);
	header('Location: roznice.php');