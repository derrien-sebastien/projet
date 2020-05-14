<?php 
////////////////////////////// Déclaration de nos Variables ////////////////////////////
$connu=array(
    'name'      =>  'checkbox',
    'value'     =>  '1',
    'checked'   =>  FALSE,
    'id'        =>  'checkbox1',
    'onClick'   =>  'GereChkbox();'
);   
$nonConnu=array(
    'name'      =>  'checkbox',
    'value'     =>  '2',
    'checked'   =>  FALSE,
    'id'        =>  'checkbox2',
    'onClick'   =>  'GereChkbox();'
);
$submit=array(
    'name'      =>  'submit',
    'value'     =>  'Soumettre',
    'class'     =>  'btn btn-primary'
);
echo '<br>';
echo '<div class="container">';
echo    '<h2 class="encadre" align="center"> Résumé de votre commande </h2>';
echo    '<div class="row">';
echo        '<div class="col-lg-12" >';
echo            '<table class="table table-dark">';
echo                '<thead>';
echo                    '<tr>';
echo                        '<td align="center">Produit</td>';
echo                        '<td align="center">libellé </td>';
echo                        '<td align="center">Prix </td>';
echo                        '<td align="center">Quantité</td>';
echo                        '<td align="center">Votre Total</td>';
echo                    '</tr>';
echo                '</thead>';
echo                '<tbody class="table table-dark">';
                        if($this->cart->total_items() > 0)
                        {
////////////////////////////// Déclaration de nos Variables ////////////////////////////
                            foreach($this->cart->contents() as $produit)
                            { 
echo                        '<tr>';
echo                            '<td align="center">';
echo                                '<img src="'.base_url().'assets/images/'.$produit["image"].'"class="img-thumbnail" width="75"/>';
echo                            '</td>';
echo                            '<td style="color:rgb(128, 122, 122);" align="center">'.$produit["name"].'</td>';
echo                            '<td style="color:rgb(128, 122, 122);" align="center">'.$produit["price"].'€</td>';         
echo                            '<td style="color:rgb(128, 122, 122);" align="center">'.$produit["qty"].'</td>';
echo                            '<td style="color:rgb(128, 122, 122);" align="center">'.$produit["subtotal"].'€</td>';
echo                       '</tr>';
                            } 
                        }
                        else
                        { 
echo                        '<tr>';
echo                            '<td colspan="6"><p> Aucun Produit</p></td>';
echo                        '</tr>';
                        }
echo                '</tbody>';
echo            '</table>';
echo        '</div>';
echo    '</div>';
echo '</div>';
///////////////////////////////   FORMULAIRE   //////////////////////////////////////// 
echo form_open('visiteur/passerCommande');
echo "<div align='center'>";
    echo "<p>Avez-vous déjà passé une commande sur notre site ?</p>";
        echo form_checkbox($connu);
            echo "oui";
            echo form_checkbox($nonConnu);
            echo "non";
            echo"</br>";
echo "<div align='center'>";
    echo form_submit($submit);
echo "</div>";
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