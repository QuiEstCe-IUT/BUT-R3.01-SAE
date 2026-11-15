<?php
namespace src\controllers\user;

use src\views\user\SignUpView;
use src\models\UserModel;

/**
 * Controller for handling user signup.
 */
class SignUpController {
    /**
     * Executes the signup logic and renders the view.
     *
     * @return void
     */
    public function execute() {

        $bad_pseudo = null;
        $bad_prenom = null;
        $bad_nom = null;
        $bad_email = null;
        $notMatch_password = null;
        $bad_adress = null;
        $notAccepted_conditions = null;

        // On vérifie le contenu du formulaire d'inscription (si on est pas déjà connecté)
        if (isset($_POST['form']) && !isset($_SESSION['uid'])) {
            // On filtre les entrées pour éviter les injections SQL
            $args = [
                'form' => [
                    'filter' => FILTER_DEFAULT,
                    'flags'  => FILTER_REQUIRE_ARRAY,
                ]
            ];
            $postData = filter_input_array(INPUT_POST, $args);
    
            if (
                isset($postData['form']['pseudo']) &&
                isset($postData['form']['prenom']) &&
                isset($postData['form']['nom']) &&
                isset($postData['form']['email']) &&
                isset($postData['form']['mdp']) &&
                isset($postData['form']['mdp2']) &&
                isset($postData['form']['adress']))
                {
                // Vérification de la taille du pseudo / prenom / nom
                if (strlen($postData['form']['pseudo']) > 20) {
                    $bad_pseudo = "le pseudonyme doit être inférieur ou égale à 20 caractères";
                } elseif (strlen($postData['form']['pseudo']) == 0) {
                    $bad_pseudo = "Veuillez entrer un pseudonyme";
                }
                if (strlen($postData['form']['prenom']) > 30) {
                    $bad_prenom = "le prenom doit être inférieur ou égale à 30 caractères";
                } elseif (strlen($postData['form']['prenom']) == 0) {
                    $bad_prenom = "Veuillez entrer le prenom";
                }
                if (strlen($postData['form']['nom']) > 30) {
                    $bad_nom = "le nom doit être inférieur ou égale à 30 caractères";
                } elseif (strlen($postData['form']['nom']) == 0) {
                    $bad_nom = "Veuillez entrer le nom";
                }
    
                // Vérification email
                if (!preg_match('/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/', $postData['form']['email'])) {
                    $bad_email = "L'email est incorrect";
                } else {
                    // Vérification si l'email est déjà utilisé dans la BD
                    if (UserModel::emailExists($postData['form']['email'])) {
                        $bad_email = "Cet email est déjà associé à un compte";
                    }
                }
    
                // Vérification mdp
                if ($postData['form']['mdp'] !== $postData['form']['mdp2']) {
                    // Les deux mots de passe entrées ne sont pas exactement similaire
                    $notMatch_password = "Le mot de passe entré est différent";
                } elseif (strlen($postData['form']['mdp']) < 12) {
                    $notMatch_password = "Veuillez entrer un mot de passe de taille 12+ caractères";
                }
    
                // Vérification Conditions générales
                if (!isset($postData['form']['generalCondition'])) {
                    // L'utilisateur n'a pas accepté les conditions d'utilisation
                    $notAccepted_conditions = "Veuillez accepter les conditions d'utilisation";
                }

                // Vérification addresse
                if (strlen($postData['form']['adress']) == 0) {
                    // L'utilisateur n'a pas entré d'addresse
                    $bad_adress = "Veuillez entrer une addresse";
                }

               
    
                // Vérification globale
                if (!isset($bad_pseudo) && !isset($bad_prenom) && !isset($bad_nom) && !isset($bad_email) && !isset($notMatch_password) && !isset($notAccepted_conditions) && !isset($bad_adress)) {

                    // On hache le mot de passe ici dans le contrôleur
                    $hash = password_hash($postData['form']['mdp'], PASSWORD_DEFAULT);

                    // On envoie null si le téléphone est vide
                    $phone = !empty($postData['form']['phone']) ? $postData['form']['phone'] : null;

                    // On enregistre les données de l'utilisateur dans la BD
                    $reussite = UserModel::register(
                        $postData['form']['pseudo'],
                        $postData['form']['prenom'],
                        $postData['form']['nom'],
                        $postData['form']['email'],
                        $hash,
                        $phone,
                        $postData['form']['adress']
                    );


                    if ($reussite) {                    
                    // On démarre la session
                    $_SESSION['suid'] = session_id();
                    $_SESSION['username'] = $postData['form']['pseudo'];
    
                    // On recharge la page pour aller sur authentification
                    header('Location: /user/login');
                    exit; //sert a ne plus charger la page apres la redirection
                    } else {
                        // Erreur lors de l'enregistrement dans la BD
                        $error_database_message = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
                    }
                }
    
            }
        }
    
        // On affiche le formulaire d'inscription
        (new SignUpView())->show(
            $bad_pseudo,
            $bad_prenom,
            $bad_nom,
            $bad_email,
            $notMatch_password,
            $bad_adress,
            $notAccepted_conditions);
    }
}