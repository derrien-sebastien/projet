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
   function get_all_produit(){
		$result=$this->db->get('ge_produit');
		return $result;
	}

   /**********************************************************************
   **   Tous les produits en cours de vente de notre table ge_produit   **
   **********************************************************************/

   public function getProduits($pNoEvenement, $pAnnee)
   {
      $this->db->select('*');
      $this->db->from('ge_evenement');
      $this->db->join('ge_produit', 'ge_evenement.NoEvenement=ge_produit.NoEvenement AND ge_evenement.Annee=ge_produit.Annee');
      $this->db->where('ge_evenement.NoEvenement', $pNoEvenement);
      $this->db->where('ge_produit.Annee', $pAnnee);
      $maCommande = $this->db->get();
      return $maCommande->result(); 
   } 
   /**********************************************************************
   **           Fonction qui va retourner le numéro max                 **
   **********************************************************************/


   public function maxProduit()
   {
      $this->db->select_max('NoProduit');
      $query=$this->db->get('ge_produit');
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

   /* SELECT DISTINCT * 
   FROM `ge_produit` 
   join `ge_evenement` 
   where `ge_produit`.`NoEvenement`=`ge_evenement`.`NoEvenement` And`ge_produit`.`Annee`=`ge_evenement`.`Annee`
   AND `ge_produit`.`stock`>0 
   order by NumeroOrdreApparition */

   /* public function getProduitEnStock()
   {
       $this->db->distinct('*');
       $this->db->from('ge_produit');
       $this->db->join('ge_evenement');
       $this->db->where(`ge_produit`.`NoEvenement`=`ge_evenement`.`NoEvenement`,$pNoEvenement);
       $this->db->where(`ge_produit`.`Annee`=`ge_evenement`.`Annee`,$pAnnee);
       $this->db->where(`ge_produit`.`stock`>0 );
       $this->db->orderby ('NumeroOrdreApparition');
       $maCde = $this->db->get();
       return $maCde->result_arry(); 
   }
   */
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
   

   

   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /**************************                                                                              *************************************/
   /**************************                  UPDATE () DE NOTRE TABLE GE_PRODUIT                         *************************************/
   /**************************                                                                              *************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/


   /**********************************************************************
   **        fonction qui va modifier un produit dans la base          **
   **********************************************************************/
   public function modifierProduit($pDonneesAInserer)
   {        
       $this->db->where('annee', $pDonneesAInserer['Annee']);
       $this->db->where('noEvenement', $pDonneesAInserer['NoEvenement']);
       $this->db->where('noProduit', $pDonneesAInserer['NoProduit']);
       return $this->db->update('ge_Produit', $pDonneesAInserer);
   }


   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /**************************                                                                              *************************************/
   /**************************                  INSERT () DE NOTRE TABLE GE_PRODUIT                         *************************************/
   /**************************                                                                              *************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/


   /**********************************************************************
   **        fonction qui va ajouter un produit dans la base          **
   **********************************************************************/


   public function ajouterProduit($pDonneesAInserer)
   {        
      return $this->db->insert('ge_produit',$pDonneesAInserer);
   }

} // CLASSE