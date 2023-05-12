<?php
    echo form_open('connecter');
    echo csrf_field();

    echo form_label('Entrez votre mail ','txtMail');
    echo form_input('txtMail', set_value('txtMail'));

    echo form_label('Entrez votre mot de passe ','txtPassword');
    echo form_password('txtPassword', set_value('txtPassword'));

    echo form_submit('btnConnecter','Se connecter');
    echo form_close();

    echo"<a href=\"inscrire\">Si vous n'avez pas de compte: inscrivez-vous.</a>";

?>