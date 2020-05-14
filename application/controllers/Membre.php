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
            /* $this->load->model('ModeleClasse'); */
            $this->load->model('ModeleCommande');
            /* $this->load->model('ModeleEnfant'); */
            $this->load->model('ModeleEvenement');
            /* $this->load->model('ModeleIdentifiantSite'); */    	
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
   public function indexMembre()
   {
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('templates/EnteteNavbar');
      $this->load->view('templates/PiedDePagePrincipal');
   }

    public function accueil()
    {
        $this->indexMembre();
        $this->load->view('membre/vueAccueilPersonne');  
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
        $this->indexMembre(); 
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
                $this->load->view('membre/vueGestionDeCompte',$DonneesInjectees);
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
            $this->load->view('templates/EntetePrincipal');
            $this->load->view('templates/EnteteNavbar');
            $this->load->view('membre/vueInsertionReussi', $DonneesInjectees);
            $this->load->view('templates/PiedDePagePrincipal');
        } 
       
    }

    /**********************************************************************
    **                    MODIFICATION DU MOT DE PASSE                   **
    **********************************************************************/

    public function ModificationMdp()
    {  
        $this->indexMembre();
        $this->form_validation->set_rules( 'password', 'mot de passe','required');
        $this->form_validation->set_rules( 'password2', 'repetez mot de passe','required');
        if($this->form_validation->run() === FALSE)
        {
            $this->load->view('membre/vueModifierMotDePasse');
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
                redirect('visiteur/seDeConnecter');
            }
            else
            {
                echo '<h1>le mot de passe saisi n\'est pas identique a la confirmation<h1>';
                $this->load->view('membre/vueModifierMotDePasse');
                $this->load->view('templates/PiedDePagePrincipal');
            }
        }
    }

    /**********************************************************************
    **                      DESINSCRIPTION NEWSLETTER                    **
    **********************************************************************/

    public function Actif()
    {
        $this->indexMembre();
        $this->form_validation->set_rules('Etre_Correspondant AND Actif','checkbox','required'); 
        $personne=$this->ModelePersonne->rechercheInfoPersonne($_SESSION['email']);
        $parent=$this->ModelePersonne->getPersonneParent($personne->NoPersonne);
        if($personne->Actif==1)
        
        {      
            if ($parent->Etre_Correspondant==1)
            {
                $this->load->view('membre/vueDesinscrireMail');
                
                if(isset($_POST['confirmer']))
                {
                    $donneesInsererParent=array('Etre_Correspondant'=>0,'NoPersonne'=>$personne->NoPersonne);
                    $this->ModelePersonne->modifierPersParent($donneesInsererParent);
                    $donneesInsererPersonne=array('Actif'=>0,'Email'=>$_SESSION['email']);
                    $this->ModelePersonne->modifierInfoPersonne($donneesInsererPersonne);
                    $this->load->view('membre/vueConfirmation');
                }
            }
            else 
            {
                $this->load->view('membre/vueConfirmation');
            }
        }
        else
            {
                $this->load->view('membre/vueInscrireMail');
                $this->form_validation->set_rules('Etre_Correspondant AND Actif','checkbox','required'); 
                if(isset($_POST['confirmer']))
                {
                    $donneesInsererParent=array('Etre_Correspondant'=>1,'NoPersonne'=>$personne->NoPersonne);
                    $this->ModelePersonne->modifierPersParent($donneesInsererParent);
                    $donneesInsererPersonne=array('Actif'=>1,'Email'=>$_SESSION['email']);
                    $this->ModelePersonne->modifierInfoPersonne($donneesInsererPersonne);
                    $this->load->view('membre/vueConfirmation');
                }
            }
        
   }
}