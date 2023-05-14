<?php
    echo form_open('connecter');
    echo csrf_field();

    echo form_label('Entrez votre mail ','txtMel');
    echo form_input('txtMel', set_value('txtMel'));

    echo form_label('Entrez votre mot de passe ','txtMotDePasse');
    echo form_password('txtMotDePasse', set_value('txtMotDePasse'));

    echo form_submit('btnConnecter','Se connecter');
    echo form_close();

    echo"<a href=\"inscrire\">Si vous n'avez pas de compte: inscrivez-vous.</a>";

?>