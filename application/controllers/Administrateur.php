<?php
//require_once(APPPATH."controllers/Visiteur.php");
class Administrateur extends CI_Controller
{



 	/**********************************************************************
 	**                           Constructeur                           **
 	**********************************************************************/


    public function __construct() //charge pour tous appel de la class
	{	
		parent::__construct();  
		$this->load->model('ModeleProduit');
		$this->load->model('ModeleEvenement');
		$this->load->model('ModeleClasse');
		$this->load->model('ModeleCommande'); 
		$this->load->helper('url'); // pour utiliser redirect
		$this->load->library('session');
		$this->load->model('ModeleIdentifiantSite');
		
		$personne=$this->ModeleIdentifiantSite->rechercheSession($this->session->__ci_last_regenerate);
		
		/* $dataSession=array(
			'email'=>$personne->Mdp,
			'profil'=>$personne->Profil
		 ); */                    
		/*  $this->session->set_userdata($dataSession); */
		
		/*redirect('/visiteur/seConnecter'); // pas les droits : redirection vers connexion
			 }*/
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		
		//cretaion constante AnneeEnCour
			 if(date('m')<8)
			 {
				 $annee=date('Y');
				 define('AnneeEnCour',$annee);				 
			 }
			 else
			 {
				$annee=date('Y')+1;
				define('AnneeEnCour',$annee); 
			 }

	}

	/**********************************************************************
    **                           Accueil                                 **
	**********************************************************************/
	

	public function accueil() //page d'accueil admin
	{
		$this->load->view('templates/EnteteAdmin');
		$this->load->view('administrateur/vueAccueilAdministrateur');
		//$this->load->view('templates/PiedDePagePrincipal');
	}

	/*********************************************************************************************************************************************/
   	/*********************************************************************************************************************************************/
   	/*********************************************************************************************************************************************/
   	/**************************                                                                              *************************************/
   	/**************************                        PAGE FORMULAIRE EVENEMENT                             *************************************/
   	/**************************                                                                              *************************************/
   	/*********************************************************************************************************************************************/
   	/*********************************************************************************************************************************************/
   	/*********************************************************************************************************************************************/


    /**********************************************************************
    **                           Ajoute un évenement                     **
    **********************************************************************/


    public function ajouterEvenement() 
	{
		$this->formulaireEvenement(null,'ajouter');
	}


	/**********************************************************************
    **                         Modifier un évenement                     **
    **********************************************************************/
	
	
	public function modifierEvenement() 
	{
		$this->load->view('templates/EnteteAdmin');
		$DonneesInjectees['Provenance']='modifier';		
		if (!isset($_POST['Evenement']))
		{
		$DonneesInjectees['LesEvenements']= $this->ModeleEvenement->getEvenementGeneral(AnneeEnCour);
		$DonneesInjectees['LesEvenements']= $DonneesInjectees['LesEvenements']+$this->ModeleEvenement->getEvenementGeneral(AnneeEnCour-1);
		$DonneesInjectees['LesEvenements']= $DonneesInjectees['LesEvenements']+$this->ModeleEvenement->getEvenementGeneral(AnneeEnCour-2);
		$this->load->view('administrateur/vueSelectionEvenements',$DonneesInjectees);		
		//$this->load->view('templates/PiedDePagePrincipal');
		}
		else
		{
		$this->formulaireEvenement($_POST['Evenement'],$DonneesInjectees['Provenance']);
		}		
	}

 
	/**********************************************************************
    **                           Ajoute un Produit	                     **
    **********************************************************************/


    public function ajouterProduit($NoEvenement=null,$Annee=null) 
	{
		$this->formulaireProduit($NoEvenement,$Annee,'ajouter');		
	}


