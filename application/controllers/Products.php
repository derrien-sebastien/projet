<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once(APPPATH."controllers/Administrateur.php");
class Products extends CI_Controller 
{

   /**********************************************************************
   **                           Constructeur                            **
   **********************************************************************/

    public function __construct()
    {	
      parent::__construct();   
      $this->load->library('cart');
      $this->load->model('ModeleIdentifiantSite');
      $this->load->model('ModeleCommande');
      $this->load->model('ModeleEvenement');    	
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

    public function index()
    {
        
        $data=array();
        $data['product']=$this->ModeleProduit->getRows();
        $this->load->view('templates/EntetePrincipal');
        $this->load->view('visiteur/product/index', $data);
    }

    public function addToCart($proID)
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
        redirect('cart/');
    }
}