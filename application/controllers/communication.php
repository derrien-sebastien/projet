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
