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

	Controlleur 
		function indexP()
		{
			$data['produits'] = $this->ModeleProduit->get_all_produit()
			$this->load->view('produits',$data);
		}

		function ajout()
		{
			$produit = $this->ModeleProduit->get($this->input->post('NoProduit'));
			$insert = array(
							'NoProduit' => $this->input->post('NoProduit'),
							'qty' => 1,
							'price' => $produit->Prix,
							'name' => $produit->LibelleCourt
							);
			if($produit->option_name)
			{
				$insert['options'] = array(
				$produit->option_name => $produit->option_values[$this->input->post($produit->option_name)]
				);
			}
			$this->cart->insert($insert);
			redirect('shop');
		}

		function maj($rowid)
		{
			$data = array(
		 					'rowid'=> $rowid,
		 					'qty'=>3
						);
			$this->cart->update($data);
    	}

		function enlever($rowid)
		{
			$data = array(
		     				'rowid'=> $rowid,
		     				'qty'=>0
		 				);
			$this->cart->update($data);
			redirect('shop');
		}   

   		function destroy()
   		{
       		$this->cart->destroy();
   		}

	Model

	function getall()
	{
		$results = $this->db->get('ge_produit')->result();
		foreach ($results as &$result) 
		{
			if ($result->option_values) 
			{
				$result->option_values = explode(',', $result->option_values);
			}
		}
		return $results;
	}
	function get($id)
	{
        $results = $this->db->get_where('ge_produit',array('NoProduit'=>$id))->result();
        $results = $results[0];  
		if($results->option_value)
		{
                $results->option_value = explode(',',$results->option_value);
        }
		return $results;
    }

	Vue

	<style type="text/css">
			.products
		{
			float: left;
		}
		.cart 
		{
			float: left;
		}
	</style>
	<div class="produits">
	<ul>
		<?php foreach($produits as $produit) : ?>
		<li>
			<?php echo form_open('visiteur/ajout'); ?>
			<div class="name"><?php echo $produit->LibelleCourt; ?></div>
			<div class="thumb"><?php echo img(array('src' => 'images/'.$produit->Img_Produit)) ?></div>
			<div class="price"><?php echo $produit->Prix ?></div>
			<div class="option">
			<?php if($produit->option_name) : ?>
				<?php echo form_label($produit->option_name, 'option_'.$produit->id); ?>
				<?php echo form_dropdown($produit->option_name, $produit->option_values,NULL,'id="option_'.$produit->id.'"'); ?>
			<?php endif; ?>
			</div>
			<?php echo form_hidden('NoProduit', $produit->NoProduit); ?>
			<?php echo form_submit('action', 'Ajouter au panier'); ?>
			<?php echo form_close(); ?>
		</li>
	<?php endforeach; ?>
	</ul>
</div>

<?php if($cart = $this->cart->contents()) : ?>
<div class="cart">
	<table>
		<caption>Cart Items</caption>
		<thead>
			<tr>
				<th>Item Name</th>
				<th>Option</th>
				<th>Price</th>
				<th></th>
			</tr>
		</thead>
	<?php foreach($cart as $item): ?>
		<tr>
			<td><?php echo $item['name']; ?></td>
			<td>
				<?php 
                    if($this->cart->has_options($item['rowid']))
                    {
                        foreach($this->cart->product_options($item['rowid']) as $option => $value)
                        {
                            echo $option . ": <em>". $value . "</em>";
                        }
                    }
                ?>
			</td>
			<td>$<?php echo $item['subtotal']; ?></td>
			<td><?php echo anchor('visiteur/enlever/'.$item['rowid'],'X'); ?></td>
		</tr>
	<?php endforeach; ?>
		<tr>
			<td colspan="2"><strong>Total</strong></td>
			<td>$<?php echo $this-> cart->total(); ?></td>
		</tr>
	</table>
</div>
<?php endif; ?>
