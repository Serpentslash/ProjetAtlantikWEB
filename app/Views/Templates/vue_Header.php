<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?php echo $TitreDeLaPage; ?></title>
</head>
<body>
    <div class="titre"><h1>Atlantik</h1></div>
    <nav>
        <a href="<?php echo site_url('accueil'); ?>">Accueil</a>
        <a href="<?php echo site_url('afficher_liaisons'); ?>">Les liaisons</a>
        <a href="">Horaires/Réservation</a>
        <?php
            $session = session();
            if(!is_null($session->get('Mel'))){
                echo '<a href="'.site_url('profil').'">Profil</a>';
                echo '<a href="'.site_url('deconnecter'),'">Se deconnecter</a>';
            }else{
                echo '<a href="'.site_url('connecter'),'">Se connecter</a>';
            }
        ?>
    </nav>