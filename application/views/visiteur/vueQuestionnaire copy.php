<h2 align="center"> Résumé de votre commande </h2>

<p align="center">Afficher le panier </p>

<h2 align="center">Avez-vous déjà passé une commande sur notre site ?</h2>
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
<form align="center"> 
    <input type="checkbox" name="connu" id="checkbox1" value="1" onclick="GereChkbox();" >Oui&emsp;&emsp;
    <input type="checkbox" name="nonconnu" id="checkbox2" value="2" onclick="GereChkbox();">Non
    <br /> 
    <p align='center'>
                <input type="submit" name='submit' value='Soumettre' class='btn btn-primary'></p>
</form>
