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
      /* $this->load->model('ModeleClasse'); */
      $this->load->model('ModeleCommande');
      /* $this->load->model('ModeleEnfant'); */
      $this->load->model('ModeleEvenement');
      /* $this->load->model('ModeleIdentifiantSite'); */    	
      $this->load->model('ModelePersonne');
      $this->load->model('ModeleProduit', 'mProd');
      $this->load->model('ModelePanier', 'mPanier');
      
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


   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /**************************                                                                              *************************************/
   /**************************                          NOTRE PAGE D'ACCUEIL                                *************************************/
   /**************************                                                                              *************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/

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
            $this->session->session_start;                                   
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
   
   public function CatalogueProduits()
   {
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('templates/EnteteNavbar');
      $data['product']=$this->mProd->get_all_produit();
      $this->load->view('visiteur/vueCatalogueProduits copy',$data);
   }

   public function voirPanier() 
   {
      $n = $this->mPanier->nbProduitsDuPanier();
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('templates/EnteteNavbar');
      if ($n > 0) 
      {
          $lesIdProduit = $this->mPanier->getLesIdProduitsDuPanier();
          $dataPanier['tablePanier'] = $this->mProd->getLesProduitsDuTableau($lesIdProduit);
          $this->load->view('visiteur/vueCatalogueProduits copy',$dataPanier);
      } 
      else 
      {
         echo "panier vide";
         $data['message'] = "panier vide !!";
         $this->load->view('templates/message', $data);
      }
   }

   public function supprimerUnProduit($noProduit) 
   {
      $this->mPanier->supprimerUnProduit($noProduit);
      $this->voirPanier();
   }
  





   
    public function Produits()
   {
      if (!isset($_POST['valider']))
		{
         $this->load->view('templates/EntetePrincipal');
         $this->load->view('templates/EnteteNavbar');
         $donnees['produits']=$this->mProd->get_all_produit();
         $this->load->view('visiteur/vueCatalogueProduits',$donnees);
      }
      else 
      {
         $LesProduits=$this->mProd-->GetProduit();
			//var_dump($LesProduits);
			//die();
			
			$i=0;
			
			$DonneesPanier= array();
			foreach ($LesProduits as $unProduit) 
			{
						$DonneesPanier[] = array(
							'id'        =>$UnProduit->Annee.'/'.$UnProduit->NoEvenement.'/'.$UnProduit->NoProduit,
							'qty'       =>$this->input->post($i),
							'price'     =>$UnProduit->Prix,
                     'name'      =>$UnProduit->LibelleCourt                
						);
			}
			$this->card->insert($DonneesPanier);
         $this->load->view('visiteur/vuePanier',$DonneesPanier);
         $i++;
         $this->cart->update($data);
      }
   } 

   /* public function ajouterProduitAuPanier($NoEvenement,$Annee)// ajout produit au panier
   {
      $produit=$this->ModeleProduit->getProduits($NoEvenement,$Annee);//Récupérer un produit spécifique par ID
      $i=1;
      foreach
      ($Produit as $UnProduit) :
      $data=array(
      'id'=>$UnProduit->Annee.'/'.$UnProduit->NoEvenement.'/'.$UnProduit->NoProduit,
      'qty'=>$this->input->post($i),
      'price'=>$UnProduit->Prix,
      'name'=>$UnProduit->LibelleCourt
      );

      $this->cart->insert($data);
      
      $i++;
      endforeach;
      $this->cart->update($data);
     
      redirect('visiteur/panier');

   }  */
   /* public function panier()
   {
      $info['titre']='contenu du panier';
      $this->load->view('visiteur/vueAfficherPanier', $info);
   }
   public function suppressionDuPanier()
   { 
      $data = array(
                        'rowid'  => $this->input->post('row_id'), 
                        'qty'    => 0, 
                     );
      $this->cart->update($data);
      redirect('visiteur/panier');
   }  */
    public function viderPanier()
   {
      $this->cart->destroy();
      redirect('visiteur/panier');
   }


   public function commande()
   {
      {
         if($this->cart->total_items() <= 0)// Si panier vide redirige vers lesProduitsEvenement
            {
               redirect('visiteur/EvenementMarchand');
            }
            $custData = $data = array();
            $submit = $this->input->post('placeOrder');
         if(isset($submit))// Si la demande de commande est soumise
            {
               $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
               $custData = array(
               'email'     => strip_tags($this->input->post('email')),// Préparer les données clients
               );
            if($this->form_validation->run() == true)// Si les règles de validation sont conformes
               {
                  $insert = $this->product->insertCustomer($custData);// on ajoute les données clients
               if($insert)// Vérifier le statut de l'insertion des données client
                  {
                     $order = $this->placeOrder($insert);// Inserer la commande
                  if($order)//Si la soumission de la commande est réussie
                     {
                        $this->session->set_userdata('success_msg', 'Article au panier');
                        redirect($this->controller.'/orderSuccess/'.$order);
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
            $data['custData'] = $custData;// Données clients
            $data['cartItems'] = $this->cart->contents();// Récupérer les données du panier de la session
            $this->load->view($this->controller.'/index', $data);// Transférer les données des produits à la vue
      }
      /* $donnees['info']=$info; */
      
      if(!isset($_post['submit']))
      {
         $this->load->view('visiteur/vueQuestionnaire');
      }
      if(!isset($_post['submit2']))
      {
         $this->form_validation->set_rules('submit','submit','required');
         $this->form_validation->set_rules('checkbox','checkbox','required');
         if($this->form_validation->run()===TRUE)
         {
            $this->load->view('visiteur/vueSaisiMailAchat');
         }  
      }
      /* elseif(!isset($_post['submit2']))
      {
         $this->form_validation->set_rules('checkbox','checkbox','required');
			$donnees['submit']=$post['submit'];
         if('checkbox'==1)
         {
            $this->load->view('visiteur/vueSaisiMailAchat',($donnees +$donnees['submit']));
         }
         if('checkbox'==2) 
         {
            $this->load->view('visiteur/vueInscriptionAchat');
         }
      }
      elseif(!isset($_post['submit3']))
      {
         $this->load->view('visiteur/vueInformation',($donnees +$donnees['submit']),$donnees['submit2']);
      } */
      else
      { 
         /* $DonneesInjectees['Personne']=$this->ModelePersonne->rechercheInfoPersonne($this->session->email);                                                                                                
         $this->load->view('membre/vueGestionDeCompte',$DonneesInjectees); */
	      echo "vue votre commande est passer + envoye mail" ;
      }
      /* vu email ($hidden['submit']=$submit)
      vue questionnaire de validation($hidden['submit']=$submit +$hidden['submit2']=$submit2) */
      
   }
   public function bla() 
   {
      var_dump($_POST);
   }
      /*  
      $this->load->view('visiteur/vueSaisiMailAchat');

      $this->load->view('visiteur/vueInformation');

      $this->load->view('visiteur/vueInscriptionAchat');
      
      $this->form_validation->set_rules('connu','deja acheter');
      $this->form_validation->set_rules('nonConnu','jamais acheter');
      if($this->form_validation->run() === FALSE) */
      
         /* $donneesInjectees['personne']= $this->modelePersonne->rechercherEmailPresent($email); */
         /* $this->load->view('visiteur/vueInformation' ,$donneesInjectees); */
         /* if(!$this->ModelePersonne->rechercherEmailPresent($email)) */
         /* {
            $this->load->view('visiteur/inscriptionAchat');
         } */
         /* else 
         {
            echo "inconnu dans db";
         } */
      
   







  
 /*   function indexPanier($NoEvenement = NULL,$Annee =NULL)
   {
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('templates/EnteteNavbar');
      $data['data']=$this->ModeleProduit->getProduits($NoEvenement,$Annee);
      $this->load->view('visiteur/vuePanier',$data); */

      /* $data = array();
      $data['ProduitsDuPanier'] = $this->cart->contents();
      $this->load->view('visteur/vuePanier', $data); */
      
      
   
   /* public function ajouterProduitAuPanier($NoEvenement,$Annee)// ajout produit au panier
   {
      $Produit=$this->ModeleProduit->getProduits($NoEvenement,$Annee);//Récupérer un produit spécifique par ID
      $i=1;
      foreach
      ($Produit as $UnProduit) :
      $data=array(
      'id'=>$UnProduit->Annee.'/'.$UnProduit->NoEvenement.'/'.$UnProduit->NoProduit,
      'qty'=>$this->input->post($i),
      'price'=>$UnProduit->Prix,
      'name'=>$UnProduit->LibelleCourt
      );

      $this->cart->insert($data);
      
      $i++;
      endforeach;
      $this->cart->update($data);
      echo $this->voirPanier(); 
      //redirect('visiteur/Panier');

   } */

   /* function ajouterProduitAuPanier()
   { 
      $produit = array(
                        'id' => $this->input->post('NoProduit'), 
                        'name' => $this->input->post('LibelleCourt'), 
                        'price' => $this->input->post('Prix'), 
                        'qty' => $this->input->post('Stock'), 
                     );
      $this->cart->insert($produit);
      $this->cart->update($produit );
      echo $this->voirPanier(); 
   } */

   /* function voirPanier()
   { 
      $output = '';
      $no = 0;
      foreach ($this->cart->contents() as $items) 
      {
         $no++;
         $output .='
         <tr>
            <td>'.$items['name'].'</td>
            <td>'.number_format($items['price']).'</td>
            <td>'.$items['qty'].'</td>
            <td>'.number_format($items['subtotal']).'</td>
            <td><button type="button" id="'.$items['rowid'].'" class="remove_cart btn btn-danger btn-sm">Cancel</button></td>
         </tr>
         ';
      }
      $output .= '
      <tr>
         <th colspan="3">Total</th>
         <th colspan="2">'.'TotalHT '.number_format($this->cart->total()).'</th>
      </tr>
      ';
      return $output;
   }

   function chargerPanier()
   { 
      echo $this->voirPanier();
   }

   function suppressionPanier()
   { 
      $data = array(
                        'rowid' => $this->input->post('row_id'), 
                        'qty' => 0, 
                     );
      $this->cart->update($data);
      echo $this->voirPanier();
   } */

    /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /**************************                                                                              *************************************/
   /**************************                                    A REVOIR                                  *************************************/
   /**************************                                                                              *************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/


   /**********************************************************************
   **                         Passer commande                          ***
   **********************************************************************/
   // garder les infos dans le panier /.....??????
   // après click on commande envoyer vue "avez vous déjà acheter sur le site oui non en checkbox"
   // si oui superposition de la vue se connecter 
   // sinon saisissez votre adresse mail nom prénom adresse et on insert dans la db 
   // une fois inserer voulez vous payer par carte bancaire 
   //                                    par cheque 
   //                                    en liquide
   // si carte bancaire paiement en ligne 
   // sinon génération mail date a venir chercher 

/*   Afficher tous les évènements en catalogue en deux parties Ev_Marchand et Ev_Non_Marchand cliquable//ok  
   /*   Afficher un seul évènement avec tous ses produits en stock + vue si stock vide //a finir 
   /*   Afficher le panier avec un lien passer commande (DANS LE RESUMER DU PANIER) + box pour connaitre info 
   /*   Si email pas dans la bdd affichage d'une vue nom, prenom, adresse puis valider pour Achat
   /*   ajouter élément cours sur paiement en ligne



   

	
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/ 
   /*********************************************************************************************************************************************/
   /**************************                                                                              *************************************/
   /**************************                           PASSER UNE COMMANDE                                *************************************/
   /**************************                                                                              *************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/

   


   /**********************************************************************
   **              IDEE          Mise à jour EnCours                   ***
   **********************************************************************/

/*
   
   public function maj()
    {
      $Evenement=$this->ModeleEvenement->getEvenement();
      $date=$this->ModeleEvenement->date();
      foreach ($Evenement as $unEvenement):
      if($unEvenement->EnCours=='0') 
         {
            if ($unEvenement->DateMiseEnLigne<=$DateActuelle)
               {
                  if ($unEvenement->DateMiseHorsLigne>=$DateActuelle)
                     {
                        $this->ModeleEvenement->setEnCours($unEvenement->NoEvenement, $unEvenement->Annee,1);
                     }  
               }
         }
         else
         {
            if ($unEvenement->DateMiseEnLigne>=$DateActuelle)
               {
                  if ($unEvenement->DateMiseHorsLigne<=$DateActuelle)
                     {
                        $this->ModeleEvenement->setEnCours($unEvenement->NoEvenement, $unEvenement->Annee,0);
                     }  
               }
         }
      endforeach;
    } */ 



   
}

