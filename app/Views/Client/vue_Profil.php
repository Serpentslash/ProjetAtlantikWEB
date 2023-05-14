<h1>Profil</h1>
<?php
    $session = session();
    echo '<p>Nom: '.$session->get('Nom').'</p>';
    echo '<p>Prenom: '.$session->get('Prenom').'</p>';

    echo form_open('profil');
    echo csrf_field();

    echo form_label('Entrez votre adresse ','txtAdresse');
    echo form_input('txtAdresse', set_value('txtAdresse'));

    echo form_label('Entrez votre code postal ','txtCodePostal');
    echo form_input('txtCodePostal', set_value('txtCodePostal'));

    echo form_label('Entrez votre ville ','txtVille');
    echo form_input('txtVille', set_value('txtVille'));

    echo form_label('Entrez votre telephone fixe ','txtTelephoneFixe');
    echo form_input('txtTelephoneFixe', set_value('txtTelephoneFixe'));

    echo form_label('Entrez votre telephone mobile ','txtTelephoneMobile');
    echo form_input('txtTelephoneMobile', set_value('txtTelephoneMobile'));

    echo form_label('Entrez votre mail ','txtMel');
    echo form_input('txtMel','');

    echo form_label('Entrez votre mot de passe ','txtMotDePasse');
    echo form_password('txtMotDePasse','');

    echo form_submit('btnModifier','Modifier');
    echo form_close();

?>