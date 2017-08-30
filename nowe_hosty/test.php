<?php
$tab = array("pies", "kot", "kura", "swinia");
// var_dump($tab);
// echo "<br>";
// unset($tab[1]);
// var_dump($tab);
for($i=0; $i<count($tab); $i++){
	if($i==2){
		array_splice($tab, -1); 
	}
}

// foreach($tab as $t){
	// if($t=="kura"){
		// unset($t);
	// }
// }
 var_dump($tab);