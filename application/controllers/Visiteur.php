<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once(APPPATH."controllers/Administrateur.php");
class Visiteur extends CI_Controller 
{

   /**********************************************************************
   **                           Constructeur                            **
   ***********************************************************************

   Permet de charger :
      - nos librairies
      - nos modèles 
      - nos constantes
      - nos conditions
   */
   public function __construct()
   {	
      parent::__construct();   
      $this->load->model('ModeleClasse', 'mClass');
      $this->load->model('ModeleCommande');
      $this->load->model('ModeleIdentifiantSite');
      $this->load->model('ModeleEvenement', 'mEven');    	
      $this->load->model('ModelePersonne','mPers');
      $this->load->model('ModeleProduit','mProd');
      $this->load->library('user_agent');
                                       ////  CONDITION 1 - Déclaration de la constante AnneeEnCour  //////
      if(date('m')<8)                  // si le mois est inférieur à 8 
		{                                // alors
			$annee=date('Y');             // la variable $annee prendra la valeur de l'année en cours
			define('AnneeEnCour',$annee);	// elle sera définie par 'AnneeEnCour'			 
		}                                //
		else                             // Sinon 
		{                                // La variable $annee prendra la valeur de l'année en cours +1
			$annee=date('Y')+1;           // soit l'année suivante définit par 'AnneeEnCour'
			define('AnneeEnCour',$annee); //
      }                                ///////////////////////////////////////////////////////////////////
                                       ////  CONDITION 2 - Déclaration du Profil et du Panier    /////////
      if (!isset($_SESSION['email']))  // si l'email n'est pas défini dans la variable $_SESSION
      {                                // alors 
         $dataSession=array(           // la variable $datatSession est créer via un tableau associatif
            'email'=>'',               // qui aura pour attribut :
            'profil'=>'',              //                email  -  profil  -  actif 
            'actif'=>'',               //    et le panier qui lui même sera un tableau associatif 
            'panier'=>array()          // La variable sera un paramêtre de la méthode set_userdata qui 
         );                            // appartient à la classe session
         $this->session->set_userdata($dataSession);///////////////////////////////////////////////////////
      }
   }


   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /**************************                                                                              *************************************/
   /**************************                          NOTRE PAGE D'ACCUEIL                                *************************************/
   /**************************                                                                              *************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /* FUNCTION DE NOTRE INDEX TEMPLATES
   
         Comprend :  

            Entete ( bootstrap // summernote // javascript )
            Navbar ( générée en fonction des utilisateurs )
            Pied de Page ( informations sur le site/l'association - les administrateurs )
   */
   public function indexVisiteur($vue, $donnees = NULL, $vue2= null, $donnees2=null)
   {
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('templates/EnteteNavbar');
      $this->load->view($vue,$donnees);
      if(isset($vue2))
      {
         $this->load->view($vue2,$donnees2);
      }
      $this->load->view('templates/PiedDePagePrincipal');
   }

   /* FUNCTION DE NOTRE PAGE D'ACCUEIL  

         Comprend :

            L'index template et notre vue
   */
   public function accueil()
   {
      $this->indexVisiteur('templates/vueAccueilPrincipal');
   }

   
   /**********************************************************************
   **                        SE CONNECTER                               **
   **********************************************************************/

