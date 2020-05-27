<?php
$montantEuros=$_GET['Montant']/100;
$ref_com=$_GET['Reference'];
$auto=$_GET['Auto'];
print("<center><b><h2>Votre transaction a été acceptée</h2></center></b><br>");
print("<br><b>MONTANT (en Euros) : </b>$montantEuros\n");
print("<br><b>REFERENCE : </b>$ref_com\n");
print("<br><b>AUTO : </b>$auto\n");
?>
