<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once(APPPATH."controllers/Administrateur.php");
class Checkout extends CI_Controller 
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
      $this->load->model('ModeleProduit');
      $this->controller = 'checkout';
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
        if($this->cart->total_items() <= 0)
        {
            redirect('product/');
        }
        $custData = $data = array();
        $submit =$this->input->post('placeOrder');
        if(isset($submit))
        {
            $this->form_validation->set_rules('name','Name','required');
            $this->form_validation->set_rules('email','Email','required|valid_email');
            $this->form_validation->set_rules('phone','Phone','required');
            $this->form_validation->set_rules('adress','Adress','required');
            $custData = array(
                'name'  => strip_tags($this->input->post('name')),
                'email' => strip_tags($this->input->post('email')),
                'phone' => strip_tags($this->input->post('phone')),
                'adress'=> strip_tags($this->input->post('adress')),
            );
            if($this->form_validation->run() === TRUE)
            {
                $insert=$this->ModeleProduit->insertCustomer($custData);
                if($insert)
                {
                    $order = $this->placeOrder($insert);
                    if($order)
                    {
                        $this->session->set_rules('success_msg', 'Order placed successfully.');
                        redirect($this->controller.'/orderSuccess/'.$order);
                    }
                    else
                    {
                        $data['error_msg'] = 'Order submission failed.';
                    }
                }
                else 
                {
                    $data['error_msg'] = 'Some problem occured, please try again.';
                }
            }
        }
        $data['custData'] = $custData;
        $data['cartItems']= $this->cart->contents();
        $this->load->view('templates/EntetePrincipal');
        $this->load->view('visiteur/checkout/index',$data);
    }

    function placeOrder($custID)
    {
        $ordData = array(
            '23'     => $custID,
            'MontantTotal'   => $this->cart->total()
        );
        $insertOrder=$this->ModeleProduit->insertOrder($ordData);
        if($insertOrder)
        {
            $cartItems = $this->cart->contents();
            //articles du panier
            $ordItemData = array();
            $i=0;
            foreach($cartItems as $item)
            {
                $ordItemData[$i]['NoCommande']     = $insertOrder;
                $ordItemData[$i]['NoProduit']      = $item['id'];
                $ordItemData[$i]['Quantite']       = $item['qty'];
                $ordItemData[$i]['MontantTotal']      = $item["subtotal"];
                $i++;
            }
            if(!empty($ordItemData))
            {
                $insertOrderItems = $this->ModeleProduit->insererOrderItems($ordItemData);//Insérer la Commande de produits
                if($insertOrderItems)
                {
                    $this->cart->destroy();// Supprimer les produits du panier
                    return $insertOrder;// retourne noCommande
                }
            }  
        }
        return false;
    }
    
    public function orderSuccess($ordID)
    {
        $data['order']=$this->ModeleProduit->getOrder($ordID);
        $this->load->view($this->controller.'/order-success',$data);
    }

}