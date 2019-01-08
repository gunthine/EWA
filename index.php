<?php
require_once './Page.php';

class indexPage extends Page
{
    protected function __construct()
    {
        parent::__construct();
    }

    protected function __destruct()
    {
        parent::__destruct();
    }

    protected function getViewData()
    {

    }

    protected function generateView()
    {
        $this->getViewData();
        $this->generatePageHeader("Startseite");
        echo <<<EOT
        <div class="wrapper">
            <h1>Pizzeria Da Salvo</h1>
            <article>
                <h2>Die beste Pizza in Mainz</h2>
                <p>Das sehr freundliche und ausmerksame Servicepersonal der Pizzeria Da Salvo gibt Ihnen das Gefühl nach Hause zu kommen.
                Hier sind nicht nur die Speisen lecker und frisch zubereitet, das familiäre Gefühl, das sich bei einem Besuch einstellt,
                ist einzigartig.</p>
            </article>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2564.278924474935!2d8.218222815715306!3d50.00612707941654!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47bd9683508f2f2d%3A0xf0d973378acef83f!2sPizzeria+Da+Salvo!5e0!3m2!1sde!2sde!4v1543933678054" width="500" height="275" allowfullscreen></iframe>
        </div>\n
EOT;
        $this->generatePageFooter();
    }

    protected function processReceivedData()
    {
        parent::processReceivedData();
    }

    public static function main()
    {
        try {
            $page = new indexPage();
            $page->processReceivedData();
            $page->generateView();
        }
        catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

indexPage::main();