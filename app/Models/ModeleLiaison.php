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
        $builder = $this->db->table('liaison');
        $builder->select('noliaison, distance, port_depart.nom as port_depart, port_arrivee.nom as port_arrivee, secteur.nom as secteur');
        $builder->join('port as port_depart', 'port_depart.noport = liaison.noport_depart');
        $builder->join('port as port_arrivee', 'port_arrivee.noport = liaison.noport_arrivee');
        $builder->join('secteur', 'secteur.nosecteur = liaison.nosecteur');
        $builder->orderBy('secteur', 'ASC');
        $builder->orderBy('noliaison', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }
}