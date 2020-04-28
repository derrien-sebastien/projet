<h2 align="center"> Résumé de votre commande </h2>

<p align="center">Afficher le panier </p>

<script type="text/javascript"> function GereChkbox() 
{ 
    if(document.getElementById("checkbox1").checked) 
    {   
        document.getElementById("checkbox2").disabled = "disabled"; 
        document.getElementById("checkbox1").disabled = ""; 
    } 
    else if(document.getElementById("checkbox2").checked) 
    { 
        document.getElementById("checkbox1").disabled = "disabled"; 
        document.getElementById("checkbox2").disabled = ""; 
    } 
    else 
    { 
        document.getElementById("checkbox1").disabled = ""; 
        document.getElementById("checkbox2").disabled = ""; 
    } 
} </script>
<?php 
$connu=array(
    'name'=>'checkbox',
    'value'=>'1',
    'checked'=>FALSE,
    'id'=>'checkbox1',
    'onClick'=>'GereChkbox();'
);   
$nonConnu=array(
    'name'=>'checkbox',
    'value'=>'2',
    'checked'=>FALSE,
    'id'=>'checkbox2',
    'onClick'=>'GereChkbox();'
);
$submit=array(
    'name'=>'submit',
    'value'=>'Soumettre',
    'class'=>'btn btn-primary'
);

echo form_open('visiteur/commande');
echo "<table align='center'>";
    echo"<tr>";
        echo "<td>";
            echo "Avez-vous déjà passé une commande sur notre site ?";
        echo "</td>";
        echo "<td>";
            echo form_checkbox($connu);
            echo "oui";
            echo form_checkbox($nonConnu);
            echo "non";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td align='center'>";
            echo form_submit($submit);
            var_dump($connu,$nonConnu,$submit);
        echo "</td>\n";
    echo "</tr>";
echo "</table>";
echo form_close();
?>