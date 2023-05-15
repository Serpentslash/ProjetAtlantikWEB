<?php
namespace App\Models;
use CodeIgniter\Model;

class ModeleTarifer extends Model
{
    protected $table = 'tarifer';
    protected $allowedFields = ['NoPeriode', 'LettreCategorie', 'NoType','NoLiaison', 'Tarif'];

    public function getTarifsParLiaison($NoLiaison) {
        $date_now = date("Y-m-d");

        return $this->select('tarifer.lettrecategorie, categorie.libelle as libelle_categorie, CONCAT(tarifer.LettreCategorie, tarifer.NoType, \' - \', type.libelle) as type, datedebut, datefin ,tarif')
                    ->join('categorie', 'categorie.LettreCategorie = tarifer.LettreCategorie')
                    ->join('type', 'type.LettreCategorie = tarifer.LettreCategorie AND type.NoType = tarifer.NoType')
                    ->join('periode', 'periode.noperiode = tarifer.noperiode')
                    ->orderBy('tarifer.lettrecategorie', 'ASC')
                    ->orderBy('type', 'ASC')
                    //->where('periode.datefin >=', $date_now)
                    ->get()
                    ->getResultArray();
    }
}