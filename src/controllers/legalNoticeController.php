<?php
namespace src\controllers;

/**
 * Controller for handling legal notice page.
 */
class LegalNoticeController {
    /**
     * Executes the legal notice logic and renders the view.
     *
     * @return void
     */
    public function execute(): void 
    {
        $companyName = "Qui est-ce";
        $address = "413 avenue Gaston Berger, Aix-En-Provence 13100";
        $contactEmail = "";

        $hostName = "";
        $hostAddress = "";

        $path = 'src\\views\\legalNoticeView';
        (new $path())->show(
            $companyName,
            $address,
            $contactEmail,
            $hostName,
            $hostAddress
        );
    }
}
