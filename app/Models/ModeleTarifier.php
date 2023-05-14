<?php
namespace App\Models;
use CodeIgniter\Model;

class ModeleTarifier extends Model
{
    protected $table = 'tarifier';
    protected $allowedFields = ['NoPeriode', 'LettreCategorie', 'NoType','NoLiaison', 'Tarif'];

    public function getLiaisonWithRestrictions()
    {
        $db = \Config\Database::connect();
        
        $query = $db->table('liaison')
                    ->select('liaison.NOLIAISON, liaison.DISTANCE, portdepart.NOM as portdepart, portarrivee.NOM as portarrivee, tarifer.PRIX, periode.DATEDEBUT, periode.DATEFIN, type.NOM as typeliaison, categorie.NOM as catliaison')
                    ->join('port as portdepart', 'portdepart.NOPORT = liaison.NOPORT_DEPART', 'left')
                    ->join('port as portarrivee', 'portarrivee.NOPORT = liaison.NOPORT_ARRIVEE', 'left')
                    ->join('tarifer', 'tarifer.NOLIAISON = liaison.NOLIAISON', 'left')
                    ->join('periode', 'periode.NOPRIX = tarifer.NOPRIX', 'left')
                    ->join('type', 'type.NOTYPE = liaison.NOTYPE', 'left')
                    ->join('categorie', 'categorie.NOCAT = liaison.NOCAT', 'left')
                    ->where('liaison.NOLIAISON', 15)
                    ->where('periode.DATEFIN >=', date('Y-m-d'))
                    ->get();

        return $query->getResult();
    }
}