	/**********************************************************************
    **                         Modifier un produit	                     **
    **********************************************************************/
  
 
 	public function modifierProduit($NoEvenement=null,$Annee=null) 
	{
		$this->load->view('templates/EnteteAdmin');
		$DonneesInjectees['Provenance']='modifier';		
		if (!isset($_POST['Evenement']))
		{
		$DonneesInjectees['LesProduits']=$this->ModeleProduit->getProduitGeneral(AnneeEnCour);
		$DonneesInjectees['LesProduits']=$DonneesInjectees['LesProduits']+$this->ModeleProduit->getProduitGeneral(AnneeEnCour-1);
		$DonneesInjectees['LesProduits']=$DonneesInjectees['LesProduits']+$this->ModeleProduit->getProduitGeneral(AnneeEnCour-2);
		$this->load->view('administrateur/vueSelectionProduits',$DonneesInjectees);
		//$this->load->view('templates/PiedDePagePrincipal');
		}
		else
		{
		$this->formulaireProduit($_POST['Produit'],$DonneesInjectees['Provenance']);
		}		
	} 


	/**********************************************************************
    **                         Upload une image                          **
	**********************************************************************/
	

	public function uploadImage($LocalisationImage) 
	{
		$config['upload_path'] = './assets/images/';//reglage image 
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '204800';
		$config['max_width'] = '100000';
		$config['max_height'] = '100000';
		$this->load->library('upload', $config);//chargement de la librairie upload
		if (!$this->upload->do_upload($LocalisationImage) == TRUE)// si l'image n'est pas upload
		{				
			$error = array('error' => $this->upload->display_errors());						
			$nomImage=0;
			return $nomImage;
		}
		else//si l'image est upload
		{
			$data = array('upload_data' => $this->upload->data());//upload image				
			$Image=$data['upload_data'];
			$nomImage=$Image['file_name'];//recuperation du nom de fichier
			return $nomImage;				
		}    
	}


