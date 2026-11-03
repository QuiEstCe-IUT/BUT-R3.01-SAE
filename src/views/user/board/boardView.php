<?php
namespace src\views\user\board;

use src\views\_Layout;

class BoardView
{
    public function show(array $characters, string $phase, ?string $question = null): void
    {
        $layout = new _Layout();
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="/assets/styles/boardViewStyle.css">
            <?php $layout->start_page(); ?>
        </head>
        <body>
            <div id="main-container">
                <header><?php $layout->navigation(); ?></header>
                <div id="right-container">
                    <main>
                        <h1>Qui est-ce ?</h1>
                        <section class="board">
                            <?php foreach ($characters as $character): ?>
                                <article class="card<?= !empty($character['eliminated']) ? ' eliminated' : '' ?>">
                                    <img
                                        src="<?= htmlspecialchars($character['image'], ENT_QUOTES, 'UTF-8') ?>"
                                        alt="<?= htmlspecialchars($character['name'], ENT_QUOTES, 'UTF-8') ?>"
                                    >
                                    <h2><?= htmlspecialchars($character['name'], ENT_QUOTES, 'UTF-8') ?></h2>
                                </article>
                            <?php endforeach; ?>
                        </section>
                        <?php
                        switch ($phase) {
                            case 'poser_question':
                                $this->formulaireQuestion();
                                break;

                            case 'attente_question':
                                $this->AdvEcritQuestion();
                                break;

                            case 'attente_reponse':
                                $this->AdvRepondQuestion();
                                break;

                            case 'choix_tour':
                                $this->ChoixProchaineQuestionDeviner();
                                $this->formulaireReponse($characters);
                                break;

                            case 'repondre_question':
                                if ($question === null) {
                                    throw new \InvalidArgumentException('La question est requise pour cette phase.');
                                }
                                $this->RepondreQuestion($question);
                                break;

                            case 'attente_elimination':
                                $this->AdvEliminePerso();
                                break;

                            default:
                                throw new \InvalidArgumentException('Phase de jeu inconnue.');
                        }
                        ?>
                    </main>
                    <footer><?php $layout->end_page(); ?></footer>
                </div>
            </div>
        </body>
        </html>
        <?php
    }

    private function formulaireQuestion(): void
    {
        ?>
        <form method="post" action="/user/board">
            <label for="question">Écris ta question :</label>
            <textarea
                id="question"
                name="question"
                required
                maxlength="250"
            ></textarea>
            <button type="submit">Envoyer</button>
        </form>
        <?php
    }

    
    private function AdvEcritQuestion(): void
    {
        ?>
        <p>L'adversaire écrit sa question</p>
        <?php
    }

    private function AdvRepondQuestion(): void
    {
        ?>
        <p>L'adversaire répond à la question</p>
        <?php
    }

    private function ChoixProchaineQuestionDeviner(): void
    {
        ?>
        <form method="post" action="/user/board">
            <button type="submit" name="next_question">Prochaine question</button>
        </form>
        <?php
    }
        

    private function formulaireReponse(array $characters): void
    {
        ?>
        <form method="post" action="/user/board">
            <label for="response">Choisis un personnage :</label>
            <select id="response" name="character_id" required>
                <option value="">Sélectionnez un personnage</option>
                <?php foreach ($characters as $character): ?>
                    <option value="<?= htmlspecialchars((string) $character['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($character['name'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Confirmer</button>
        </form>
        <?php
    }

    private function RepondreQuestion(string $question): void
    {
    ?>
    <section>
        <h2>Question posée</h2>
        <p><?= htmlspecialchars($question, ENT_QUOTES, 'UTF-8') ?></p>
        <form method="post" action="/board/answerQuestion">
            <label for="reponse">Écris ta réponse :</label>
                <textarea
                    id="reponse"
                    name="form[reponse]"
                    required
                    maxlength="250"
                ></textarea>
                <button type="submit">Envoyer</button>
        </form>
    </section>
    <?php
    }

    private function AdvEliminePerso(): void
    {
        ?>
        <p>L'adversaire élimine des personnages</p>
        <?php
    }

}