<?php
$cveCatalogo = "I-1800008687";
$numInventar = 2113465;
$annio = 87698;
		if ($cveCatalogo != "Todos")
			$where[] = " CveCatalogo = '" . $cveCatalogo . "' ";
		if ($numInventar != "")
			$where[] = " NumInv = " . $numInventar . " ";
		if ($annio != "")
			$where[] = " AnnoAlta = " . $annio . " ";
		//Mezclar el array where y agregar la palabra and entre cada uno
		foreach($where as $val){
			$strQ = "{$strQ}{$val}";
			if(end($where) != $val)
				$strQ = $strQ ." and ";
		}
		echo $strQ;
?>