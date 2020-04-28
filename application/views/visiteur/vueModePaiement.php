<h2 align="center"> Résumé de votre commande </h2>

<p align="center">Afficher le panier </p>

<script type="text/javascript"> function GereChkbox() 
{ 
    if(document.getElementById($connu).checked) 
    {   
        document.getElementById($nonConnu).disabled = "disabled"; 
        document.getElementById($connu).disabled = ""; 
    } 
    else if(document.getElementById($nonConnu).checked) 
    { 
        document.getElementById($connu).disabled = "disabled"; 
        document.getElementById($nonConnu).disabled = ""; 
    } 
    else 
    { 
        document.getElementById($connu).disabled = ""; 
        document.getElementById($nonConnu).disabled = ""; 
    } 
} </script>
<?php 

$submit=array(
    'name'=>'submit',
    'value'=>'Soumettre',
    'class'=>'btn btn-primary'
);

$js=['onClick' => 'GereChkbox();'];
echo form_open('visiteur/commande');
echo "<table align='center'>";
    echo"<tr>";
        echo "<td>";
            echo "Comment souhaitez-vous payer ?";
        echo "</td>";
        echo "<td>";
            echo form_checkbox('connu','1',FALSE,$js);
            echo "oui";
            echo form_checkbox('nonConnu','2',FALSE,$js);
            echo "non";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td align='center'>";
            echo form_submit($submit);
        echo "</td>\n";
    echo "</tr>";
echo "</table>";
echo form_close();
?>