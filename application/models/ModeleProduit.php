<?php
 
class ModeleProduit extends CI_Model 

{

   /**********************************************************************
   **                           Constructeur                           **
   **********************************************************************/

   public function __construct()
   {

      $this->load->database();
      $this->proTable='ge_produit';
      $this->custTable='ge_personne';
      $this->ordTable='ge_commande';
      $this->ordItemsTable='ge_contenir';
      
   }


   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /**************************                                                                              *************************************/
   /**************************                  SELECT () DE NOTRE TABLE GE_PRODUIT                         *************************************/
   /**************************                                                                              *************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   public function get_all_produit()
   {
      $result=$this->db->get('ge_produit');
      return $result->result();
   }
   public function obtenirLesProduits($pNoEvenement, $pAnnee) 
   {
      $criteres="NoEvenement = '$pNoEvenement' And Annee = '$pAnnee'";
      $this->db->where($criteres);
      $query = $this->db->get('ge_produit');
      return $query->result();
   }

   public function getRows($noEv, $ann, $noProd) //pour le panier
   {
      $this->db->select('*');
      $this->db->from('ge_produit');
      $this->db->join('ge_evenement','ge_evenement.NoEvenement=ge_produit.NoEvenement AND ge_evenement.Annee=ge_produit.Annee');
      $this->db->join('ge_ev_marchand','ge_ev_marchand.NoEvenement=ge_produit.NoEvenement AND ge_ev_marchand.Annee=ge_produit.Annee');
      $this->db->where('ge_evenement.EnCours', 1);
      if($noEv && $ann && $noProd)
      {
         $this->db->where('ge_produit.NoEvenement', $noEv);
         $this->db->where('ge_produit.Annee', $ann);
         $this->db->where('ge_produit.NoProduit', $noProd);
         $query=$this->db->get();
         $result=$query->row_array();
      }
      else
      {
         $this->db->order_by('LibelleCourt','asc');
         $query=$this->db->get();
         $result=$query->result_array();
      }
      return !empty($result)?$result:false;
   } 

   public function getOrder($id)
   {
      $this->db->select('comm.*,pers.Nom,pers.Email,pers.TelPortable,pers.Ville');
      $this->db->from($this->ordTable.'as comm');
      $this->db->join($this->custTable.'as pers','pers.NoPersonne = comm.NoPersonne', 'left');
      $this->db->where('comm.NoCommande', $id);
      $query = $this->db->get();
      $result = $query->row_array();
      
      $this->db->select('cont.*','prod.Img_Produit','prod_LibelleCourt','prod.Prix');
      $this->db->from($this->ordItemsTable.'as cont');
      $this->db->join($this->proTable.'as prod','prod.NoProduit=cont.NoProduit','left');
      $this->db->where('cont.NoProduit',$id);
      $query2 = $this->db->get();
      $result['items'] = ($query2->num_rows() > 0)?$query2->result_array():array();
      return !empty($result)?$result:false;
   }

   public function insertCustomer($data)
   {
      if(!array_key_exists("created",$data))
      {
         $data['created'] = date("Y-m-d H:i:s");
      }
      if(!array_key_exists("modified",$data))
      {
         $data['modified'] = date("Y-m-d H:i:s");
      }
      $insert = $this->db->insert($this->custTable, $data);
      return $insert?$this->db->insert_id():false;
   }

   public function insertOrder($data)
   {
      if(!array_key_exists("created",$data))
      {
         $data['DateCommande'] = date("Y-m-d H:i:s");
      }
      if(!array_key_exists("modified",$data))
      {
         $data['DateValidation'] = date("Y-m-d H:i:s");
      }
      $insert = $this->db->insert($this->ordTable, $data);
      return $insert?$this->db->insert_id():false;
   }

   public function insertOrderItems($data=array())
   {
      $insert = $this->db->insert_batch($this->ordItemsTable, $data);
      return $insert?true:false;
   }


  /************************************************************************************
  **   Tous les produits en cours de vente et en stock de notre table ge_produit     **
  *************************************************************************************/
   public function retournerProduit($pNoEvenement = FALSE, $pAnnee = FALSE)
   {
      if ($pNoEvenement === FALSE || $pAnnee === FALSE)
      {
         $this->db->select('*');
         $this->db->from('ge_produit');
         $this->db->join('ge_evenement', 'ge_produit.NoEvenement=ge_evenement.NoEvenement AND ge_produit.Annee=ge_evenement.Annee');   
         $this->db->join('ge_contenir', 'ge_produit.NoEvenement=ge_contenir.NoEvenement AND ge_produit.Annee=ge_contenir.Annee AND ge_produit.NoProduit=ge_contenir.NoProduit');
         $this->db->where('ge_produit', $Annee);
         $this->db->where('ge_produit', $NoEvenement);
         $this->db->where(`ge_produit.stock`>0 );
         $this->db->where('ge_evenement.EnCours', 1); 
         $maListe = $this->db->get();
         return $maListe->result();
      }
         $maListe = $this->db->get_where('ge_produit', array('NoEvenement' => $pNoEvenement,'Annee'=>$pAnnee));
         return $maListe->row_array();
       
   } 