   public function seConnecter()
   {  
      $urlDArriver =  $this->agent->referrer();     
  
      $this->form_validation->set_rules('txtEmail', 'email', 'trim|required|valid_email');
      $this->form_validation->set_rules('password','mot de passe');      
      $DonneesInjectees['TitreDeLaPage'] = 'Se Connecter';                             
      if($this->form_validation->run() === FALSE)                                     
      {  
       
         $DonneesInjectees['urlRedirect']=$urlDArriver;
         $this->indexVisiteur('visiteur/vueLogin',$DonneesInjectees);         
      }
      else                                                                             
      {  
         $email=$_POST['txtEmail'];
         
         if($_POST['password']=='')
         {
            $password=NULL;
         }
         else
         {
            $password=$_POST['password'];
         }
         $personne=$this->mPers->recherchePersonne($email,$password);
         if(isset($personne)) 
         {
            //$this->session->session_start;                                  
            $dataSession=array(
               'email'=>$personne->Email,
               'profil'=>$personne->profil,
               'actif'=>$personne->Actif
            );                    
            $this->session->set_userdata($dataSession);                                                   
            if($this->session->profil=='admin')
            {  
               if ($_POST['urlRedirect']!='http://[::1]/projet/index.php/Visiteur/seConnecter') 
               {  
                  if($_POST['urlRedirect']=='http://[::1]/projet/index.php/visiteur/accueil')
                  {                        
                     redirect('http://[::1]/projet/index.php/Administrateur/accueil');
                  } 
                  else
                  {
                     redirect($_POST['urlRedirect']);
                  }          
               }               
               else
               {
                  redirect('Administrateur/accueil');
               }
            }
            elseif ($this->session->profil=='membre')
            {               
               
               if ($_POST['urlRedirect']!='http://[::1]/projet/index.php/Visiteur/seConnecter') 
                  {           
                     redirect($_POST['urlRedirect']);
                  }
                  else
                  {
                     $this->accueil();
                  }
               
            }
            else
            {
               $this->catalogueEvenement();
            }           
         }
         else
         {
            if(!$this->mPers->rechercherEmailPresent($email))
            {
               $this->indexVisiteur('visiteur/vueAjouterpersonne');  
            }
            else
            {   
               $this->indexVisiteur('visiteur/vueLogin', $DonneesInjectees);
            }
         }     
      }
   }

   /**********************************************************************
   **                           INSCRIPTION                             **
   **********************************************************************/

   public function inscription()
   {  
      $this->indexVisiteur();
      $this->form_validation->set_rules( 'txtEmail', 'Identifiant', 'required'); 
      $this->form_validation->set_rules( 'password', 'mot de passe');
      $this->form_validation->set_rules( 'password2', 'repetez mot de passe'); 
      if ($this->form_validation->run() === TRUE)                                     
      {
         if($_POST['password']==$_POST['password2'])
         {
            if($_POST['password']=='')
            {
               $mdp=NULL;
            }
            else
            {
               $mdp=$_POST['password'];
            }
            $noPersonne=$this->ModelePersonne->maxPersonne()+1;
            $donnees = array(  
               'NoPersonne'   => $noPersonne,                                                            
               'Email'        => $this->input->post('txtEmail'),
               'MotDePasse'   => $mdp,
               'panier'       => array()                                    
            );
            $this->ModelePersonne->insererInformationPersonne($donnees);                                                                                
            $this->seConnecter();    
         }
         else
         {
            $this->load->view('visiteur/vueErreurMDPCorrespondant');
            $this->load->view('visiteur/vueAjouterpersonne');
            $this->load->view('templates/PiedDePagePrincipal');
         }
      }
      else                                                                             
      {                                                                                                   
         $this->load->view('templates/PiedDePagePrincipal');                                                 
      }
   } 

   /**********************************************************************
   **                      MOT DE PASSE OUBLIE                          **
   **********************************************************************/
   public function oublieMotDePasse()
	{
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('templates/EnteteNavbar');
      $this->form_validation->set_rules('txtLogin','email','required');
      if($this->form_validation->run() === FALSE)
         { 
            $this->load->view('visiteur/vueMotDePasseOublie');
            $this->load->view('templates/PiedDePagePrincipal');
         }
         else
         {    
            if (!($rechercherEmailPresent($_POST['txtLogin'])))
            {  //erreure de mail a refaire
               $Value['Value'] = 'Adresse e-mail incorrect';
               //$this->load->view('vueErreur');
               $this->load->view('visiteur/vueMotDePasseOublie');
               $this->load->view('templates/PiedDePagePrincipal');
            }
            else
            {
               $nouveauMdp='';
               for ($i=1;$i<=10;$i++)
               {
                  $nouveauMdp= chr(floor(rand(0, 25)+97));
               }   
               $this->email->from('ge_personne');
               $this->email->to($DonneesPersonne['Email']);
               $this->email->subject('MOT DE PASSE GES');
               $message = "Votre mot de passe est : '".$nouveauMdp."'. Pensez à changer votre mot de passe.";
               $this->email->message($message);
               if (!$this->email->send())
               {
                  $this->email->print_debugger();
               }
               redirect('visiteur/nosEvenements');
            }          
         }
   }
   /**********************************************************************
   **                      SE DECONNECTER                               **
   **********************************************************************/
   