    /**********************************************************************
    **                Formulaire  évènement                              **
    **********************************************************************/

    
	public function formulaireEvenement ($AncienEvenementEnLigne=null,$Provenance=null)	//formulaire evenement nom a modifier
	{		
		if($this->input->post('submit'))//upload image entete
        {	
			$LocalisationImage=$this->input->post('TxtImgEntete');
			$NomImageEntete=$this->uploadImage($LocalisationImage);			
		}		 
			if($this->input->post('submit'))//upload image pied de page    
        	{
				$LocalisationImage=$this->input->post('TxtImgPiedDePage');
				$NomImagePiedPage=$this->uploadImage($LocalisationImage);							
			}			
    	$this->form_validation->set_rules('AnneeEvenement','Annee','required');//regle de validation du formulaire
		$this->form_validation->set_rules('DateMiseEnLigne','DateMiseEnLigne');
		$this->form_validation->set_rules('DateMiseHorsLigne','DateMiseHorsLigne');
		$this->form_validation->set_rules('TexteEntete','TxtHTMLEntete');
		$this->form_validation->set_rules('TexteCorps','TxtHTMLCorps','required');
		$this->form_validation->set_rules('TextePied','TxtHTMLPiedDePage');
		$this->form_validation->set_rules('EmailInfo','EmailInformationHTML');
		$this->form_validation->set_rules('EnCours','EnCours');		
		if ($this->form_validation->run() === FALSE)//si le formulaire n'est pas validé
	 	{
			$DonneesInjectees['LesProduits']=$this->ModeleProduit->getProduitGeneral(AnneeEnCour);//recuperation des produit en objet
			$DonneesInjectees['LesProduits']=$DonneesInjectees['LesProduits']+$this->ModeleProduit->getProduitGeneral(AnneeEnCour-1);
			$DonneesInjectees['LesProduits']=$DonneesInjectees['LesProduits']+$this->ModeleProduit->getProduitGeneral(AnneeEnCour-2);
			$DonneesInjectees['Provenance']=$Provenance;
			$this->load->view('templates/EnteteAdmin');//indispensable pour le script	
			if ($Provenance=='ajouter')//si on ajoute un evenement
			{
				$DonneesInjectees['LesEvenements']= $this->ModeleEvenement->getEvenementGeneral(AnneeEnCour);//recuperation les evenement en objet
				$DonneesInjectees['LesEvenements']=$DonneesInjectees['LesEvenements']+$this->ModeleEvenement->getEvenementGeneral(AnneeEnCour-1);
				$DonneesInjectees['LesEvenements']=$DonneesInjectees['LesEvenements']+$this->ModeleEvenement->getEvenementGeneral(AnneeEnCour-2);
				$this->load->view('administrateur/vueSelectionEvenements',$DonneesInjectees);//charge la vue pour preremplir le formulaire
				//$this->load->view('templates/PiedDePagePrincipal');
			}
			$this->load->view('administrateur/vueFormulaireEvenement',$DonneesInjectees);//charge la vue formulaire eventuelment prérempli
			//$this->load->view('templates/PiedDePagePrincipal');
		}		
		else// si la validation du formulaire est bonne
		{				
			if ($NomImageEntete===0)// si l'image n'est pas upload
			{				
				$NomImageEntete=$this->input->post('ImgEntete');//utilisation de l'ancien nom 
			}
			if ($NomImagePiedPage===0)// si l'image n'est pas upload
			{
				$NomImagePiedPage=$this->input->post('ImgPiedDePage');//utilisation de l'ancien nom 
			}
			if(isset($_POST['supImgEntete']))//si on a coché supprimer l'image 
			{
				$NomImageEntete=null;//l'image est mise a nul
			}
			if(isset($_POST['supImgPiedPage']))//si on a coché supprimer l'image 
			{
				$NomImagePiedPage=null;//l'image est mise a nul
			}
			if(isset($_POST['EnCours']))//si encours est coché
			{
				$encours=$this->input->post('EnCours');//charge la valeur de l'encour
			}
			else//si encour est décoché
			{
				$encours=0;//encour est mis a 0
			}
		$Provenance=$_POST['Provenance'];
			if($Provenance=='ajouter')//si on ajoute un evenement
			{		
				$noMax = $this->ModeleEvenement->maxEvenement();//recherche du max evenement
				$noEvenement=$noMax+1;//on met le numero d'evenement a max+1
				$annee =$this->input->post('AnneeEvenement');//on utilise l'année selectionné
			}
			elseif($Provenance=='modifier')//si on modifie un evenement
			{				
				$annee=$_POST['AnneeEvenement'];//recuperation de l'année
				$noEvenement=$_POST['NoEvenement'];//recuperation du numero evenement
			}
		$donneesAInserer = array(//création d'un tableau avec les valeur a rentré dans la base de donnée
		'Annee'=>$annee,
		'NoEvenement'=>$noEvenement,			
		'DateMiseEnLigne'=>$this->input->post('DateMiseEnLigne'),
		'DateMiseHorsLigne'=>$this->input->post('DateMiseHorsLigne'),
		'TxtHTMLEntete'=>$this->input->post('TexteEntete'),
		'TxtHTMLCorps'=>$this->input->post('TexteCorps'),
		'TxtHTMLPiedDePage'=>$this->input->post('TextePied'),
		'ImgEntete'=>$NomImageEntete,
		'ImgPiedDePage'=>$NomImagePiedPage,
		'EmailInformationHTML'=>$this->input->post('EmailInfo'),
		'EnCours'=>$encours
		);
		//array
	$donnees=array(
	'Annee'=>$annee,
	'NoEvenement'=>$noEvenement
	);
		if($Provenance=='ajouter')//si on ajoute un evenement
		{			 
			$this->ModeleEvenement->ajouterEvenement($donneesAInserer);//création d'une nouvel ligne a la table 
			if (isset($_POST['AjoutProduit']))//si on ajoute un produit 
			{				
				$this->formulaireProduit($donneesAInserer['NoEvenement'],$donneesAInserer['Annee'],'ajouter');//charge le controleur de formulaire produit
			}
			else
			{
				$this->ModeleEvenement->ajouterEvenementNonMarchand($donnees);//ajout a la table non marchand					
			}
		}
		elseif($Provenance=='modifier')//si on modifie un evenement
		{
			$this->ModeleEvenement->modifierEvenement($donneesAInserer);//modification de la ligne liée a l'evenement dans la db
			if (isset($_POST['AjoutProduit']))//si on ajoute un produit
			{				
				$this->formulaireProduit($donneesAInserer['NoEvenement'],$donneesAInserer['Annee'],'modifier');//charge le controleur de formulaire produit
			}
			else
			{
				if(!$this->ModeleEvenement->getEvenementMarchand($donneesAInserer['Annee'],$donneesAInserer['NoEvenement']))
				{
					if(!$this->ModeleEvenement->getEvenementNonMarchand($donneesAInserer['Annee'],$donneesAInserer['NoEvenement']))
					{							
						$this->ModeleEvenement->ajouterEvenementNonMarchand($donnees);//ajout a la table non marchand	
					}
				}					
			}
		}
		}
	}


