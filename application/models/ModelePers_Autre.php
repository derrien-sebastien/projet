<?php
class ModelePers_Autre extends CI_Model 
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