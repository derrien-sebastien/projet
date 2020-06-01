<?php 
/* donnée a envoyer dans le mail:
-objet (viens base de donnees) facultatif
-corpsTexte(viens de la base de donnees) facultatif  
sortie:
-adresseExpediteur 
-object
-message
-aTitrePersonnel
-destinataire (probablement un tableau a tester en var dump)
*/
////////////////////////////// Déclaration de nos Variables ////////////////////////////

$object=array(
    'type'      =>  'infoCompte',
    'name'      =>  'object',
    'class'     =>  'form-control'
);
$message=array(
    'id'        =>  'summernote',
    'type'      =>  'texte',
    'name'      =>  'message'
);

$pieceJointe=array(
    'type'      =>  'file',
    'name'      =>  'pieceJointe',
    'accept'    =>  '.doc,.txt,.jpg,.pdf,.bmp,.avi,.mp3,.mp4',//a completer
    'multiple'  =>  TRUE
);
$submit=array(
    'name'      =>  'submit',
    'value'     =>  'Envoyer',
    'class'     =>  'btn btn-primary'
);

///////////////////////// Variables déjà connu ? On réassigne... ////////////////////////

if(isset($objet))
{
    $object['value']    =   $objet;
};
if(isset($corpsTexte))
{
    $message['value']   =   $corpsTexte;
};

///////////////////////////////   FORMULAIRE   ////////////////////////////////////////
echo form_open_multipart('Membre/problem');
    echo '<br>';
    echo '<div class="container-fluid">';
        echo "<h1 class='encadre'>Besoin d'assistance ?</h1>";
        echo '</br>';
        echo '<table id="envoiMail">';
            echo '<tr>';
                echo '<td>';
                    echo form_label("Objet de votre message","object");
                echo '</td>';
                echo '<td>';
                    echo form_input($object);
                echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('Saisissez le message','message');
                echo '</td>';
                echo '<td>';
                    echo form_textarea($message);
                echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>';
                    echo form_label('Selectionnez une ou des pièces jointes si besoin','pieceJointe');
                echo '</td>';
                echo '<td>';
                    echo form_input($pieceJointe);
                echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td colspan="2">';
                    echo '<div align="center">';
                        echo form_submit($submit);
                    echo '</div>';
                echo '</td>';
            echo '</tr>';
        echo '</table>';
    echo '</div>';
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