	/**********************************************************************
    **                          formulaire produit                       **
    **********************************************************************/
	

	public function formulaireProduit($NoEvenement=null,$Annee=null,$Provenance=null)
	{
		if($NoEvenement==null)
		{
			$NoEvenement=0;
		}
		if($Annee==null)
		{
			$Annee=0;
		}
		if($this->input->post('submit'))//upload image
       	{
			$LocalisationImage=$this->input->post('ImgProduit');
			$NomImageProduit=$this->uploadImage($LocalisationImage);			
		}
		if($this->input->post('submit'))//upload image
       	{
			$LocalisationImage=$this->input->post('ImgTicket');
			$NomImageTicket=$this->uploadImage($LocalisationImage);
		}	
		$this->form_validation->set_rules('libelleHTML','libelleHTML','required');
		$this->form_validation->set_rules('libelleCourt','libelleCourt','required');
		$this->form_validation->set_rules('prix','prix','required');
		$this->form_validation->set_rules('stock','stock');
		$this->form_validation->set_rules('numeroOrdreApparition','numeroOrdreApparition','required');
		$this->form_validation->set_rules('etreTicket','etreTicket');
		if ($this->form_validation->run() === FALSE)
		{	
			$DonneesInjectees['Provenance']=$Provenance;
			$this->load->view('templates/EnteteAdmin');
			if($Provenance==='Ajouter')
			{
				$DonneesInjectees['LesProduits']=$this->ModeleProduit->getProduitGeneral(AnneeEnCour);
				$DonneesInjectees['LesProduits']=$DonneesInjectees['LesProduits']+$this->ModeleProduit->getProduitGeneral(AnneeEnCour-1);
				$DonneesInjectees['LesProduits']=$DonneesInjectees['LesProduits']+$this->ModeleProduit->getProduitGeneral(AnneeEnCour-2);
				$this->load->view('administrateur/vueSelectionProduits',$DonneesInjectees);
				//$this->load->view('templates/PiedDePagePrincipal');
			}
			$this->load->view('administrateur/vueFormulaireProduit',$DonneesInjectees);	
			//$this->load->view('templates/PiedDePagePrincipal');		
		}
		else
		{
			if ($NomImageProduit===0)
			{				
				$NomImageProduit=$this->input->post('ImgProduit');
			}
			if ($NomImageTicket===0)
			{
				$NomImageTicket=$this->input->post('ImgTicket');
			}
			if(isset($_POST['SupImgProduit']))//si on a coché supprimer l'image 
			{
				$NomImageProduit=null;//l'image est mise a nul
			}
			if(isset($_POST['SupImgTicket']))//si on a coché supprimer l'image 
			{
				$NomImageTicket=null;//l'image est mise a nul
			}
			if($Provenance==='Ajouter')
			{
			$noMax = $this->ModeleProduit-> maxProduit();
			$NoProduit=$noMax+1;
			}
			elseif($Provenance=='Modifier')
			{
				//$NoProduit=$this->
			}
			$donneesAInserer = array(
			'NoEvenement'=>$NoEvenement,
			'Annee'=>$Annee,			
			'NoProduit'=>$NoProduit,
			'libelleHTML'=>$this->input->post('libelleHTML'),
			'libelleCourt'=>$this->input->post('libelleCourt'),
			'prix'=>$this->input->post('prix'),
			'ImgProduit'=>$NomImageProduit,
			'stock'=>$this->input->post('stock'),
			'numeroOrdreApparition'=>$this->input->post('numeroOrdreApparition'),
			'etre_Ticket'=>$this->input->post('etreTicket'),
			'ImgTicket'=>$NomImageTicket
			 );	
			 if($Provenance==='Ajouter')
			{		 
				$this->ModeleProduit->ajouterProduit($donneesAInserer);
			}
			elseif($Provenance=='Modifier')
			{
				$this->ModeleProduit->modifierProduit($donneesAInserer);
			}	
			$this->load->view('templates/EnteteAdmin');
			$this->load->view('administrateur/vueFormulaireProduit');// a supprimer
			//$this->load->view('templates/PiedDePagePrincipal');
		}	;	
	} 


