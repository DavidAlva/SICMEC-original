<?php
require_once('Connections/consulta.php'); 
require('fpdf.php');
session_start(); 
$consecutivo = $_SESSION['consecutivo'];


$query_impconsulta = sprintf("SELECT * FROM ccertificados WHERE Consecutivo = '%s'", $consecutivo);
$impconsulta = mysql_query($query_impconsulta, $consulta) or die(mysql_error());
$row_impconsulta = mysql_fetch_assoc($impconsulta);
$totalRows_impconsulta = mysql_num_rows($impconsulta);

$vconsecutivo = $row_impconsulta["Consecutivo"];
$vmatricula = $row_impconsulta["Matricula"];
$vnombre = $row_impconsulta["Paterno"] . " " . $row_impconsulta["Materno"] . " " . $row_impconsulta["Nombre"];
$vfnacim = $row_impconsulta["FNacim"];
$vfconc = $row_impconsulta["FConclusion"];
$vpromedio = $row_impconsulta["Promedio"];
$vetapa = $row_impconsulta["Etapa"];
$vmodelo = $row_impconsulta["Modelo"];
$vfolio = $row_impconsulta["Literal"] . " - " . $row_impconsulta["Folio"] . "  / " . $row_impconsulta["TipoFormato"];
$vlibro = $row_impconsulta["Libro"];
$vfoja = $row_impconsulta["Foja"];
$vfemision = $row_impconsulta["FEmision"];
$vfelabora = $row_impconsulta["FElabora"];
$vfentrega = $row_impconsulta["FEntrega"];
$vfcancela = $row_impconsulta["FCancela"];
$vcvecancela = $row_impconsulta["CveCancela"];
$vobserva = $row_impconsulta["Observaciones"];
$vbase = $row_impconsulta["Base"];


$pdf=new FPDF();
$pdf->SetProtection(array('print'));
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial','B',11);
$pdf->SetDisplayMode("real","default");
$pdf->Cell(50);
$pdf->Cell(120,5,'INSTITUTO NACIONAL PARA LA EDUCACION DE LOS ADULTOS',0,1,'C');
$pdf->Ln();$pdf->Cell(75);$pdf->Cell(60,5,'Delegacin Guanajuato',0,1,'C');
$pdf->Ln();$pdf->Cell(70);$pdf->Cell(70,5,'Detalle de Certificados Emitidos',0,1,'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(30,10,'CZ: ');$pdf->Cell(20,10,$row_impconsulta["CveCZ"]);
$pdf->Ln(5);$pdf->Cell(30,10,'Matricula: ');$pdf->Cell(20,10,$vmatricula);
$pdf->Ln(5);$pdf->Cell(30,10,'Nombre: ');$pdf->Cell(20,10,$vnombre);
$pdf->Ln(5);$pdf->Cell(30,10,'F-Nacimiento: ');$pdf->Cell(20,10,$vfnacim);
$pdf->Ln(5);$pdf->Cell(30,10,'F-Conclusin: ');$pdf->Cell(20,10,$fconc);
$pdf->Ln(5);$pdf->Cell(30,10,'Promedio: ');$pdf->Cell(20,10,$vpromedio);
$pdf->Ln(5);$pdf->Cell(30,10,'Etapa: ');$pdf->Cell(20,10,$vetapa);
$pdf->Ln(5);$pdf->Cell(30,10,'Modelo: ');$pdf->Cell(20,10,$vmodelo);
$pdf->Ln(5);$pdf->Cell(30,10,'Folio: ');$pdf->Cell(20,10,$vfolio);
$pdf->Ln(5);$pdf->Cell(30,10,'Libro: ');$pdf->Cell(20,10,$vlibro);
$pdf->Ln(5);$pdf->Cell(30,10,'Foja: ');$pdf->Cell(20,10,$vfoja);
$pdf->Ln(5);$pdf->Cell(30,10,'Fecha Emisin: ');$pdf->Cell(20,10,$vfemision);
$pdf->Ln(5);$pdf->Cell(30,10,'Fecha Elabora: ');$pdf->Cell(20,10,$vfelabora);
$pdf->Ln(5);$pdf->Cell(30,10,'Fecha Entrega: ');$pdf->Cell(20,10,$vfentrega);
$pdf->Ln(5);$pdf->Cell(30,10,'Fecha Cancela: ');$pdf->Cell(20,10,$vfcancela);
$pdf->Ln(5);$pdf->Cell(30,10,'Cve Cancela: ');$pdf->Cell(20,10,$vcvecancela);
$pdf->Ln(5);$pdf->Cell(30,10,'Observaciones: ');$pdf->Cell(20,10,$vobserva);
$pdf->Ln(5);$pdf->Cell(30,10,'Base: ');$pdf->Cell(20,10,$vbase); 

$pdf->Output();
mysql_free_result($impconsulta);
?>
