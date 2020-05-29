<?php
//require_once(APPPATH."controllers/Administrateur.php");
class Membre extends CI_Controller 
{


    /**********************************************************************
    **                           Constructeur                            **
    **********************************************************************/


    public function __construct()
    {	
        parent::__construct();
        if($_SESSION['profil']!='admin')
		{	
            if($_SESSION['profil']!='membre')	
            {	
			redirect('/visiteur/seConnecter');
            }
        }  
            $this->load->model('ModeleIdentifiantSite');
            $this->load->model('ModeleCommande');
            $this->load->model('ModeleEnfant');
            $this->load->model('ModeleEvenement');	
            $this->load->model('ModelePersonne');
            $this->load->model('ModeleProduit');
        
            //constante AnneeEnCour
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
            $this->load->library('email');
            date_default_timezone_set('Europe/Paris');
    
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

    /* FUNCTION DE NOTRE INDEX Membre
   
         Comprend :  

            Entete ( bootstrap // summernote // javascript )
            Navbar ( générée en fonction des utilisateurs )
            Pied de Page ( informations sur le site/l'association - les administrateurs )
   */
    public function indexMembre($vue, $donnees = NULL, $vue2= null, $donnees2=null)
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


    public function accueil()
    {
        $this->indexMembre('membre/vueAccueilPersonne');
    }


    /*********************************************************************************************************************************************/
    /*********************************************************************************************************************************************/
    /*********************************************************************************************************************************************/
    /**************************                                                                              *************************************/
    /**************************                                GESTION COMPTE                                *************************************/
    /**************************                                                                              *************************************/
    /*********************************************************************************************************************************************/
    /*********************************************************************************************************************************************/
    /*********************************************************************************************************************************************/

    /**********************************************************************
    **        AJOUTER | VOIR | MODIFIER LES INFORMATIONS DU COMPTE       **
    **********************************************************************/
    
    public function infosCompte ()	
    {	
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
                $this->indexMembre('membre/vueGestionDeCompte',$DonneesInjectees);
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
            'Email'=>$_SESSION['email'],
            'Nom' => $this->input->post('txtNom'),
            'Prenom' => $this->input->post('txtPrenom'),    
            'Adresse' => $this->input->post('txtAdresse'),
            'CodePostal' => $this->input->post('txtCp'),
            'Ville' => $this->input->post('txtVille'),
            'TelPortable' => $this->input->post('txtTelP'),
            'TelFixe' => $this->input->post('txtTelF')
            );           
            $this->ModelePersonne->modifierInfoPersonne($donneesInsererPersonne);
            $DonneesInjectees['Personne']=$this->ModelePersonne->rechercheInfoPersonne($this->session->email);
            $this->indexMembre('membre/vueInsertionReussi', $DonneesInjectees);
        } 
       
    }

    /**********************************************************************
    **                    MODIFICATION DU MOT DE PASSE                   **
    **********************************************************************/

    public function modificationMdp()
    {  
        $this->form_validation->set_rules( 'password', 'mot de passe','required');
        $this->form_validation->set_rules( 'password2', 'repetez mot de passe','required');
        if($this->form_validation->run() === FALSE)
        {
            $this->indexMembre('membre/vueModifierMotDePasse');
        }
        else 
        {
            if($_POST['password']==$_POST['password2'])
            {
                $donnees=array(
                'Email'=>$_SESSION['email'],
                'MotDePasse'=>$_POST['password']
                );
                $this->ModelePersonne->modifierInfoPersonne($donnees);
                redirect('visiteur/seDeConnecter');
            }
            else
            {
                echo '<h1>le mot de passe saisi n\'est pas identique a la confirmation<h1>';
                $this->indexMembre('membre/vueModifierMotDePasse');

            }
        }
    }

    /**********************************************************************
    **                      DESINSCRIPTION NEWSLETTER                    **
    **********************************************************************/

    public function actif()
    {
        $personne=$this->ModelePersonne->rechercheInfoPersonne($_SESSION['email']);
        $parent=$this->ModelePersonne->getPersonneParent($personne->NoPersonne);
        if(!isset($_POST['submit']))
        {
            if($personne->Actif==1)
            {
                $donnees=array(
                    'actif'=>'oui'
                );
            }
            else
            {
                $donnees=array(
                    'actif'=>'non'
                );
            }
            $this->indexMembre('membre/vueDesinscrireMail',$donnees);
        }
        else
        {
            if($personne->Actif==1)
            
            {   
                if(isset($parent->Etre_Correspondant)) 
                {  
                    $donneesInsererParent=array('Etre_Correspondant'=>0,'NoPersonne'=>$personne->NoPersonne);
                    $this->ModelePersonne->modifierPersParent($donneesInsererParent);
                    $donneesInsererPersonne=array('Actif'=>0,'Email'=>$_SESSION['email']);
                    $this->ModelePersonne->modifierInfoPersonne($donneesInsererPersonne);
                    $this->indexMembre('membre/vueConfirmation');
                }
                else
                {
                    $donneesInsererPersonne=array('Actif'=>0,'Email'=>$_SESSION['email']);
                    $this->ModelePersonne->modifierInfoPersonne($donneesInsererPersonne);
                    $this->indexMembre('membre/vueConfirmation');
                }
            }
            else
            {
                $donneesInsererPersonne=array('Actif'=>1,'Email'=>$_SESSION['email']);
                $this->ModelePersonne->modifierInfoPersonne($donneesInsererPersonne);
                $this->indexMembre('membre/vueConfirmation');
            }
        }
    }  
  
    public function problem()
    {
        $this->form_validation->set_rules( 'message','Votre message', 'required');
        $this->form_validation->set_rules( 'object','Objet de votre message', 'required');
        if($this->form_validation->run() === FALSE)
        {
            $this->indexMembre('membre/vueEnvoiMail');
        }
        else 
        {
            $adresse='adresseAssocition@example.com';//adresse de l'association
            $personne=$this->ModelePersonne->rechercheInfoPersonne($_SESSION['email']);
            if(isset($personne->Nom))//si aucun nom est inscrit dans le formulaire
            {
                $nom=$personne->Nom;//nom qui figurera sur le mail 
            }
            else
            {
                $nom=$personne->Email;
            }
            $destinataire=$adresse;//destinataire passer dans la funtion
            $copie=$personne->Email;// adresse a mettre en copie de chaque mail
            $object=$_POST['object'];//object
            $texte=$_POST['message'];//corps du message
            $P=0;
            if(isset($donnees['piecesJointes']))
            {
                foreach($donnees['piecesJointes'] as $pieceJointe)
                {
                    $P++;
                    $piecesJointes[$nombreDePiecesJointes]=$pieceJointe;
                }
            } 
            $expediteur=$adresse;
            //envoye du mail a l'expediteur et en copie responsable; 
            $this->email->from($adresse,$nom); 
            $this->email->to($expediteur); 
            $this->email->cc($copie);
            $this->email->subject( $object ); 
            $this->email->message( $texte );
            if(isset($pieceJointe))
            {
                foreach($piecesJointes as $attachement)
                {
                    $this->email->attach($attachement);
                }
            }
            if($this->email->send())
            {
                echo 'votre message a bien été envoyé.';
            }
            else
            {
            echo "votre message n'a pas pu être envoyé.";
            }       
        }
    }

  
    public function mesCommandes()
    {
        $mesCommandes=$this->ModeleCommande->commandesEmail($_SESSION['email']);
        $donneesVue=array(
          'commandes'=>$mesCommandes
        );
        $this->indexMembre('membre/vueAffichageCommandes',$donneesVue);
    }    
    
    public function afficherUneCommande()
    {
        foreach($_POST as $unPost)//$_POST['o']=array noCommande=qqch $_Post['1']=array NoCommande=qqch $_POST['2']=voir=VOIR
        { 
            if(isset($unPost['noCommande']))//a chaque numero commande
            {
                $noCommande = $unPost['noCommande'];//on recupere le numero commande pour memoriser le dernier
            }
            if($unPost=='VOIR')// si on est rendu au submit 
            {
                $ligneCommande=$this->ModeleCommande->getUneCommande($noCommande);
                $i=0;
                foreach($ligneCommande as $uneLigne)
                {   
                    $donnees=array(
                        'NoEvenement'   =>  $uneLigne->NoEvenement,
                        'Annee'         =>  $uneLigne->Annee,
                        'NoProduit'     =>  $uneLigne->NoProduit
                    );
                    $produit=$this->ModeleProduit->getUnProduit($donnees);
                    $evenement=$this->ModeleEvenement->retournerUnEvenement ($donnees['NoEvenement'], $donnees['Annee']);
                    $donneesLigneCommande[$i]=array(
                        'ligneCommande' =>  $uneLigne,
                        'produit'       =>  $produit,
                        'evenement'     =>  $evenement,
                    );
                    $i++;
                }
                $donneesVue=array(
                    'donneesLigne'      =>  $donneesLigneCommande,
                    'noCommande'        =>  $noCommande
                );
                $this->indexMembre('membre/vueUneCommande',$donneesVue);
            }
        }
    }

    /* public function modificationCommande()
    {

    } */

}