	public function formulaireMail($questionTechnique=null,$noEvenement=null,$annee=null)
	{
		/*donneés d'entrée:
		-$questionTechnique
		-$noEvenement(si vient d'un evenement)
		-$annee(si vient d'un evenement)

		requetage basse de données:
		-recuperation des classes(pour l'affichage de selection)

		données de sortie vers formulaire: 

		données sortie vers function envoyerMail():

		action de la function:

		*/
		
		$this->form_validation->reset_validation();
		$this->form_validation->set_rules('adresseExpediteur','AdresseExpediteur','required');
		$this->form_validation->set_rules('object','Object','required');
		$this->form_validation->set_rules('message','Message','required');
		$this->form_validation->set_rules('aTitrePersonnel','ATitrePersonnel');
		$this->form_validation->set_rules('destinataire','Destinataire','required');
		$this->form_validation->set_rules('pieceJointe','PieceJointe');
			
		if ($this->form_validation->run() == FALSE)
		{
			
			//recuperation mail session			
			if(isset($noEvenement))
			{
				$evenement=$this->modeleEvenement->retournerUnEvenement($noEvenement,$annee);
				$objet=$evenement->TxtHtmlEntete;
				$corpsTexte=$evenement->TxtHtmlCorps;
			}
			else
			{
				$objet='';
				$corpsTexte='';
			};
			$classe=$this->ModeleClasse->retournerClasse();
			
			$donneesMail= array(
				'adExpediteur'=> '',//session
				'objet'=>$objet, 				
				'corpsTexte'=>$corpsTexte,
				'classes'=>$classe				
			);
			if(isset($questionTechnique))
			{
				$donneesMail['questionTechnique']=$questionTechnique;
			}
			else
			{
				$donneesMail['questionTechnique']=null;
			}
			$this->load->view('templates/EnteteAdmin');			
			$this->load->view('administrateur/vueCreationMail',$donneesMail);
		}
		else
		{
			//upload piece jointe pour l'envoyer 
			/*données:
			['nom'] soit asso soit expediteur(if $aTitrePersonel)
			['destinataire'] (if $questionTechnique responsable)
							ifdestinataire requetage 
			['reply'] (if $aTitrePersonel)
			['object'] post->object
			['texte'] post->message 
			['piecesJointes] pieces jointes (facultatif)
			['expediteur'] adresse mail de l'expediteur pour les confirmation ou echec
			-adresseExpediteur 

		*/
		//for each 
		
		$uploaddir = '/asset/temp/';
		$uploadfile = $uploaddir . basename($_FILES['pieceJointe']['name']);
		if (move_uploaded_file($_FILES['pieceJointe']['tmp_name'], $uploadfile))  
		{
			$nomPieceJointe=basename($_FILES['pieceJointe']['name']);
		}
		else
		{
			echo "erreure de telechargement de piece jointe ";//a supprimer si ok
		}
		if(!isset($aTitrePersonel))
		{
			$nom='assocition@addresse.fr';
		}
		else
		{
			$nom=$_POST['adresseExpediteur'];
		}
		if($_POST['destinataire']='tous')
		{
			$personnes=$this->ModelePersonne->getPersonne();			
			$i=0;
			
			foreach($personnes as $personne)
			{	
			
			$email[$i]=$personne->Email;
			$i++;
			};				
		}
		/*elseif($_POST['destinataire']='administrateur')
		{
			$personnes='';
		};
		elseif($_POST['destinataire']=)
		{
			
		};
		elseif($_POST['destinataire']=)
		{
			
		};*/
		$donneesEnvoyeMail=array(
			'nom'=>$nom,
			'destinataire'=>$email,
			'reply'=>$nom
			/*'object'=
			'texte'=			
			'expediteur'=*/
		);
		if(isset($nomPieceJointe))
		{
			//foreach $donneesEnvoyeMail['piecesJointes']=$nomPieceJointe
		}
		
			//apel fonction envoyer mail

		}



	} 

