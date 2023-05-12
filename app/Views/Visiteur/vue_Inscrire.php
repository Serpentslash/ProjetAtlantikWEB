<?php
    echo form_open('connecter');
    echo csrf_field();

    echo form_label('Entrez votre nom ','txtNom');
    echo form_input('txtNom','');

    echo form_label('Entrez votre prénom ','txtPrenom');
    echo form_input('txtPrenom','');

    echo form_label('Entrez votre adresse ','txtAdresse');
    echo form_input('txtAdresse','');

    echo form_label('Entrez votre code postal ','txtCodePostal');
    echo form_input('txtCodePostal','');

    echo form_label('Entrez votre ville ','txtVille');
    echo form_input('txtVille','');

    echo form_label('Entrez votre telephone fixe ','txtTelephoneFixe');
    echo form_input('txtTelephoneFixe','');

    echo form_label('Entrez votre telephone mobile ','txtTelephoneMobile');
    echo form_input('txtTelephoneMobile','');

    echo form_label('Entrez votre mot de passe ','password');
    echo form_password('password','');

    echo form_submit('btnConnecter','Se connecter');
    echo form_close();

    echo"<a href=\"connecter\">Si vous avez déjà un compte: connectez-vous.</a>";

?>