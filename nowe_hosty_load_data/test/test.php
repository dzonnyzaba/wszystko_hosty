<?php
	
	require_once "connection.php";
	libxml_disable_entity_loader(false);
	$conn = @mysqli_connect($servername, $username, $password, $dbname);
	if(!$conn){
		die("Błąd połączenia z bazą: ".mysqli_connect_error());
	}
	
	$sql = "LOAD XML LOCAL FILE 'person.xml' INTO TABLE person ROWS IDENTIFIED BY '<person>';";
	
	$result = mysqli_query($conn, $sql);
	// var_dump($result);
	// $row = mysqli_fetch_array($result);
	// var_dump($row);
	
	$doc = new DOMDocument();
	$doc->load('plik.xml');
	$doc->save('plik.xml', LIBXML_NOEMPTYTAG );