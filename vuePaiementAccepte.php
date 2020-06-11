<?php
$MontantPayer = $_GET['Montant']/100;
$Reference = $_GET['Reference'];
$Erreur = $_GET['Erreur'];
$db_dsn='mysql:host=localhost;dbname=projet;charset=utf8';
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
if ($Erreur == "00000") 
{	
    $donneesCommande=explode('-',$Reference);
    $nomEvenement=$donneesCommande['0'];
    $noCommande=$donneesCommande['1'];
    $requete='SELECT MontantTotal FROM ge_commande WHERE NoCommande='.$noCommande ;
    $resultat=$con->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $MontantTotal=$resultat->fetch()->MontantTotal;

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
$requeteCommande = ' '.$noCommande;
$select = $con->query($requeteCommande);
$select->setFetchMode(PDO::FETCH_OBJ);
$i=0;
while($ligne = $select->fetch())
{
    $lesCommandes[$i]=$ligne;
    $email=$ligne->Email;
    $noCommande=$ligne->NoCommande;
    $i++;
}  

foreach($lesCommandes as $uneCommande)
{
    $noCommande=$uneCommande->NoCommande;
    $modePayement=$uneCommande->ModePaiement;
    $paye=$uneCommande->Payer;
    $email=$uneCommande->Email;
    $nom=$uneCommande->Nom;
    $prenom=$uneCommande->Prenom;
    $montantTotal=$uneCommande->MontantTotal;
}
$entete  = 'MIME-Version: 1.0' . "\r\n";
$entete .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$entete .= 'To='.$email . "\r\n";
$entete .= 'From: ' ."adressepipo@ovh.fr" . "\r\n";
$objet='Commande n°'.$noCommande;
$message="      <h4>Bonjour,</br>".$nom."&nbsp;".$prenom." , merci de votre confiance.</br></h4>
                Votre N° de commande :".$noCommande."</br>
                A été validée.</br></br>
                Information sur votre commande:</br>";
                foreach($lesCommandes as $uneCommande)
                {
                    $message=$message."Vous avez commandé ".$uneCommande->Quantite."&nbsp".$uneCommande->LibelleCourt."</br>";
                           
                }
                "Pour un montant de ".$montantTotal."€ </br>";  
                $message=$message." Facturée à: ".$email." </br>
                                    Date de commande: ".date("d-m-Y")."</br>
                                    Mode de paiement par ".$modePayement."</br>
                                    Vous avez payer ".$paye."€</br>
                                    Nous vous invitons à concervez ces informations.";
                $retour = mail($email,$objet, $message, $entete);  
echo '<div class="container-fluid">';
    echo '<div align="center">';
        echo '<h2>Votre transaction a été acceptée</h2>';
        echo '<a href="http://[::1]/projet/index.php/Visiteur/catalogueEvenement">retour au site</a>';
    echo '</div>';
echo '</div>'; 
?>

                            