   public function seDeConnecter() 
   {
      $this->session->sess_destroy($_SESSION['__ci_last_regenerate']);   
      redirect('visiteur/accueil');
   }

   /**********************************************************************
   **                    Mention légales et cookies                     **
   **********************************************************************/
   //A REVOIR
    
   public function mentionsLegales()
   {
      $DonneesInjectees['TitreDeLaPage'] = 'Informations Légales';  
      $this->indexVisiteur('visiteur/vueMentionsLegales', $DonneesInjectees);                                         
   }
  


   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/ 
   /*********************************************************************************************************************************************/
   /**************************                                                                              *************************************/
   /**************************                        DONNEES PAGE EVENEMENTS                               *************************************/
   /**************************                                                                              *************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/

   
   /**********************************************************************
   **               CATALOGUE DES EVENEMENTS EN COURS                  ***
   **********************************************************************/


   public function catalogueEvenement()            
   {   
      $DonneesInjectees['lesEvenementsMarchands'] = $this->mEven->retournerEvenementsMarchands();
      $DonneesInjectees['lesEvenementsNonMarchands'] = $this->mEven->retournerEvenementsNonMarchands();
      $this->indexVisiteur('visiteur/vueCatalogueEvenements', $DonneesInjectees);
   } 
 
   /**********************************************************************
   **                       UN EVENEMENT CHOISI                        ***
   **********************************************************************/

   public function EvenementMarchand($noEvenement = NULL, $annee=NULL)
   {
      $DonneesProduit['lesProduits'] = $this->mProd->getRows($noEvenement, $annee);   
      $DonneesProduit['unEvenementMarchand'] = $this->mEven->retournerEvenements($noEvenement, $annee);
      $DonneesProduit['prodPanier']=$this->cart->contents();
      
      if (empty($DonneesProduit['unEvenementMarchand']))
      {   
         show_404();
      }
      else
      {
         $this->indexVisiteur('visiteur/vueEvenementMarchandEntete', $DonneesProduit);
      }
   }
   
   public function EvenementNonMarchand($noEvenement = NULL,$annee =NULL)
   {
      
      $DonneesInjectees['unEvenementNonMarchand'] = $this->mEven->retournerEvenements($noEvenement,$annee);
      if (empty($DonneesInjectees['unEvenementNonMarchand']))
      {   
         show_404();
      }
      $DonneesInjectees['TitreDeLaPage'] = $DonneesInjectees['unEvenementNonMarchand']['TxtHTMLEntete'];
      $this->indexVisiteur('visiteur/vueEvenementNonMarchandEntete', $DonneesInjectees);
   }

   /**********************************************************************
   **                               PANIER                             ***
   **********************************************************************/
  
   public function panier($noEvenement = NULL, $annee=NULL )
   { 
      $DonneesProduit['lesProduits'] = $this->mProd->getRows($noEvenement, $annee);      
      $DonneesProduit['unEvenementMarchand'] = $this->mEven->retournerEvenements($noEvenement, $annee);
      $DonneesProduit['prodPanier']=$this->cart->contents();
      $this->indexVisiteur('visiteur/vuePanier', $DonneesProduit);
   }

   public function ajoutPanier()
   {
      $produit=explode('X',$_POST['adress']);
      $noEvenement=$produit['0'];
      $annee=$produit['1'];
      $noProduit=$produit['2'];
      $DonneesProduit=$this->ModeleProduit->getRows($noEvenement, $annee, $noProduit);
      $data = array(
            'id'    => $DonneesProduit['NoProduit']/* .'/'.$DonneesProduit['NoEvenement'].'/'.$DonneesProduit['annee'] */,
            'qty'   => $_POST['qty'],
            'price' => $DonneesProduit['Prix'],
            'name'  => $DonneesProduit['LibelleCourt'],
            'image' => $DonneesProduit['Img_Produit'],
            'adress'=> $_POST['adress']
        );
      $this->cart->insert($data);
      $this->EvenementMarchand($noEvenement,$annee);
   }

