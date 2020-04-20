<?php

class ModeleEnfant extends CI_Model

{


	/**********************************************************************
	**                           Constructeur                            **
	**********************************************************************/

	public function __construct()
	{
	    $this->load->database();
    }


	/*********************************************************************************************************************************************/
	/*********************************************************************************************************************************************/
	/*********************************************************************************************************************************************/
	/**************************                                                                              *************************************/
	/**************************                    SELECT () DE NOTRE TABLE GE_ENFANT                        *************************************/
	/**************************                                                                              *************************************/
	/*********************************************************************************************************************************************/
	/*********************************************************************************************************************************************/
	/*********************************************************************************************************************************************/
	public function enfant($email) 
   	{
		$this->db->select('ge_enfant.Nom as NomEnfant, ge_enfant.Prenom as PrenomEnfant,ge_enfant.DateNaissance, ge_classe.Nom as NomClasse, ge_enfant.NoEnfant');
		$this->db->from('ge_personne');
		$this->db->join('ge_pers_parent','ge_pers_parent.NoPersonne=ge_personne.NoPersonne');
		$this->db->join('ge_scolariser','ge_personne.NoPersonne = ge_scolariser.NoPersonne');
		$this->db->join('ge_enfant','ge_enfant.NoEnfant = ge_scolariser.NoEnfant');
		$this->db->join('ge_appartenir','ge_appartenir.NoEnfant = ge_enfant.NoEnfant');
		$this->db->join('ge_classe','ge_classe.NoClasse = ge_appartenir.NoClasse');
		$this->db->where('ge_personne.Email', $email);
		$maListe = $this->db->get(); 		
      	return $maListe->result();
	}

	public function personne($noEnfant)
	{
		$this->db->select('ge_personne.Nom as NomParent,ge_personne.Prenom as PrenomParent');
		$this->db->from('ge_personne');
		$this->db->join('ge_scolariser','ge_personne.NoPersonne = ge_scolariser.NoPersonne');
		$this->db->where('ge_scolariser.NoEnfant', $noEnfant);
		$maListe = $this->db->get();
      	return $maListe->result();

	}

	public function getEnfant($nom,$prenom)
	{
		$this->db->select('*');
		$this->db->from('ge_enfant');
		$this->db->where('nom', $nom);
		$this->db->where('prenom', $prenom);
		$maListe = $this->db->get(); 
      	return $maListe->result();
	}
	public function getEnfants()
	{
		$this->db->select('*');
		$this->db->from('ge_enfant');		
		$maListe = $this->db->get(); 
      	return $maListe->result();
	}

	public function getScolariser($noEnfant,$noPersonne)
	{
		$this->db->select('*');
		$this->db->from('ge_scolariser');
		$this->db->where('noEnfant', $noEnfant);
		$this->db->where('noPersonne', $noPersonne);
		$maListe = $this->db->get(); 
      	return $maListe->row();
	}

	public function enfantSansCorrespondant()
	{
		$this->db->select('ge_enfant.NoEnfant');
		$this->db->from('ge_enfant');
		$this->db->join('ge_scolariser','ge_enfant.Noenfant = ge_scolariser.NoEnfant');
		$this->db->join('ge_pers_parent','ge_pers_parent.NoPersonne = ge_scolariser.NoPersonne');
		$this->db->where('Etre_Correspondant', 1);
		$maListe = $this->db->get(); 
		$enfantsAvecCorrespondant=$maListe->result();
		var_dump($enfantsAvecCorrespondant);
		$i=0;
		foreach($enfantsAvecCorrespondant as $enfantAc)
		{
			$enfantsAC[$i]=$enfantAc->NoEnfant;
			$i=$i+1;
		}
		$this->db->select('*');
		$this->db->from('ge_enfant');
		$this->db->where_not_in('NoEnfant', $enfantsAC);
		$query=$this->db->get();
		return $query->result();
		
		
	}
	public function getEnfantClasse($classe)
	{
		$this->db->select('*');
		$this->db->from('ge_enfant');
		$this->db->join('ge_appartenir','ge_enfant.NoEnfant=ge_appartenir.NoEnfant');
		$this->db->where('ge_appartenir.DateFin',NULL);
		$this->db->where('ge_appartenir.NoClasse',$classe);
		$query=$this->db->get();
		return $query->result();
	}
/*public function getEnfantClasse($classe) a modifier where numero enfant $query row
	{
		$this->db->select('*');
		$this->db->from('ge_enfant');
		$this->db->join('ge_appartenir','ge_enfant.NoEnfant=ge_appartenir.NoEnfant');
		$this->db->where('ge_appartenir.DateFin',NULL);
		$this->db->where('ge_appartenir.NoClasse',$classe);
		$query=$this->db->get();
		return $query->result();
	}*/


	/*********************************************************************************************************************************************/
	/*********************************************************************************************************************************************/
	/*********************************************************************************************************************************************/
	/**************************                                                                              *************************************/
	/**************************                     INSERT () DE NOTRE TABLE GE_ENFANT                       *************************************/
	/**************************                                                                              *************************************/
	/*********************************************************************************************************************************************/
	/*********************************************************************************************************************************************/
	/*********************************************************************************************************************************************/



	/*********************************************************************************************************************************************/
	/*********************************************************************************************************************************************/
	/*********************************************************************************************************************************************/
	/**************************                                                                              *************************************/
	/**************************                     UPDATE () DE NOTRE TABLE GE_ENFANT                       *************************************/
	/**************************                                                                              *************************************/
	/*********************************************************************************************************************************************/
	/*********************************************************************************************************************************************/
	/*********************************************************************************************************************************************/
	public function insetScolariser($donnees)
	{
		return $this->db->insert('ge_scolariser', $donnees);
	}

    
}