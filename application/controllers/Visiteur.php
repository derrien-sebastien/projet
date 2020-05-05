<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once(APPPATH."controllers/Administrateur.php");
class Visiteur extends CI_Controller 
{

   /**********************************************************************
   **                           Constructeur                            **
   **********************************************************************/

   public function __construct()
   {	
      parent::__construct();   
      $this->load->model('ModeleIdentifiantSite');
      $this->load->model('ModeleCommande');
      $this->load->model('ModeleEvenement');    	
      $this->load->model('ModelePersonne');
      $this->load->model('ModeleProduit','mProd');
      
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
      if (!isset($_SESSION))
      {
         $dataSession=array(
            'email'=>'',
            'profil'=>'',
            'actif'=>''
         );                    
         $this->session->set_userdata($dataSession);
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

   public function index()
   {
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('templates/EnteteNavbar');
      $this->load->view('templates/PiedDePagePrincipal');
   }
   public function accueil()
   {
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('templates/EnteteNavbar');
      $this->load->view('templates/vueAccueilPrincipal'); 
      $this->load->view('templates/PiedDePagePrincipal');
   }

   /**********************************************************************
   **                           INSCRIPTION                             **
   **********************************************************************/
   // A REVOIR

   public function inscription()
   {  
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('templates/EnteteNavbar');
      $this->form_validation->set_rules( 'txtEmail', 'Identifiant', 'required'); 
      $this->form_validation->set_rules( 'password', 'mot de passe', 'required');
      $this->form_validation->set_rules( 'password2', 'repetez mot de passe', 'required'); 
      if ($this->form_validation->run() === TRUE)                                     
      {
         if($_POST['password']==$_POST['password2'])
         {
            $donnees = array(                                                              
               'Email' => $this->input->post('txtEmail'),
               'MotDePasse'=>$this->input->post('password')                                    
            );                                                                                   
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
   **                        SE CONNECTER                               **
   **********************************************************************/

   //A REVOIR

   public function seConnecter()
   {  
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('templates/EnteteNavbar');
         
      $this->form_validation->set_rules('txtEmail', 'email', 'trim|required|valid_email');
      $this->form_validation->set_rules('password','mot de passe');      
      $DonneesInjectees['TitreDeLaPage'] = 'Se Connecter';                             
      if($this->form_validation->run() === FALSE)                                     
      {         
         $this->load->view('visiteur/vueLogin',$DonneesInjectees);
         $this->load->view('templates/PiedDePagePrincipal');
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
               redirect('Administrateur/accueil');
            }
            elseif ($this->session->profil=='membre')
            {               
               redirect('membre/accueil');
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
            $this->load->view('visiteur/vueAjouterpersonne');
            $this->load->view('templates/PiedDePagePrincipal');
            }
            else
            {
               $this->load->view('visiteur/vueErreurMDPIncorrect');   
               $this->load->view('visiteur/vueLogin',$DonneesInjectees);
               $this->load->view('templates/PiedDePagePrincipal');
            }
         }     
      }
   }


   /**********************************************************************
   **                      SE DECONNECTER                               **
   **********************************************************************/
   // OK

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
      $this->load->view('templates/EntetePrincipal'); 
      $this->load->view('templates/EnteteNavbar');                                 
      $this->load->view('visiteur/vueMentionsLegales', $DonneesInjectees);            
      $this->load->view('templates/PiedDePagePrincipal');                              
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
      $DonneesInjectees['lesEvenementsMarchands'] = $this->ModeleEvenement->retournerEvenementsMarchands();
      $DonneesInjectees['lesEvenementsNonMarchands'] = $this->ModeleEvenement->retournerEvenementsNonMarchands();
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('templates/EnteteNavbar');
      $this->load->view('visiteur/vueCatalogueEvenements', $DonneesInjectees);
   } 
 
   /**********************************************************************
   **                         UN EVENEMENT                             ***
   **********************************************************************/

   public function EvenementMarchand($noEvenement = NULL)
   {

      $DonneesInjectees['LesProduits'] = $this->mProd->retournerProduit($noEvenement);     
      $DonneesInjectees['unEvenementMarchand'] = $this->ModeleEvenement->retournerEvenements($noEvenement);
      if (empty($DonneesInjectees['unEvenementMarchand']))
      {   
         show_404();
      }
      else
      {
         $DonneesInjectees['TitreDeLaPage'] = $DonneesInjectees['unEvenementMarchand']['TxtHTMLEntete'];
         $this->load->view('templates/EntetePrincipal');
         $this->load->view('templates/EnteteNavbar');
         $this->load->view('visiteur/vueEvenementMarchandEntete', $DonneesInjectees);
         
      }
   }
   
   public function EvenementNonMarchand($noEvenement = NULL,$Annee =NULL)
   {
      
      $DonneesInjectees['unEvenementNonMarchand'] = $this->ModeleEvenement->retournerEvenements($noEvenement);
      if (empty($DonneesInjectees['unEvenementNonMarchand']))
      {   
         show_404();
      }
      $DonneesInjectees['TitreDeLaPage'] = $DonneesInjectees['unEvenementNonMarchand']['TxtHTMLEntete'];
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('templates/EnteteNavbar');
      $this->load->view('visiteur/vueEvenementNonMarchandEntete', $DonneesInjectees);
   }

   /**********************************************************************
   **                               PANIER                             ***
   **********************************************************************/
   
   public function catalogueProduits()
   {
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('templates/EnteteNavbar');
      $data['product']=$this->mProd->getProduitsActif();
      $this->load->view('visiteur/vueCatalogueProduits copy',$data); 
   }

   public function index2()
   {
      $data['cartItems']=$this->cart->contents();
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('templates/EnteteNavbar');
      $this->load->view('visiteur/panier/index',$data);
   }
   public function add()
   {
      $product=$this->ModeleProduit->getRows($proID);
      $data = array(
            'id'    => $product['NoProduit'],
            'qty'   => 1,
            'price' => $product['Prix'],
            'name'  => $product['LibelleCourt'],
            'image' => $product['Img_Produit']
         );
      $this->cart->insert($data);
      redirect('visiteur/panier');
   }

   public function updateItemQty()
   {
       $update=0;
       $rowid=$this->input->get('rowid');
       $qty=$this->input->get('qty');
       if(!empty($rowid) && !empty($qty))
       {
           $data=array(
               'rowid'     =>  $rowid,
               'qty'       =>$qty
           );
           $update=$this->cart->update($data);
       }
       echo $update?'ok':'err';
   }
   
   function removeItem($rowid)
   {
       $remove=$this->cart->remove($rowid);
       redirect('cart/');
   }


   public function viderPanier()
   {
      $this->cart->destroy();
      echo $this->view();
   }

   /**********************************************************************
   **                           COMMANDE                               ***
   **********************************************************************/
   public function commande()
   {
      if($this->cart->total_items() <= 0)// Si panier est vide on redirige 
      {
         redirect('visiteur/EvenementMarchand');
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
      $data['cartItems'] = $this->cart->contents();// Récupérer les données du panier 
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
         $cartItems = $this->cart->contents();// Récupérer les données du panier
         $commandeItemData = array();
         $i=0;
         foreach($cartItems as $item)
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
   
   
}

