<?php
class ModelePersonne extends CI_Model 
{
   /* private $NoPersonne;
   private $Email;
   private $MotDePasse; */

   public function __construct()
   {
      $this->load->database();
   } 

   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /**************************                                                                              *************************************/
   /**************************                        SELECT () DE NOTRE TABLE GE_PRODUIT                   *************************************/
   /**************************                                                                              *************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/

   /**********************************************************************
   **                    Tous les champs de notre table                 **
   **********************************************************************/

   public function getPersonne()
   {
      $this->db->select('*');
      $this->db->from('ge_personne');      
      $this->db->join('ge_pers_parent','ge_pers_parent.NoPersonne=ge_personne.NoPersonne','left outer');   
      $maListe = $this->db->get(); 
      return $maListe->result(); 
   }
   public function getUnePersonne($noPersonne)
   {
      $this->db->select('*');
      $this->db->from('ge_personne'); 
      $this->db->where('NoPersonne', $noPersonne);      
      $Liste = $this->db->get();
      return $Liste->row(); 
   }

   /**********************************************************************
   **                      recherche Email existante                    **
   **********************************************************************/ 

   public function rechercherEmail($Email,$MotDePasse) 
   {
      $this->db->select('*');
      $this->db->from('ge_personne'); 
      $this->db->where('Email', $Email);
      $this->db->where('MotDePasse', $MotDePasse);
      $query = $this->db->get('utilisateur');
      if ($query->num_rows() > 0)
         {
            return true;
         }
         else  
         {
            return false;
         }
   }

   public function rechercherEmailPresent($Email) 
   {
      $this->db->select('*');
      $this->db->from('ge_personne'); 
      $this->db->where('Email', $Email);      
      $query = $this->db->get();
      if ($query->num_rows() > 0)
         {
            return true;
         }
         else  
         {
            return false;
         }
   }

   public function presenceMdp($Email) 
   {
      $this->db->select('MotDePasse');
      $this->db->from('ge_personne'); 
      $this->db->where('Email', $Email);      
      $query = $this->db->get();
      /* var_dump($query);
      die; */
      $mdp=$query->row();
      
      if (isset($mdp->MotDePasse) and $mdp!='' )
      {
         return true;
      }
      else  
      {
         return false;
      }
   }

   public function recherchePersonne($Email,$MotDePasse) 
   {
      $this->db->select('*');
      $this->db->from('ge_personne'); 
      $this->db->where('Email', $Email);
      $this->db->where('MotDePasse', $MotDePasse);
      $Liste = $this->db->get();
      return $Liste->row();     
   }
                   
   public function rechercheInfoPersonne($Email) 
   {
      $this->db->select('NoPersonne,Email,Nom,Prenom,Adresse,Ville,CodePostal,TelPortable,TelFixe,Actif,profil');
      $this->db->from('ge_personne'); 
      $this->db->where('Email', $Email);      
      $Liste = $this->db->get();
      return $Liste->row();     
   }
   public function getPersonneParent($noPersonne)
   {
      $this->db->select('*');
      $this->db->from('ge_pers_parent'); 
      $this->db->where('NoPersonne', $noPersonne);      
      $Liste = $this->db->get();
      return $Liste->row(); 
   }

   /**********************************************************************
   **                   Récupérer des données uniques                   **
   **********************************************************************/

   public function retourInfos($info)
   {
      $this->db->where('infos',$infos);
      $query=$this->db->get('ge_personne');
      return $query;
   }

   /**********************************************************************
   **       Renvoi la personne existante sous forme d'objet            **
   **********************************************************************/   

   public function retournerPersonne($pPersonne)
   {
      $requete = $this->db->get_where('ge_personne',$pPersonne);
      return $requete->row();
   } 

   public function maxPersonne()
   {
      $this->db->select_max('NoPersonne');
      $this->db->from('ge_personne');
      $query=$this->db->get();
      $ligne = $query->row();	    
      $noMax= $ligne->NoPersonne;	
      return $noMax;
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
   **        Modifier les informations de la table ge_personne          **
   **********************************************************************/

   public function modifierEtreCorrespondant($pDonneesAInserer)
   {
      $this->db->where('Etre_Correspondant', $pDonneesAInserer['Etre_Correspondant']);
      return $this->db->update('ge_pers_parent', $pDonneesAInserer);
   }

   public function modifierInfoPersonne($pDonneesAInserer)
   {   
      
      $this->db->where('Email',  $pDonneesAInserer['Email']);      
      return $this->db->update('ge_personne', $pDonneesAInserer);
   }

   public function modifierPersParent($donnees)
   {
     
      $this->db->where('NoPersonne',  $donnees['NoPersonne']);      
      return $this->db->update('ge_pers_parent', $donnees);
   }

   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /**************************                                                                              *************************************/
   /**************************                  INSERT () DE NOTRE TABLE GE_PERSONNE                        *************************************/
   /**************************                                                                              *************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   /*********************************************************************************************************************************************/
   
   /**********************************************************************
   **       Ajouter des informations sur la table ge_pers_parent        **
   **********************************************************************/ 

   public function insererInformationPersonneParent($donneesInsererPersonneParent)
   {
      return $this->db->insert('ge_pers_parent', $donneesInsererPersonneParent);
   }

   /**********************************************************************
   **       Ajouter des informations sur la table ge_pers_parent        **
   **********************************************************************/

   public function insererInformationPersonne($donneesInsererPersonne)
   {
      return $this->db->insert('ge_personne', $donneesInsererPersonne);
   }
} // Fin Classe