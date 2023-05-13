<?php
namespace App\Controllers;
use App\Models\ModeleClient;

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
            'txtMail' => 'required',
            'txtPassword' => 'required',
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
        $MEL = $this->request->getPost('txtMail');
        $password = $this->request->getPost('txtPassword');

        /* on va chercher dans la BDD l'utilisateur correspondant aux id et mot de passe saisis */
        $modClient = new ModeleClient(); // instanciation modèle
        $clientRetourne = $modClient->retournerClient($MEL, $password);

        if ($clientRetourne != null) {
            /* identifiant et mot de passe OK : identifiant et profil sont stockés en session */
            $session->set('MEL', $clientRetourne["MEL"]);
            // profil = "SuperAdministrateur ou "Administrateur"
            $data['MEL'] = $MEL;
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
        session()->destroy();
        return redirect()->to('accueil');
    }

    public function inscrire()
    {
        $data['TitreDeLaPage'] = 'S\'inscrire';

        if (!$this->request->is('post')) {
            return view('Templates/vue_Header', $data)
            . view('Visiteur/vue_Inscrire')
            . view('Templates/vue_Footer');
        }

        /* SI FORMULAIRE NON POSTE, LE CODE QUI SUIT N'EST PAS EXECUTE */

        /* VALIDATION DU FORMULAIRE */

        $reglesValidation = [
            'NOM' => [
                'label' => 'Nom',
                'rules' => 'required|string|max_length[50]',
                'errors' => [
                    'required' => 'Le champ {field} est obligatoire.',
                    'string' => 'Le champ {field} doit être une chaîne de caractères.',
                    'max_length' => 'Le champ {field} ne doit pas dépasser {param} caractères.'
                ]
            ],
            'PRENOM' => [
                'label' => 'Prénom',
                'rules' => 'required|string|max_length[50]',
                'errors' => [
                    'required' => 'Le champ {field} est obligatoire.',
                    'string' => 'Le champ {field} doit être une chaîne de caractères.',
                    'max_length' => 'Le champ {field} ne doit pas dépasser {param} caractères.'
                ]
            ],
            'ADRESSE' => [
                'label' => 'Adresse',
                'rules' => 'required|string|max_length[255]',
                'errors' => [
                    'required' => 'Le champ {field} est obligatoire.',
                    'string' => 'Le champ {field} doit être une chaîne de caractères.',
                    'max_length' => 'Le champ {field} ne doit pas dépasser {param} caractères.'
                ]
            ],
            'CODEPOSTAL' => [
                'label' => 'Code Postal',
                'rules' => 'required|exact_length[5]|integer',
                'errors' => [
                    'required' => 'Le champ {field} est obligatoire.',
                    'exact_length' => 'Le champ {field} doit contenir exactement {param} chiffres.',
                    'integer' => 'Le champ {field} doit être un entier.'
                ]
            ],
            'VILLE' => [
                'label' => 'Ville',
                'rules' => 'required|string|max_length[50]',
                'errors' => [
                    'required' => 'Le champ {field} est obligatoire.',
                    'string' => 'Le champ {field} doit être une chaîne de caractères.',
                    'max_length' => 'Le champ {field} ne doit pas dépasser {param} caractères.'
                ]
            ],
            'TELEPHONEFIXE' => [
                'label' => 'Téléphone Fixe',
                'rules' => 'permit_empty|regex_match[/(0|\+33)[1-9]( *[0-9]{2}){4}/]',
                'errors' => [
                    'regex_match' => 'Le champ {field} doit être un numéro de téléphone fixe valide en France (exemple : 01 23 45 67 89).'
                ]
            ],
            'TELEPHONEMOBILE' => [
                'label' => 'Téléphone Mobile',
                'rules' => 'required|regex_match[/(0|\+33)[67]( *[0-9]{2}){4}/]',
                'errors' => [
                    'required' => 'Le champ {field} est obligatoire.',
                    'regex_match' => 'Le champ {field} doit être un numéro de téléphone mobile valide en France (exemple : 06 12345678).'
                ]
            ],
            'MEL' => [
            'label' => 'Adresse email',
            'rules' => 'required|valid_email',
            'errors' => [
            'required' => 'Le champ {field} est obligatoire.',
            'valid_email' => 'Le champ {field} doit être une adresse email valide.'
                ]
            ],
            'MOTDEPASSE' => [
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
            $data['TitreDeLaPage'] = "S'inscrire";

            return view('Templates/vue_Header', $data)
            . view('Visiteur/vue_Inscrire')
            . view('Templates/vue_Footer');
        }

        /* SI FORMULAIRE NON VALIDE, LE CODE QUI SUIT N'EST PAS EXECUTE */

        /* INSERTION PRODUIT SAISI DANS BDD */

        $donneesAInserer = array(
            'NOM' => $this->request->getPost('txtNOM'),
            'PRENOM' => $this->request->getPost('txtPRENOM'),
            'ADRESSE' => $this->request->getPost('txtADRESSE'),
            'CODEPOSTAL' => $this->request->getPost('txtCODEPOSTAL'),
            'VILLE' => $this->request->getPost('txtVILLE'),
            'TELEPHONEFIXE' => $this->request->getPost('txtTELEPHONEFIXE'),
            'TELEPHONEMOBILE' => $this->request->getPost('txtTELEPHONEMOBILE'),
            'MEL' => $this->request->getPost('txtMEL'),
            'MOTDEPASSE' => $this->request->getPost('txtMOTDEPASSE'),
        ); // reference, libelle, prixht, quantiteenstock, image : champs de la table 'produit'

        $modClient = new ModeleClient(); //instanciation du modèle
        $donnees['produitAjoute'] = $modClient->insert($donneesAInserer, false);

        // provoque insert into sur la table mappée (produit, ici), retourne 1 (true) si ajout OK

        return view('Templates/Header')

            .view('Administrateur/vue_RapportAjouterProduit', $donnees)

            .view('Templates/Footer');

    } // ajouterProduit
}