   function removeItem($rowid,$adress)
   {  
      $produit=explode('X',$adress);
      $noEvenement=$produit['0'];
      $annee=$produit['1'];     
      $data = array(
          'rowid'   => $rowid,
          'qty'     => 0
      );
      $DonneesProduit['lesProduits'] = $this->mProd->getRows($noEvenement, $annee);
      $DonneesProduit['unEvenementMarchand'] = $this->mEven->retournerEvenements($noEvenement, $annee);
      $DonneesProduit['prodPanier']=$this->cart->contents();
      $this->cart->update($data);
      $this->indexVisiteur('visiteur/vueEvenementMarchandEnTete',$DonneesProduit);
   }

   public function updateItemQty()
   {
      $data=array();
      for($i=1;$i<=$this->cart->total_items();$i++)
      {
         $data=array(
            'rowid'     =>  $_POST[$i.'rowid'],
            'qty'       =>  $_POST['Qty']
         );
      }
      $this->cart->update($data);
      echo $update?'ok':'err';
   }

   public function viderPanier($noEvenement,$annee)
   {
      $this->cart->destroy();
      $this->EvenementMarchand($noEvenement,$annee);
      
   }

   /**********************************************************************
   **                           COMMANDE                               ***
   **********************************************************************/
   public function commande()
   {
      if($this->cart->total_items() <= 0)
      {
         $this->panier();
      }
         $donneesUtilisateur = $data = array();
         $submit = $this->input->post('placerCommande');
         if(isset($submit))// Si la demande de commande est soumise
         {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $donneesUtilisateur = array(
               'email'     => strip_tags($this->input->post('email')),// Préparer les données clients
            );
            if($this->form_validation->run() == true)// Si les règles de validation sont bonne
            {
               $insert = $this->mProd->insererDonneesClient($donneesUtilisateur);// on ajoute les données clients
               if($insert)// on érifier le statut de l'insertion des données client
               {
                  $commande = $this->placerCommande($insert);// si ok on insert la commande
                  if($commande)//Si la soumission de la commande est réussie
                  {
                     $this->session->set_userdata('success_msg', 'Article au panier');
                     redirect(''.$commande);///\/\/\/\/\/\/\/\ PAIEMENT EN LIGNE  /\/\/\/\/\/\/\/\\/\/\/\/\/\/\/\
                  }
                  else
                  {
                     $data['error_msg'] = 'La soumission de la commande a échoué, veuillez réessayer.';
                  }
               }
               else
               {
                  $data['error_msg'] = 'Des problèmes sont survenus, veuillez réessayer.';
               }
            }
         }
      $data['donneesUtilisateur'] = $donneesUtilisateur;// Données personne
      $data['prodPanier'] = $this->cart->contents();// Récupérer les données du panier 
      $this->load->view('Visiteur/catalogueProduits', $data);// Transférer les données à la vue
      
   }

   public function placerCommande($personne)// Insérer les données de la commande via la variable personne
   {
      $commande = array(
         'noPersonne' => $personne,
         'grand_total' => $this->cart->total()
      );
      $insertComande = $this->mProd->insererCommande($commande);
      if($insertCommande)
      {
         $prodPanier = $this->cart->contents();// Récupérer les données du panier
         $commandeItemData = array();
         $i=0;
         foreach($prodPanier as $item)
         {
            $commandeItemData[$i]['noCommande']     = $insertCommande;
            $commandeItemData[$i]['noProduit']     = $item['id'];
            $commandeItemData[$i]['quantity']     = $item['qty'];
            $commandeItemData[$i]['sub_total']     = $item["subtotal"];
            $i++;
         }
         if(!empty($commandeItemData))
         {
            $insertCommandeItems = $this->mProd->insererArticleCommande($commandeItemData);//Insérer la Commande de produits
            if($insertCommandeItems)
            {
               $this->cart->destroy();// Supprimer les produits du panier
               return $insertCommande;// retourne noCommande
            }
         }  
      }
   return false;
   }


