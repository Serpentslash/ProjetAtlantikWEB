<?php
namespace App\Controllers;
use App\Models\ModeleClient;
use App\Models\ModeleLiaison;

helper(['url', 'assets', 'form']);

class Visiteur extends BaseController{

    public function accueil(){
        $data['TitreDeLaPage'] = 'Accueil';
        return view('Templates/vue_Header', $data)
            . view('Visiteur/vue_Accueil')
            . view('Templates/vue_Footer');
    }

    public function connecter()
    {
        helper(['form']);
        $session = session();

        $data['TitreDeLaPage'] = 'Se connecter';

        /* TEST SI FORMULAIRE POSTE OU SI APPEL DIRECT (EN GET) */
        if (!$this->request->is('post')) {
            return view('Templates/vue_Header', $data) // Renvoi formulaire de connexion
            . view('Visiteur/vue_Connecter')
            . view('Templates/vue_Footer');
        }
        /* SI FORMULAIRE NON POSTE, LE CODE QUI SUIT N'EST PAS EXECUTE */

        /* VALIDATION DU FORMULAIRE */
        $reglesValidation = [ // Régles de validation
            'txtMel' => 'required',
            'txtMotDePasse' => 'required',
        ];

        if (!$this->validate($reglesValidation)) {
            /* formulaire non validé */
            $data['TitreDeLaPage'] = "Saisie incorrecte";
            return view('Templates/vue_Header', $data) // Renvoi formulaire de connexion
            . view('Visiteur/vue_Connecter')
            . view('Templates/vue_Footer');
        }

        /* SI FORMULAIRE NON VALIDE, LE CODE QUI SUIT N'EST PAS EXECUTE */
        /* RECHERCHE UTILISATEUR DANS BDD */
        $Mel = $this->request->getPost('txtMel');
        $MotDePasse = $this->request->getPost('txtMotDePasse');

        /* on va chercher dans la BDD l'utilisateur correspondant aux id et mot de passe saisis */
        $modClient = new ModeleClient();
        $clientRetourne = $modClient->retournerClient($Mel, $MotDePasse);

        if ($clientRetourne != null) {
            /* identifiant et mot de passe OK : identifiant et profil sont stockés en session */
            $colonnesMAJ = ['NOM', 'PRENOM', 'ADRESSE','CODEPOSTAL', 'VILLE', 'TELEPHONEFIXE', 'TELEPHONEMOBILE', 'MEL', 'MOTDEPASSE'];
            $colonnesMIN = ['Nom', 'Prenom', 'Adresse','CodePostal', 'Ville', 'TelephoneFixe', 'TelephoneMobile', 'Mel', 'MotDePasse'];

            for($i = 0; $i <= 8; $i++) {
                $session->set($colonnesMIN[$i], $clientRetourne[$colonnesMAJ[$i]]);
            }

            $data['Mel'] = $Mel;
            $data['TitreDeLaPage'] = "Accueil";
            return redirect()->route('accueil');
        } else {
            /* identifiant et/ou mot de passe OK : on renvoie le formulaire  */
            $data['TitreDeLaPage'] = "Identifiant ou/et Mot de passe inconnu(s)";
            return view('Templates/vue_Header', $data)
            . view('Visiteur/vue_Connecter')
            . view('Templates/vue_Footer');
        }
    } // Fin seConnecter

    public function deconnecter()
    {
        $session = session();
        if(!is_null($session->get('Mel'))){
            session()->destroy();
            return redirect()->to('accueil');
        }else{
            return redirect()->route('accueil');
        }
    }

