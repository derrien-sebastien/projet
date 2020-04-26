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
		$this->load->model('ModeleEnfant');
		$this->load->model('ModeleCommande'); 
		$this->load->helper('url'); // pour utiliser redirect
		$this->load->library('session');
		$this->load->model('ModeleIdentifiantSite');
			
		if($_SESSION['profil']!='admin')
		{			
			redirect('/visiteur/seConnecter'); // pas les droits : redirection vers connexion
		}
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
		$this->load->view('templates/EntetePrincipal');
		$this->load->view('templates/EnteteNavbar');
		$this->load->view('administrateur/vueAccueilAdministrateur');
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
		$donnees['Provenance']='ajouter';
		if(isset($_POST['evenement']))
		{
		$AncienEvenement=explode("/",$_POST['evenement']);
   	 	$Annee=$AncienEvenement['0'];
		$NoEvenement=$AncienEvenement['1'];
		$donnees['evenement']=$this->ModeleEvenement->retournerUnEvenement($NoEvenement,$Annee);
		}
		$this->formulaireEvenement($donnees);
	}
	

	/**********************************************************************
    **                         Modifier un évenement                     **
    **********************************************************************/
	
	
	public function modifierEvenement() 
	{
		$this->load->view('templates/EntetePrincipal');
		$this->load->view('templates/EnteteNavbar');
		
		$donneesInjectees=array(
			'Provenance'=>'modifier'
		);		
		if (!isset($_POST['evenement']))
		{
			$donneesInjectees['lesEvenements']= $this->ModeleEvenement->getEvenementGeneral(AnneeEnCour);
			$donneesInjectees['lesEvenements']= $donneesInjectees['lesEvenements']+$this->ModeleEvenement->getEvenementGeneral(AnneeEnCour-1);
			$donneesInjectees['lesEvenements']= $donneesInjectees['lesEvenements']+$this->ModeleEvenement->getEvenementGeneral(AnneeEnCour-2);
			$this->load->view('administrateur/vueSelectionEvenements',$donneesInjectees);		
			//$this->load->view('templates/PiedDePagePrincipal');
		}
		else
		{
			
			$AncienEvenement=explode("/",$_POST['evenement']);
   	 		$Annee=$AncienEvenement['0'];
			$NoEvenement=$AncienEvenement['1'];
			$donneesInjectees['evenement']=$this->ModeleEvenement->retournerUnEvenement($NoEvenement,$Annee);
				
			$this->formulaireEvenement($donneesInjectees);
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
		$this->load->view('templates/EntetePrincipal');
		$this->load->view('templates/EnteteNavbar');
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
	

	public function uploadImage($localisationImage) 
	{
		$config['upload_path'] = './assets/images/';//reglage image 
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '204800';
		$config['max_width'] = '100000';
		$config['max_height'] = '100000';
		$this->load->library('upload', $config);//chargement de la librairie upload
		if (!$this->upload->do_upload($localisationImage) == TRUE)// si l'image n'est pas upload
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

    
	public function formulaireEvenement ($donnees=null)	//formulaire evenement nom a modifier
	{		
		
		/* 
		arrivé sur la fontion:
		-ajouté evenement 
		-modifier evenement
		-formulaire evenement

		donnée entrée:
		-provenance (ajouter, modifier)
		-evenement /de la vue selection evenement
		-
		*/
		
		$this->form_validation->set_rules('anneeEvenement','Annee','required');//regle de validation du formulaire
		$this->form_validation->set_rules('noEvenement',"numero d'evenement");
		$this->form_validation->set_rules('imgEntete',"image entete");
		$this->form_validation->set_rules('imgPiedDePage',"image pied de page");
		$this->form_validation->set_rules('dateMiseEnLigne','DateMiseEnLigne');
		$this->form_validation->set_rules('dateMiseHorsLigne','DateMiseHorsLigne');
		$this->form_validation->set_rules('texteEntete','TxtHTMLEntete');
		$this->form_validation->set_rules('texteCorps','TxtHTMLCorps','required');
		$this->form_validation->set_rules('textePied','TxtHTMLPiedDePage');
		$this->form_validation->set_rules('txtImgEntete',"image pied de page");
		$this->form_validation->set_rules('txtImgPiedDePage',"image pied de page");
		$this->form_validation->set_rules('supImgEntete',"supprime image entete");
		$this->form_validation->set_rules('supImgPiedPage',"supprime image pied de page");
		$this->form_validation->set_rules('emailInfo','EmailInformationHTML');
		$this->form_validation->set_rules('enCours','EnCours');	
		$this->form_validation->set_rules('ajoutProduit','ajout de produit');		
		if ($this->form_validation->run() === FALSE)//si le formulaire n'est pas validé
	 	{
			//creation de la variable LesProduits avec l'année en cour et année -1 et -2
			$donneesInjectees['lesProduits']=$this->ModeleProduit->getProduitGeneral(AnneeEnCour);//recuperation des produit en objet
			$donneesInjectees['lesProduits']=$donneesInjectees['lesProduits']+$this->ModeleProduit->getProduitGeneral(AnneeEnCour-1);
			$donneesInjectees['lesProduits']=$donneesInjectees['lesProduits']+$this->ModeleProduit->getProduitGeneral(AnneeEnCour-2);
			//creation de la variable Provenance
			$donneesInjectees['Provenance']=$donnees['Provenance'];
			//si on vient avec un evenement selectionné
			if(isset($donnees['evenement']))
			{
				//cration de la variable evenement
				$donneesInjectees['evenement']=$donnees['evenement'];
			}
			//chargement des entetes
			$this->load->view('templates/EntetePrincipal');
			$this->load->view('templates/EnteteNavbar');
			if ($donnees['Provenance']=='ajouter')//si on ajoute un evenement
			{
				// creation variable lesEvenement année en cours et -1 et -2
				$donneesInjectees['lesEvenements']= $this->ModeleEvenement->getEvenementGeneral(AnneeEnCour);//recuperation les evenement en objet
				$donneesInjectees['lesEvenements']=$donneesInjectees['lesEvenements']+$this->ModeleEvenement->getEvenementGeneral(AnneeEnCour-1);
				$donneesInjectees['lesEvenements']=$donneesInjectees['lesEvenements']+$this->ModeleEvenement->getEvenementGeneral(AnneeEnCour-2);
				//chargement de la vue selection evenement 
				$this->load->view('administrateur/vueSelectionEvenements',$donneesInjectees);//charge la vue pour preremplir le formulaire
				
			}
			//chargement de la vue formulaire evenement et du pied de page
			$this->load->view('administrateur/vueFormulaireEvenement copy',$donneesInjectees);
			$this->load->view('templates/PiedDePagePrincipal');
		}
		else 
		{
			//traitement des image :
				//image entete
			if(isset($_POST['supImgEntete']))//si on a coché supprimer l'image 
			{
				$NomImageEntete=null;//l'image est mise a nul
			}
			else 
			{				
				if($this->input->post('submit'))//upload image entete
				{	
					$LocalisationImage='txtImgEntete';
					$NomImageEntete=$this->uploadImage($LocalisationImage);						
				}
				if ($NomImageEntete===0)// si l'image n'est pas upload
				{				
					$NomImageEntete=$this->input->post('imgEntete');//utilisation de l'ancien nom 
				}
			}
				//image pied page 
			if(isset($_POST['supImgPiedPage']))//si on a coché supprimer l'image 
			{
				$NomImagePiedPage=null;//l'image est mise a nul
			}
			else 
			{		 
				if($this->input->post('submit'))//upload image pied de page    
				{
					$LocalisationImage='txtImgPiedDePage';
					$NomImagePiedPage=$this->uploadImage($LocalisationImage);							
				}			
				if ($NomImagePiedPage===0)// si l'image n'est pas upload
				{
					$NomImagePiedPage=$this->input->post('imgPiedDePage');//utilisation de l'ancien nom 
				}
			}
			//gestion du encour
			if(isset($_POST['enCours']))//si encours est coché
			{
				$encours=$this->input->post('enCours');//charge la valeur de l'encour
			}
			else//si encour est décoché
			{
				$encours=0;//encour est mis a 0
			}
			$provenance=$_POST['provenance'];
			if($provenance=='ajouter')//si on ajoute un evenement
			{		
				$noMax = $this->ModeleEvenement->maxEvenement();//recherche du max evenement
				$noEvenement=$noMax+1;//on met le numero d'evenement a max+1
			}
			elseif($provenance=='modifier')//si on modifie un evenement
			{
				$noEvenement=$_POST['noEvenement'];//recuperation du numero evenement
			}
			//creation du tableau pour remplir la base de données
			$donneesAInserer = array(
				'Annee'=>$_POST['anneeEvenement'],
				'NoEvenement'=>$noEvenement,			
				'DateMiseEnLigne'=>$this->input->post('dateMiseEnLigne'),
				'DateMiseHorsLigne'=>$this->input->post('dateMiseHorsLigne'),
				'TxtHTMLEntete'=>$this->input->post('texteEntete'),
				'TxtHTMLCorps'=>$this->input->post('texteCorps'),
				'TxtHTMLPiedDePage'=>$this->input->post('textePied'),
				'ImgEntete'=>$NomImageEntete,
				'ImgPiedDePage'=>$NomImagePiedPage,
				'EmailInformationHTML'=>$this->input->post('emailInfo'),
				'EnCours'=>$encours
			);
			// tableau pour lesrecherche dans d'autre table 
			$donnees=array(
				'Annee'=>$_POST['anneeEvenement'],
				'NoEvenement'=>$noEvenement
			);
			if($provenance=='ajouter')//si on ajoute un evenement
			{			 
				$this->ModeleEvenement->ajouterEvenement($donneesAInserer);//création d'une nouvel ligne a la table 
				if (isset($_POST['ajoutProduit']))//si on ajoute un produit 
				{	
					// ajout des produit selectionné
					$i=1;
					foreach ($_POST['produit'] as $unProduit)
					{
						if($unProduit!='//')
						{
						$AncienEvenement=explode("/",$unProduit);
   	 					$donneesProduit['Annee']=$AncienEvenement['0'];
						$donneesProduit['NoEvenement']=$AncienEvenement['1'];
						$donneesProduit['NoProduit']=$AncienEvenement['2'];
						$Produit=$this->ModeleProduit->getUnProduit($donneesProduit);
						$Produit['Annee']=$donnees['Annee'];
						$Produit['NoEvenement']=$donnees['NoEvenement'];
						$Produit['NoProduit']=$i;
						$i++;
						$this->ModeleProduit->ajouterProduit($Produit);
						}
						else 
						{
							$new=1;
						}
					}
					//ajout evenement marchant
					$donnees['DateRemiseProduit']=$_POST['dateRemiseProduit'];
					$this->ModeleEvenement->ajouterEvenementMarchand($donnees);
					if ($new=1)
					{
						$this->formulaireProduit($donnees['NoEvenement'],$donnees['Annee'],'ajouterEvenement');
					}					
				}
				else
				{
					$this->ModeleEvenement->ajouterEvenementNonMarchand($donnees);//ajout a la table non marchand					
				}
			}
			elseif($Provenance=='modifier')//si on modifie un evenement
			{
				$this->ModeleEvenement->modifierEvenement($donneesAInserer);//modification de la ligne liée a l'evenement dans la db
				if (isset($_POST['ajoutProduit']))//si on ajoute un produit
				{	
					//$i prend la valeur max des produit de l'evenement 
					$i=$this->ModeleProduit->maxProduit($donnees);
					foreach ($_POST['produit'] as $unProduit)
					{
						if($unProduit!='//')
						{
							$AncienEvenement=explode("/",$unProduit);
   	 						$donneesProduit['Annee']=$AncienEvenement['0'];
							$donneesProduit['NoEvenement']=$AncienEvenement['1'];
							$donneesProduit['NoProduit']=$AncienEvenement['2'];
							if ($donneesProduit['NoEvenement']!=$donnees['NoEvenement']||$donneesProduit['Annee']!=$donnees['Annee'])
							{
								$Produit=$this->ModeleProduit->getUnProduit($donneesProduit);
								$Produit['Annee']=$donnees['Annee'];
								$Produit['NoEvenement']=$donnees['NoEvenement'];
								$Produit['NoProduit']=$i;
								$i++;
								$this->ModeleProduit->ajouterProduit($Produit);
							}
						}
						else 
						{
							$new=1;
						}
					}
					//presence evenement marchant
					if($this->ModeleEvenement->presenceEvenementMarchand($donnees['Annee'],$donnees['NoEvenement']))
					{
						//sortie evenement marchant
						$evenementMarchant=$this->ModeleEvenement->getEvenementMarchand($donnees['Annee'],$donnees['NoEvenement']);
						//y a t'il eu modification de la date remise produit
						if($evenementMarchant->DateRemiseProduit!=$donnees['DateRemiseProduit'])
						{
							//update evenement marchant
							$this->ModeleEvenement->modifierEvenementMarchant($donnees);
						}
					}
					else 
					{	
						//l'evenement etait il precedement non marchand
						if($this->ModeleEvenement->presenceEvenementNonMarchand($donnees['Annee'],$donnees['NoEvenement']))
						{
							//suppression de l'evenement non marchand
							$this->ModeleEvenement->deleteEvenementNonMarchand($donnees); 
						}
						//creation de l'evenement marchand 
						$donnees['DateRemiseProduit']=$_POST['dateRemiseProduit'];
						$this->ModeleEvenement->ajouterEvenementMarchand($donnees);
					}					
					if ($new=1)
					{
						$this->formulaireProduit($donnees['NoEvenement'],$donnees['Annee'],'modifierEvenement');
					}
					
				}
				else
				{
					if(!$this->ModeleEvenement->presenceEvenementMarchand($donneesAInserer['annee'],$donneesAInserer['noEvenement']))
					{
						if(!$this->ModeleEvenement->presenceEvenementNonMarchand($donneesAInserer['annee'],$donneesAInserer['NoEvenement']))
						{							
							$this->ModeleEvenement->ajouterEvenementNonMarchand($donnees);//ajout a la table non marchand	
						}
					}
					else 
					{
						// vue modification impossible voir avec l'administrateur de la base de registre 
						// la suppression de l'evenement marchant influe sur tout les produit de l'evenement 
						// toutes les requettes son chambouller (voir avec damien )
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
			$this->load->view('templates/EntetePrincipal');
			$this->load->view('templates/EnteteNavbar');
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
			$this->load->view('templates/EntetePrincipal');
			$this->load->view('templates/EnteteNavbar');
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
			$this->load->view('templates/EntetePrincipal');
			$this->load->view('templates/EnteteNavbar');			
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
			$this->load->view('templates/EntetePrincipal');
			$this->load->view('templates/EnteteNavbar');
			$this->load->view('administrateur/vueSelectionEvenements',$DonneesInjectees);		
			//$this->load->view('templates/PiedDePagePrincipal');
		}
		else
		{
			$evenement=explode("/",$_POST['evenement']);
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
			$this->load->view('templates/EntetePrincipal');
			$this->load->view('templates/EnteteNavbar');		
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
			$this->load->view('templates/EntetePrincipal');
			$this->load->view('templates/EnteteNavbar');
			$this->load->view('administrateur/vueRecapCommande',$donnees);
			$this->load->view('templates/PiedDePagePrincipal');

		}
	}
	public function afficherProbleme()
	{
		$donnees['enfantSansCorrepondant']=$this->ModeleEnfant->enfantSansCorrespondant();
		$donnees['classesSansEnfants']=$this->ModeleClasse->nbEleveParClasse();	
		$this->load->view('templates/EntetePrincipal');
		$this->load->view('templates/EnteteNavbar');
		$this->load->view('administrateur/vueProbleme',$donnees);
		$this->load->view('templates/PiedDePagePrincipal');
	}
	public function modifCorrespondantEnfant()
	{
		foreach($_POST as $key=>$value)
		{
			if($key != 'submit')
			{
				if($this->ModelePersonne->rechercherEmailPresent($value))
				{
					$personne=$this->ModelePersonne->rechercheInfoPersonne($value);
					$donnees=array(
						'NoPersonne'=>$personne->NoPersonne,
						'EtreCorrespondant'=>1
					);
					$personneParent=$this->ModelePersonne->getPersonneParent($personne->NoPersonne);
					if($personneParent!=null)
					{
						if($personneParent->EtreCorrepondant==0)
						{
							$this->ModelePersonne->modifierPersParent($donnees);
						}
					}
					else
					{
						$this->ModelePersonne->insererInformationPersonneParent($donnees);
					}

				}
			}
		}		
		$this->afficherProbleme();
	}
	public function afficherEleveClasse()
	{
		$donnees=array(
			'lesClasses'=>$this->ModeleClasse->retournerClasse()
		);
		$this->load->view('administrateur/vueSelectionClasse',$donnees);
		if(isset($_POST['envoyer']))
		{
			$donneesEleves=array(
				'eleves'=>$this->ModeleEnfant->getEnfantClasse($_POST['classe'])
			);
			if($_POST['classe']!=0)
			{
				$donneesEleves['classe']=$this->ModeleClasse->retournerinfoClasse($_POST['classe']);
			}
			$this->load->view('administrateur/vueTableauEleves',$donneesEleves);
		}
	}

	public function modifierClasse()
	{
		if(isset($_POST['modifications']))
		{
			
			foreach($_POST['supprime'] as $supprime)
			{				
				if($_POST[$supprime]!='')
				{
					$donnees=array(
						'NoEnfant'=>$supprime,
						'NoClasse'=>$_POST['classe'],
						'DateFin'=>$_POST[$supprime]
					);
					//modeleClasse update appartenir $donnees						
				}
			}
			foreach($_POST['selection'] as $ajout)
			{
				if (!$donnees['enfant'])//$this modele enfant info 
				{
					//stock l'enfant dans une variable
				}
			}
			//vue date debut 
			//nouvelle fonction pour ajouté l'enfant modele enfant insert
		}
		else
		{
			if(isset($_POST['modifier'])||isset($_POST['envoyer']))
			{			
				$classe=$this->ModeleClasse->retournerinfoClasse($_POST['classe']);
				$elevesDeLaClasse=$this->ModeleEnfant->getEnfantClasse($_POST['classe']);
				$eleves=$this->ModeleEnfant->getEnfants();
				$donnees=array(
					'classe'=>$classe,
					'elevesDeLaClasse'=>$elevesDeLaClasse,
					'eleves'=>$eleves
				);
				$this->load->view('administrateur/vueModificationDeClasse',$donnees);
			}
			else
			{
				$donnees['lesClasses']=$this->ModeleClasse->retournerClasse();
				$this->load->view('administrateur/vueSelectionClasse',$donnees);
			}
		}
	}

}//fin  de class
