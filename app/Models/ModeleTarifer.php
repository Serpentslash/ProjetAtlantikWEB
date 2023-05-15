<?php
namespace App\Models;
use CodeIgniter\Model;

class ModeleTarifer extends Model
{
    protected $table = 'tarifer';
    protected $allowedFields = ['NoPeriode', 'LettreCategorie', 'NoType','NoLiaison', 'Tarif'];

    public function getTarifsParLiaison($NoLiaison) {
        $date_now = date("Y-m-d");
    
        return $this->join('periode', 'tarifer.NoPeriode = periode.NoPeriode')
                    ->join('type', 'tarifer.NoType = type.NoType')
                    ->join('categorie', 'tarifer.LettreCategorie = categorie.LettreCategorie')
                    ->join('liaison', 'tarifer.NoLiaison = liaison.NoLiaison')
                    ->join('port portdepart', 'liaison.noport_depart = portdepart.noport')
                    ->join('port portarrivee', 'liaison.noport_arrivee = portarrivee.noport')
                    ->where('tarifer.NoLiaison', $NoLiaison)
                    ->where('periode.datefin >=', $date_now)
                    ->get()
                    ->getResult();
    }
}