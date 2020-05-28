<?php
//donnees d'entrée
//$Personne
//
////////////////////////////// Déclaration de nos Variables ////////////////////////////

            $email2=array(	
                'type'              =>  'email',
                'name'			    =>	'txtEmail'
            );
            $email=array(
                'type'              =>  'email',
                'name'			    =>	'txtEmail'
                
            );
            $txtNom=array(
                'type'              =>  'text',
                'name'              =>  'txtNom',
                'aria-describedby'  =>  'aideUserName',
                'class'             =>  'form-control'
            );
            $txtPrenom=array(
                'type'              =>  'text',
                'name'              =>  'txtPrenom',
                'class'             =>  'form-control'
            );
            $txtAdresse=array(
                'type'              =>  'text',
                'name'              =>  'txtAdresse',
                'class'             =>  'form-control'
            );
            $txtCp=array(
                'type'              =>  'text',
                'name'              =>  'txtCp',
                'class'             =>  'form-control'
            );
            $txtVille=array(
                'type'              =>  'text',
                'name'              =>  'txtVille',
                'class'             =>  'form-control'
            );
            $txtTelF=array(
                'type'              =>  'text',
                'name'              =>  'txtTelF',
                'class'             =>  'form-control'
            );
            $txtTelP=array(
                'type'              =>  'text',
                'name'              =>  'txtTelP',
                'class'             =>  'form-control'
            );
            
            $submit=array(
                'name'              =>  'submit',
                'value'             =>  'Paiement par chèque/espèces',
                'class'             =>  'btn btn-primary'
            );
            $hidden=array();
            $style=array(
                'class'		        =>	'btnSubmit btn-lg btn-primary'
            );

///////////////////////// Variables déjà connu ? On réassigne... //////////////////////// 
            if(isset($Personne->NoPersonne))
            {    
                $hidden['noPersonne']   =  $Personne->NoPersonne;
            }
            if(isset($Personne->Email))
            {
                $email                  =   $Personne->Email;
                $hidden['txtEmail']     =   $Personne->Email;
            }            
            if(isset($Personne->Nom))
            {
                $txtNom                 =   $Personne->Nom;
                $hidden['txtNom']       =   $Personne->Nom;
            }
            if(isset($Personne->Prenom))
            {
                $txtPrenom              =   $Personne->Prenom;
                $hidden['txtPrenom']    =   $Personne->Prenom;
            }
            if(isset($Personne->Adresse))
            {
                $txtAdresse             =   $Personne->Adresse;
                $hidden['txtAdresse']   =   $Personne->Adresse;
            }
            if(isset($Personne->CodePostal))
            {
                $txtCp                  =   $Personne->CodePostal;
                $hidden['txtCp']        =   $Personne->CodePostal;
            }
            if(isset($Personne->Ville))
            {
                $txtVille               =   $Personne->Ville;
                $hidden['txtVille']     =   $Personne->Ville;
            }
            if(isset($Personne->TelPortable))
            {
                $txtTelP                =   $Personne->TelPortable;
                $hidden['txtTelP']      =   $Personne->TelPortable;
            }
            if(isset($Personne->TelFixe))
            {
                $txtTelF                =   $Personne->TelFixe;
                $hidden['txtTelF']      =   $Personne->TelFixe;
            }

///////////////////////////////   FORMULAIRE   ////////////////////////////////////////
echo form_open('Visiteur/formulaireLivraison');
if(!isset($Personne->Email))
{
    echo '<body id="bodyLogin">';
    echo '<div class="containerLogin">';
        echo '<img src="'.base_url().'assets/img_site/utilisateur.svg">';
        echo '<h4>Saisissez votre adresse mail</h4>';
        echo '</br>';
        echo '<div>';
            echo form_input($email2); 
        echo '</div>';
        echo '<div>';
            echo '</br>';
            echo form_submit('submit', 'Envoyer',$style);
        echo '</div>';
    echo '</div>';
    echo form_close();
}
else
{
    echo '</br>';   
    echo '<div class="container-fluid">';
        echo '<h1 class="encadre" align="center">Vos informations</h1>';
        echo '<div align="right">';
            if(!isset($Personne->Nom, $Personne->Prenom, $Personne->Adresse, $Personne->CodePostal, $Personne->Ville))
            {                    
                echo '(*) informations obligatoires';
            }
        echo '</div>';
        echo form_hidden($hidden);  
        echo '<div align="center">';           
            echo form_label('<img src="'.base_url().'assets/img_site/utilisateur.svg" height="100" width="100">',"txtEmail");
            echo form_label($email);
        echo '</div>';
        echo '<table id="infoTable">';
            echo '<thead>';
                echo '<tr>';
                    echo'<th>';
                        echo form_label("Nom-Prénom");
                    echo '</th>';
                    echo'<th>';
                        echo form_label("Adresse");
                    echo '</th>';
                    echo'<th>';
                        echo form_label("Coordonnées Téléphoniques");
                echo '</th>';
                echo '</tr>';
            echo '</thead>';
                echo '<tbody>';
                    echo '<tr>';
                        echo '<td>';
                            if(isset($Personne->Nom))
                            {                  
                                echo form_label($txtNom);
                                echo '</br>';
                            } 
                            else
                            {
                                echo form_label('Saisissez votre nom (*)');
                                echo form_input($txtNom);
                            }                    
                            if(isset($Personne->Prenom))
                            {
                                echo form_label($txtPrenom);
                            }
                            else
                            {
                                echo form_label('prénom (*)');
                                echo form_input($txtPrenom);
                            }
                        echo '</td>';
                        echo '<td>';
                            if(isset($Personne->Adresse))
                            {
                                    echo form_label($txtAdresse).'</br>';
                            }
                            else
                            {
                                echo form_label('Saisissez votre adresse (*)');
                                echo form_input($txtAdresse);
                            }
                            if(isset($Personne->CodePostal))
                            {
                                echo form_label($txtCp).'</br>';
                            }
                            else
                            {
                                echo form_label('code postal (*)');
                                echo form_input($txtCp);
                            }
                            if(isset($Personne->Ville))
                            {
                                echo form_label($txtVille);
                            }
                            else
                            {
                                echo form_label('votre ville (*)');
                                echo form_input($txtVille);
                            }
                        echo '</td>';
                        echo '<td>';
                            echo form_label('Téléphone Fixe').'<br>';
                            if(isset($Personne->TelFixe))
                            {
                                echo form_label($txtTelF); 
                                echo '</br>';
                            }
                            else
                            {
                                echo form_input($txtTelF);
                            }                    
                            echo form_label('Téléphone Portable').'<br>';
                            if(isset($Personne->TelPortable))
                            {
                                echo form_label($txtTelP);
                            }
                            else
                            {
                                echo form_input($txtTelP);
                            }
                        echo '</td>';
                    echo '</tr>';        
                echo '</tbody>';
                echo '<tfoot>';
                    if($this->cart->total_items() > 0)
                    {
                        echo '<tr>';
                            echo '<td>';
                                echo form_label('Comment souhaitez-vous payer ?');
                            echo '</td">';
                            echo '<td>';
                                echo '<button name="payementCb" class="btn btn-primary">Paiement par carte bancaire</button>';
                            echo '</td>';
                            echo '<td>';
                                echo form_submit($submit);
                            echo '</td>';
                        echo '</tr>';    
                    }    
                echo '</tfoot>';
            echo'</table>';
        echo '</div>';
        echo '</br>';              
    echo form_close();  
}

//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////

?>
