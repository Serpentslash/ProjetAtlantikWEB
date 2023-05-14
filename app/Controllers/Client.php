<?php
namespace App\Controllers;
use App\Models\ModeleClient;

helper(['url', 'assets', 'form']);

class Client extends BaseController{
    public function profil()
    {
        $session = session();
        if(!is_null($session->get('Mel'))){
            helper(['form']);

            $data['TitreDeLaPage'] = 'Profil';

            /* TEST SI FORMULAIRE POSTE OU SI APPEL DIRECT (EN GET) */
            if (!$this->request->is('post')) {
                return view('Templates/vue_Header', $data)
                . view('Client/vue_Profil')
                . view('Templates/vue_Footer');
            }
            /* SI FORMULAIRE NON POSTE, LE CODE QUI SUIT N'EST PAS EXECUTE */

            /* VALIDATION DU FORMULAIRE */
            // $reglesValidation = [ // Régles de validation
            //     'txtAdresse' => [
            //         'label' => 'Adresse',
            //         'rules' => 'string|max_length[255]',
            //         'errors' => [
            //             'string' => 'Le champ {field} doit être une chaîne de caractères.',
            //             'max_length' => 'Le champ {field} ne doit pas dépasser {param} caractères.'
            //         ]
            //     ],
            //     'txtCodePostal' => [
            //         'label' => 'Code Postal',
            //         'rules' => 'exact_length[5]|integer',
            //         'errors' => [
            //             'exact_length' => 'Le champ {field} doit contenir exactement {param} chiffres.',
            //             'integer' => 'Le champ {field} doit être un entier.'
            //         ]
            //     ],
            //     'txtVille' => [
            //         'label' => 'Ville',
            //         'rules' => 'string|max_length[50]',
            //         'errors' => [
            //             'string' => 'Le champ {field} doit être une chaîne de caractères.',
            //             'max_length' => 'Le champ {field} ne doit pas dépasser {param} caractères.'
            //         ]
            //     ],
            //     'txtTelephoneFixe' => [
            //         'label' => 'Téléphone Fixe',
            //         'rules' => 'regex_match[/(0|\+33)[1-9]( *[0-9]{2}){4}/]',
            //         'errors' => [
            //             'regex_match' => 'Le champ {field} doit être un numéro de téléphone fixe valide en France (exemple : 01 23 45 67 89).'
            //         ]
            //     ],
            //     'txtTelephoneMobile' => [
            //         'label' => 'Téléphone Mobile',
            //         'rules' => 'regex_match[/(0|\+33)[67]( *[0-9]{2}){4}/]',
            //         'errors' => [
            //             'regex_match' => 'Le champ {field} doit être un numéro de téléphone mobile valide en France (exemple : 06 12345678).'
            //         ]
            //     ],
            //     'txtMel' => [
            //         'label' => 'Adresse email',
            //         'rules' => 'valid_email',
            //         'errors' => [
            //             'valid_email' => 'Le champ {field} doit être une adresse email valide.'
            //         ]
            //     ],
            //     'txtPassword' => [
            //         'label' => 'Mot de passe',
            //         'rules' => 'min_length[8]',
            //         'errors' => [
            //             'min_length' => 'Le champ {field} doit contenir au moins {param} caractères.'
            //         ]
            //     ]
            // ];

            // if (!$this->validate($reglesValidation)) {
            //     /* formulaire non validé */
            //     $data['TitreDeLaPage'] = "Saisie incorrecte";
            //     return view('Templates/vue_Header', $data) // Renvoi formulaire de connexion
            //     . view('Client/vue_Profil')
            //     . view('Templates/vue_Footer');
            // }

            /* on va chercher dans la BDD l'utilisateur correspondant aux id et mot de passe saisis */
            $modClient = new ModeleClient();

            $donnees = $this->request->getPost();

            // Vérification des champs remplis
            $champsRemplis = [];
            foreach ($donnees as $nomChamp => $valeurChamp) {
                if (!empty($valeurChamp)) {
                    $champsRemplis[str_replace('txt', '', $nomChamp)] = $valeurChamp;
                }
            }

            // Si aucun champ n'a été rempli, on renvoie une erreur
            if (empty($champsRemplis)) {
                return redirect()->back()->with('error', 'Au moins un champ doit être rempli.');
            }

            $modeleClient = new ModeleClient();

            $MelClient = $session->get('Mel');

            // Modification des champs remplis dans la base de données
            $modeleClient->modifierClient($MelClient, $champsRemplis);
            return redirect()->route('accueil');
        }else{
            return redirect()->route('accueil');
        }
    }
}