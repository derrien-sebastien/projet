<?php


	
if($NoEvenement==null)
{
    $NoEvenement=0;
}
if($Annee==null)
{
    $Annee=0;
}
if($this->input->post('submit'))//upload image
   {
    $LocalisationImage=$this->input->post('ImgProduit');
    $NomImageProduit=$this->uploadImage($LocalisationImage);			
}
if($this->input->post('submit'))//upload image
   {
    $LocalisationImage=$this->input->post('ImgTicket');
    $NomImageTicket=$this->uploadImage($LocalisationImage);
}	
$this->form_validation->set_rules('libelleHTML','libelleHTML','required');
$this->form_validation->set_rules('libelleCourt','libelleCourt','required');
$this->form_validation->set_rules('prix','prix','required');
$this->form_validation->set_rules('stock','stock');
$this->form_validation->set_rules('numeroOrdreApparition','numeroOrdreApparition','required');
$this->form_validation->set_rules('etreTicket','etreTicket');
if ($this->form_validation->run() === FALSE)
{	
    $DonneesInjectees['Provenance']=$Provenance;
    $this->load->view('templates/EntetePrincipal');
    $this->load->view('templates/EnteteNavbar');
    if($Provenance==='Ajouter')
    {
        $DonneesInjectees['LesProduits']=$this->ModeleProduit->getProduitGeneral(AnneeEnCour);
        $DonneesInjectees['LesProduits']=$DonneesInjectees['LesProduits']+$this->ModeleProduit->getProduitGeneral(AnneeEnCour-1);
        $DonneesInjectees['LesProduits']=$DonneesInjectees['LesProduits']+$this->ModeleProduit->getProduitGeneral(AnneeEnCour-2);
        $this->load->view('administrateur/vueSelectionProduits',$DonneesInjectees);
        //$this->load->view('templates/PiedDePagePrincipal');
    }
    $this->load->view('administrateur/vueFormulaireProduit',$DonneesInjectees);	
    //$this->load->view('templates/PiedDePagePrincipal');		
}
else
{
    if ($NomImageProduit===0)
    {				
        $NomImageProduit=$this->input->post('ImgProduit');
    }
    if ($NomImageTicket===0)
    {
        $NomImageTicket=$this->input->post('ImgTicket');
    }
    if(isset($_POST['SupImgProduit']))//si on a coché supprimer l'image 
    {
        $NomImageProduit=null;//l'image est mise a nul
    }
    if(isset($_POST['SupImgTicket']))//si on a coché supprimer l'image 
    {
        $NomImageTicket=null;//l'image est mise a nul
    }
    if($Provenance==='Ajouter')
    {
    $noMax = $this->ModeleProduit-> maxProduit();
    $NoProduit=$noMax+1;
    }
    elseif($Provenance=='Modifier')
    {
        //$NoProduit=$this->
    }
    $donneesAInserer = array(
    'NoEvenement'=>$NoEvenement,
    'Annee'=>$Annee,			
    'NoProduit'=>$NoProduit,
    'libelleHTML'=>$this->input->post('libelleHTML'),
    'libelleCourt'=>$this->input->post('libelleCourt'),
    'prix'=>$this->input->post('prix'),
    'ImgProduit'=>$NomImageProduit,
    'stock'=>$this->input->post('stock'),
    'numeroOrdreApparition'=>$this->input->post('numeroOrdreApparition'),
    'etre_Ticket'=>$this->input->post('etreTicket'),
    'ImgTicket'=>$NomImageTicket
     );	
     if($Provenance==='Ajouter')
    {		 
        $this->ModeleProduit->ajouterProduit($donneesAInserer);
    }
    elseif($Provenance=='Modifier')
    {
        $this->ModeleProduit->modifierProduit($donneesAInserer);
    }	
    $this->load->view('templates/EntetePrincipal');
    $this->load->view('templates/EnteteNavbar');
    $this->load->view('administrateur/vueFormulaireProduit');// a supprimer
    //$this->load->view('templates/PiedDePagePrincipal');
}

