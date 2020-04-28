<?php
//require_once(APPPATH."controllers/Administrateur.php");
class test2 extends CI_Controller 
{

   /**********************************************************************
   **                           Constructeur                            **
   **********************************************************************/

   public function __construct()
   {	
      parent::__construct();
   }

   public function accueil()
   {
      $this->load->view('templates/EntetePrincipal');
      $this->load->view('templates/EnteteNavbar');
   }
}