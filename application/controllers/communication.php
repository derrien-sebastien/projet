salut seb ici on pourra communiquer simplement 
oublie pas de regulierement faire des pull meme si je suis sensé ne pas avoir boser on sait jamais 
j'ai remis mes info sur les different page que j'avais fait en esperant ne rien avoir oublier 
au sujet de nos modele :
le model administrateur est inutile vu qu'on va viré la table 
le modele identifiant site est a vidé on fera les fonction dessus sous peu cela conserne uniquement le payement 
les model pers parent et pers autre sont a supprimer pour ma par a chaque fois que je requette sur 
les parent j'utilise au moins l'info noPersonne donc je fait tout dans le model personne 
probleme je n'ai pas la vueCatalogue donc aucune possibilité de se connecter en visiteur
la gestion de compte ne fonctionne plus en administrateur
=========================
 
Les modifications du jour  :
le model administrateur                   SUPPRIMER
le modele identifiant                     VIDER  
les model pers parent et pers             SUPPRIMER EN EFFET VU QU'ON REQUETE SUR MODELE PERSONNE
vueCatalogue                              Fonctionnelle (je terminerais d'ici peu c'est un début)
la gestion de compte en administrateur    Fonctionnelle


Pourrais-tu retoucher dans visiteur/seConnecter pour le nouveau controller membre?

Bonne journée... MAJ           17 / 04  à 10h00
========================
 on va avoir un bug a la modification d'info compte 
 deja il serait bien de la proposer des que la personne desire s'enregistré
 ensuite vu qu'on utilise la meme fonction pour un admin ou un membre il faut qu'on requete pour savoir 
 si la personne est admin membre ou rien dans se cas on doit modifier le profil en membre ou le conserver en admin 
 eventuelement on peu faire un if ($_SESSION['profil']==admin ){$donné['profil']=admin;}else{$donné['profil']=membre;}

 je t'ai fait la securité si tu utilise le controleur admin il faut que ton profil soit admin si tu utilise le controleur membre 
 il faut que ton profil soit admin ou membre 


 bon j'ai a peu pres fini l'affichage des eleve 
 la fonction est toute conne mais efficasse il me reste plus qu'a utiliser la fonction pour modifier les enfant dans la classe 
 et apres eventuelement les faire migré 

$i=0
foreach($lignes as $unLigne)
{
    $produits[$i]=array(
        'noEvenement'=>$unLigne->noEvenement,
        'annee'=>$unLigne->Annee,
        'noProduit'=>$unLigne->NoProduit,
        'quantité'=>$unLigne->Quantité
        );
    $i++;
}
$_SESSION['panier']=$produits;

========
rester sur url d'arriver apres connection( function se connecter recup url et redirection vers celle ci )
============

on a soit 
if visiteur{lien visiteur}if membre{lien membre}if admin{lien admin}
ou 
if visiteur ou membre ou admin{lien visiteur(if membre ou admin{lien membre(if admin{lien admin})})}

========
salut seb donc pour reexpliquer pour le ajax pour mon pb apres reflexion je pense qu'il faudrais que se soit dans 
un seul et meme script avec deux function sur une feuille a part 

sur la vue vueSelectionEvenement il faudrais que j'appel le script qui incremente une variable avec NoEvenement et Annee
la function devra me renvoyer un objet evenement donc passer par le modelEvenemlent
sur la vue formulaireEvenement je recupere l'object et le traire en dynamique (modification
des value de mes champ input texteArea) 
pour corser un peu le tout les texte area de mon formulaire appel deja les script summernote 

donc si je me trompe pas la vue1 apel le script1.1 qui apel le controleur qui apel la methode puis 
rempli le script et la vue 2 apel le script 1.2 pour s'auto remplir les value 

bref ca me parrait compliquer donc pour le moment je pense que rester comme ca c'est pas trop grave 
par la suite pourquoi pas 
======