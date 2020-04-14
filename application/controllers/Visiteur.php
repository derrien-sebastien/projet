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
      $this->load->model('ModeleAdministrateur');
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


   public function inscription()//génère l'inscription
   {  
      $this->load->view('templates/EntetePrincipal');
      $this->form_validation->set_rules( 'txtEmail', 'Identifiant', 'required'); 
      $this->form_validation->set_rules( 'password', 'mot de passe', 'required');
      $this->form_validation->set_rules( 'password2', 'repetez mot de passe', 'required'); 
      if ($this->form_validation->run() === TRUE)                                      // si les règles sont respectées 
      {
         if($_POST['password']==$_POST['password2'])
         {
            $donnees = array(                                                               // on associe l'email a un tableau 
               'Email' => $this->input->post('txtEmail'),
               'MotDePasse'=>$this->input->post('password')                                     //
            );                                                                                    //
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
      else                                                                             // si les règles ne sont pas respectées
      {                                                                                                 
         
         $this->load->view('templates/PiedDePagePrincipal');                                                 // on redirige vers notre fonction 'erreur'
      }
   }


   /**********************************************************************
   **                        SE CONNECTER                               **
   **********************************************************************/


   public function seConnecter()
   {  
      $this->load->view('templates/EntetePrincipal');   
      $this->form_validation->set_rules('txtEmail', 'email', 'trim|required|valid_email');
      $this->form_validation->set_rules('password','mot de passe');      
      $DonneesInjectees['TitreDeLaPage'] = 'Se Connecter';                             // on injecte dans notre variable TitreDeLaPage ='Se Connecter'
      if($this->form_validation->run() === FALSE)                                     // les règles ne sont pas respectées
      {         
         $this->load->view('visiteur/vueLogin',$DonneesInjectees);
      }
      else                                                                             // Sinon 
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
            else
            {
               $this->load->view('visiteur/vueAccueilPersonne'); 
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


   public function seDeConnecter() 
   {
      $this->session->sess_destroy($_SESSION['__ci_last_regenerate']);   
      redirect('visiteur/accueil');
   }


   /**********************************************************************
   **                      MOT DE PASSE OUBLIE                          **
   **********************************************************************/
   public function oublieMotDePasse()
	{
      $this->load->view('templates/EntetePrincipal');
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
            $this->load->view('vueErreur');
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



   public function ModificationMdp()//Modification mot de passe
   {  
      $this->load->view('templates/EntetePrincipal');
      $this->form_validation->set_rules( 'password', 'mot de passe','required');
      $this->form_validation->set_rules( 'password2', 'repetez mot de passe','required');
      if($this->form_validation->run() === FALSE)
      {
         $this->load->view('visiteur/vueModifierMotDePasse');
         $this->load->view('templates/PiedDePagePrincipal');
      }
      else 
      {
         if($_POST['password']==$_POST['password2'])
         {
            
            $donnees=array(
               'email'=>$_SESSION['email'],
               'MotDePasse'=>$_POST['password']
            );
            $this->ModelePersonne->modifierInfoPersonne($donnees);
            $this->seDeConnecter();
         }
         else
         {
            echo '<h1>le mot de passe saisi n\'est pas identique a la confirmation<h1>';
            $this->load->view('visiteur/vueModifierMotDePasse');
            $this->load->view('templates/PiedDePagePrincipal');
         }
      }
   }

   /**********************************************************************
   **                    Mention légales et cookies                     **
   **********************************************************************/
  
    
   public function mentionsLegales()
   {
      $DonneesInjectees['TitreDeLaPage'] = 'Informations Légales';                     // on injecte dans notre variable TitreDeLaPage ='Informations Légales'
      $this->load->view('templates/EntetePrincipal');                                  // on charge l'entete de notre dossier templates
      $this->load->view('visiteur/vueMentionsLegales', $DonneesInjectees);             // on charge la vue des ML de notre dossier visiteur dans laquelle on injecte notre variable
      $this->load->view('templates/PiedDePagePrincipal');                              // on charge le pied de page de note dossier template
   }
  

   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /**************************                                                                              *************************************/
   /**************************                        DONNEES PAGE GESTION DE COMPTE                        *************************************/
   /**************************                                                                              *************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
  


   

   /**********************************************************************
   **        AJOUTER | VOIR | MODIFIER LES INFORMATIONS DU COMPTE       **
   **********************************************************************/

   public function infosCompte ()	
   {	
      $this->load->view('templates/EntetePrincipal'); 
      
      $this->form_validation->set_rules('txtNom','Nom','required');
      $this->form_validation->set_rules('txtPrenom','Prenom');
      $this->form_validation->set_rules('txtAdresse','Adresse');
      $this->form_validation->set_rules('txtCp','Code postal');
      $this->form_validation->set_rules('txtVille','Ville');
      $this->form_validation->set_rules('txtTelP','TelPortable');
      $this->form_validation->set_rules('txtTelF','TelFixe');
      if ($this->form_validation->run() === FALSE)
      {  
         
         
         if($this->ModelePersonne->presenceMdp($this->session->email))
         {   
            $DonneesInjectees['Personne']=$this->ModelePersonne->rechercheInfoPersonne($this->session->email);                                                                                                
            $this->load->view('visiteur/vueGestionDeCompte',$DonneesInjectees);//charge la vue formulaire eventuelment prérempli
         }
         else
         {
            echo '</br>';
            echo '</br>';
            echo '<h1>le mot de passe est obligatoire pour modifier ses informations personnel</h1>';
         
            $this->ModificationMdp();
         }   
		}         
      else
      {
         $donneesInsererPersonne = array(
            'email'=>$_SESSION['email'],
            'Nom' => $this->input->post('txtNom'),//$_POST['txtNom]
            'Prenom' => $this->input->post('txtPrenom'),    
            'Adresse' => $this->input->post('txtAdresse'),
            'CodePostal' => $this->input->post('txtCp'),
            'Ville' => $this->input->post('txtVille'),
            'TelPortable' => $this->input->post('txtTelP'),
            'TelFixe' => $this->input->post('txtTelF'),
            );           
            $this->ModelePersonne->modifierInfoPersonne($donneesInsererPersonne);
            $this->load->view('templates/EntetePrincipal');
            $this->load->view('Visiteur/vueInsertionReussi');
            $this->load->view('templates/PiedDePagePrincipal');
         } 
        
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






            ////////////////////////////////////////////////////////////////////////////
         ////////////////////////////////////////////////////////////////////////////////////
      /////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////// A FINIR ///////////////////////////////////////////////////////
      /////////////////////////////////////////////////////////////////////////////////////////////
         ////////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////



   /**********************************************************************
   **                 LiISTER LES EVENEMENTS EN COURS                  ***
   **********************************************************************/


   public function catalogueEvenement()            
   {  
      $donnees['Evenements']=$this->ModeleEvenement->getEvMarchParent();
   } 


   /**********************************************************************
   **                        VOIR UN EVENEMENT                         ***
   **********************************************************************/


   public function voirUnEvenement($NoEvenement = NULL,$Annee =NULL) 
   {
      if (!isset($_POST['valider']))
		{
			$Donnees['LesProduits']=$this->ModeleProduit->GetProduit();
			$this->load->view('/templates/Entete');
			$this->load->view('/visiteur/vueCatalogue.php',$Donnees);
		}
		else
		{
			$LesProduits=$this->ModeleProduit->GetProduit();
			
			
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
			$this->load->view('/visiteur/vuePanier');
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
   **                    fonction propre aux produits                  ***
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


   /**********************************************************************
   **                    fonction propre au panier                     ***
   **********************************************************************/
   function indexPanier()
   {
      $this->load->view('templates/EntetePrincipal');
      $data['data']=$this->ModeleProduit->get_all_produit();
      $this->load->view('visiteur/vuePanier',$data);
   }

function ajouterProduitAuPanier(){ 
   $data = array(
      'id' => $this->input->post('NoProduit'), 
      'name' => $this->input->post('LibelleCourt'), 
      'price' => $this->input->post('Prix'), 
      'qty' => $this->input->post('Stock'), 
   );
   $this->cart->insert($data);
   echo $this->voirPanier(); 
}

function voirPanier(){ 
   $output = '';
   $no = 0;
   foreach ($this->cart->contents() as $items) {
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

function chargerPanier(){ 
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