   public function commandeValide($noCommande)
   {
      $data['commande'] = $this->mProd->obtenirCommande($noCommande);//Récupérer les données de commande dans la base de données
      $this->load->view('', $data); // Affiche les détails de la commande // a finir
   } 


   public function passerCommande($noEvenement = NULL, $annee = NULL)
   {
      $urlDArriver =  $this->agent->referrer();
      if($_SESSION['profil']=='membre' || $_SESSION['profil']=='admin')
      {
         $this->formulaireLivraison();
      }
      else
      {
         $this->form_validation->set_rules('checkbox','Choix','required');
         $this->form_validation->set_rules('submit','Soumettre','required');
         if ($this->form_validation->run() === FALSE)
         {  
            $DonneesProduit['lesProduits'] = $this->mProd->getRows($noEvenement, $annee);      
            $DonneesProduit['unEvenementMarchand'] = $this->mEven->retournerEvenements($noEvenement, $annee);
            $DonneesProduit['prodPanier']=$this->cart->contents();
            $this->indexVisiteur('visiteur/vueQuestionnaire');
         }
         else
         {
            if($_POST['checkbox']=='1')
            {
               $DonneesInjectees['urlRedirect']=$urlDArriver;
               $this->form_validation->set_rules('email', 'Email', 'required|valid_email');  
               if ($this->form_validation->run() === FALSE) 
               {  
                  $this->indexVisiteur('visiteur/vueSaisiMailAchat',$DonneesInjectees);
               } 
               else
               {
                  $this->formulaireLivraison();
               }  
            }
            elseif($_POST['checkbox']=='2')
            {             
               $this->formulaireLivraison();
            }
            else 
            {
               $this->load->view('visiteur/vueQuestionnaire');
            }
         }
      }   
      
   }
   public function formulaireLivraison()
   {
      $this->form_validation->set_rules('email', 'Email', 'required|valid_email');  //regle de validation du formulaire
		$this->form_validation->set_rules('txtNom','Nom','required');
      $this->form_validation->set_rules('txtPrenom','Prenom');
      $this->form_validation->set_rules('txtAdresse','Adresse','required');
      $this->form_validation->set_rules('txtCp','Code postal','required');
      $this->form_validation->set_rules('txtVille','Ville','required');
      $this->form_validation->set_rules('txtTelP','TelPortable');
      $this->form_validation->set_rules('txtTelF','TelFixe');
      if($_SESSION['email'])
      {
         $donneesPersonne['Personne']=$this->ModelePersonne->rechercheInfoPersonne($_SESSION['email']);
         $this->indexVisiteur('visiteur/vueInscriptionAchat',$donneesPersonne,'visiteur/vueModePaiement');
      }
      elseif($_POST['email'])
      {
         if($this->ModelePersonne->presenceMdp($_POST['email']))
         {
            $this->seConnecter();
         }
         else
         {
            $donneesPersonne['Personne']=$this->ModelePersonne->rechercheInfoPersonne($_POST['email']);
            $this->indexVisiteur('visiteur/vueInscriptionAchat',$donneesPersonne, 'visiteur/vueModePaiement') ;
         }
      }
      else
      {
         $this->indexVisiteur('visiteur/vueInscriptionAchat','visiteur/vueModePaiement' );
      }
   }

   public function problemGeneral($questionTechnique=null,$noEvenement=null,$annee=null)
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
				$evenement=$this->mEven->retournerUnEvenement($noEvenement,$annee);
				$objet=$evenement->TxtHtmlEntete;
				$corpsTexte=$evenement->TxtHtmlCorps;
			}
			else
			{
				$objet='';
				$corpsTexte='';
			};
			$classe=$this->mClass->retournerClasse();
			
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
			$this->load->view('membre/vueEnvoiMail',$donneesMail);
			$this->load->view('templates/PiedDePagePrincipal');
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
   
   public function problemCommande($donnees)
   {
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
				$this->load->view('templates/PiedDePagePrincipal');
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




}


