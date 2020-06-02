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


Un peu naz je vais me coucher 
Je t'ai fais des petites modif coté admin coté membre et visiteur notamment sur tout l'aspect visuel et miracle 
je commence à maitriser méchant mais c'est long à produire. Je poursuivrais ultérieurement.
pour la fin de la semaine je veux maitriser mon panier :D 
Concernant nos bootstrap j'ai retouché notre head viré tout SAUF 2 fichiers de M..... dont j'arrive 
pas du tout à me débarasser 
j'ai tenter plusieurs manip mais à chaque coup ton summernote plante si jamais tu decouvre d'autre probleme 
que ce soit sur les script ou en css je m'en occupe 
d'ailleurs je pense d'ici a ce week end finir le tri dans le dossier js dist css font et image 
Bonne nuit a demain.


===========


vue modificationMdp foctionne pas en admin (visiteur et non membre)

========
dans le controleur (visiteur je crois ) a la fonction se connecter il faudrais mettre en debut de 
fonction

$urlDArriver =  $this->agent->referrer();

sans oublier de charger la librairie dans le construct

$this->load->library('user_agent');

a la fin de la fonction il faudrai faire un redirect vers $urlDArriver comme ca on garde la page 
precedende en memoire 
on arrive sur se connecter quelque soit la page precedente on revien dessus des qu'on est connecter 
vu que c'est ton controleur je me dit que tu prefere peu etre le faire mais si tu veux je peu le faire 
=======
verifier getProduits si elle est utiliser ou non car la fonction ne doit pas fonctionné
pas de ->result() ou ->result_array() ou ->row()
=====
punaise je suis face a un dilem 
on a un produit sapin cle ev:10 annee:2019 produit:1 
on a un deuxieme produit sapin ev:10 annee:2020 produit:2
l'admin modifie l'evenement 10 de 2020 il selectionne des produit il sont deja dedant mais bon il a pas compris 
il met sapin il en choisi 1 des 2 manque de pot il prend le mauvais 
et pouf il a deux sapin dans son evenement et j'ai aucun d'eviter ca !!! grrrr 
la seul chose que je peu lui faire c'est lui preselectionné ceux qu'il a mais il clic sans 
appuyer sur ctrl et pouf il se deselectionne tous 
distinct?



