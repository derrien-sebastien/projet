<?php
$montantEuros=$_GET['Montant']/100;
$ref_com=$_GET['Reference'];
$auto =$_GET['Auto'];
echo '<div class="container-fluid">';
    echo '<div align="center">';
        echo '<h2>Votre transaction a été refusée</h2>';
        echo '<br>';
        echo '<h4>MONTANT (en Euros):</h4>'; 
        echo $montantEuros;
        echo '<br>';
        echo '<h4>REFERENCE :</h4>'; 
        echo $ref_com;
        echo '<br>';
        echo '<h4>AUTO :</h4>'; 
        echo $auto;
    echo '</div>';
echo '</div>';
?>