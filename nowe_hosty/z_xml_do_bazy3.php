<?php
	
	//ob_start();
	$suma = 0;
	$start = microtime(true);
	require_once "funkcje.php";
	require_once "connection.php";
	 
	$tabela_z_xmla = array();
    $xml = simplexml_load_file('out.xml');
	$attrdate = $xml->runstats->finished->attributes();
	$datatab = $attrdate['timestr'];
	$data = utworzDate($datatab);
	$licznik_wierszy = 0;
    foreach($xml->host as $host){
        if(isset($host->address[1]) && isset($host->address[0])){
			$attrmac = $host->address[1]->attributes();
			$ajpi = $host->address[0]->attributes();
			$tabela_z_xmla[$licznik_wierszy]['mac'] = $attrmac['addr'];
			$tabela_z_xmla[$licznik_wierszy]['ip'] = $ajpi['addr'];
			$licznik_wierszy++;	
		}
	}

	$stop = microtime(true);
	$suma = $stop - $start;
//echo $tabela_z_xmla[0]['mac'];
	
	$conn = @mysqli_connect($servername, $username, $password, $dbname);
	if(!$conn){
		die("Błąd połączenia z bazą: ".mysqli_connect_error());
	}
	
	foreach($tabela_z_xmla as $t){
	$zapytanie = "SELECT mac_address, ip_address FROM znane_hosty WHERE mac_address='".$t['mac']."'";
	$rezultat_porownanie = mysqli_query($conn, $zapytanie);
	//var_dump($rezultat_porownanie);
	$row=mysqli_fetch_array($rezultat_porownanie);
	echo "mac: ".$row['mac_address']." ip: ".$row['ip_address']."<br>";
	}
	$nowe = array();
	$j=0;
	// while($row = mysqli_fetch_array($rezultat_porownanie)){

		// for($i=0; $i<count($tabela_z_xmla); $i++){
			// if($tabela_z_xmla[$i]['mac']==$row['mac_address']){
				// unset($tabela_z_xmla[$i]);
				// array_splice($tabela_z_xmla, 1, 1);
			// }
		// }
	// }
	// $licz =1;
	// foreach($tabela_z_xmla as $n){
		// echo "id= $licz mak: ".$n['mac']." ip: ".$n['ip']."<br>";
		// $licz++;
	// }
?>
<!doctype html>
<html>
     <head>
          <meta charset="UTF-8" />
     </head>
     <body>
	 <table border=1>
		<tr>
			<th>id</th><th>adres IP</th><th>adres MAC</th><th></th>
		</tr>
		<?php
			// while($row = mysqli_fetch_array($rezultat)){
				// echo "<tr>";
				// echo "<td>".$row['id_nowego_hosta']."</td><td>".
				// $row['nowy_ip']."</td><td>".$row['nowy_mac'].'</td><td><a href="dodaj_host.php?id='.
				// $row['id_nowego_hosta'].'">Dodaj hosta do bazy</a></td>';
				// echo "</tr>";
			// }
			
			//mysqli_free_result($rezultat);
	
			mysqli_close($conn);
		?>
	 </table>
	 <a href="zakoncz.php">Zakończ</a>
     </body>
</html>
?>