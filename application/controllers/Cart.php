<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once(APPPATH."controllers/Administrateur.php");
class Cart extends CI_Controller 
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
   }

    function index()
    {
        $data['cartItems']=$this->cart->contents();
        $this->load->view('templates/EntetePrincipal');
        $this->load->view('visiteur/panier/index',$data);
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
    
    function removeItem($rowid) {   
        $data = array(
            'rowid'   => $rowid,
            'qty'     => 0
        );

        $this->cart->update($data);
        redirect('Cart/');
}
}