    public function inscrire()
    {
        helper(['form']);
        $session = session();

        $data['TitreDeLaPage'] = 'S\'inscrire';

        if (!$this->request->is('post')) {
            return view('Templates/vue_Header', $data)
            . view('Visiteur/vue_Inscrire')
            . view('Templates/vue_Footer');
        }

        /* SI FORMULAIRE NON POSTE, LE CODE QUI SUIT N'EST PAS EXECUTE */

        /* VALIDATION DU FORMULAIRE */

        $reglesValidation = [
            'txtNom' => [
                'label' => 'Nom',
                'rules' => 'required|string|max_length[50]',
                'errors' => [
                    'required' => 'Le champ {field} est obligatoire.',
                    'string' => 'Le champ {field} doit être une chaîne de caractères.',
                    'max_length' => 'Le champ {field} ne doit pas dépasser {param} caractères.'
                ]
            ],
            'txtPrenom' => [
                'label' => 'Prénom',
                'rules' => 'required|string|max_length[50]',
                'errors' => [
                    'required' => 'Le champ {field} est obligatoire.',
                    'string' => 'Le champ {field} doit être une chaîne de caractères.',
                    'max_length' => 'Le champ {field} ne doit pas dépasser {param} caractères.'
                ]
            ],
            'txtAdresse' => [
                'label' => 'Adresse',
                'rules' => 'required|string|max_length[255]',
                'errors' => [
                    'required' => 'Le champ {field} est obligatoire.',
                    'string' => 'Le champ {field} doit être une chaîne de caractères.',
                    'max_length' => 'Le champ {field} ne doit pas dépasser {param} caractères.'
                ]
            ],
            'txtCodePostal' => [
                'label' => 'Code Postal',
                'rules' => 'required|exact_length[5]|integer',
                'errors' => [
                    'required' => 'Le champ {field} est obligatoire.',
                    'exact_length' => 'Le champ {field} doit contenir exactement {param} chiffres.',
                    'integer' => 'Le champ {field} doit être un entier.'
                ]
            ],
            'txtVille' => [
                'label' => 'Ville',
                'rules' => 'required|string|max_length[50]',
                'errors' => [
                    'required' => 'Le champ {field} est obligatoire.',
                    'string' => 'Le champ {field} doit être une chaîne de caractères.',
                    'max_length' => 'Le champ {field} ne doit pas dépasser {param} caractères.'
                ]
            ],
            'txtTelephoneFixe' => [
                'label' => 'Téléphone Fixe',
                'rules' => 'permit_empty|regex_match[/(0|\+33)[1-9]( *[0-9]{2}){4}/]',
                'errors' => [
                    'regex_match' => 'Le champ {field} doit être un numéro de téléphone fixe valide en France (exemple : 01 23 45 67 89).'
                ]
            ],
            'txtTelephoneMobile' => [
                'label' => 'Téléphone Mobile',
                'rules' => 'required|regex_match[/(0|\+33)[67]( *[0-9]{2}){4}/]',
                'errors' => [
                    'required' => 'Le champ {field} est obligatoire.',
                    'regex_match' => 'Le champ {field} doit être un numéro de téléphone mobile valide en France (exemple : 06 12345678).'
                ]
            ],
            'txtMel' => [
                'label' => 'Adresse email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Le champ {field} est obligatoire.',
                    'valid_email' => 'Le champ {field} doit être une adresse email valide.'
                ]
            ],
            'txtMotDePasse' => [
                'label' => 'Mot de passe',
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Le champ {field} est obligatoire.',
                    'min_length' => 'Le champ {field} doit contenir au moins {param} caractères.'
                ]
            ]
        ];

        if (!$this->validate($reglesValidation)) {
            /* formulaire non validé, on renvoie le formulaire */
            $data['TitreDeLaPage'] = "S'erreur";

            return view('Templates/vue_Header', $data)
            . view('Visiteur/vue_Inscrire')
            . view('Templates/vue_Footer');
        }

        /* SI FORMULAIRE NON VALIDE, LE CODE QUI SUIT N'EST PAS EXECUTE */

        /* INSERTION PRODUIT SAISI DANS BDD */

        $Mel = $this->request->getPost('txtMel');

        $modClient = new ModeleClient();
        $melRetourne = $modClient->retournerMel($Mel);

        if ($melRetourne != null) {
            //Erreur mail déjà utilise
            $data['TitreDeLaPage'] = "S'erreur";

            return view('Templates/vue_Header', $data)
            . view('Visiteur/vue_Inscrire')
            . view('Templates/vue_Footer');

        } else {
            //Mail non utilise
            $telephoneFixe = $this->request->getPost('txtTelephoneFixe');
            $telephoneFixe = substr_replace($telephoneFixe, '.', 2, 0);
            $telephoneFixe = substr_replace($telephoneFixe, '.', 5, 0);
            $telephoneFixe = substr_replace($telephoneFixe, '.', 8, 0);
            $telephoneFixe = substr_replace($telephoneFixe, '.', 11, 0);

            $telephoneMobile = $this->request->getPost('txtTelephoneMobile');
            $telephoneMobile = substr_replace($telephoneMobile, '.', 2, 0);
            $telephoneMobile = substr_replace($telephoneMobile, '.', 5, 0);
            $telephoneMobile = substr_replace($telephoneMobile, '.', 8, 0);
            $telephoneMobile = substr_replace($telephoneMobile, '.', 11, 0);
            
            $donneesAInserer = array(
                'Nom' => $this->request->getPost('txtNom'),
                'Prenom' => $this->request->getPost('txtPrenom'),
                'Adresse' => $this->request->getPost('txtAdresse'),
                'CodePostal' => $this->request->getPost('txtCodePostal'),
                'Ville' => $this->request->getPost('txtVille'),
                'TelephoneFixe' => $telephoneFixe,
                'TelephoneMobile' => $telephoneMobile,
                'Mel' => $this->request->getPost('txtMel'),
                'MotDePasse' => $this->request->getPost('txtMotDePasse'),
            );

            $donnees['nouveauClient'] = $modClient->insert($donneesAInserer, false);
            
            $colonnes = ['Nom', 'Prenom', 'Adresse','CodePostal', 'Ville', 'TelephoneFixe', 'TelephoneMobile', 'Mel', 'MotDePasse'];
            foreach ($donneesAInserer as $cle => $valeur){
                $session->set($cle, $valeur);
            }

            return redirect()->route('accueil');
        }      
    }

    public function afficherLiaisons()
    {
        $modLiaison = new ModeleLiaison();
        $data['liaisons'] = $modLiaison->getLiaisons();
        $data['TitreDeLaPage'] = "Liste des liaisons";

        return view('Templates/vue_Header', $data)
            . view('Visiteur/vue_AfficherLiaisons')
            . view('Templates/vue_Footer');
    }

    public function afficherTarifs()
    {
        $modTarif = new ModeleTarifs();
        $data['tarifs'] = $modTarif->getTarifs();
        $data['TitreDeLaPage'] = "Liste des tarifs";

        return view('Templates/vue_Header', $data)
            . view('Visiteur/vue_AfficherTarifs')
            . view('Templates/vue_Footer');
    }
}