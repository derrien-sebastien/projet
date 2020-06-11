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

   public function retournerUnEvenement ($NoEvenement=NULL, $Annee=NULL)
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

   public function retournerEvenements($pNoEvenement = FALSE)
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
      $this->db->where('ge_evenement.EnCours',1); 
      $this->db->order_by('ge_evenement.Annee','DESC');
      $this->db->order_by('ge_evenement.NoEvenement','DESC');
      $evMarchand = $this->db->get();
      return $evMarchand->result(); 
   } 
   
   /***************************************************************************************************
   ** retourner les évènements marchands de notre table ge_evenement en fonction de l'annee et du n° **
   ***************************************************************************************************/

   public function getEvenementMarchand($Annee,$NoEvenement)
   {
      $this->db->select('*');
      $this->db->from('ge_evenement');
      $this->db->join('ge_ev_marchand','ge_evenement.NoEvenement=ge_ev_marchand.NoEvenement AND ge_evenement.Annee=ge_ev_marchand.Annee');
      $this->db->where('ge_ev_marchand.Annee', $Annee);
      $this->db->where('ge_ev_marchand.NoEvenement', $NoEvenement);
      $this->db->order_by('ge_evenement.Annee','DESC');
      $this->db->order_by('ge_evenement.NoEvenement','DESC');
      $maListe = $this->db->get();
      return $maListe->row();
   }
   public function nbEvenementMarchand($Annee)
   {
      $this->db->select('COUNT(*) as NombreDEvenement');
      $this->db->from('ge_evenement');
      $this->db->join('ge_ev_marchand','ge_evenement.NoEvenement=ge_ev_marchand.NoEvenement AND ge_evenement.Annee=ge_ev_marchand.Annee');
      $this->db->where('ge_ev_marchand.Annee', $Annee);;
      $maListe = $this->db->get();
      return $maListe->row();
   }

   public function presenceEvenement($donnees)
   {
      $this->db->select('*');
      $this->db->from('ge_evenement');      
      $this->db->where('ge_evenement.Annee', $donnees['Annee']);
      $this->db->where('ge_evenement.NoEvenement', $donnees['NoEvenement']);    
      $maListe = $this->db->get();
      if ($maListe->num_rows() > 0)
      {
         return true;
      }
      else  
      {
         return false;
      }
   }

   public function presenceEvenementMarchand($Annee,$NoEvenement)
   {
      $this->db->select('*');
      $this->db->from('ge_ev_marchand');      
      $this->db->where('ge_ev_marchand.Annee', $Annee);
      $this->db->where('ge_ev_marchand.NoEvenement', $NoEvenement);    
      $maListe = $this->db->get();
      if ($maListe->num_rows() > 0)
      {
         return true;
      }
      else  
      {
         return false;
      }
   }

   public function presenceEvenementNonMarchand($Annee,$NoEvenement)
   {
      $this->db->select('*');
      $this->db->from('ge_ev_non_marchand');
      $this->db->where('ge_ev_non_marchand.Annee', $Annee);
      $this->db->where('ge_ev_non_marchand.NoEvenement', $NoEvenement); 
      $maListe = $this->db->get();
      if ($maListe->num_rows() > 0)
      {
         return true;
      }
      else  
      {
         return false;
      }
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
      $this->db->order_by('ge_evenement.Annee','DESC');
      $this->db->order_by('ge_evenement.NoEvenement','DESC');
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

   /**********************************************************************
    **        fonction qui va modifier un évenement dans la base         **
    **********************************************************************/

   public function modifierEvenement($pDonneesAInserer)
   {        
      $this->db->where('annee', $pDonneesAInserer['Annee']);
      $this->db->where('noEvenement', $pDonneesAInserer['NoEvenement']);
      return $this->db->update('ge_evenement', $pDonneesAInserer);
   }

     public function modifierEvenementMarchand($pDonneesAInserer)
   {        
      $this->db->where('annee', $pDonneesAInserer['Annee']);
      $this->db->where('noEvenement', $pDonneesAInserer['NoEvenement']);
      return $this->db->update('ge_ev_marchand', $pDonneesAInserer);
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

   public function ajouterEvenementMarchand($pDonneesAInserer)
	{        
		return $this->db->insert('ge_ev_marchand',$pDonneesAInserer);
   }

   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /**************************                                                                              *************************************/
   /**************************                    DROP () DE NOTRE TABLE GE_EVENEMENT                       *************************************/
   /**************************                                                                              *************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/

   public function deleteEvenementNonMarchand($donnees)
   {
      $this->db->where('ge_ev_non_marchand.Annee', $donnees['Annee']);
      $this->db->where('ge_ev_non_marchand.NoEvenement', $donnees['NoEvenement']);
      return $this->db->delete('ge_ev_non_marchand');
   }

} // Fin Classe
