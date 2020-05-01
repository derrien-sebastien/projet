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


    /* public function obtenirCommande($id)
    {
    $this->db->select('*');
    $this->db->from('ge_commande');
    $this->db->join('ge_personne', 'ge_personne.NoPersonne = ge_commande.NoPersonne');
    $this->db->where('ge_personne.NoPersonne', $id);
    $query = $this->db->get();
    $result = $query->row_array();
    // Get order items
    $this->db->select('i.*, p.image, p.name, p.price');
    $this->db->from($this->ordItemsTable.' as i');
    $this->db->join($this->proTable.' as p', 'p.id = i.product_id', 'left');
    $this->db->where('i.order_id', $id);
    $query2 = $this->db->get();
    $result['items'] = ($query2->num_rows() > 0)?$query2->result_array():array();
    return !empty($result)?$result:false;
    } */
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

    public function modifierPaye($pDonneesAInserer)
    {          
       $this->db->where('NoCommande', $pDonneesAInserer['NoCommande']);
       return $this->db->update('ge_commande', $pDonneesAInserer);
    }

}