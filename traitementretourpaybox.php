<?php
// ON TRAVAILLERA ICI EN PHP ‘CLASSIQUE’, pas d’appel au framework (appels BDD via PDO)
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

if ($Erreur == "00000") /* PAIEMENT OK (PayBox appelle par ailleurs le script renseigné dans $pbx_effectue, exemple : accepte.php) */
{	
    $donneesCommande=explode('-',$Reference);
    $nomEvenement=$donneesCommande['0'];
    $noCommande=$donneesCommande['1'];
    $requeteMontant='SELECT MontantTotal FROM ge_commande WHERE NoCommande='.$noCommande ;
    $resultat=$con->query($requeteMontant);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $MontantTotal=$resultat->fetch()->MontantTotal;
    $requeteCommande = 'SELECT  cont.Quantite,cont.Remis,cont.NoProduit,
                                comm.NoPersonne,comm.Payer,comm.NoCommande,
                                comm.MontantTotal,pers.Email,
                                pers.Nom,pers.Prenom,prod.LibelleCourt
                        FROM    ge_contenir as cont,
                        JOIN    ge_commande as comm , cont.NoCommande = comm.NoCommande,
                        JOIN    ge_personne as pers , comm.NoPersonne = pers.NoPersonne,
                        JOIN    ge_produit as prod,cont.NoProduit = prod.NoProduit AND cont.NoEvenement=prod.NoEvenement AND cont.Annee=prod.Annee,
                        WHERE   NoCommande='.$noCommande;
                        $resultat=$con->query($requeteCommande);
                        /* $resultat->setFetchMode(PDO::FETCH_OBJ);
                        $MontantTotal=$resultat->fetch()->MontantTotal; */

} 
/* SI PAIEMENT KO : il n’y a rien à faire
le serveur PayBox appelle automatiquement suivant les cas, le script $pbx_annule (ex. annule.php) ou $pbx_refuse (ex. refuse.php)
?>


/*

$reponse=retour array 
$donnees=array(
    'NoCommande'=>$noCommande,
    'Payer=>$MontantPayer,
    'ResteAPayer=>$reponse['MontantTotale]-$MontantPayer
);
requete preparé update
where NoComande=$donnees['Nocomande']
set Payer=$donnees['Payer'],ResteAPayer=$donnees['ResteAPayer']