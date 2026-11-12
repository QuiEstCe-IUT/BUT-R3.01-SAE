<?php

namespace src\controllers\board;

use src\views\board\PickView;


class PickController {
    /**
     * @return void
     */
    public function showPickCharacter() : void {
        
        $characters = [];

        (new PickView())->show($characters);
    }
}