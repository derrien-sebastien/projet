<?php
// ON TRAVAILLERA ICI EN PHP ‘CLASSIQUE’, pas d’appel au framework (appels BDD via PDO)
$MontantPayer = $_GET['Montant']/100;
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

if ($Erreur == "00000") /* PAIEMENT OK (PayBox appelle par ailleurs le script renseigné dans $pbx_effectue, exemple : accepte.php) */
{	
    
    $donneesCommande=explode('-',$Reference);
    $nomEvenement=$donneesCommande['0'];
    $noCommande=$donneesCommande['1'];
    $requete='SELECT MontantTotal FROM ge_commande WHERE NoCommande='.$noCommande ;
    $resultat=$con->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $MontantTotal=$resultat->fetch()->MontantTotal;// faire en requete preparer

    try 
    {  
        $resteApayer=$MontantTotal-$MontantPayer;
        $stmt = $con->prepare('UPDATE ge_commande SET Payer = :Payer, ResteAPayer = :ResteApayer WHERE  NoCommande= :noCommande');
        $stmt->bindValue(':Payer', $MontantPayer, PDO::PARAM_STR);
        $stmt->bindValue(':ResteApayer', $resteApayer, PDO::PARAM_STR);
        $stmt->bindValue(':noCommande', $noCommande, PDO::PARAM_INT);
        $stmt->execute();
    } 
    catch (Exception $e ) 
    {
        echo "Une erreur est survenue";
    }

} 
echo '<div class="container-fluid">';
    echo '<div align="center">';
        echo '<h2>Votre transaction a été acceptée</h2>';
        echo '<a href="http://[::1]/projet/index.php/Visiteur/commandeValide">retour au site</a>';
    echo '</div>';
echo '</div>';
?>

                            