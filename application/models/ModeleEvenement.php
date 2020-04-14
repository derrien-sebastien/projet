<?php

class ModeleEvenement extends CI_Model 

{

   /*********************************************************************
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
   /**************************                  SELECT () DE NOTRE TABLE GE_EVENEMENT                       *************************************/
   /**************************                                                                              *************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/


   /*********************************************************************
   **                       Table Evenement                            **
   **********************************************************************/
  public function getEvMarchParent()
  {
     $this->db->select('*');
     $this->db->from('ge_evenement');
     $this->db->join('ge_ev_marchand','ge_evenement.NoEvenement=ge_ev_marchand.NoEvenement AND ge_evenement.Annee=ge_ev_marchand.Annee AND ge_personne.NoPersonne=ge_scolariser.NoPersonne AND ge_enfant.NoEnfant=ge_scolariser.Noenfant');
     $this->db->where('ge_evenement.EnCours','1'); 
     $this->db->order_by('ge_evenement.NoEvenement','ge_evenement.Annee','asc');
     $maListe = $this->db->get();
     var_dump($maListe);
     return $maListe->result(); 
  } 

   public function getEvenement()
   {
      $this->db->select('*');
      $this->db->from('ge_evenement');   
      $maListe = $this->db->get();
      return $maListe->result(); 
   }


   /**********************************************************************
   **    Fonction qui va retourner tout les évènements d'une année     **
   **********************************************************************/


   public function getEvenementGeneral($pAnnee)
   {
      $this->db->select('*');
      $this->db->from('ge_evenement');   
      $this->db->where('ge_evenement.Annee', $pAnnee);
      $maListe = $this->db->get();
      return $maListe->result(); 
   } 


   /*********************************************************************************************
   ** retourner les évènements de notre table ge_evenement en fonction du numero et de l'année **
   **********************************************************************************************/


   public function retournerUnEvenement ($NoEvenement, $Annee)
   {
      $this->db->select('*');
      $this->db->from('ge_evenement');   
      $this->db->where('ge_evenement.NoEvenement', $NoEvenement);
      $this->db->where('ge_evenement.Annee', $Annee);
      $maListe = $this->db->get();
      return $maListe->row(); 
   }


   /*********************************************************************************************
   **             retourner les évènements En Cours de notre table ge_evenement                **
   **********************************************************************************************/


   public function retournerEvenements()
   {
      if ($pNoEvenement === FALSE)
         {
            $this->db->select('*');
            $this->db->from('ge_evenement');   
            $this->db->where('ge_evenement.EnCours', 1);
            $maListe = $this->db->get();
            return $maListe->result_array();
         }
         $maListe = $this->db->get_where('ge_evenement', array('NoEvenement' => $pNoEvenement));
         return $maListe->row_array();
   } 


   /****************************************************************************
   ** retourner les évènements marchands EN COURS de notre table ge_evenement **
   ****************************************************************************/


   public function retournerEvenementsMarchands()//parametre a mettre en cours pour les ev marchands
   {
      $this->db->select('*');
      $this->db->from('ge_evenement');
      $this->db->join('ge_ev_marchand','ge_evenement.NoEvenement=ge_ev_marchand.NoEvenement AND ge_evenement.Annee=ge_ev_marchand.Annee');
      $this->db->where('ge_evenement.EnCours','1'); 
      $this->db->order_by('ge_evenement.NoEvenement','ge_evenement.Annee','asc');
      $evMarchand = $this->db->get();
      return $evMarchand->result(); 
   } 
   

   
   /***************************************************************************************************
   ** retourner les évènements marchands de notre table ge_evenement en fonction de l'annee et du n° **
   ***************************************************************************************************/


   public function getEvenementMarchand($Annee,$NoEvenement)
   {
        $this->db->select('*');
        $this->db->from('ge_ev_marchand');   
        $this->db->where('ge_ev_marchand.Annee', $Annee);
        $this->db->where('ge_ev_marchand.NoEvenement', $NoEvenement);
        $maListe = $this->db->get();
        return $maListe->result();
   }


   /********************************************************************************
   ** retourner les évènements Non marchands EN COURS de notre table ge_evenement **
   *********************************************************************************/


   public function retournerEvenementsNonMarchands()
   {
      $this->db->select('*');
      $this->db->from('ge_evenement');
      $this->db->join('ge_ev_non_marchand','ge_evenement.NoEvenement=ge_ev_non_marchand.NoEvenement AND ge_evenement.Annee=ge_ev_non_marchand.Annee');
      $this->db->where('ge_evenement.EnCours','1'); 
      $this->db->order_by('ge_evenement.NoEvenement','ge_evenement.Annee','asc');
      $evNonMarchand = $this->db->get();
      return $evNonMarchand->result(); 
   } 


   /*******************************************************************************************************
   ** retourner les évènements non marchands de notre table ge_evenement en fonction de l'annee et du n° **
   ********************************************************************************************************/


   public function getEvenementNonMarchand($Annee,$NoEvenement)
   {
      $this->db->select('*');
      $this->db->from('ge_ev_non_marchand');   
      $this->db->where('ge_ev_non_marchand.Annee', $Annee);
      $this->db->where('ge_ev_non_marchand.NoEvenement', $NoEvenement);
      $maListe = $this->db->get();
      return $maListe->result();
   }




   /**********************************************************************
   **           Fonction qui va retourner le numéro max                **
   **********************************************************************/


   public function maxEvenement()
	{
	   $this->db->select_max('NoEvenement');
	   $query=$this->db->get('ge_evenement');
      $ligne = $query->row();	    
	   $noMax= $ligne->NoEvenement;	
	   return $noMax;	
   }


   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /**************************                                                                              *************************************/
   /**************************                  UPDATE () DE NOTRE TABLE GE_EVENEMENT                       *************************************/
   /**************************                                                                              *************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/


   /*********************************************************************
   **                           Nos Updates                            **
   **********************************************************************/


   /* public function setEnCours($NoEvenement,$Annee,$EnCours)
   {
      $this->db->set('EnCours',$EnCours);
      $this->db->where('NoEvenement',$NoEvenement and'Annee',$Annee);
      $this->db->update('ge_evenement');   
      $query= $this->db->get();
      return $query->result();
   } */


   /**********************************************************************
    **        fonction qui va modifier un évenement dans la base         **
    **********************************************************************/

   public function modifierEvenement($pDonneesAInserer)
   {        
      $this->db->where('annee', $pDonneesAInserer['Annee']);
      $this->db->where('noEvenement', $pDonneesAInserer['NoEvenement']);
      return $this->db->update('ge_evenement', $pDonneesAInserer);
   }

   


   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /**************************                                                                              *************************************/
   /**************************                  INSERT () DE NOTRE TABLE GE_EVENEMENT                       *************************************/
   /**************************                                                                              *************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
 

   /**********************************************************************
   **        fonction qui va ajouter un évenement dans la base          **
   **********************************************************************/


   public function ajouterEvenement($pDonneesAInserer)
   {        
	   return $this->db->insert('ge_evenement',$pDonneesAInserer);
   }

   
   /**********************************************************************
   **  fonction qui va ajouter un évenement dans la table non marchand  **
   **********************************************************************/


   public function ajouterEvenementNonMarchand($pDonneesAInserer)
	{        
		return $this->db->insert('ge_ev_non_marchand',$pDonneesAInserer);
   }




} // Fin Classe
