<div class="container">
    <div class="col-sm-4">
    </div>
    <div class="col-sm-4" style="background-color:#8a8a8a">
    <h3 align='center'><span class='textBlanc'>Récupération de votre mot de passe</span></h3>
    <?php
       echo form_open('visiteur/oublieMotDePasse');
    ?>
    <p align='center'><label for="txtLogin"><span class='textBlanc'>Votre e-mail :</span></label>
    <input type="text" name='txtLogin' class='form-control' required>
    <p>Vous allez recevoir un mail avec votre mot de passe.</p>
    <p align='center'><input type="submit" name="submit" value='Envoyer' class='btn btn-primary'></p>
    </form>
  </div>
</div>