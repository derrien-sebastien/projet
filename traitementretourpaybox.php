<?php
echo 'coucou';
die();
$MontantPayer = $_GET['Montant'];
$Reference = $_GET['Reference'];
$Erreur = $_GET['Erreur']; 
$db_dsn='mysql:host=localhost;dbname=projet';
$db_user='root';
$db_pass='';
try
{
    $con=new PDO($db_dsn,$db_user,$db_pass);
}
catch(PDOException $pe)
{
    echo'ERREUR:'.$pe->getMessage();
}
    $donneesCommande=explode('-',$Reference);
    $nomEvenement=$donneesCommande['0'];
    $noCommande=$donneesCommande['1'];
    $requeteMontant='SELECT MontantTotal FROM ge_commande WHERE NoCommande='.$noCommande ;
    $resultat=$con->query($requeteMontant);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $MontantTotal=$resultat->fetch()->MontantTotal;                        
?>
