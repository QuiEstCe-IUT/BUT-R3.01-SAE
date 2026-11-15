<?php

namespace src\controllers\board;

use src\views\board\PickView;

class PickController {
    

    public function execute() : void {
        // TODO 
        $characters = [
            ['id' => 1, 'name' => 'Prost'],
            ['id' => 2, 'name' => 'Casali']
        ]; 
        
        (new PickView())->show($characters);
    }

    // 2. On va traiter le choix du joueur
    public function selectCharacter() : void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['character_id'])) {
            $characterId = $_POST['character_id'];
            
            // On stocke le choix en session par exemple
            $_SESSION['selected_character'] = $characterId;

            // On redirige vers la suite du jeu
            header('Location: /board/game');
            exit();
        }
    }
}