	/**********************************************************************
    **                       fonction envoyer mail                       **
    **********************************************************************/



	public function envoyeMail($donnees)// envoye de mail quelque soit la source
	{
		/* pour cette fonction $donnees sera un tableau composer de :
		['nom'] le nom de l'expediteur (facultatif)
		['destinataire'] tableau des adresse mail des destinataire 
		['reply'] adresse de reponse (facultatif)
		['object'] object du mail
		['texte'] corps du message 
		['piecesJointes] pieces jointes (facultatif)
		['expediteur'] adresse mail de l'expediteur pour les confirmation ou echec
		cette fonction envoye le message a l'expediteur et une copie au responsable
		si le message est passer elle envoye un message a tout les destinataire 
		un par un pour eviter de donner les adresse mail des un au autre 
		elle comptabilise les echecs d'envoye et memorise les adresse des personne 
		qui l'on pas eu 
		puis envoye un message a l'expediteur en cas d'echec a l'expediteur 
		avec les adresse de tout les echec 
		si le message n'est pas passer elle envoye un mail d'erreur a l'expediteur et si celui ci
		passe pas elle affiche une vue d'erreur 
		il reste a faire 
		suprimmer la piece jointe 
		*/ 
		$this->load->library('email');// charge la librairie email 
		$Addresse='adresseAssocition@example.com';//adresse de l'association
		if(!isset($donnees['nom']))//si aucun nom est inscrit dans le formulaire
		{
			$nom='École primaire privée Sainte-Anne';//nom qui figurera sur le mail 
		}
		else
		{
			$nom=$donnees['nom'];
		}
		$destinataire=$donnees['destinataire'];//destinataire passer dans la funtion
		$copie='adressePresident@exemple.com,adresseGestionSite@exemple.com';// adresse a mettre en copie de chaque mail
		if(!isset($donnees['reply']))//si aucun nom est inscrit dans le formulaire
		{
			$reponse='adresseAssocition@example.com';//nom qui figurera sur le mail 
		}
		else
		{
			$reponse=$donnees['reply'];//nom de l'expediteur si il veux des reponsse pour lui
		}
		$object=$donnees['object'];//object
		$texte=$donnees['texte'];//corps du message
		$P=0;
		if(isset($donnees['piecesJointes']))
		{
			foreach($donnees['piecesJointes'] as $pieceJointe)
			{
				$P++;
				$piecesJointes[$nombreDePiecesJointes]=$pieceJointe;
			}
		} 
		$expediteur=$donnees['expediteur'];
		$echec=0;

		//envoye du mail a l'expediteur et en copie responsable; 
		$this->email->from($Addresse,$nom); 
		$this->email->to($expediteur); 
		$this->email->cc($copie);
		$this->email->reply_to($reponse, $nom);
		$this->email->subject( $object ); 
		$this->email->message( $texte );
		foreach($piecesJointes as $attachement)
		{
			$this->email->attach($attachement);
		}
		if($this->email->send())
		{
			foreach($destinataire as $mail)
			{
				$this->email->from($Addresse,$nom); 
				$this->email->to($mail);		
				$this->email->reply_to($reponse, $nom);
				$this->email->subject( $object ); 
				$this->email->message( $texte );
				foreach($piecesJointes as $attachement)
				{
					$this->email->attach($attachement);
				}
				if(!$this->email->send())//en cas d'echec on memorise le nombre d'echec et les adresses
				{
					$echec++;
					$addresseEchec[$echec]=$mail;
				}
			}
		}
		else
		{
			$this->email->from($Addresse,$nom); 
			$this->email->to($expediteur);
			$this->email->subject( "echec d'envoye du message" ); 
			$this->email->message( "le message ne peut etre delivré" );
			if(!$this->email->send())
			{
				$this->load->view(vueErreurMail);//a modifier
			}	
		}
		if($echec!=0)
		{
		$messageEchec="le message n'as pu etre envoyer au personne suivante : ";
		foreach($addresseEchec as $addresseE)
		{
			$messageEchec=$messageEchec." - ". $addresseE." . ";
		}
		$this->email->from($Addresse,$nom); 
		$this->email->to($expediteur);
		$this->email->subject( "echec d'envoye de messages" ); 
		$this->email->message( $messageEchec );
		$this->email->send(); 
		}
	}

