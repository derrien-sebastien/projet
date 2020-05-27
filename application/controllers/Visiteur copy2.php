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
      $this->load->model('ModeleCommande');
      $this->load->model('ModeleIdentifiantSite');
      $this->load->model('ModeleEvenement', 'mEven');    	
      $this->load->model('ModelePersonne');
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
            'actif'=>''               //    et le panier qui lui même sera un tableau associatif 
            //'panier'=>array()          // La variable sera un paramêtre de la méthode set_userdata qui 
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
           
      if(!isset($_SESSION['email'])||($_SESSION['email']==''))
      {
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
            $personne=$this->ModelePersonne->recherchePersonne($email,$password);
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
                  if($_POST['urlRedirect']!= 'http://[::1]/projet/index.php/Visiteur/inscription')
                  {
                     $this->accueil();
                  }
                  elseif ($_POST['urlRedirect']!='http://[::1]/projet/index.php/Visiteur/seConnecter') 
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
               if(!$this->ModelePersonne->rechercherEmailPresent($email))
               {
                  $this->indexVisiteur('visiteur/vueAjouterPersonne');  
               }
               else
               {  
                  $DonneesInjectees['urlRedirect']='http://[::1]/projet/index.php/Visiteur/catalogueEvenement';
                  $this->indexVisiteur('visiteur/vueLogin', $DonneesInjectees);
               }
            }     
         }
      }
      else
      {
         redirect($_POST['urlRedirect']);
      }
   }

   /**********************************************************************
   **                           INSCRIPTION                             **
   **********************************************************************/

   public function inscription()
   { 
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
               'Profil'       => 'membre',
               'Actif'        => '1'                                   
            );
            if(!$this->ModelePersonne->rechercherEmailPresent($donnees['Email']))
            {
               $this->ModelePersonne->insererInformationPersonne($donnees); 
               $this->indexVisiteur('visiteur/vueCatalogueEvenements');
            }
            else
            {
               $this->seConnecter();
            }                                                                             
              
         }
         else
         {
            $this->indexVisiteur('visiteur/vueErreurMDPCorrespondant','','visiteur/vueAjouterPersonne');
            
         }
      }
      else                                                                             
      {                                                                                                   
         $this->indexVisiteur('visiteur/vueAjouterPersonne');                                            
      }
   } 

   /**********************************************************************
   **                      MOT DE PASSE OUBLIE                          **
   **********************************************************************/
   public function oublieMotDePasse()
	{
      $this->form_validation->set_rules('txtLogin','email','required');
      if($this->form_validation->run() === FALSE)
         { 
            $this->indexVisiteur('visiteur/vueMotDePasseOublie');
         }
         else
         {    
            if (!($rechercherEmailPresent($_POST['txtLogin'])))
            {  //erreure de mail a refaire
               $Value['Value'] = 'Adresse e-mail incorrect';
               //$this->load->view('vueErreur');
               $this->indexVisiteur('visiteur/vueMotDePasseOublie');
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
   **                       UN EVENEMENT MARCHAND                      ***
   **********************************************************************/

   public function EvenementMarchand($noEvenement = NULL, $annee=NULL)
   {
      $DonneesProduit['lesProduits'] = $this->mProd->obtenirLesProduits($noEvenement, $annee);   
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
   /**********************************************************************
   **                     UN EVENEMENT NON MARCHAND                    ***
   **********************************************************************/
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
   **                          LE PANIER                               ***
   **********************************************************************/
  function panier2()
  {
     $this->indexVisiteur('visiteur/vuePanier2');   
  }
  function majPanier()
  {
      for ($i=1; $i <= $this->cart->total_items(); $i++)
      {
         $data = array(
         'rowid'  => $this->input->post($i.'[rowid]'),
         'qty'    => $this->input->post($i.'[qty]')
         );
         $this->cart->update($data);
      } // for
  } // function

   public function panier($noEvenement = NULL, $annee=NULL )
   { 
      $DonneesProduit['lesProduits'] = $this->mProd->getRows($noEvenement, $annee);      
      $DonneesProduit['unEvenementMarchand'] = $this->mEven->retournerEvenements($noEvenement, $annee);
      $DonneesProduit['prodPanier']=$this->cart->contents();
      $this->indexVisiteur('visiteur/vuePanier', $DonneesProduit);
   }
   /**********************************************************************
   **                   AJOUTER DES PRODUITS AU PANIER                 ***
   **********************************************************************/
   public function ajoutPanier()
   {
      var_dump($_POST);
      $produit=explode('X',$_POST['adress']);
      $noEvenement=$produit['0'];
      $annee=$produit['1'];
      $noProduit=$produit['2'];
      $DonneesProduit=$this->mProd->getRows($noEvenement, $annee, $noProduit);
      $data = array(
            'id'    => $_POST['adress'],              //$DonneesProduit['NoProduit']/* .'/'.$DonneesProduit['NoEvenement'].'/'.$DonneesProduit['annee'] */,
            'qty'   => $_POST['qty'],
            'price' => $DonneesProduit['Prix'],
            'name'  => $DonneesProduit['LibelleCourt'],
            'image' => $DonneesProduit['Img_Produit'],
            'noProduit'=> $noProduit,
            'anne'=>$annee,
            'noEvenement'=>$noEvenement
        );
      $this->cart->insert($data);
      $this->EvenementMarchand($noEvenement,$annee);
   }
   /**********************************************************************
   **                    ENLEVER UN PRODUIT DU PANIER                  ***
   **********************************************************************/
   function removeItem($rowid)
   {  
      $DonneesProduit['prodPanier']=$this->cart->contents();
      foreach($DonneesProduit['prodPanier'] as $unProduit )
      {
         if($unProduit['rowid']=$rowid)
         {
            $produit=explode('X',$unProduit['id']);
            $noEvenement=$produit['0'];
            $annee=$produit['1'];
         }
      }     
      $data = array(
          'rowid'   => $rowid,
          'qty'     => 0
      );
      $DonneesProduit['lesProduits'] = $this->mProd->getRows($noEvenement, $annee);
      $DonneesProduit['unEvenementMarchand'] = $this->mEven->retournerEvenements($noEvenement, $annee);
            
      $this->cart->update($data);
      $this->indexVisiteur('visiteur/vueEvenementMarchandEnTete',$DonneesProduit);
   }
  /**********************************************************************
   **               MAJ DE LA QUANTITE DE PRODUIT DU PANIER           ***
   **********************************************************************/
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
  /**********************************************************************
   **                        VIDER LE  PANIER                         ***
   **********************************************************************/
   public function viderPanier($noEvenement,$annee)
   {
      $this->cart->destroy();
      $this->EvenementMarchand($noEvenement,$annee);
      
   }

   /**********************************************************************
   **                           COMMANDE                               ***
   **********************************************************************/
   
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
            if($_POST['checkbox']=='1')// à modifier en lien vers deux methode 
                                       // une méthode se connecter 
                                       // une autre vers le formulaire Livraison
            {
               $DonneesInjectees['urlRedirect']=$urlDArriver;
               
               //$this->form_validation->set_rules('email', 'Email', 'required|valid_email');  
               if ($_SESSION['email']=='') 
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
     
   /**********************************************************************
   **                      FORMULAIRE DE LA COMMANDE                   ***
   **********************************************************************/
   public function formulaireLivraison()
   {
      $this->form_validation->set_rules('email', 'Email', 'required');  //regle de validation du formulaire
		$this->form_validation->set_rules('txtNom','Nom','required');
      $this->form_validation->set_rules('txtPrenom','Prenom');
      $this->form_validation->set_rules('txtAdresse','Adresse','required');
      $this->form_validation->set_rules('txtCp','Code postal','required');
      $this->form_validation->set_rules('txtVille','Ville','required');
      $this->form_validation->set_rules('txtTelP','TelPortable');
      $this->form_validation->set_rules('txtTelF','TelFixe');
      
      if ($this->form_validation->run() === false)                                     
      {
         if($_SESSION['email']!='')
         {
            $donneesPersonne['Personne']=$this->ModelePersonne->rechercheInfoPersonne($_SESSION['email']);
            $this->indexVisiteur('visiteur/vueInformation',$donneesPersonne);
            
         }
         elseif(isset($_POST['email']))
         {
            if($this->ModelePersonne->presenceMdp($_POST['email']))
            {
               $this->form_validation->reset_validation();
               $this->seConnecter();
            }
            elseif($this->ModelePersonne->rechercherEmailPresent($_POST['email']))
            {
               $donneesPersonne['Personne']=$this->ModelePersonne->rechercheInfoPersonne($_POST['email']);
               $this->indexVisiteur('visiteur/vueInformation',$donneesPersonne) ;
            }
            else
            {
               $donneesAInserer= array(
                  'NoPersonne'=> $this->ModelePersonne->maxPersonne()+1,
                  'Email'     => $_POST['email'],
                  //'MotDePasse'=> NULL,
                  'Profil'    => 'membre'
               );
               $this->ModelePersonne->insererInformationPersonne($donneesAInserer);
               $donneesPersonne['Personne']=$this->ModelePersonne->rechercheInfoPersonne($_POST['email']);
               $this->indexVisiteur('visiteur/vueInformation',$donneesPersonne) ;
            }
            
         }
         else
         {
            $this->indexVisiteur('visiteur/vueInformation');
         }
      }
      else
      {
         $donneesInsererPersonne = array(
            'NoPersonne'=>$_POST['noPersonne'],
            'Email'=>$_POST['email'],
            'Nom' => $_POST['txtNom'],
            'Prenom' => $_POST['txtPrenom'],    
            'Adresse' => $_POST['txtAdresse'],
            'CodePostal' => $_POST['txtCp'],
            'Ville' => $_POST['txtVille'],
            'TelPortable' => $_POST['txtTelP'],
            'TelFixe' => $_POST['txtTelF']
         );           
         $this->ModelePersonne->modifierInfoPersonne($donneesInsererPersonne);
         $donneesInjectees['Personne']=$this->ModelePersonne->rechercheInfoPersonne($this->session->email);
         $this->indexVisiteur('visiteur/vueInformation', $donneesInjectees);
         var_dump('<br>',$_POST);
         if(!false)//fonction a damien
         {
            if(!isset($_POST['nouveauSubmit']))//vue livraison differente
            {
               $noPersonne=$_POST['noPersonne'];//a rajouter hidden vueInformation
               $noCommande=$this->ModeleCommande->maxCommande()+1;
               $donneeCommande=array(
                  'NoPersonne'=>$noPersonne,
                  'NoCommande'=>$noCommande,
                  'DateCommande'=>date('Y-m-d')
               );
               $i=0;
               $total=0;
               foreach($this->cart->contents() as $unProduit)
               {
                  $produit=explode('X',$unProduit['id']);
                  $noEvenement=$produit['0'];
                  $annee=$produit['1'];
                  $noProduit=$produit['2'];
                  $donneeProduit[$i]=array(
                     'NoProduit'=>$noProduit,
                     'NoEvenement'=>$noEvenement,
                     'Annee'=>$annee,
                     'Quantite'=>$unProduit['qty'],
                     'NoCommande'=>$noCommande
                  );
                  $total=$total+$unProduit['subtotal'];
                  $i++;
               }
               $donneesCommande['MontantTotal']=$total;               
               if($_POST['paiement'] == 'cheque' || $_POST['paiement'] == 'espece')
               {
                  $donneesCommande['Payer']=0;            
                  $donneesCommande['ResteAPayer']=$total;               
                  
               }
               $donneeCommande['ModePaiement']=$_POST['paiement'];            
               if($_POST['livraison'] == 2)
               {
                  $donneeLivraison=array(
                     'donneeCommande'=>$donneesCommande,
                     'donneeproduit'=>$donneeProduit
                  );
                  $this->load->view('visiteur/vueAdresseDeLivraison',$donneeLivraison);//$donnee en hidden dans la vue
               }
            }
            else
            {
               //form Validation
               if(false)
               {
                  $donneeLivraison=array(
                     'donneeCommande'=>$_POST['donneesCommande'],
                     'donneeproduit'=>$_POST['donneeProduit']
                  );
                  $this->load->view('visiteur/vueAdresseLivraison',$donneeLivraison);//$donnee en hidden dans la vue
               }
               
               else
               {                  
                  $donneeCommande=$_POST['donneeCommande'];
                  $donneeProduit=$_POST['donneeProduit'];
                  $string='';
                  if(isset($_POST['nom']))
                  {
                     /* string=string.$_POST['nom'].'/'; */
                  }
                  if(isset($_POST['prenom']))
                  {
                    /*  string=string.$_POST['prenom'].'/'; */
                  }
                  if(isset($_POST['nom']))
                  if(isset($_POST['nom']))
                  if(isset($_POST['nom']))
                  if(isset($_POST['nom']))
                  $donneeCommande['CommentaireAcheteur']=$string;
                  
                  if($_POST["donneeComande['ModePayement']"] == 'cb')
                  {
                     $this->fonctionDamien($totale);//+donne commande produit hidden
                  }
               }
            }
         }
                                
      //else
         
         //$donneeCommande=$_POST['donneeCommande'];
         //$donneeProduit=$_POST['donneeProduit'];
         //$donneeCommande['Payer']=montantPayer
         //$donneeCommande['Restepayer']=total-montantPayer
         //if payement ok
            //$donneeCommande['ModePaiement']=cb
         // else 
            //$donneeCommande['ModePayement']=Espece

      //if(insert commande)
            //foreach $donneeProduit as $unproduit
            //insert $unproduit dans contenir 

      }
   }


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


   public function validerLaCommande($noCommande)
   {
      $data['commande'] = $this->mProd->obtenirCommande($noCommande);//Récupérer les données de commande dans la base de données
      $this->load->view('', $data); // Affiche les détails de la commande // a finir
   } 

public function adress()
{
   $this->indexVisiteur('visiteur/vueAdresseDeLivraison');
}

}


