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
        $champsRemplis = array_filter($donnees, 'strlen');
        $this->where('Mel', $Mel)->set($champsRemplis)->update();
    }
}