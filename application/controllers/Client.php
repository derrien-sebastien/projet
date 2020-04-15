<?php
//require_once(APPPATH."controllers/Administrateur.php");
class Client extends CI_Controller 
{


    /**********************************************************************
    **                           Constructeur                            **
    **********************************************************************/


    public function __construct()
    {	
        parent::__construct();
        if ($this->user->is_logged_in() === FALSE) {
            redirect('visiteur/accueil');
        };   
        $this->load->model('ModeleIdentifiantSite');
        $this->load->model('ModeleAdministrateur');
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
    //OK
    public function accueil()
    {
        $this->load->view('templates/EntetePrincipal');
        $this->load->view('templates/vueAccueilPrincipal');
    }

    /**********************************************************************
    **                      MOT DE PASSE OUBLIE                          **
    **********************************************************************/
    //OK
    public function oublieMotDePasse()
	{
        $this->load->view('templates/EntetePrincipal');
        $this->form_validation->set_rules('txtLogin','email','required');
        if($this->form_validation->run() === FALSE)
        { 
            $this->load->view('client/vueMotDePasseOublie');
            $this->load->view('templates/PiedDePagePrincipal');
        }
        else
        {    
            if (!($rechercherEmailPresent($_POST['txtLogin'])))
            {   //erreure de mail a refaire
                $Value['Value'] = 'Adresse e-mail incorrect';
                //$this->load->view('vueErreur');
                $this->load->view('client/vueMotDePasseOublie');
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
    **        AJOUTER | VOIR | MODIFIER LES INFORMATIONS DU COMPTE       **
    **********************************************************************/
    //OK
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
                $this->load->view('client/vueGestionDeCompte',$DonneesInjectees);//charge la vue formulaire eventuelment prérempli
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
            $this->load->view('client/vueInsertionReussi');
            $this->load->view('templates/PiedDePagePrincipal');
        } 
       
    }

    //Modification mot de passe OK
    public function ModificationMdp()
    {  
        $this->load->view('templates/EntetePrincipal');
        $this->form_validation->set_rules( 'password', 'mot de passe','required');
        $this->form_validation->set_rules( 'password2', 'repetez mot de passe','required');
        if($this->form_validation->run() === FALSE)
        {
            $this->load->view('client/vueModifierMotDePasse');
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
                $this->load->view('client/vueModifierMotDePasse');
                $this->load->view('templates/PiedDePagePrincipal');
            }
        }
    }

}