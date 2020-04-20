<?php
echo form_open('membre/actif');
echo "<div class='row'>";
echo "<div class='form-group'>";
echo "<table align=center>\n";
echo 	"<tr>";
echo 		"<td>";
echo			"<label>";
		$data = [
					'name'    => 'newsletter',
					'id'      => 'newsletter',
					'value'   => 'accept',
					'checked' =>  FALSE,
					'style'   => 'margin:10px'
				];
echo form_checkbox($data);
echo " Pour vous désinscrire de la Newsletter et ne plus recevoir de mail de notre part cocher la case et confirmer";
echo 			"</label>";
echo		"</td>";
echo 	"</tr>";
echo 	"<tr>";
echo 		"<td align=center>";
echo 			"<input type='submit' id='btnSubmit' class='btn btn-info align=center' name='confirmer' value='Confirmer'>\n";
echo 	"</tr>";
echo "</table>";
echo "</div>";
echo "</div>";
echo "</form>";
