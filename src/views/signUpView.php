<?php
namespace src\views;

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
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">

                <link rel="stylesheet" href="assets/styles/_default.min.css">
                <link rel="stylesheet" href="assets/styles/_navigation.min.css">
                <link rel="stylesheet" href="assets/styles/signUpStyle.min.css">
                <?php start_page(); ?>
            </head>
            <body>
                <div id="main-container">
                    <header>
                        <?php navigation(); ?>
                    </header>

                    <div id="right-container">
                        <main>
                            <div class="cont">
                                <h1>S'inscrire</h1>
                                <form method='post' class="form_bg" action="index.php?page=signUp">
                                    <p class="inpt">Pseudo:</p>
                                    <input name='form[pseudo]' class="input" type="text">
                                    <?php if (isset($bad_pseudo)) {
                                        echo $bad_pseudo;} ?>

                                    <p class="inpt">Prenom:</p>
                                    <input name='form[prenom]' class="input" type="text">
                                    <?php if (isset($bad_prenom)) {
                                        echo $bad_prenom;} ?>

                                    <p class="inpt">Nom:</p>
                                    <input name='form[nom]' class="input" type="text">
                                    <?php if (isset($bad_nom)) {
                                        echo $bad_nom;} ?>

                                    <p class="inpt">Email:</p>
                                    <input name='form[email]' class="input" type="text">  
                                    <?php if (isset($bad_email)) {
                                        echo $bad_email;} ?>

                                    <p class="inpt">Mot de passe:</p>
                                    <input name='form[mdp]' class="input" type="password">
                                    <p class="inpt">Confirmation du mot de passe:</p>
                                    <input name='form[mdp2]' class="input" type="password">
                                    <?php if (isset($notMatch_password)) {
                                        echo $notMatch_password;} ?>

                                    <!-- Phone number -->
                                    <p class="inpt">Numéro de téléphone (optionnel):</p>
                                    <input name='form[phone]' class="input" type="tel">

                                    <!-- Adress -->
                                    <p class="inpt">Adresse:</p>
                                    <input name='form[adress]' class="input" type="text">
                                    <?php if (isset($bad_adress)) {
                                        echo $bad_adress;} ?>

                                    <p class="inpt">Conditions générales:</p>
                                    <input name='form[generalCondition]' type="checkbox">
                                    <?php if (isset($notAccepted_conditions)) {
                                        echo $notAccepted_conditions;} ?>

                                    <input type="submit" class="submit">
                                </form>
                                <a href="index.php?page=login" class="link">S'authentifier</a><br>
                            </div>
                        </main>
                        <footer>
                            <?php end_page(); ?>
                        </footer>
                    </div>
                </div>
            </body>
        </html>
        <?php
    }
}