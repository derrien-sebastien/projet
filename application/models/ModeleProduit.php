<?php
 
class ModeleProduit extends CI_Model 

{

   /**********************************************************************
   **                           Constructeur                           **
   **********************************************************************/

  public function __construct()
  {
     $this->load->database();
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

   public function getRows($id='') 
   {
      $this->db->select('*');
      $this->db->from('ge_produit');
      $this->db->join('ge_evenement','ge_evenement.NoEvenement=ge_produit.NoEvenement AND ge_evenement.Annee=ge_produit.Annee');
      $this->db->join('ge_ev_marchand','ge_ev_marchand.NoEvenement=ge_produit.NoEvenement AND ge_ev_marchand.Annee=ge_produit.Annee');
      $this->db->where('ge_evenement.EnCours', 1);
      if($id)
      {
         $this->db->where('NoProduit', $id);
         $query=$this->db->get();
         $result=$query->row_array();
      }
<<<<<<< HEAD
      else
      {
         $this->db->order_by('LibelleCourt','asc');
         $query=$this->db->get();
         $result=$query->result_array();
      }
      return !empty($result)?$result:false;
=======
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
>>>>>>> e899c1b8d568d0fc9f63fcdf3341a27d98162461
   } 

  /************************************************************************************
  **   Tous les produits en cours de vente et en stock de notre table ge_produit     **
  *************************************************************************************/
 public function retournerProduit($pNoEvenement = FALSE)
  {
    if ($pNoEvenement === FALSE)
       {
          $this->db->select('*');
          $this->db->from('ge_evenement');
          $this->db->join('ge_produit', 'ge_evenement.NoEvenement=ge_produit.NoEvenement AND ge_evenement.Annee=ge_produit.Annee');   
          $this->db->join('ge_contenir', 'ge_evenement.NoEvenement=ge_produit.NoEvenement AND ge_evenement.Annee=ge_produit.Annee AND ge_produit.NoProduit=ge_contenir.NoProduit');
          $this->db->where(`ge_produit.stock`>0 );
          $this->db->where('ge_evenement.EnCours', 1);
          $maListe = $this->db->get();
          return $maListe->result_array();
       }
       $maListe = $this->db->get_where('ge_produit', array('NoEvenement' => $pNoEvenement));
       return $maListe->row_array();
       
  }
 /*  public function retournerProduit($pNoEvenement,$pAnnee,$pNoProduit)
  {
     if ($pNoEvenement === FALSE)
     {
        $this->db->select('*');
        $this->db->from('ge_evenement');
        $this->db->join('ge_produit', 'ge_evenement.NoEvenement=ge_produit.NoEvenement AND ge_evenement.Annee=ge_produit.Annee');   
        $this->db->join('ge_contenir', 'ge_evenement.NoEvenement=ge_produit.NoEvenement AND ge_evenement.Annee=ge_produit.Annee AND ge_produit.NoProduit=ge_contenir.NoProduit');
        $this->db->where(`ge_produit.stock`>0 );
        $this->db->where('ge_evenement.EnCours', 1);
        $maListe = $this->db->get();
        return $maListe->result_array();
       }
       $maListe = $this->db->get_where('ge_produit', array('NoEvenement' => $pNoEvenement,'Annee'=>$pAnnee,'NoProduit'=>$pNoProduit));
       return $maListe->row_array();
  } */
  public function rechercherProduit($id)
  {
     $recherche = $this->db->get_where('ge_produit',array('NoProduit' => $id));
     return $recherche->row_array();
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


  
 /* public function getProduitsActif()
  {
     $this->db->select('*');
     $this->db->from('ge_produit');
     $this->db->join('ge_evenement','ge_evenement.NoEvenement=ge_produit.NoEvenement AND ge_evenement.Annee=ge_produit.Annee');
     $this->db->where('ge_evenement.EnCours', 1);      
     $maCommande = $this->db->get();
     return $maCommande->result(); 
  } */
} // CLASSE