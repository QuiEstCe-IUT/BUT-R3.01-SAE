<?php
namespace src\views\user;
use src\views\_Layout;

/**
 * View for the signup page.
 */
class SignUpView {
    /**
     * Display the view of the signup page.
     *
     * @return void
     */
    public function show(
        $bad_pseudo,
        $bad_prenom,
        $bad_nom,
        $bad_email,
        $notMatch_password,
        $bad_adress,
        $notAccepted_conditions
    ) {
        $path = 'src\\views\\_layout';
        $layout = new $path();
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">

                <link rel="stylesheet" href="../assets/styles/_default.min.css">
                <link rel="stylesheet" href="../assets/styles/_navigation.min.css">
                <link rel="stylesheet" href="../assets/styles/signUpStyle.min.css">
                <?php $layout->start_page(); ?>
            </head>
            <body>
                <div id="main-container">
                    <header>
                        <?php $layout->navigation(); ?>
                    </header>

                    <div id="right-container">
                        <main>
                            <div class="cont">
                                <h1>S'inscrire</h1>
                                <form method='post' class="form_bg" action="/user/signup">
                                    <p class="inpt">Pseudo:</p>
                                    <input name='form[pseudo]' class="input" type="text">
                                    <p class='error'><?php if (isset($bad_pseudo)) {
                                        echo $bad_pseudo;} ?></p>

                                    <p class="inpt">Prenom:</p>
                                    <input name='form[prenom]' class="input" type="text">
                                    <p class='error'><?php if (isset($bad_prenom)) {
                                        echo $bad_prenom;} ?></p>

                                    <p class="inpt">Nom:</p>
                                    <input name='form[nom]' class="input" type="text">
                                    <p class='error'><?php if (isset($bad_nom)) {
                                        echo $bad_nom;} ?></p>

                                    <p class="inpt">Email:</p>
                                    <input name='form[email]' class="input" type="text" required>  
                                    <p class='error'><?php if (isset($bad_email)) {
                                        echo $bad_email;} ?></p>

                                    <p class="inpt">Mot de passe:</p>
                                    <input name='form[mdp]' class="input" type="password" minlength="12" required>
                                    <p class="inpt">Confirmation du mot de passe:</p>
                                    <input name='form[mdp2]' class="input" type="password" minlength="12" required>
                                    <p class='error'><?php if (isset($notMatch_password)) {
                                        echo $notMatch_password;} ?></p>

                                    <!-- Phone number -->
                                    <p class="inpt">Numéro de téléphone (optionnel):</p>
                                    <input name='form[phone]' class="input" type="tel">

                                    <!-- Adress -->
                                    <p class="inpt">Adresse:</p>
                                    <input name='form[adress]' class="input" type="text">
                                    <p class='error'><?php if (isset($bad_adress)) {
                                        echo $bad_adress;} ?></p>

                                    <p class="inpt">Conditions générales:</p>
                                    <input name='form[generalCondition]' type="checkbox">
                                    <p class='error'><?php if (isset($notAccepted_conditions)) {
                                        echo $notAccepted_conditions;} ?></p>

                                    <input type="submit" class="submit">
                                </form>
                                <a href="/user/login" class="link">S'authentifier</a><br>
                            </div>
                        </main>
                        <footer>
                            <?php $layout->end_page(); ?>
                        </footer>
                    </div>
                </div>
            </body>
        </html>
        <?php
    }
}