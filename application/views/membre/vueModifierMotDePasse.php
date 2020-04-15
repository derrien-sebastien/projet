    <div>
        <h2 align='center'>Paramètre confidentiel de votre compte</h2> <br>
        <p align='center'>Vous pouvez changer vos informations personnelle ici</p>
        <script>
            function confirmationMotDePasse()
            {
                var mdp = document.getElementById("password").value;
                var confirmMdp = document.getElementById("password2").value;
                if(mdp == confirmMdp)
                    {
                        return true;
                    }
                else
                    {
                        alert('Les mots de passe ne correspondent pas.');
                        document.getElementById("password").value = "";
                        document.getElementById("password2").value = "";
                        document.getElementById("password").focus();
                        return false;
                    }
            }
        </script>
            <?php
                echo form_open('visiteur/ModificationMdp','class="form-horizontal" name="form"'); // j'ouvre mon form
                 echo '<form onsubmit="return confirmationMotDePasse()" action="'.site_url('visiteur/ModificationMdp').'" method="post">';
            ?>
            <table align='center'>
            <tr>
            <td>
            <label for="password">
                <span class='textBlanc'>Saisissez votre nouveau mot de passe :</span>
            </label>
            </td>
            <td>
                <input type="password" name='password' id='password' class='form-control' required>
            </td>
            </tr>
            <tr>
            <td>
            <label for="password2">
                <span class='textBlanc'>Confirmer le nouveau mot de passe : </span>
            </label>
            </td>
            <td>
                <input type="password" name='password2' id='password2'class='form-control' required>
            </td>
            </tr>
            </table>
        </br>
                <p align='center'>
                <input type="submit" name='submit' value='Modifier' class='btn btn-primary'></p>
    </div>