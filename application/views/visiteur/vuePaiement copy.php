<?php
// Identifiant de votre site de eCommerce (fournies par votre banque en production)
$pbx_site = '1999888';         // Test (voir Compte de test)
$pbx_rang = '32';              // Test
$pbx_identifiant = '107904482';        // Test

// Identifiant de la transaction (doit être unique en prod., a générer)
$pbx_cmd = '2020123';   // forcé ici

// Identifiant client du site qui souhaite faire le paiement = mail client
$pbx_porteur = 'derrien.sebastien@hotmail.fr';  // Valeur de test ici, en prod. = mail client
 
// Somme à débiter de la Carte Bancaire, en centimes (forcée à 100 ici = 1 euros)
$pbx_total = $total; 

// Suppression des points ou virgules dans le montant                       
$pbx_total = str_replace(",", "", $pbx_total);
$pbx_total = str_replace(".", "", $pbx_total);

// Paramétrage des urls de redirection après paiement

// $pbx_effectue = Page renvoyée si paiement accepté (voir ex. Annexe : accepte.php)
// $pbx_effectue = 'http://www.votre-site.extention/page-de-confirmation';
$pbx_effectue = 'http://127.0.0.1/PaiementEnLigne/accepte.php';
// $pbx_annule = Page renvoyée si paiement annulé, par le client (voir ex. Annexe : annule.php)
// $pbx_annule = 'http://www.votre-site.extention/page-d-annulation';
$pbx_annule ='http://127.0.0.1/PaiementEnLigne/annule.php';
// $pbx_refuse = Page renvoyée si paiement refuse, par PayBox (voir ex. Annexe : refuse.php)
// $pbx_refuse = 'http://www.votre-site.extention/page-de-refus';
$pbx_refuse ='http://127.0.0.1/PaiementEnLigne/refuse.php';
 
/* url de retour back office site : $pbx_repondre_a
Cette URL est appelée de serveur à serveur dès que le client valide son paiement (que ce dernier soit autorisé ou refusé). Cela permet ainsi de valider automatiquement le bon de commande correspondant même si le client coupe la connexion ou décide de ne pas revenir sur la boutique, car cet appel ne transite pas par le navigateur du porteur de carte.
*/
$pbx_repondre_a = 'http://www.votre-site.extention/page-de-back-office-site';
// Pour que l'URL $pbx_repondre_a puisse être appelée, il faut que le site soit hébergé
// Ex. Code Igniter : $pbx_repondre_a  = base_url('application/views/traitementretourpaybox.php'); 
// VOIR ANNEXE pour traitementretourpaybox.php
/* NOTA BENE : le script retour, sur notre serveur, sera appelé par le serveur PayBox, dans ce script, on aura donc pas accès aux variables de session !
*/

// Paramétrage du retour back office site
$pbx_retour = 'Montant:M;Reference:R;Auto:A;Erreur:E';
/*
M : Montant de la transaction (précisé dans PBX_TOTAL).
R : Référence commande (précisée dans PBX_CMD)
A : Numéro d’autorisation délivré par le centre d’autorisation de la banque du commerçant 
si le paiement est accepté
E : Code réponse de la transaction
*/

/* $keyTest : clé secrète HMAC. En prod. : générée depuis le back office mise à dispo. par votre banque puis stockée dans BBD par exemple. Ici on l’a mise en dur, pour test */
$keyTest = '0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF';

/* --------------- TESTS DE DISPONIBILITE DES SERVEURS ---------------
PayBox dispose de plusieurs serveurs, dans ce qui suit on cherche un serveur de prod. Opérationnel pour répondre à notre demande */
$serveurs = array('tpeweb.paybox.com', //serveur primaire
'tpeweb1.paybox.com'); //serveur secondaire
$serveurOK = "";

foreach($serveurs as $serveur)
{
$doc = new DOMDocument();
$doc->loadHTMLFile('https://'.$serveur.'/load.html');
$server_status = "";
$element = $doc->getElementById('server_status');
if($element){
$server_status = $element->textContent;}
if($server_status == "OK")
{
// Le serveur est prêt et les services opérationnels
$serveurOK = $serveur;
break;
}
// else : La machine est disponible mais les services ne le sont pas.
}

