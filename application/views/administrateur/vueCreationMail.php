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
$adresseExpediteur=array(
    'type'  =>'email',
    'name'  =>'adresseExpediteur',
    'value' =>$adExpediteur
);
$object=array(
    'type'=>'text',
    'name'=>'object'
);
if(isset($objet))
{
    $object['value']=$objet;
};
$message=array(
    'id'=>'summernote',
    'type'=>'texte',
    'name'=>'message'
);
if(isset($corpsTexte))
{
    $message['value']=$corpsTexte;
};
$expediteur=array(
    'name'=>'aTitrePersonnel'
);
$pieceJointe=array(
    'type'=>'file',
    'name'=>'pieceJointe',
    'accept'=>'.doc,.txt,.jpg,.pdf,.bmp,.avi,.mp3,.mp4',//a completer
    'multiple'=>TRUE
);
echo form_open_multipart('Administrateur/formulaireMail');//vers la function formulaireEmail
echo "<table><tr>";
echo "<td><label for='adresseExpediteur'>entrez votre adresse mail</label></td>";
echo "<td>";
echo form_input($adresseExpediteur);
echo "</td></tr>";
echo "<tr><td><label for='object'>entrez l'objet du message</label></td>";
echo "<td>";
echo form_input($object);
echo "</td></tr>";
echo "<tr><td><label for='message'>votre message</label></td>";
echo "<td>";
echo form_textarea($message);
echo "</td></tr>";
echo "<tr><td><label for=envoyerPar>ce message doit-il etre envoyer par vous? (coché) </br>ou par l'association? (décoché)</label></td>";
echo "<td>";
echo form_checkbox($expediteur);
echo "</td></tr>";
if($questionTechnique===null)
{
    echo "<tr><td><label for=destinataire>a qui destinez vous ce mail?<label></td>";
    echo "<td><select name=destinataire required=true multiple=true>
            <option value='tous'>tous</option>
            <option value='administrateur'>tous les administrateur</option>
            <option value='responsable'>responsable du site</option>
            <option value= 'parents'>tous les parents</option>";
    
    foreach($classes as $classe)
    {
        echo"<option value=".$classe['Nom'].">".$classe['Nom']."</option>";
    };
    echo "</select>";
}
else
{
    echo form_hidden('destinataire','responsable');
}
echo "</td></tr>";
echo "<tr><td><label for=pieceJointe>selectionnez une ou des pieces jointes si besoin</label></td>";
echo "<td>";
echo form_input($pieceJointe);
echo"</tr></td></table>";
echo form_submit('envoyer','envoyer');
echo "<script>
$(document).ready(function() {
    $('#summernote').summernote();
});
</script>";