<?php
class ModelePersonne extends CI_Model 
{
   /*private $NoPersonne;
   private $Email;
   private $MotDePasse;*/

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


   /**********************************************************************
   **                    Requete pour 1 Utilisateur                     **
   **********************************************************************/


  /* public function getByNoPersonne($NoPersonne)
  {
     $limit=1;
     $offset=0;
     $requete = $this->db->get_where('ge_personne', array('NoPersonne' => $NoPersonne),$limit,$offset);
     return $this->db->query($requete)->result_array(); 
  } */


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
      // SELECT * FROM ge_personne WHERE Email = $Email AND MotDePasse = $MotDePasse
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
      // SELECT * FROM ge_personne WHERE Email = $Email AND MotDePasse = $MotDePasse
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
      // SELECT * FROM ge_personne WHERE Email = $Email AND MotDePasse = $MotDePasse
      $mdp=$query->row();
      if ($mdp->MotDePasse and $mdp!='')
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
      $this->db->select('Email,Nom,Prenom,Adresse,Ville,CodePostal,TelPortable,TelFixe');
      $this->db->from('ge_personne'); 
      $this->db->where('Email', $Email);      
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
   **                 Personne existante dans la db                     **
   **********************************************************************/


   /* public function existe($pPersonne)
   {
      $this->db->where($pPersonne);
      $this->db->from('ge_personne');
      return $this->db->count_all_results(); 
   } */
   

   /**********************************************************************
   **       Renvoi la personne existante sous forme d'objet            **
   **********************************************************************/   


   public function retournerPersonne($pPersonne)
   {
      $requete = $this->db->get_where('ge_personne',$pPersonne);
      return $requete->row();
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


   /* function majDonnees($Donnees,$infos)
   {
      $this->db->where('infos',$infos);
      $this->db->update('ge_personne',$Donnees);
   } */

   /**********************************************************************
   **        Modifier les informations de la table ge_personne          **
   **********************************************************************/


   public function modifierPersonne($pDonneesAInserer)
   {        
      $this->db->where('email', $pDonneesAInserer['Email']);
      $this->db->where('adress', $pDonneesAInserer['Adresse']);
      $this->db->where('vil', $pDonneesAInserer['Ville']);
      $this->db->where('cp', $pDonneesAInserer['CodePostal']);
      $this->db->where('telP', $pDonneesAInserer['TelPortable']);
      $this->db->where('telF', $pDonneesAInserer['TelFixe']);
      $this->db->where('mdp', $pDonneesAInserer['MotDePasse']);
      return $this->db->update('ge_personne', $pDonneesAInserer);
   }


   public function modifierInfoPersonne($pDonneesAInserer)
   {   
      $this->db->where('email',  $pDonneesAInserer['email']);      
      return $this->db->update('ge_personne', $pDonneesAInserer);
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