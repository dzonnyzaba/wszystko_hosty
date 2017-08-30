<?php
	
require_once "connection.php";
	
	$nazwa_pliku = 'dhcpd-vlan64.conf';
    $stare_hosty_plik = file($nazwa_pliku);
	$wzor_do_vlana = "@^dhcpd-vlan([0-9]{2}).conf$@";
	$dopasuj = preg_match($wzor_do_vlana, $nazwa_pliku, $match_vlan);
	$nr_vlan = $match_vlan[1];
    $wzor = '@^host ([0-9a-zA-Z._-]+) +{fixed-address (\d+\.\d+\.\d+\.\d+) ?;hardware ethernet +([a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2});}@';

    $conn = @mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
	$licznik = 0;
    foreach($stare_hosty_plik as $linijka){
        if(strlen($linijka)>1){
        if($reg = preg_match($wzor, $linijka, $match)){
		$licznik++;
        $nazwa = $match[1];
        $mac = $match[3];
        $ip = $match[2];
		echo $ip;
        $rezultat = mysqli_query($conn, "INSERT INTO znane_hosty(`nazwa_hosta`, `mac_address`, `ip_address`, `VLAN`) VALUES ('$nazwa', '$mac', '$ip', '$nr_vlan')");
          
        if($rezultat){
            echo "<br>Rekord $licznik został dodany poprawnie<br>";
        }else{ echo "<br>Błąd nie udało się dodać nowego rekordu $licznik<br>";}
            }else{
                echo "<br>wiersz nie pasuje do wzoru $licznik<br>";
            }
        }
    }
    mysqli_close($conn);

?>