if(!$serveurOK)
{
	die("Erreur : Aucun serveur n'a été trouvé");
}

// Activation de l'univers de préproduction (CAS LORSQU’ON VA TRAVAILLER EN TEST)
// On remplace le serveur de prod. trouvé ci-dessus par : 
$serveurOK = 'preprod-tpeweb.paybox.com'; // Ligne à commenter si on veut passer en prod.

//Création de l'url cgi paybox – vers laquelle on enverra nos données (encryptées)
$serveurOK = 'https://'.$serveurOK.'/cgi/MYchoix_pagepaiement.cgi';

// --------------- TRAITEMENT DES VARIABLES à envoyer vers serveur PayBox ---------------
// On récupère la date au format ISO-8601
$dateTime = date("c");

// On crée la chaîne à hacher sans URLencodage
$msg = "PBX_SITE=".$pbx_site.
"&PBX_RANG=".$pbx_rang.
"&PBX_IDENTIFIANT=".$pbx_identifiant.
"&PBX_TOTAL=".$pbx_total.
"&PBX_DEVISE=978".
"&PBX_CMD=".$pbx_cmd.
"&PBX_PORTEUR=".$pbx_porteur.
"&PBX_REPONDRE_A=".$pbx_repondre_a.
"&PBX_RETOUR=".$pbx_retour.
"&PBX_EFFECTUE=".$pbx_effectue.
"&PBX_ANNULE=".$pbx_annule.
"&PBX_REFUSE=".$pbx_refuse.
"&PBX_HASH=SHA512".
"&PBX_TIME=".$dateTime;
// echo $msg;

// Si la clé est en ASCII, On la transforme en binaire
$binKey = pack("H*", $keyTest);

// On calcule l’empreinte (à renseigner dans le paramètre PBX_HMAC) grâce à la fonction hash_hmac et //
// la clé binaire / On envoi via la variable PBX_HASH l'algorithme de hachage qui a été utilisé (SHA512 dans ce cas)
// Pour afficher la liste des algorithmes disponibles sur votre environnement, décommentez la ligne //
// suivante
// print_r(hash_algos());
$hmac = strtoupper(hash_hmac('sha512', $msg, $binKey));
var_dump($pbx_total)

// La chaîne sera envoyée en majuscule, d'où l'utilisation de strtoupper()
// On crée le formulaire à envoyer
// ATTENTION : l'ordre des champs est extrêmement important, il doit
// Correspondre exactement à l'ordre des champs dans la chaîne hachée
?>

<!------------------ ENVOI DES INFORMATIONS A PAYBOX (Formulaire avec champs Hidden) ------------------>
<!------------------ ENVOI des champs Hidden sur clic sur le submit ------------------>
</br>
</br>
<form method="POST" action="<?php echo $serveurOK; ?>">
<input type="hidden" name="PBX_SITE" value="<?php echo $pbx_site; ?>">
<input type="hidden" name="PBX_RANG" value="<?php echo $pbx_rang; ?>">
<input type="hidden" name="PBX_IDENTIFIANT" value="<?php echo $pbx_identifiant; ?>">
<input type="hidden" name="PBX_TOTAL" value="<?php echo $pbx_total; ?>">
<input type="hidden" name="PBX_DEVISE" value="978">
<input type="hidden" name="PBX_CMD" value="<?php echo $pbx_cmd; ?>">
<input type="hidden" name="PBX_PORTEUR" value="<?php echo $pbx_porteur; ?>">
<input type="hidden" name="PBX_REPONDRE_A" value="<?php echo $pbx_repondre_a; ?>">
<input type="hidden" name="PBX_RETOUR" value="<?php echo $pbx_retour; ?>">
<input type="hidden" name="PBX_EFFECTUE" value="<?php echo $pbx_effectue; ?>">
<input type="hidden" name="PBX_ANNULE" value="<?php echo $pbx_annule; ?>">
<input type="hidden" name="PBX_REFUSE" value="<?php echo $pbx_refuse; ?>">
<input type="hidden" name="PBX_HASH" value="SHA512">
<input type="hidden" name="PBX_TIME" value="<?php echo $dateTime; ?>">
<input type="hidden" name="PBX_HMAC" value="<?php echo $hmac; ?>">
<input type="submit" value="Envoyer">
</form>
