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

    public function inscrire(){
        $data['TitreDeLaPage'] = 'S\'inscrire';
        return view('Templates/vue_Header', $data)
            . view('Visiteur/vue_Inscrire')
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
}