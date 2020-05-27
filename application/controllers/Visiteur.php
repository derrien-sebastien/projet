<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once(APPPATH."controllers/Administrateur.php");
class Visiteur extends CI_Controller 
{
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /**************************                                                                              ********************************/
   /**************************                             NOTRE CONSTRUCTEUR                               ********************************/
   /**************************                                                                              ********************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /* 
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
            'actif'=>''                //    et le panier qui lui même sera un tableau associatif 
            //'panier'=>array()        // La variable sera un paramêtre de la méthode set_userdata qui 
         );                            // appartient à la classe session
         $this->session->set_userdata($dataSession);///////////////////////////////////////////////////////
      }
      date_default_timezone_set('Europe/Paris'); // Constante de notre fuseau horaire
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////
   }


   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /**************************                                                                              ********************************/
   /**************************                          NOTRE INDEX VISITEUR                                ********************************/
   /**************************                                                                              ********************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
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

   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /**************************                                                                              ********************************/
   /**************************                                 NOTRE ACCUEIL                                ********************************/
   /**************************                                                                              ********************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/

   /* FUNCTION DE NOTRE PAGE D'ACCUEIL  

         Comprend :

            L'index template et notre vue
   */
   public function accueil()
   {
      $this->indexVisiteur('templates/vueAccueilPrincipal');
   }

   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /**************************                                                                              ********************************/
   /**************************     SE CONNECTER  -  SE DECONNECTER  -  INSCRIPTION  - MOT DE PASS OUBLIE    ********************************/
   /**************************                                                                              ********************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/

   /**********************************************************************
   **                          SE CONNECTER                             **
   **********************************************************************/
   /*
      Données entrantes :
         - $urlDArriver

      Données sortantes :
         - urlRedirect  
   */
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
   /*
      Données entrantes :

      Données sortantes :

   */
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
      $this->form_validation->set_rules('txtEmail','email','required');
      if($this->form_validation->run() === FALSE)
         { 
            $this->indexVisiteur('visiteur/vueMotDePasseOublie');
         }
         else
         {    
            if (!($rechercherEmailPresent($_POST['txtEmail'])))
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
               redirect('Visiteur/catalogueEvenement');
            }          
         }
   }

   /**********************************************************************
   **                      SE DECONNECTER                               **
   **********************************************************************/

   public function seDeConnecter() 
   {
      $this->session->sess_destroy($_SESSION['__ci_last_regenerate']);   
      redirect('Visiteur/catalogueEvenement');
   }

   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/ 
   /****************************************************************************************************************************************/
   /**************************                                                                              ********************************/
   /**************************                CATALOGUE DES EVENEMENTS MARCHANDS ET NON MARCHAND            ********************************/
   /**************************                                                                              ********************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   
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
         $this->indexVisiteur('visiteur/vueEvenementMarchand', $DonneesProduit);
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

   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /**************************                                                                              ********************************/
   /**************************                            FONCTIONS DU PANIER                               ********************************/
   /**************************                                                                              ********************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/

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
   **                            AJOUTER                               ***
   **********************************************************************/

   public function ajoutPanier()
   {
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
            'annee'=>$annee,
            'noEvenement'=>$noEvenement
        );
      $this->cart->insert($data);
      $this->EvenementMarchand($noEvenement,$annee);
   }

   /**********************************************************************
   **                            RETIRER                               ***
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
      $this->indexVisiteur('visiteur/vueEvenementMarchand',$DonneesProduit);
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
   **                        VIDER LE  PANIER                          ***
   **********************************************************************/
   public function viderPanier($noEvenement,$annee)
   {
      $this->cart->destroy();
      $this->EvenementMarchand($noEvenement,$annee);
      
   }

   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /**************************                                                                              ********************************/
   /**************************                            FONCTIONS DES COMMANDES                           ********************************/
   /**************************                                                                              ********************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/
   /****************************************************************************************************************************************/

   /**********************************************************************
   **                        PASSER UNE COMMANDE                       ***
   **********************************************************************/
   
   public function passerCommande($noEvenement = NULL, $annee = NULL)
   {
      $urlDArriver =  $this->agent->referrer();
      if($_SESSION['profil']=='membre' || $_SESSION['profil']=='admin' || $_SESSION['email'] != '')
      {
         $this->formulaireLivraison();
      }
      else
      {
         $donnees=array(
            'urlRedirect'=>$urlDArriver,
            'provenance'=>'commande'
         );
         $this->indexVisiteur('Visiteur/vueLogin',$donnees);          
      }   
   }

   /**********************************************************************
   **                       VALIDER UNE COMMANDE                       ***
   **********************************************************************/

   public function validationCommande()
   {
      $urlDArriver =  $this->agent->referrer();
      if(isset($_POST['txtEmail']))
      {
         if($this->ModelePersonne->rechercherEmailPresent($_POST['txtEmail']))
         {
            if($this->ModelePersonne->presenceMdp($_POST['txtEmail']))
            {
               $personne=$this->ModelePersonne->recherchePersonne($_POST['txtEmail'], $_POST['password']);
               if(isset($personne)) 
               {                                 
                  $dataSession=array(
                     'email'=>$personne->Email,
                     'profil'=>$personne->profil,
                     'actif'=>$personne->Actif
                  );                    
                  $this->session->set_userdata($dataSession); 
                  $this->formulaireLivraison();
               }
               else
               {
                  $donnees=array(
                     'urlRedirect'=>$urlDArriver,
                     'provenance'=>'commande'
                  );
                  $this->indexVisiteur('Visiteur/vueLogin',$donnees); 
               }
            }
            else
            {
               $personne=$this->ModelePersonne->rechercheInfoPersonne($_POST['txtEmail']);
               $dataSession=array(
                  'email'=>$personne->Email,
                  'profil'=>$personne->profil,
                  'actif'=>$personne->Actif
               );                
               $this->session->set_userdata($dataSession); 
               $this->formulaireLivraison();
            }
         }
         else 
         {
            if($_POST['password']=='')
            {
               $password=NULL;
            }
            else
            {
               $password=$_POST['password'];
            }
            $donnees=array(
               'NoPersonne'=> $this->ModelePersonne->maxPersonne()+1,
               'Email'=> $_POST['txtEmail'],
               'MotDePasse'=>$password,
               'Actif'=>1,
               'Profil'=>'membre'
            );
            $this->ModelePersonne->insererInformationPersonne($donnees);
            $personne=$this->ModelePersonne->rechercheInfoPersonne($donnees['Email']);
            $dataSession=array(
               'email'=>$personne->Email,
               'profil'=>$personne->profil,
               'actif'=>$personne->Actif
            );                    
            $this->session->set_userdata($dataSession); 
            $this->formulaireLivraison();
         }
      }
      else
      {
         $donnees=array(
            'urlRedirect'=>$urlDArriver,
            'provenance'=>'commande'
         );
         $this->indexVisiteur('Visiteur/vueLogin',$donnees);
      }
   }
   
   /**********************************************************************
   **                      FORMULAIRE COMMANDE                         ***
   **********************************************************************/

   public function formulaireLivraison()
   {
      $urlDArriver =  $this->agent->referrer();
      $this->form_validation->set_rules('txtEmail', 'Email', 'required');  //regle de validation du formulaire
		$this->form_validation->set_rules('txtNom','Nom','required');
      $this->form_validation->set_rules('txtPrenom','Prenom');
      $this->form_validation->set_rules('txtAdresse','Adresse','required');
      $this->form_validation->set_rules('txtCp','Code postal','required');
      $this->form_validation->set_rules('txtVille','Ville','required');
      $this->form_validation->set_rules('txtTelP','TelPortable');
      $this->form_validation->set_rules('txtTelF','TelFixe');
      if ($this->form_validation->run() === false)                                     
      {
         if($_SESSION['email'] == '')
         {          
            $donnees=array(
               'urlRedirect'=>$urlDArriver,
               'provenance'=>'commande'
            );
            $this->indexVisiteur('visiteur/vueLogin',$donnees);
         }
         else
         {
            $donnees=array(
               'Personne'=>$this->ModelePersonne->rechercheInfoPersonne($_SESSION['email'])
            );
            $this->indexVisiteur('visiteur/vueInformation',$donnees);
         }
      }
      else
      {
         $personne=$this->ModelePersonne->rechercheInfoPersonne($_SESSION['email']);
         if(!isset($personne))
         {
            $donnees=array(
               'urlRedirect'=>$urlDArriver,
               'provenance'=>'commande'
            );
            $this->indexVisiteur('visiteur/vueLogin',$donnees);
         }
         else
         {
            if($_POST['txtTelP']=='')
            {
               $telP=NULL;
            }
            else
            {
               $telP=$_POST['txtTelP'];
            }
            if($_POST['txtTelF']=='')
            {
               $telF=NULL;
            }
            else
            {
               $telF=$_POST['txtTelF'];
            }
            $donneesInsererPersonne = array(
               'NoPersonne'=>$_POST['noPersonne'],
               'Email'=>$_POST['txtEmail'],
               'Nom' => $_POST['txtNom'],
               'Prenom' => $_POST['txtPrenom'],    
               'Adresse' => $_POST['txtAdresse'],
               'CodePostal' => $_POST['txtCp'],
               'Ville' => $_POST['txtVille'],
               'TelPortable' => $telP,
               'TelFixe' => $telF
            );           
            $this->ModelePersonne->modifierInfoPersonne($donneesInsererPersonne);
            $personne=$this->ModelePersonne->rechercheInfoPersonne($_SESSION['email']);            
            $noCommande=$this->ModeleCommande->maxCommande()+1;
            $donneesCommandeGlobal=array();
            $i=0;
            $total=0;
            foreach($this->cart->contents() as $unProduit)
            {
               $donneesProduit=array(
                  'NoEvenement'  => $unProduit['noEvenement'],
                  'Annee'        => $unProduit['annee'],
                  'NoProduit'    => $unProduit['noProduit']
               );
               $produit=$this->mProd->getUnProduit($donneesProduit);
               $donneesCommandeGlobal[$i]=array(               
                  'noEvenement'  => $unProduit['noEvenement'],
                  'annee'        => $unProduit['annee'],
                  'noProduit'    => $unProduit['noProduit'],
                  'quantite'     => $unProduit['qty'],
                  'imgProduit'   => $produit->Img_Produit,
                  'libelle'      => $produit->LibelleCourt               
               );
               $total=$total+$unProduit['subtotal'];
               $i=$i+1;
            }
            if(!isset($_POST['submit']))
            {
               $donneesCB=array(
                  'pbx_total'=> $total 
               );
               $this->payementCb($donneesCB);
            }
            else
            {
             
            $donneesVue=array(
               'donneesCommandeGlobal' => $donneesCommandeGlobal,
               'total'                 => $total,
               'modeReglement'         => 'Cheque/Espece',
               'Regler'                => 0,
               'noCommande'            => $noCommande
            );
            
            $this->indexVisiteur('visiteur/vueRecap',$donneesVue);
            }
         }
      }
   }

   /**********************************************************************
   **                       FIN DE LA COMMANDE                         ***
   **********************************************************************/

   public function finCommande()
   {
      if($_POST['commentaire']!='')
      {
         $commentaire=$_POST['commentaire'];
      }
      else
      {
         $commentaire='RAS';
      }
      $montantTotal=0;
      foreach($this->cart->contents() as $unProduit) 
      {
         $montantTotal=$montantTotal+$unProduit['subtotal'];
      }
      $personne=$this->ModelePersonne->rechercheInfoPersonne($_SESSION['email']);
      $donneesCommande=array(
         'NoCommande'         => $_POST['noCommande'],
         'NoPersonne'         => $personne->NoPersonne,
         'DateCommande'       => date('Y-m-d H:i:s'),
         'MontantTotal'       => $montantTotal,
         'Payer'              => 0,
         'ResteAPayer'        => $montantTotal,
         'ModePaiement'       => 'Espece/Cheque',
         'CommentaireAcheteur'=> $commentaire
      );
      $this->ModeleCommande->ajouterCommande($donneesCommande);
      foreach($this->cart->contents() as $unProduit)
      {
         $donneesContenir=array(
            'NoCommande'   => $_POST['noCommande'],
            'NoEvenement'  => $unProduit['noEvenement'],
            'Annee'        => $unProduit['annee'],
            'NoProduit'    => $unProduit['noProduit'],
            'Quantite'     => $unProduit['qty']
         );
         $this->ModeleCommande->insererContenir($donneesContenir);
      }    
      $this->cart->destroy();
      $this->indexVisiteur('templates/vueAccueilPrincipal');         
   }

   /**********************************************************************
   **                  MODIFIER ADRESSE DE LIVRAISON                   ***
   **********************************************************************/

   public function adress()
   {
      $this->indexVisiteur('visiteur/vueAdresseDeLivraison');
   }
   
   /**********************************************************************
   **                  Paiement par Carte Bancaire                     ***
   **********************************************************************/

   function payementCb($donnees=NULL)
   {//0
      /*
      Donnees entree
         $donnees	= array()
         -	$pbx_total (montant total de la transaction)


      Donnees fixe
         -  $pbx_site(numero site)
         -	$pbx_rang 
         -	$pbx_identifiant
         -	$pbx_cmd(identifiant transaction à générer)
         - 	$pbx_porteur (adresse mail du client/$_SESSION['email'])
         - 	$pbx_effectue(vuePaiementAccepte)
         -	$pbx_annule (vuePaiementAnnule)
         -	$pbx_refuse (vuePaiementRefuse)
         -	$pbx_repondre_a(vueReponsePayBox)
         -	$pbx_retour(en dur)
         -	$keyTest(ModeleIdentifiantSite->Fonction)
         -	$serveurs(en dur)
         -	$serveurOK
         - 	$doc(en dur)
         -	$server_status(en dur)
         -	$element(en dur)
         -	$dateTime(date())
         - 	$msg(tableau de toutes les sorties hasher)(en dur)
         -	$binKey(en dur)
         
         
      Donnees sortie
         $donneesPayement= array()
         -	$pbx_site
         -	$pbx_rang 
         -	$pbx_identifiant
         - 	$pbx_total
         -	$pbx_cmd
         - 	$pbx_porteur
         -	$pbx_repondre_a
         -	$pbx_retour
         - 	$pbx_effectue
         -	$pbx_annule
         -	$pbx_refuse
         -	$dateTime(date())
         -	$hmac
         
      */   
      $pbx_site         = '1999888';// Test (voir Compte de test)=Correspond au numéro du site
      $pbx_rang         = '32';              		// Test
      $pbx_identifiant  = '107904482';     // Test = (modele identifiant site)
      $pbx_cmd          = '2020124';   //'cmd_rabelaisY';   		// forcé ici// numero de comande// a modifier 
      $pbx_porteur      = $_SESSION['email'];  	// Valeur de test ici, en prod. = mail client
      $pbx_total        = $donnees['pbx_total']*100;                       
      $pbx_total        = str_replace(",", "", $pbx_total);
      $pbx_total        = str_replace(".", "", $pbx_total);
      $pbx_effectue     = 'http://127.0.0.1/projet/vuePaiementAccepte.php';// a mettre en base_url()
      $pbx_annule       = 'http://127.0.0.1/projet/vuePaiementAnnule.php';// a mettre en base_url()
      $pbx_refuse       = 'http://127.0.0.1/projet/vuePaiementRefuse.php';// a mettre en base_url()
      $pbx_repondre_a   = 'http://www.votre-site.extention/page-de-back-office-site';//base_url('visiteur/pageBackOff');
      $pbx_retour       = 'Montant:M;Reference:R;Auto:A;Erreur:E';
      $keyTest          = '0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF';		// = (ModeleIdentifiantSite->fonction à faire
      $serveurs         = array('tpeweb.paybox.com','tpeweb1.paybox.com');
      $serveurOK        = "";
      foreach($serveurs as $serveur)
      {//1
         $doc = new DOMDocument();
         $doc->loadHTMLFile('https://'.$serveur.'/load.html');
         $server_status = "";
         $element = $doc->getElementById('server_status');
         if($element)
         {//2
            $server_status = $element->textContent;
         }
         if($server_status == "OK")
         {//3
            $serveurOK = $serveur;
            break;
         }// -3
      }
      if(!$serveurOK)
      {//2
         die("Erreur : Aucun serveur n'a été trouvé");
      }// -2
      $serveurOK = 'preprod-tpeweb.paybox.com';
      $serveurOK = 'https://'.$serveurOK.'/cgi/MYchoix_pagepaiement.cgi';
      $dateTime = date("c");
      $msg = 
         "PBX_SITE=".$pbx_site.
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
         "&PBX_TIME=". $dateTime;
      $binKey = pack("H*", $keyTest);
      $hmac = strtoupper(hash_hmac('sha512', $msg, $binKey));
      $donneesPayement=array(
         'serveurOK' => $serveurOK,
         'hidden'    =>array(
            'PBX_SITE'       =>  $pbx_site,
	         'PBX_RANG'       =>  $pbx_rang,
	         'PBX_IDENTIFIANT'=>  $pbx_identifiant,
	         'PBX_TOTAL'      =>  $pbx_total,
	         'PBX_DEVISE'     =>  '978',
	         'PBX_CMD'        =>  $pbx_cmd,
	         'PBX_PORTEUR'    =>  $pbx_porteur,
	         'PBX_REPONDRE_A' =>  $pbx_repondre_a,
	         'PBX_RETOUR'     =>  $pbx_retour,
	         'PBX_EFFECTUE'   =>  $pbx_effectue,
	         'PBX_ANNULE'     =>  $pbx_annule,
	         'PBX_REFUSE'     =>  $pbx_refuse,
	         'PBX_HASH'       =>  'SHA512',
	         'PBX_TIME'       =>  $dateTime,
	         'PBX_HMAC'       =>  $hmac
         )
      );
      
         $this->indexVisiteur('visiteur/vuePaiement',$donneesPayement);
   }// -0
   
      
   
}//fin class