public function ajoutMultipleEnfant()
	{
		$this->form_validation->set_rules('nom','nom','required');
		$this->form_validation->set_rules('prenom','prenom','required');
		$this->form_validation->set_rules('dateNaissance','date de naissance');
		$this->form_validation->set_rules('classe','classe');
		$this->form_validation->set_rules('email[]','emails');
		$this->form_validation->set_rules('nomParent[]','Nom des parents');
		$this->form_validation->set_rules('prenomParent[]','Prenom des parents');
		$this->form_validation->set_rules('adresseParent[]','Adresse des parents');
		$this->form_validation->set_rules('villeParent[]','Ville des parents');
		$this->form_validation->set_rules('cpParent[]','Code postal des parents');
		$this->form_validation->set_rules('telFixe[]','Telephone fixe des parents');
		$this->form_validation->set_rules('telPort[]','Telephone portable des parents');

		if ($this->form_validation->run() === FALSE)//si le formulaire n'est pas validé
	 	{	
			
			$donneesVue=array(
				'lesClasses'=>$this->ModeleClasse->retournerClasse(),
				'lesEnfants'=>$this->ModeleEnfant->getEnfants(),
				'provenance'=>'ajouter'
			);
			
			$this->load->view('templates/EntetePrincipal');
			$this->load->view('templates/EnteteNavbar');
			$this->load->view('administrateur/vueAjoutMultipleEnfant',$donneesVue);
			$this->load->view('templates/PiedDePagePrincipal');
		}
		else
		{
			if(!$this->ModeleEnfant->presenceEnfant($_POST['nom'],$_POST['prenom']))
			{
				$numeroEnfant=$this->ModeleEnfant->maxEnfant()+1;
				$donneesEnfant=array(
					'NoEnfant'=>$numeroEnfant,
					'Nom'=>$_POST['nom'],
					'Prenom'=>$_POST['prenom'],
					'DateNaissance'=>$_POST['dateNaissance']
				);
				$this->ModeleEnfant->insetEnfant($donneesEnfant);
				if($_POST['classe']!='0')
				{
					$donneesAppartenir=array(
						'NoEnfant'=>$numeroEnfant,
						'NoClasse'=>$_POST['classe'],	
					);
					$this->ModeleEnfant->insetAppartenir($donneesAppartenir);

				}
			}
			else
			{
				//voir confirmation homonime
				$donneesEnfant['NoEnfant']=$this->ModeleEnfant->getEnfant($_POST['nom'],$_POST['prenom']);

			}
			if (isset($_POST['emails']))
			{
				$i=0;
				foreach ($_POST['emails'] as $unEmail)
				{
					if(!$this->ModelePersonne->presenceMdp($unEmail))
					{
						$noPersonne=$this->ModelePersonne->maxPersonne()+1;
						$donneesPersonne=array(
							'NoPersonne'=>$noPersonne,
							'Email'=>$unEmail,
							'Nom'=>$_POST['nomParent['.$i.']'],
							'Prenom'=>$_POST['prenomParent['.$i.']'],
							'Adresse'=>$_POST['AdresseParent['.$i.']'],
							'Ville'=>$_POST['VilleParent['.$i.']'],
							'CodePostal'=>$_POST['cpParent['.$i.']'],
							'TelPortable'=>$_POST['telPort['.$i.']'],
							'TelFixe'=>$_POST['telFixe['.$i.']'],
						);						
						
						$this->ModelePersonne->insererInformationPersonne($donneesPersonne);
						}
					else
					{
						$Personne=$this->ModelePersonne->rechercheInfoPersonne($unEmail);
						$noPersonne=$presonne->NoPersonne;
					}
					$donneesPersonne=array(
						'NoPersonne'=>$noPersonne,
						'Email'=>$unEmail
					}
					if($_POST['nomParent['.$i.']']!='')
					{
						$donneesPersonne['Nom']=$_POST['nomParent['.$i.']'];
					}
					if($_POST['prenomParent['.$i.']']!='')
					{
						$donneesPersonne['Prenom']=$_POST['prenomParent['.$i.']'];
					}
					if($_POST['adresseParent['.$i.']']!='')
					{
						$donneesPersonne['Adresse']=$_POST['adresseParent['.$i.']'];
					}
					if($_POST['villeParent['.$i.']']!='')
					{
						$donneesPersonne['Ville']=$_POST['villeParent['.$i.']'];
					}
					if($_POST['cpParent['.$i.']']!='')
					{
						$donneesPersonne['CodePostal']=$_POST['cpParent['.$i.']'];
					}
					if($_POST['telFixe['.$i.']']!='')
					{
						$donneesPersonne['TelFixe']=$_POST['telFixe['.$i.']'];
					}					
					if($_POST['telPort['.$i.']']!='')
					{
						$donneesPersonne['TelPortable']=$_POST['telPort['.$i.']'];
					}
					$memoire[$i]=$noPersonne;
					$i++;
					$donneesPersonneParent=array(
						'NoPersonne'=>$noPersonne,
						'NoEnfant'=>$donneesEnfant['NoEnfant'],
						'EtreCorrespondant'=>1
					);
					//update/parent
					$this->ModelePersonne->insererInformationPersonneParent($donneesPersonneParent);
					
				}
				if(isset($_POST['infosParents']))
				{
					//$this->load->view(modifierInfoPersonne)
				}
			}
			unset($_POST);
			$this->ajoutMultipleEnfant;
				
		}
	}
	
	<?php
	$fluo=array(
		'fond'=>'red',
		'texte'=>'blue'
	);
	$sobre=array('fond'=>'yellow',
	'texte'=>'blue');

	if ($color==fluo){
		$couleurchoisi=$fluo
	}

    
    