   public function getProduits($pNoEvenement, $pAnnee)
   {
      $this->db->select('*');
     $this->db->from('ge_produit');
     $this->db->where('ge_produit.NoEvenement', $pNoEvenement);
     $this->db->where('ge_produit.Annee', $pAnnee);
     $maCommande = $this->db->get();
     return $maCommande->result(); 
  } 


  public function getUnProduit($donneesProduit)
  {
     $this->db->select('*');
     $this->db->from('ge_produit');
     $this->db->where('ge_produit.NoEvenement', $donneesProduit['NoEvenement']);
     $this->db->where('ge_produit.Annee', $donneesProduit['Annee']);
     $this->db->where('ge_produit.NoProduit', $donneesProduit['NoProduit']);
     $maCommande = $this->db->get();
     return $maCommande->row(); 
  } 
  /**********************************************************************
  **           Fonction qui va retourner le numéro max                 **
  **********************************************************************/


  public function maxProduit($donneesProduit)
  {
     $this->db->select_max('NoProduit');
     $this->db->from('ge_produit');
     $this->db->where('ge_produit.NoEvenement', $donneesProduit['NoEvenement']);
     $this->db->where('ge_produit.Annee', $donneesProduit['Annee']);
     $query=$this->db->get();
     $ligne = $query->row();	    
     $noMax= $ligne->NoProduit;	
     return $noMax;
  }
   
  /**********************************************************************
  **                      Tous les produits                            **
  **********************************************************************/

  public function getProduitGeneral($pAnnee)
  {
     $this->db->select('*');
     $this->db->from('ge_produit');   
     $this->db->where('ge_produit.Annee', $pAnnee);
     $maListe = $this->db->get();
     return $maListe->result();    
  } 

  /* public function getProduitEnStock()
  {
      $this->db->distinct('*');
      $this->db->from('ge_produit');
      $this->db->join('ge_evenement');
      $this->db->where(`ge_produit.NoEvenement=ge_evenement.NoEvenement`,$pNoEvenement);
      $this->db->where(`ge_produit.Annee=ge_evenement.Annee`,$pAnnee);
      $this->db->where(`ge_produit.stock`>0 );
      $this->db->orderby ('NumeroOrdreApparition');
      $maCde = $this->db->get();
      return $maCde->result_arry(); 
  } */
 
 //Récupérer les données des produits dans la base de données
 //id renvoie un seul enregistrement s'il est spécifié, sinon tous les enregistrements
  public function obtenirInfosProduits($id = 'NoProduit')
  {
     $this->db->select('*');
     $this->db->from($this->proTable);
     $this->db->where(`ge_produit`.`stock`>0 );
     if($id){
         $this->db->where('NoProduit', $id);
         $query = $this->db->get();
         $result = $query->row_array();
     }else{
         $this->db->order_by('LibelleCourt', 'asc');
         $query = $this->db->get();
         $result = $query->result_array();
     }
     return !empty($result)?$result:false;
  }


  
 public function getProduitsActif()
  {
     $this->db->select('*');
     $this->db->from('ge_produit');
     $this->db->join('ge_evenement','ge_evenement.NoEvenement=ge_produit.NoEvenement AND ge_evenement.Annee=ge_produit.Annee');
     $this->db->where('ge_evenement.EnCours', 1);      
     $maCommande = $this->db->get();
     return $maCommande->result(); 
  } 
} // CLASSE