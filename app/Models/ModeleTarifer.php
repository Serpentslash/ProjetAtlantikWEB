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
                    ->getResult();//->select('periode, distance, port_depart.nom as port_depart, port_arrivee.nom as port_arrivee, secteur.nom as secteur')

        return $this->select('lettrecategorie, categorie.libelle as libelle_categorie, CONCAT(LettreCategorie, NoType, \' - \', type.libelle) as type, datedebut, datefin ,tarif')
                    ->join('categorie', 'categorie.LettreCategorie = tarifer.LettreCategorie')
                    ->join('type', 'type.LettreCategorie = tarifer.LettreCategorie AND type.NoType = tarifer.NoType')
                    ->join('periode', 'periode.noperiode = tarifer.noperiode')
                    ->get()
                    ->getResultArray();
    }
}