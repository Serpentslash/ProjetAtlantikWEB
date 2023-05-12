<?php
namespace App\Models;
use CodeIgniter\Model;

class ModeleClient extends Model
{
    protected $table = 'client';
    protected $primaryKey = 'noclient';
    protected $allowedFields = ['NOM', 'PRENOM', 'ADRESSE','CODEPOSTAL', 'VILLE', 'TELEPHONEFIXE', 'TELEPHONEMOBILE', 'MEL', 'MOTDEPASSE'];
   
    public function seConnecter()
    {
        $db=\Config\Database::connect();
        $builder = $db->table('client');
        $builder->insert('NOM', 'PRENOM', 'ADRESSE','CODEPOSTAL', 'VILLE', 'TELEPHONEFIXE', 'TELEPHONEMOBILE', 'MEL', 'MOTDEPASSE');

        return $builder->get(); /* Pour générer le tableau automatiquement, sinon
        return $builder->get()->getResult();  (voir vue associée)
        */
    }

    public function retournerClient($MEL, $password)
    {
        return $this->where(['MEL' => $MEL, 'MOTDEPASSE' => $password])->first();
        // <=> SELECT * FROM utilisateur  WHERE identifiant='$pId' and motdepasse='$MotdePasse'
    } // retournerUtilisateur
}