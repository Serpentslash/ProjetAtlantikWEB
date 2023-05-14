<?php
namespace App\Models;
use CodeIgniter\Model;

class ModeleClient extends Model
{
    protected $table = 'client';
    protected $primaryKey = 'noclient';
    protected $allowedFields = ['Nom', 'Prenom', 'Adresse','CodePostal', 'Ville', 'TelephoneFixe', 'TelephoneMobile', 'Mel', 'MotDePasse'];

    public function retournerClient($Mel, $password)
    {
        return $this->where(['Mel' => $Mel, 'MotDePasse' => $password])->first();
        // <=> SELECT * FROM utilisateur  WHERE identifiant='$pId' and motdepasse='$MotdePasse'
    } // retournerUtilisateur

    public function retournerMel($Mel)
    {
        return $this->where(['Mel' => $Mel])->first();
    }

    public function modifierClient($Mel, $donnees)
    {
        $champsRemplis = array_filter($donnees, 'strlen'); // on récupère les champs remplis
        $this->where('Mel', $Mel)->set($champsRemplis)->update(); // on met à jour les champs remplis pour le client avec l'id correspondant
    }
}