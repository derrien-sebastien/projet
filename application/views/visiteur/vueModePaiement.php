<?php 
////////////////////////////// Déclaration de nos Variables ////////////////////////////
    $submit=array(
            'name'  =>  'submit',
            'value' =>  'Soumettre',
            'class' =>  'btn btn-primary'
        );
    $js=['onClick'  =>  'GereChkbox();'];
///////////////////////////////   FORMULAIRE   ////////////////////////////////////////    
echo form_open('visiteur/commande');
echo "<table align='center'>";
    echo"<tr>";
        echo "<td>";
            echo "Comment souhaitez-vous payer ?";
        echo "</td>";
        echo "<td>";
            echo form_checkbox('esp','1',FALSE,$js);
            echo "Espèces";
            echo form_checkbox('chk','2',FALSE,$js);
            echo "Chèque";
            echo form_checkbox('cb','3',FALSE,$js);
            echo "Par carte bancaire";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td></td>";
        echo '<td align="center">';
            echo form_submit($submit);
        echo "</td>\n";
    echo "</tr>";
echo "</table>";
echo form_close();
//////////////////////////////  FIN DE FORMULAIRE ///////////////////////////////////////
?>
<!----------------------------------------------------------------------------------------
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||       SCRIPT       ||||||||||||||||||||||||||||||||||||||
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
----------------------------------------------------------------------------------------->
<script type="text/javascript"> function GereChkbox() 
{ 
    if(document.getElementById($esp).checked) 
    {   
        document.getElementById($chk).disabled = "disabled"; 
        document.getElementById($cb).disabled = "disabled"; 
        document.getElementById($esp).disabled = ""; 
    } 
    else if(document.getElementById($chk).checked) 
    { 
        document.getElementById($esp).disabled = "disabled"; 
        document.getElementById($cb).disabled = "disabled"; 
        document.getElementById($chk).disabled = ""; 
    } 
    else if(document.getElementById($cb).checked) 
    { 
        document.getElementById($esp).disabled = "disabled"; 
        document.getElementById($chk).disabled = "disabled"; 
        document.getElementById($cb).disabled = ""; 
    } 
    else 
    { 
        document.getElementById($esp).disabled = ""; 
        document.getElementById($chk).disabled = "";
        document.getElementById($cb).disabled = ""; 
    } 
} </script>