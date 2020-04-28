<?php

		// a verifier
		if($this->input->post('submit'))//upload image entete
        {	
			$LocalisationImage=$this->input->post('txtImgEntete');
			$NomImageEntete=$this->uploadImage($LocalisationImage);						
		}		 
		if($this->input->post('submit'))//upload image pied de page    
        {
			$LocalisationImage=$this->input->post('txtImgPiedDePage');
			$NomImagePiedPage=$this->uploadImage($LocalisationImage);							
		}			
    	$this->form_validation->set_rules('anneeEvenement','Annee','required');//regle de validation du formulaire
		$this->form_validation->set_rules('noEvenement',"numero d'evenement");
		$this->form_validation->set_rules('imgEntete',"image entete");
		$this->form_validation->set_rules('imgPiedDePage',"image pied de page");
		$this->form_validation->set_rules('dateMiseEnLigne','DateMiseEnLigne');
		$this->form_validation->set_rules('dateMiseHorsLigne','DateMiseHorsLigne');
		$this->form_validation->set_rules('texteEntete','TxtHTMLEntete');
		$this->form_validation->set_rules('texteCorps','TxtHTMLCorps','required');
		$this->form_validation->set_rules('textePied','TxtHTMLPiedDePage');
		$this->form_validation->set_rules('txtImgEntete',"image pied de page");
		$this->form_validation->set_rules('txtImgPiedDePage',"image pied de page");
		$this->form_validation->set_rules('supImgEntete',"supprime image entete");
		$this->form_validation->set_rules('supImgPiedPage',"supprime image pied de page");
		$this->form_validation->set_rules('emailInfo','EmailInformationHTML');
		$this->form_validation->set_rules('enCours','EnCours');	
		$this->form_validation->set_rules('ajoutProduit','ajout de produit');		
		if ($this->form_validation->run() === FALSE)//si le formulaire n'est pas validé
	 	{
			$donneesInjectees['LesProduits']=$this->ModeleProduit->getProduitGeneral(AnneeEnCour);//recuperation des produit en objet
			$donneesInjectees['LesProduits']=$donneesInjectees['LesProduits']+$this->ModeleProduit->getProduitGeneral(AnneeEnCour-1);
			$donneesInjectees['LesProduits']=$donneesInjectees['LesProduits']+$this->ModeleProduit->getProduitGeneral(AnneeEnCour-2);
			$donneesInjectees['Provenance']=$donnees['Provenance'];
			if(isset($donnees['evenement']))
			{
				$donneesInjectees['evenement']=$donnees['evenement'];
			}
			$this->load->view('templates/EntetePrincipal');
			$this->load->view('templates/EnteteNavbar');//indispensable pour le script	
			if ($donnees['Provenance']=='ajouter')//si on ajoute un evenement
			{
				$donneesInjectees['lesEvenements']= $this->ModeleEvenement->getEvenementGeneral(AnneeEnCour);//recuperation les evenement en objet
				$donneesInjectees['lesEvenements']=$donneesInjectees['lesEvenements']+$this->ModeleEvenement->getEvenementGeneral(AnneeEnCour-1);
				$donneesInjectees['lesEvenements']=$donneesInjectees['lesEvenements']+$this->ModeleEvenement->getEvenementGeneral(AnneeEnCour-2);
				$donneesInjectees['Provenance']='ajouter';
				$this->load->view('administrateur/vueSelectionEvenements',$donneesInjectees);//charge la vue pour preremplir le formulaire
				//$this->load->view('templates/PiedDePagePrincipal');
			}
			$this->load->view('administrateur/vueFormulaireEvenement',$donneesInjectees);//charge la vue formulaire eventuelment prérempli
			//$this->load->view('templates/PiedDePagePrincipal');
		}		
		else// si la validation du formulaire est bonne
		{				
			if ($NomImageEntete===0)// si l'image n'est pas upload
			{				
				$NomImageEntete=$this->input->post('imgEntete');//utilisation de l'ancien nom 
			}
			if ($NomImagePiedPage===0)// si l'image n'est pas upload
			{
				$NomImagePiedPage=$this->input->post('imgPiedDePage');//utilisation de l'ancien nom 
			}
			if(isset($_POST['supImgEntete']))//si on a coché supprimer l'image 
			{
				$NomImageEntete=null;//l'image est mise a nul
			}
			if(isset($_POST['supImgPiedPage']))//si on a coché supprimer l'image 
			{
				$NomImagePiedPage=null;//l'image est mise a nul
			}
			if(isset($_POST['enCours']))//si encours est coché
			{
				$encours=$this->input->post('enCours');//charge la valeur de l'encour
			}
			else//si encour est décoché
			{
				$encours=0;//encour est mis a 0
			}
		$provenance=$_POST['provenance'];
			if($provenance=='ajouter')//si on ajoute un evenement
			{		
				$noMax = $this->ModeleEvenement->maxEvenement();//recherche du max evenement
				$noEvenement=$noMax+1;//on met le numero d'evenement a max+1
				$annee =$this->input->post('anneeEvenement');//on utilise l'année selectionné
			}
			elseif($Provenance=='modifier')//si on modifie un evenement
			{				
				$annee=$_POST['anneeEvenement'];//recuperation de l'année
				$noEvenement=$_POST['noEvenement'];//recuperation du numero evenement
			}
		$donneesAInserer = array(
		'Annee'=>$annee,
		'NoEvenement'=>$noEvenement,			
		'DateMiseEnLigne'=>$this->input->post('dateMiseEnLigne'),
		'DateMiseHorsLigne'=>$this->input->post('dateMiseHorsLigne'),
		'TxtHTMLEntete'=>$this->input->post('texteEntete'),
		'TxtHTMLCorps'=>$this->input->post('texteCorps'),
		'TxtHTMLPiedDePage'=>$this->input->post('textePied'),
		'ImgEntete'=>$NomImageEntete,
		'ImgPiedDePage'=>$NomImagePiedPage,
		'EmailInformationHTML'=>$this->input->post('emailInfo'),
		'EnCours'=>$encours
		);
		//array
	$donnees=array(
	'Annee'=>$annee,
	'NoEvenement'=>$noEvenement
	);
		if($Provenance=='ajouter')//si on ajoute un evenement
		{			 
			$this->ModeleEvenement->ajouterEvenement($donneesAInserer);//création d'une nouvel ligne a la table 
			if (isset($_POST['ajoutProduit']))//si on ajoute un produit 
			{				
				$this->formulaireProduit($donneesAInserer['NoEvenement'],$donneesAInserer['Annee'],'ajouter');//charge le controleur de formulaire produit
			}
			else
			{
				$this->ModeleEvenement->ajouterEvenementNonMarchand($donnees);//ajout a la table non marchand					
			}
		}
		elseif($Provenance=='modifier')//si on modifie un evenement
		{
			$this->ModeleEvenement->modifierEvenement($donneesAInserer);//modification de la ligne liée a l'evenement dans la db
			if (isset($_POST['ajoutProduit']))//si on ajoute un produit
			{				
				$this->formulaireProduit($donneesAInserer['noEvenement'],$donneesAInserer['annee'],'modifier');//charge le controleur de formulaire produit
			}
			else
			{
				if(!$this->ModeleEvenement->getEvenementMarchand($donneesAInserer['annee'],$donneesAInserer['noEvenement']))
				{
					if(!$this->ModeleEvenement->getEvenementNonMarchand($donneesAInserer['annee'],$donneesAInserer['NoEvenement']))
					{							
						$this->ModeleEvenement->ajouterEvenementNonMarchand($donnees);//ajout a la table non marchand	
					}
				}					
			}
		}
		}
		//insert update evenement marchant non marchant a revoir
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
