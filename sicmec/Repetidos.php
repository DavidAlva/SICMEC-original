<?php require_once('Connections/SICMEC.php');?>

<?php ini_set('max_execution_time', 3600);

if   ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1"))
  {
  $editFormAction = $_SERVER['PHP_SELF'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);}
	
  mysql_select_db($database_SICMEC, $SICMEC);
  $query_constemp = sprintf("SELECT * FROM actfijo GROUP BY CveCatalogo, NumInv, AnnoAlta ORDER BY CveAct DESC");
  $constemp = mysql_query($query_constemp, $SICMEC) or die(mysql_error());
  $totalRows_constemp = mysql_num_rows($constemp);
  $contador = 0;
  $cve = 0;
  while ($row_constemp = mysql_fetch_assoc($constemp))
    {
     $query_cons = sprintf("SELECT * FROM actfijo WHERE CveCatalogo = '%s' AND NumInv = %s AND AnnoAlta= %s AND NumSerie != '%s'", $row_constemp['CveCatalogo'], $row_constemp['NumInv'], $row_constemp['AnnoAlta'], $row_constemp['NumSerie']);
     $cons = mysql_query($query_cons, $SICMEC) or die(mysql_error());
     $row_cons = mysql_fetch_assoc($cons);
     $totalRows_cons = mysql_num_rows($cons);
     if ($totalRows_cons > 0)
      {
	  if ($row_constemp['CveAct'] > $row_cons['CveAct'])
	    {
	      $mayor = $row_constemp['CveAct'];
		  $menor = $row_cons['CveAct'];
		  $status = $row_cons['CveStatus'];
		  $ubic = $row_cons['CveUbic'];
		  $hist = $row_cons['CveHist'];
		}
	  else   
	    {
		 $mayor = $row_cons['CveAct'];
		 $menor = $row_constemp['CveAct'];
		 $status = $row_constemp['CveStatus'];
   	     $ubic = $row_constemp['CveUbic'];
         $hist = $row_constemp['CveHist'];
		} 
	  $query_update = sprintf("UPDATE actfijo SET CveStatus = %s, CveUbic = %s, CveHist = %s WHERE CveAct = %s ", $status, $ubic, $hist, $mayor);
	  $cons = mysql_query($query_update, $SICMEC) or die(mysql_error());
	  $query_delete = sprintf("DELETE FROM actfijo WHERE CveAct = %s", $menor);
      $cons = mysql_query($query_delete, $SICMEC) or die(mysql_error());
	  $contador += 1;
      }
    }
	echo "------------------------".$contador;	
  }
  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Busca Repetidos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<table width="43%" border="0" align="center"><!--DWLayoutTable-->
  <tr>
    <td><div align="center" class="Estilo1">Procedimiento para Actualizar la BD </div></td>
  </tr>
  <tr>
    <td width="100%"><form name="form1" method="post" action="">
      <div align="center">
        <input type="submit" name="Submit" value="Busca Repetidos">
        <input type="hidden" name="MM_insert" value="form1">
      </div>
    </form></td>
  </tr>
</table>
</body>
</html>