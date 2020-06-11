<?php

class ModeleCommande extends CI_Model

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
    /**************************                     SELECT () DE NOTRE TABLE GE_COMMANDE                     *************************************/
    /**************************                                                                              *************************************/
    /*********************************************************************************************************************************************/
    /*********************************************************************************************************************************************/
    /*********************************************************************************************************************************************/
    public function commandeClient($pNoEven, $pAnnee)
    {
        $this->db->Select('cont.Quantite,cont.Remis,cont.NoProduit,comm.NoPersonne,comm.Payer,comm.NoCommande,comm.MontantTotal,comm.ResteAPayer,pers.Email,pers.Nom,pers.Prenom,prod.LibelleCourt');
        $this->db->from('ge_contenir as cont');
        $this->db->join('ge_commande as comm','cont.NoCommande = comm.NoCommande');
        $this->db->join('ge_personne as pers','comm.NoPersonne = pers.NoPersonne');
        $this->db->join('ge_produit as prod','cont.NoProduit = prod.NoProduit AND cont.NoEvenement=prod.NoEvenement AND cont.Annee=prod.Annee');//+AND
        $this->db->where('cont.NoEvenement',$pNoEven);
        $this->db->where('cont.Annee',$pAnnee);
        $this->db->order_by('cont.NoProduit');
        $this->db->order_by('pers.Email');
        $query=$this->db->get();
        return $query->result();
    }
    public function commandeDunClient($pNoPersonne)
    {
        $this->db->Select('cont.Quantite,cont.NoProduit,prod.LibelleCourt,comm.ModePaiement,comm.NoPersonne,comm.Payer,comm.NoCommande,comm.MontantTotal,comm.ResteAPayer,pers.Email,pers.Nom,pers.Prenom');
        $this->db->from('ge_commande as comm');
        $this->db->join('ge_contenir  as cont','comm.NoCommande = cont.NoCommande');
        $this->db->join('ge_personne as pers','comm.NoPersonne = pers.NoPersonne');
        $this->db->join('ge_produit as prod','cont.NoProduit = prod.NoProduit AND cont.NoEvenement=prod.NoEvenement AND cont.Annee=prod.Annee');//+AND
        $this->db->where('comm.NoPersonne',$pNoPersonne);
        $query=$this->db->get();
        return $query->row();
    }
    public function nbCommandeClient($pNoEven, $pAnnee)
    {
        $this->db->Select('COUNT(*) as nbLignes');
        $this->db->from('ge_contenir as cont');
        $this->db->join('ge_commande as comm','cont.NoCommande = comm.NoCommande');
        $this->db->join('ge_personne as pers','comm.NoPersonne = pers.NoPersonne');
        $this->db->join('ge_produit as prod','cont.NoProduit = prod.NoProduit AND cont.NoEvenement=prod.NoEvenement AND cont.Annee=prod.Annee');//+AND
        $this->db->where('cont.NoEvenement',$pNoEven);
        $this->db->where('cont.Annee',$pAnnee);
        $query=$this->db->get();
        return $query->result();
    }
    public function commandeParEvenement($pNoEvenement,$annee)
    {
        $this->db->select('*');
        $this->db->from('ge_personne');
        $this->db->join('ge_commande','ge_personne.NoPersonne = ge_commande.NoPersonne');
        $this->db->join('ge_contenir','ge_commande.NoCommande = ge_contenir.NoCommande');
        $this->db->join('ge_produit','ge_produit.NoProduit=ge_contenir.NoProduit AND ge_produit.Noevenement=ge_contenir.Noevenement AND ge_produit.annee=ge_contenir.annee' );
        $this->db->where('ge_contenir.NoEvenement',$pNoEvenement);
        $this->db->where('ge_contenir.Annee',$annee);
        $this->db->order_by('ge_personne.NoPersonne');
        $maListe = $this->db->get(); 
        return $maListe->result();
    }

    public function getUneCommande($noCommande)
    {
        $this->db->select('*');
        $this->db->from('ge_commande');
        $this->db->join('ge_contenir','ge_contenir.NoCommande = ge_commande.NoCommande');
        $this->db->where('ge_commande.NoCommande',$noCommande);
        $this->db->order_by('ge_contenir.NoEvenement');
        $liste=$this->db->get();
        return $liste->result();
    }
    public function getUneLigneCommande($noCommande,$noProduit)
    {
        $this->db->select('*');
        $this->db->from('ge_contenir');
        $this->db->where('ge_contenir.NoCommande',$noCommande);
        $this->db->where('ge_contenir.NoProduit',$noProduit);
        $this->db->order_by('ge_contenir.NoEvenement');
        $liste=$this->db->get();
        return $liste->row_array();
    }
    public function commandesEmail($email)
    {
        $this->db->select('*');
        $this->db->from('ge_commande');
        $this->db->join('ge_personne','ge_personne.NoPersonne = ge_commande.NoPersonne');        
        $this->db->where('ge_personne.Email',$email);
        $this->db->order_by('ge_commande.NoCommande','DESC');        
        $liste=$this->db->get();
        return $liste->result();
    }
    public function lastCommande($email)
    {
        $this->db->select_max('NoCommande');
        $this->db->from('ge_commande');
        $this->db->join('ge_personne','ge_personne.NoPersonne = ge_commande.NoPersonne');        
        $this->db->where('ge_personne.Email',$email);
        $query=$this->db->get();
        return $query->row();	    
    }

    public function maxCommande()
    {
        $this->db->select_max('NoCommande');
        $this->db->from('ge_commande');
        $query=$this->db->get();
        $ligne = $query->row();	    
        $noMax= $ligne->NoCommande;	
        return $noMax;
    }

    public function getContenir($pNoCommande)
    {
        $this->db->select('*');
        $this->db->from('ge_contenir');
        $this->db->where('ge_contenir.NoCommande', $pNoCommande);
        $query=$this->db->get();	    
        return $query->result();
    }
    public function getNbProduit($NoEvenement,$annee)
    {
        $this->db->select('COUNT(*) as nbProduit, LibelleCourt');
        $this->db->from('ge_contenir');
        $this->db->join('ge_produit','ge_produit.NoProduit=ge_contenir.NoProduit AND ge_produit.NoEvenement=ge_contenir.NoEvenement AND ge_produit.annee=ge_contenir.annee' );
        $this->db->where('ge_contenir.NoEvenement',$NoEvenement);
        $this->db->where('ge_contenir.Annee',$annee);
        $this->db->group_by('LibelleCourt');
        $query=$this->db->get();	    
        return $query->result();
    }
    public function MontantTotalParEvenement($NoEvenement,$annee)
    {
        $this->db->select_sum('MontantTotal' , 'MontantDesCommandes');
        $this->db->from('ge_commande');
        $this->db->join('ge_contenir','ge_contenir.NoCommande = ge_commande.NoCommande');
        $this->db->where('ge_contenir.NoEvenement',$NoEvenement);
        $this->db->where('ge_contenir.Annee',$annee);
        $query=$this->db->get();	    
        return $query->row();        
    }
    public function MontantPayeParEvenement($NoEvenement,$annee)
    {
        $this->db->select_sum('Payer' , 'MontantPaye');
        $this->db->from('ge_commande');
        $this->db->join('ge_contenir','ge_contenir.NoCommande = ge_commande.NoCommande');
        $this->db->where('ge_contenir.NoEvenement',$NoEvenement);
        $this->db->where('ge_contenir.Annee',$annee);
        $query=$this->db->get();	    
        return $query->row();        
    }
    /*********************************************************************************************************************************************/
    /*********************************************************************************************************************************************/
    /*********************************************************************************************************************************************/
    /**************************                                                                              *************************************/
    /**************************                    INSERT () DE NOTRE TABLE GE_COMMANDE                      *************************************/
    /**************************                                                                              *************************************/
    /*********************************************************************************************************************************************/
    /*********************************************************************************************************************************************/
    /*********************************************************************************************************************************************/


    /**********************************************************************
    **                              ajouter                              **
    **********************************************************************/

    public function creerCommande($nom,$rue,$cp,$ville,$mail, $lesIdProduit )
    {
        $this->db->select_max('NoCommande','maxId');
        $query = $this->db->get('ge_commande');
        $tab = $query->result();
        $idCommande= $tab[0]->maxId +1;
        $dateA = date('Y/m/d');
        $dateF = date('d/m/Y');
        $commande = array(
            'NoCommande'        => $idCommande,
            'DateCommande'      => $dateA,
            'nomPrenomClient'   => $nom,
            'adresseRueClient'  => $rue,
            'cpClient'          => $cp,
            'villeClient'       => $ville,
            'mailClient'        => $mail
        );
        $this->db->insert('ge_commande', $commande); 
        foreach($lesIdProduit as $unIdProduit)  
        {
            $ligneCde = array(
                'idCommande'    => $idCommande,
                'idProduit'     => $unIdProduit,
                'quantite'      => 1
            );
            $this->db->insert('Contenir', $ligneCde); 
        }
        return array($dateF,$idCommande);	
    }

    public function ajouterCommande($pDonneesAInserer)
    {        
        $this->db->insert('ge_commande',$pDonneesAInserer);
        return $this->db->insert_id();
    }

    public function insererContenir($pDonneesAInserer)
    {
        return $this->db->insert('ge_contenir', $pDonneesAInserer);
    }


    /*********************************************************************************************************************************************/
    /*********************************************************************************************************************************************/
    /*********************************************************************************************************************************************/
    /**************************                                                                              *************************************/
    /**************************                   UPDATE () DE NOTRE TABLE GE_COMMANDE                       *************************************/
    /**************************                                                                              *************************************/
    /*********************************************************************************************************************************************/
    /*********************************************************************************************************************************************/
    /*********************************************************************************************************************************************/

    public function modifierRemis($pDonneesAInserer)
    {        
       $this->db->where('Annee', $pDonneesAInserer['Annee']);
       $this->db->where('NoEvenement', $pDonneesAInserer['NoEvenement']);
       $this->db->where('NoCommande', $pDonneesAInserer['NoCommande']);
       $this->db->where('NoProduit', $pDonneesAInserer['NoProduit']);
       return $this->db->update('ge_contenir', $pDonneesAInserer);
    }
    public function modifierContenir($pDonneesAInserer)
    {        
       
       $this->db->where('NoCommande', $pDonneesAInserer['NoCommande']);
       $this->db->where('NoProduit', $pDonneesAInserer['NoProduit']);
       return $this->db->update('ge_contenir', $pDonneesAInserer);
    }
    public function modifierPaye($pDonneesAInserer)//modifier le nom de la fonction
    {          
       $this->db->where('NoCommande', $pDonneesAInserer['NoCommande']);
       return $this->db->update('ge_commande', $pDonneesAInserer);
    }

}