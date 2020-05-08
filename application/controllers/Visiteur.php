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
      $this->load->model('ModeleEvenement', 'mEven');    	
      $this->load->model('ModelePersonne','mPers');
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
      if (!isset($_SESSION['panier']))
      {
         $_SESSION['panier'] = array();
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
      $this->index();
      $this->load->view('templates/vueAccueilPrincipal'); 
   }

   /**********************************************************************
   **                           INSCRIPTION                             **
   **********************************************************************/
   // A REVOIR

   /* public function inscription()
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
   } */

   /**********************************************************************
   **                        SE CONNECTER                               **
   **********************************************************************/

   //A REVOIR

   public function seConnecter()
   {  
      $this->index();
      $this->form_validation->set_rules('txtEmail', 'email', 'trim|required|valid_email');
      $this->form_validation->set_rules('password','mot de passe');      
      $DonneesInjectees['TitreDeLaPage'] = 'Se Connecter';                             
      if($this->form_validation->run() === FALSE)                                     
      {         
         $this->load->view('visiteur/vueLogin',$DonneesInjectees);
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
            if(!$this->mPers->rechercherEmailPresent($email))
            {
            $this->load->view('visiteur/vueAjouterpersonne');
            }
            else
            {   
               $this->load->view('visiteur/vueLogin',$DonneesInjectees);
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
      $this->index();
      $DonneesInjectees['TitreDeLaPage'] = 'Informations Légales';                                                      
      $this->load->view('visiteur/vueMentionsLegales', $DonneesInjectees);                                          
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
      var_dump($DonneesInjectees['lesEvenementsMarchands'][0]);
      $DonneesInjectees['lesEvenementsNonMarchands'] = $this->mEven->retournerEvenementsNonMarchands();
      /* $this->index(); */
      $this->load->view('visiteur/vueCatalogueEvenements', $DonneesInjectees);
   } 
 
   /**********************************************************************
   **                       UN EVENEMENT CHOISI                        ***
   **********************************************************************/

  public function EvenementMarchand($noEvenement = NULL, $annee=NULL)
   {
      
      $DonneesProduit['lesProduits'] = $this->mProd->getProduits($noEvenement, $annee);   
      $DonneesProduit['unEvenementMarchand'] = $this->mEven->retournerEvenements($noEvenement, $annee);
      var_dump($DonneesProduit['lesProduits']);
      $DonneesProduit['prodPanier']=$this->cart->contents();
      if (empty($DonneesProduit['unEvenementMarchand']))
      {   
         show_404();
      }
      else
      {
         $this->load->view('templates/EntetePrincipal');
         /* $this->load->view('templates/EnteteNavbar'); */
         $this->load->view('visiteur/vueEvenementMarchandEntete', $DonneesProduit);
         
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
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('templates/EnteteNavbar');
      $this->load->view('visiteur/vueEvenementNonMarchandEntete', $DonneesInjectees);
   }

   /**********************************************************************
   **                               PANIER                             ***
   **********************************************************************/
<<<<<<< HEAD
  
   public function ajoutPanier($pNoEven = NULL, $pAnne = NULL, $pNoProd = NULL)
=======
   
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
>>>>>>> ef1122d5b5b1e6b9c796d464aec8f555b5ee7a47
   {
       
      $DonneesProduit=$this->ModeleProduit->getRows($pNoEven, $pAnne, $pNoProd);
      $data = array(
            'id'    => $DonneesProduit['NoProduit'],
            'qty'   => 1,
            'price' => $DonneesProduit['Prix'],
            'name'  => $DonneesProduit['LibelleCourt'],
            'image' => $DonneesProduit['Img_Produit']
        );
      $this->cart->insert($data);
      redirect('visiteur/panier');
   }
   
   public function panier($noEvenement=NULL, $Annee=NULL)
   {  
      $this->load->view('templates/EntetePrincipal');
      $DonneesProduit['unEvenementMarchand'] = $this->mEven->retournerEvenements($noEvenement,$Annee);
      $data['prodPanier']=$this->cart->contents();
      $this->load->view('visiteur/vueEvenementMarchandEntete', $DonneesProduit,$data);
      var_dump($DonneesProduit, $data);
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
      $data = array(
          'rowid'   => $rowid,
          'qty'     => 0
      );
      var_dump($data);
      $this->cart->update($data);
      redirect('visiteur/panier');
   }


   public function viderPanier()
   {
      $this->cart->destroy();
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
   
   
}

