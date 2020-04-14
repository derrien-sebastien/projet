<?php
class ModelePers_Parent extends CI_Model 
{
    private $NoPersonne;
    private $Nom;
    private $Prenom;

    public function __construct()
    {
        $this->load->database();
    } 
}
?>