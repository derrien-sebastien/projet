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

    public function commandeParEvenement($envenement,$annee)
    {
        $this->db->select('*');
        $this->db->from('ge_personne');
        $this->db->join('ge_commande','ge_personne.NoPersonne = ge_commande.NoPersonne');
        $this->db->join('ge_contenir','ge_commande.NoCommande = ge_contenir.NoCommande');
        $this->db->join('ge_produit','ge_produit.NoProduit=ge_contenir.NoProduit AND ge_produit.Noevenement=ge_contenir.Noevenement AND ge_produit.annee=ge_contenir.annee' );
        $this->db->where('ge_contenir.NoEvenement',$envenement);
        $this->db->where('ge_contenir.annee',$annee);
        $this->db->order_by('ge_personne.NoPersonne');
        $maListe = $this->db->get(); 
        return $maListe->result();
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
        return $this->db->insert('ge_commande',$pDonneesAInserer);
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

    public function modifierPaye($pDonneesAInserer)//modifier le nom de la fonction
    {          
       $this->db->where('NoCommande', $pDonneesAInserer['NoCommande']);
       return $this->db->update('ge_commande', $pDonneesAInserer);
    }

}