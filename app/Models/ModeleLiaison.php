<?php
namespace App\Models;
use CodeIgniter\Model;

class ModeleLiaison extends Model
{
    protected $table = 'liaison';
    protected $primaryKey = 'NOLIAISON';
    protected $allowedFields = ['NOPORT_DEPART', 'NOSECTEUR', 'NOPORT_ARRIVEE','DISTANCE'];

    public function getLiaisons()
    {
        return $this->select('noliaison, distance, port_depart.nom as port_depart, port_arrivee.nom as port_arrivee, secteur.nom as secteur')
                    ->join('port as port_depart', 'port_depart.noport = liaison.noport_depart')
                    ->join('port as port_arrivee', 'port_arrivee.noport = liaison.noport_arrivee')
                    ->join('secteur', 'secteur.nosecteur = liaison.nosecteur')
                    ->orderBy('secteur', 'ASC')
                    ->orderBy('noliaison', 'ASC')
                    ->get()
                    ->getResultArray();
    }
}