	/**********************************************************************
    **          fonction  selection recap/modif commande                 **
	**********************************************************************/

	public function selectionCommande()
	{	
		if(!isset($_POST['existant']))
		{
			$DonneesInjectees['Provenance']='commande';			
			$DonneesInjectees['lesEvenements']= $this->ModeleEvenement->getEvenementGeneral(AnneeEnCour);
			$DonneesInjectees['lesEvenements']=$DonneesInjectees['lesEvenements']+$this->ModeleEvenement->getEvenementGeneral(AnneeEnCour-1);
			$DonneesInjectees['lesEvenements']=$DonneesInjectees['lesEvenements']+$this->ModeleEvenement->getEvenementGeneral(AnneeEnCour-2);
			$this->load->view('templates/EnteteAdmin');
			$this->load->view('administrateur/vueSelectionEvenements',$DonneesInjectees);		
			//$this->load->view('templates/PiedDePagePrincipal');
		}
		else
		{
			$evenement=explode("/",$_POST['Evenement']);
			$noEvenement=$evenement['1'];
			$annee=$evenement['0'];
			if(isset($_POST['modif']))
			{
				$modif=$_POST['modif'];
			}
			else
			{
				$modif='';
			}
			$i=0;
			$this->commande($noEvenement,$annee,$modif);
		
		}
	}

	/**********************************************************************
    **                 fonction recap/modif commande                     **
	**********************************************************************/
	


	public function commande($noEvenement=null,$annee=null,$modif=null)
	{
		if(!isset($_POST['submit']))
		{
			$lignesCommandes=$this->ModeleCommande->commandeParEvenement($noEvenement,$annee);
			$donnees=array(
				'lignesCommandes'=>$lignesCommandes,
				'annee'=>$annee,
				'noEvenement'=>$noEvenement			
			);
			if(isset($modif))
			{
				$donnees['modif']=$modif;
			}
			$this->load->view('templates/EnteteAdmin');		
			$this->load->view('administrateur/vueRecapCommande',$donnees);
			$this->load->view('templates/PiedDePagePrincipal');
		}
		else
		{
			$annee=$_POST['annee'];
			$noEvenement=$_POST['noEvenement'];
			$indexRemis = array_keys($_POST['remis']);
			$indexPaye = array_keys($_POST['paye']);
			
			foreach($indexRemis as $indexs)
			{
				$indexProduit=array_keys($_POST['remis'][$indexs]);
				foreach($indexProduit as $index)
				{
					$update=array(
						'NoCommande'=>$indexs,
						'Annee'=>$annee,
						'NoEvenement'=>$noEvenement,
						'NoProduit'=>$index,
						'Remis'=>$_POST['remis'][$indexs][$index]
					);
					$this->ModeleCommande->modifierRemis($update);
				}
			}
			foreach($indexPaye as $index)
			{
				$update=array(
					'NoCommande'=>$index,					
					'Payer'=>floatval($_POST['paye'][$index])
				);
				echo gettype($update['Payer']);
				$this->ModeleCommande->modifierPaye($update);
			}
			
			$lignesCommandes=$this->ModeleCommande->commandeParEvenement($noEvenement,$annee);
			$donnees=array(
				'lignesCommandes'=>$lignesCommandes,
				'annee'=>$annee,
				'noEvenement'=>$noEvenement,
				'modif'=>null		
			);
			$this->load->view('templates/EnteteAdmin');
			$this->load->view('administrateur/vueRecapCommande',$donnees);
			$this->load->view('templates/PiedDePagePrincipal');

		}
	}


}//fin  de class
?>