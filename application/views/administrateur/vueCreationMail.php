</br>
<?php 
/* donnée a envoyer dans le mail:
-adExpediteur (viens de la base de donnees )
-objet (viens base de donnees) facultatif
-corpsTexte(viens de la base de donnees) facultatif
-$classes (viens de la base de donnees)
-$questionTechnique(pour contacter uniquement le responsable) facultatif  
sortie:
-adresseExpediteur 
-object
-message
-aTitrePersonnel
-destinataire (probablement un tableau a tester en var dump)
*/
//////////////////////////////  Déclaration de nos Variables ////////////////////////////
        $adresseExpediteur=array(
            'type'      =>  'email',
            'name'      =>  'adresseExpediteur',
            'value'     =>  $adExpediteur
        );
        $object=array(
            'type'      =>  'text',
            'name'      =>  'object',
            'class'     =>  'form-control'
        );
        $message=array(
            'id'        =>  'summernote',
            'type'      =>  'texte',
            'name'      =>  'message'
        );
        $expediteur=array(
            'name'      =>  'aTitrePersonnel'
        );
        $pieceJointe=array(
            'type'      =>  'file',
            'name'      =>  'pieceJointe',
            'accept'    =>  '.doc,.txt,.jpg,.pdf,.bmp,.avi,.mp3,.mp4',//a completer
            'multiple'  =>  TRUE
        );
        $lesDestinataires=array(
            'tous'=>'tous',
            'administrateur'=>'tous les administrateur',
            'responsable'=>'responsable du site',
            'parents'=>' tous les parents'

        );
        foreach($classes as $classe)
        {
            $lesDestinataires[$classe['Nom']]=$classe['Nom'];
        };
        $submit=array(
            'name'          =>  'evnoyer',
            'value'         =>  'Valider',
            'class'         =>  'btn btn-primary'
        );
        
///////////////////////// Variables déjà connu ? On réassigne... ////////////////////////

if(isset($objet))
{
    $object['value']=$objet;
};
if(isset($corpsTexte))
{
    $message['value']=$corpsTexte;
};

/////////////////////////////// FORMULAIRE   ////////////////////////////////////////

echo form_open_multipart('Administrateur/formulaireMail');
echo '<div class="container-fluid">';
    echo "<h1 class='encadre'>Mailing - Envoi massif à tous les contacts de la base de données</h1>";
echo '</div>';
echo "<table>";
echo "<tr>";
echo "<td>";
echo form_label('Entrez votre adresse mail','adresseExpediteur');
echo "</td>";
echo "<td>";
echo form_input($adresseExpediteur);
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo form_label("Entrez l'objet du message","object");
echo "<td>";
echo form_input($object);
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo form_label('Votre message','message');
echo "<td>";
echo form_textarea($message);
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo form_label("Ce message doit-il etre envoyer par vous? (coché) </br>ou par l'association? (décoché)",'envoyerPar');
echo "</td>";
echo "<td>";
echo form_checkbox($expediteur);
echo "</td>";
echo "</tr>";
if($questionTechnique===null)
{
    echo "<tr>";
    echo "<td>";
    echo form_label('A qui destinez vous ce mail?</br>Pour une selection multiple maintenez la touche ctrl et cliquez &nbsp;','destinataire');
    
    echo "<td>";
    echo form_multiselect('destinataire[]', $lesDestinataires);
}
else
{
    echo form_hidden('destinataire','responsable');
}
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo form_label('Sélectionnez une ou des pièces jointes si besoin','pieceJointe');
echo "<td>";
echo form_input($pieceJointe);
echo"</tr>";
echo "</td>";
echo "</table>";
echo '<div align="center">';
echo form_submit($submit);
echo '</div>';
echo'</div>';
echo form_close();      
//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////

?>

<!----------------------------------------------------------------------------------------
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||       SCRIPT       ||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
----------------------------------------------------------------------------------------->

<script>
    $(document).ready(function() 
    {
        $('#summernote').summernote();
    });
</script>