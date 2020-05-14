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
////////////////////////////// Déclaration de nos Variables ////////////////////////////
$adresseExpediteur=array(
    'type'  =>'email',
    'name'  =>'adresseExpediteur',
    'value' =>$adExpediteur
);
$object=array(
    'type'=>'text',
    'name'=>'object'
);
$message=array(
    'id'=>'summernote',
    'type'=>'texte',
    'name'=>'message'
);
$expediteur=array(
    'name'=>'aTitrePersonnel'
);
$pieceJointe=array(
    'type'=>'file',
    'name'=>'pieceJointe',
    'accept'=>'.doc,.txt,.jpg,.pdf,.bmp,.avi,.mp3,.mp4',//a completer
    'multiple'=>TRUE
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

///////////////////////////////   FORMULAIRE   ////////////////////////////////////////
echo '<br>';
echo '<div class="container">';
echo    "<h1 class='encadre'>Demande d'assistance</h1>";
echo '</div>';
echo '</br>';
echo '<div class="container">';
echo    form_open_multipart('Membre/problemGeneral');//vers la function formulaireEmail
echo    '<table>';
echo        '<tr>';
echo            '<td>';
echo                form_label('entrez votre adresse mail', 'adresseExpediteur');
echo            '</td>';
echo            '<td>';
echo		        '<div style="color:rgba(193, 193, 193);" class="form_input">';
echo                    form_input($adresseExpediteur);
echo 			    '</div>';
echo            '</td>';
echo        '</tr>';
echo        '<tr>';
echo            '<td>';
echo                form_label("entrez l'objet du message","object");
echo            '</td>';
echo            '<td>';
echo                form_input($object);
echo            '</td>';
echo        '</tr>';
echo        '<tr>';
echo            '<td>';
echo                form_label('votre message','message');
echo            '</td>';
echo            '<td>';
echo                form_textarea($message);
echo            '</td>';
echo        '</tr>';
echo        '<tr>';
echo            '<td>';
echo                form_label("ce message doit-il etre envoyer par vous? (coché) </br>ou par l'association? (décoché)","envoyerPar");
echo            '</td>';
echo            '<td>';
echo                form_checkbox($expediteur);
echo            '</td>';
echo        '</tr>';
echo        '<tr>';
echo            '<td>';
                    if($questionTechnique===null)
                    {
echo                    '<tr>';
echo                    '<td>';
echo                        form_label('a qui destinez vous ce mail?','destinataire');
echo                    '</td>';
echo                    "<td><select name=destinataire required=true multiple=true>  
                            <option value='administrateur'>un administrateur</option>
                            <option value='responsable'>responsable du site</option>";
echo                        "</select>";
echo                    '</td>';
                    }
                    else
                    {
echo                    form_hidden('destinataire','responsable');
                    }
echo            '</td>';
echo        '</tr>';
echo        '<tr>';
echo            '<td>';
echo                form_label('selectionnez une ou des pieces jointes si besoin','pieceJointe');
echo            '</td>';
echo            '<td>';
echo                form_input($pieceJointe);
echo        '</tr>';
echo    '</table>';
echo    form_submit('envoyer','envoyer');
echo    form_close();
echo '</div>';

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