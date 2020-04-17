<?php
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
      $this->load->model('ModeleProduit');
      
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
      $this->load->view('templates/vueAccueilPrincipal');  
   }

   /**********************************************************************
   **                           INSCRIPTION                             **
   **********************************************************************/
   // A REVOIR

   public function inscription()
   {  
      $this->load->view('templates/EntetePrincipal');
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
         $personne=$this->ModelePersonne->recherchePersonne($email,$password);
         
         if(isset($personne)) 
         {
            $this->session->session_start;                                   
            $dataSession=array(
               'email'=>$personne->Email,
               'profil'=>$personne->profil
            );                    
            $this->session->set_userdata($dataSession);                     
            if($this->session->profil=='admin')
            {
               $donneesSession=array(
                  'email'=>$this->session->__ci_last_regenerate,
                  'mdp'=>$personne->Email,
                  'profil'=>$personne->profil
               );
               $this->ModeleIdentifiantSite->insererInformationSession($donneesSession);
			   $this->session_save_path;
               redirect('Administrateur/accueil');
            }
            elseif ($this->session->profil=='membre')
            {
               $donneesSession=array(
               'email'=>$this->session->__ci_last_regenerate,
               'mdp'=>$personne->Email,
               'profil'=>$personne->profil
               );
               $this->ModeleIdentifiantSite->insererInformationSession($donneesSession);
			      $this->session_save_path;
               redirect('membre/vueAccueilPersonne');
            }
            else
            {
               $this->load->view('visiteur/vueCatalogue');
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

   /*   Afficher tous les évènements en catalogue en deux parties Ev_Marchand et Ev_Non_Marchand cliquable  
   /*   Afficher un seul évènement avec tous ses produits en stock + vue si stock vide  
   /*   Afficher le panier avec un lien passer commande (DANS LE RESUMER DU PANIER) + box pour connaitre info 
   /*   Si email pas dans la bdd affichage d'une vue nom, prenom, adresse puis valider pour Achat
   /*   ajouter élément cours sur paiement en ligne



   /**********************************************************************
   **                 LiISTER LES EVENEMENTS EN COURS                  ***
   **********************************************************************/


   public function catalogueEvenement()            
   {  
      
      $DonneesInjectees['lesEvenementsMarchands'] = $this->ModeleEvenement->retournerEvenementsMarchands();
      $DonneesInjectees['lesEvenementsNonMarchands'] = $this->ModeleEvenement->retournerEvenementsNonMarchands();
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('visiteur/vueCatalogueEvenements', $DonneesInjectees);
   } 
 
   /**********************************************************************
   **                        VOIR UN EVENEMENT                         ***
   **********************************************************************/

   public function EvenementMarchand($noEvenement = NULL,$Annee =NULL)
   {
      
      $DonneesInjectees['unEvenementMarchand'] = $this->ModeleEvenement->retournerEvenements($noEvenement);
      if (empty($DonneesInjectees['unEvenementMarchand']))
      {   
         show_404();
      }
      $DonneesInjectees['TitreDeLaPage'] = $DonneesInjectees['unEvenementMarchand']['TxtHTMLEntete'];
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('visiteur/vueEvenementMarchandEntete', $DonneesInjectees);
      $this->indexPanier();//à finir affichage en catalogue des produit EN STOCK 
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
      $this->load->view('visiteur/vueEvenementNonMarchandEntete', $DonneesInjectees);
   }

   /**********************************************************************
   **                    fonction propre au panier                     ***
   **********************************************************************/
   function indexPanier()
   {
      $this->load->view('templates/EntetePrincipal');
      $data['data']=$this->ModeleProduit->get_all_produit();
      $this->load->view('visiteur/vuePanier',$data);
   }

   function ajouterProduitAuPanier()
   { 
      $data = array(
                        'id' => $this->input->post('NoProduit'), 
                        'name' => $this->input->post('LibelleCourt'), 
                        'price' => $this->input->post('Prix'), 
                        'qty' => $this->input->post('Stock'), 
                     );
      $this->cart->insert($data);
      echo $this->voirPanier(); 
   }

   function voirPanier()
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
            <td><button type="button" id="'.$items['rowid'].'" class="romove_cart btn btn-danger btn-sm">Cancel</button></td>
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
   }













   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /**************************                                                                              *************************************/
   /**************************                                    A REVOIR                                  *************************************/
   /**************************                                                                              *************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/













   public function voirUnEvenementAutre($NoEvenement = NULL,$Annee =NULL) 
   {
      if (!isset($_POST['valider']))
		{
			$Donnees['LesProduits']=$this->ModeleProduit->get_all_produit();
			$this->load->view('templates/EntetePrincipal');
			$this->load->view('visiteur/vueCatalogue.php',$Donnees);
		}
		else
		{
			$LesProduits=$this->ModeleProduit->get_all_produit();
			
			
			$Compteur=0;
			
			$DonneesPanier= array();
			foreach ($LesProduits as $unProduit) 
			{
						$tarif=($unProduit->PRIXHT+(($unProduit->PRIXHT*$unProduit->TAUXTVA)/100));
						$DonneesPanier[] = array(
							'id'      => $unProduit->NOPRODUIT,
							'qty'     => $_POST[$unProduit->NOPRODUIT],
							'price'   => $tarif,
							'name'    => $unProduit->LIBELLE,                
						);
			}
			$this->cart->insert($DonneesPanier);
			$this->load->view('  visiteur/vuePanier');
		}

	
      $DonneesInjectees['Evenement'] = $this->ModeleEvenement->retournerUnEvenement($NoEvenement,$Annee);
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('visiteur/vueVoirUnEvenementEntete', $DonneesInjectees);
      $this->load->view('visiteur/vueVoirUnEvenementPiedDePage', $DonneesInjectees);
      $this->load->view('templates/PiedDePagePrincipal');
   }

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
   **                                    ***
   **********************************************************************/

   
   public function lesProduitsEvenement($NoEvenement,$Annee)//index produits
   {
      $Donnees=array('LesProduits'=>$this->ModeleProduit->getProduits($NoEvenement,$Annee), 'Evenement'=>$this->ModeleEvenement->retournerUnEvenement($NoEvenement,$Annee));
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('visiteur/vueVoirUnEvenementEntete', $Donnees);
      $this->load->view('visiteur/vuePasserCommande', $Donnees);
      $this->load->view('visiteur/vueVoirUnEvenementPiedDePage', $Donnees);
      $this->load->view('templates/PiedDePagePrincipal');
   }

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
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('visiteur/vueCommande', $data);
      $this->load->view('templates/PiedDePagePrincipal');
      //redirect('visiteur/Panier');

   } */


   

   /* function indexPanier()
   {
      $data = array();
      $data['ProduitsDuPanier'] = $this->cart->contents();
      $this->load->view('visteur/vuePanier', $data);
   }


   function majQuantiteProduit()
   {
      $update = 0;
      $rowid = $this->input->get('rowid');// Obtenir des informations sur le panier
      $qty = $this->input->get('qty');
      
      // MAJ du poroduit dans le panier
      if(!empty($rowid) && !empty($qty))
         {
            $data = array(
            'rowid' => $rowid,
            'qty'   => $qty
            );
            $update = $this->cart->update($data);
         }
      
      // Retourne la réponse
      echo $update?'ok':'err';
   } */
  
   /* function removeItem($rowid)
   {
      // Retire les produits du panier
      $remove = $this->cart->remove($rowid);
      //redirect('visiteur/Panier');
   } */
  
   /**********************************************************************
   **                    fonction pour paiement                        ***
   **********************************************************************/


  /* function indexCommande()
  {
      if($this->cart->total_items() <= 0)// Si panier vide redirige vers lesProduitsEvenement
         {
            redirect('visiteur/lesProduitsEvenement');
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
                     $this->session->set_userdata('success_msg', 'Order placed successfully.');
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
   } */

   /* function placeOrder($custID)// Insérer les données de la commande
   {
      $ordData = array(
      'customer_id' => $custID,
      'grand_total' => $this->cart->total()
      );
      $insertOrder = $this->product->insertOrder($ordData);
      if($insertOrder)
         {
            $cartItems = $this->cart->contents();// Récupérer les données du panier de la session
            $ordItemData = array();
            $i=0;
            foreach($cartItems as $item)
            {
               $ordItemData[$i]['order_id']     = $insertOrder;
               $ordItemData[$i]['product_id']     = $item['id'];
               $ordItemData[$i]['quantity']     = $item['qty'];
               $ordItemData[$i]['sub_total']     = $item["subtotal"];
               $i++;
            }
            if(!empty($ordItemData))
               {
                  $insertOrderItems = $this->product->insertOrderItems($ordItemData);//Insérer la Commande de produits
               if($insertOrderItems)
                  {
                     $this->cart->destroy();// Supprimer les produits du panier
                     return $insertOrder;// retourne id commande
                  }
               }  
         }
      return false;
   } */


/* function orderSuccess($ordID)
{
   $data['order'] = $this->product->obtenirCommande($ordID);//Récupérer les données de commande dans la base de données
   $this->load->view($this->controller.'/order-success', $data); // Affiche les détails de la commande 
} */






   /**********************************************************************
   **              IDEE          Mise à jour EnCours                   ***
   **********************************************************************/


     /* public function maj()
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

